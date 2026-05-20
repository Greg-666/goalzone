<?php
$titre_page = 'Éditer un match';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';
require_once '../../includes/ia.php';

/** @var \PDO $pdo */

exiger_admin();

// Vérifie que l'ID est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/matchs/liste.php');
    exit;
}

$id      = (int) $_GET['id'];
$erreurs = [];

// Récupère le match
$stmt = $pdo->prepare("
    SELECT m.*,
           ed.nom AS equipe_dom,
           ee.nom AS equipe_ext,
           s.nom AS stade, s.ville
    FROM matchs m
    JOIN equipes ed ON m.equipe_dom_id = ed.id
    JOIN equipes ee ON m.equipe_ext_id = ee.id
    JOIN stades s ON m.stade_id = s.id
    WHERE m.id = :id
");
$stmt->execute([':id' => $id]);
$match = $stmt->fetch();

if (!$match) {
    header('Location: /admin/matchs/liste.php');
    exit;
}

// Récupère les équipes et stades pour les selects
$equipes = $pdo->query("SELECT id, nom FROM equipes ORDER BY nom")->fetchAll();
$stades  = $pdo->query("SELECT id, nom, ville FROM stades ORDER BY nom")->fetchAll();

$phases = [
    'groupes'       => 'Phase de groupes',
    'huitieme'      => 'Huitième de finale',
    'quart'         => 'Quart de finale',
    'demi'          => 'Demi-finale',
    'finale_petite' => 'Match pour la 3e place',
    'finale'        => 'Finale'
];

// Génération aperçu IA
if (isset($_POST['generer_apercu'])) {
    $match_complet = [
        'equipe_dom' => $match['equipe_dom'],
        'equipe_ext' => $match['equipe_ext'],
        'stade'      => $match['stade'],
        'ville'      => $match['ville'],
        'date_match' => $match['date_match'],
        'phase'      => $match['phase'],
    ];

    $apercu = generer_apercu_match($match_complet);

    if ($apercu) {
        sauvegarder_apercu($pdo, $id, $apercu);
        header('Location: /admin/matchs/liste.php?message=apercu');
        exit;
    } else {
        $erreurs[] = 'Erreur lors de la génération de l\'aperçu IA. Vérifiez votre clé API.';
    }
}

// Modification du match
if (isset($_POST['modifier'])) {

    $equipe_dom_id = (int) ($_POST['equipe_dom_id'] ?? 0);
    $equipe_ext_id = (int) ($_POST['equipe_ext_id'] ?? 0);
    $stade_id      = (int) ($_POST['stade_id'] ?? 0);
    $date_match    = trim($_POST['date_match'] ?? '');
    $phase         = trim($_POST['phase'] ?? '');
    $score_dom     = $_POST['score_dom'] !== '' ? (int) $_POST['score_dom'] : null;
    $score_ext     = $_POST['score_ext'] !== '' ? (int) $_POST['score_ext'] : null;

    // Validation
    if (!$equipe_dom_id)                    $erreurs[] = 'L\'équipe domicile est obligatoire.';
    if (!$equipe_ext_id)                    $erreurs[] = 'L\'équipe extérieure est obligatoire.';
    if ($equipe_dom_id === $equipe_ext_id)  $erreurs[] = 'Les deux équipes doivent être différentes.';
    if (!$stade_id)                         $erreurs[] = 'Le stade est obligatoire.';
    if (empty($date_match))                 $erreurs[] = 'La date est obligatoire.';
    if (!array_key_exists($phase, $phases)) $erreurs[] = 'La phase est invalide.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            UPDATE matchs SET
                equipe_dom_id = :equipe_dom_id,
                equipe_ext_id = :equipe_ext_id,
                stade_id      = :stade_id,
                date_match    = :date_match,
                phase         = :phase,
                score_dom     = :score_dom,
                score_ext     = :score_ext
            WHERE id = :id
        ");
        $stmt->execute([
            ':equipe_dom_id' => $equipe_dom_id,
            ':equipe_ext_id' => $equipe_ext_id,
            ':stade_id'      => $stade_id,
            ':date_match'    => $date_match,
            ':phase'         => $phase,
            ':score_dom'     => $score_dom,
            ':score_ext'     => $score_ext,
            ':id'            => $id,
        ]);

        header('Location: /admin/matchs/liste.php?message=modifie');
        exit;
    }
}

// Valeurs du formulaire
$valeurs = $_POST ?: $match;
$date_format = date('Y-m-d\TH:i', strtotime($match['date_match']));
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>✏️ Éditer le match #<?= $id ?></h2>
            <a href="/admin/matchs/liste.php" class="btn btn-outline"
               style="border-color:#333; color:#333;">← Retour</a>
        </div>

        <?php if (!empty($erreurs)): ?>
            <div class="alerte alerte-erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <div>❌ <?= htmlspecialchars($erreur) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Aperçu IA -->
        <div class="card mb-4">
            <div class="card-header">⚡ Aperçu IA</div>
            <div class="card-body">
                <?php if ($match['apercu_genere'] && $match['apercu_ia']): ?>
                    <div class="apercu-ia">
                        <div class="ia-badge">⚡ Aperçu généré</div>
                        <p><?= nl2br(htmlspecialchars($match['apercu_ia'])) ?></p>
                    </div>
                    <form method="POST" style="margin-top:1rem;">
                        <button type="submit" name="generer_apercu" class="btn btn-secondary">
                            🔄 Regénérer l'aperçu IA
                        </button>
                    </form>
                <?php else: ?>
                    <p style="color:#666; margin-bottom:1rem;">
                        Aucun aperçu IA généré pour ce match.
                    </p>
                    <form method="POST">
                        <button type="submit" name="generer_apercu" class="btn btn-secondary">
                            ⚡ Générer l'aperçu IA
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Formulaire édition -->
        <div class="card">
            <div class="card-header">Modifier le match</div>
            <div class="card-body">
                <form method="POST" action="/admin/matchs/edition.php?id=<?= $id ?>">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                        <div class="form-groupe">
                            <label for="equipe_dom_id">Équipe domicile *</label>
                            <select id="equipe_dom_id" name="equipe_dom_id" required>
                                <?php foreach ($equipes as $equipe): ?>
                                    <option value="<?= $equipe['id'] ?>"
                                        <?= ($valeurs['equipe_dom_id'] ?? $match['equipe_dom_id']) == $equipe['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($equipe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="equipe_ext_id">Équipe extérieure *</label>
                            <select id="equipe_ext_id" name="equipe_ext_id" required>
                                <?php foreach ($equipes as $equipe): ?>
                                    <option value="<?= $equipe['id'] ?>"
                                        <?= ($valeurs['equipe_ext_id'] ?? $match['equipe_ext_id']) == $equipe['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($equipe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="stade_id">Stade *</label>
                            <select id="stade_id" name="stade_id" required>
                                <?php foreach ($stades as $stade): ?>
                                    <option value="<?= $stade['id'] ?>"
                                        <?= ($valeurs['stade_id'] ?? $match['stade_id']) == $stade['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($stade['nom']) ?> — <?= htmlspecialchars($stade['ville']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="phase">Phase *</label>
                            <select id="phase" name="phase" required>
                                <?php foreach ($phases as $valeur_phase => $label): ?>
                                    <option value="<?= $valeur_phase ?>"
                                        <?= ($valeurs['phase'] ?? $match['phase']) === $valeur_phase ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="date_match">Date et heure *</label>
                            <input type="datetime-local" id="date_match" name="date_match"
                                   value="<?= $date_format ?>" required>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                            <div class="form-groupe">
                                <label for="score_dom">Score domicile</label>
                                <input type="number" id="score_dom" name="score_dom" min="0"
                                       value="<?= $match['score_dom'] ?? '' ?>"
                                       placeholder="—">
                            </div>
                            <div class="form-groupe">
                                <label for="score_ext">Score extérieur</label>
                                <input type="number" id="score_ext" name="score_ext" min="0"
                                       value="<?= $match['score_ext'] ?? '' ?>"
                                       placeholder="—">
                            </div>
                        </div>

                    </div>

                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <button type="submit" name="modifier" class="btn btn-primary">
                            Enregistrer les modifications
                        </button>
                        <a href="/admin/matchs/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Annuler</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>