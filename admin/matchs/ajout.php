<?php
$titre_page = 'Ajouter un match';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$erreurs = [];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $equipe_dom_id = (int) ($_POST['equipe_dom_id'] ?? 0);
    $equipe_ext_id = (int) ($_POST['equipe_ext_id'] ?? 0);
    $stade_id      = (int) ($_POST['stade_id'] ?? 0);
    $date_match    = trim($_POST['date_match'] ?? '');
    $phase         = trim($_POST['phase'] ?? '');
    $score_dom     = $_POST['score_dom'] !== '' ? (int) $_POST['score_dom'] : null;
    $score_ext     = $_POST['score_ext'] !== '' ? (int) $_POST['score_ext'] : null;

    // Validation
    if (!$equipe_dom_id)                        $erreurs[] = 'L\'équipe domicile est obligatoire.';
    if (!$equipe_ext_id)                        $erreurs[] = 'L\'équipe extérieure est obligatoire.';
    if ($equipe_dom_id === $equipe_ext_id)      $erreurs[] = 'Les deux équipes doivent être différentes.';
    if (!$stade_id)                             $erreurs[] = 'Le stade est obligatoire.';
    if (empty($date_match))                     $erreurs[] = 'La date est obligatoire.';
    if (!array_key_exists($phase, $phases))     $erreurs[] = 'La phase est invalide.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            INSERT INTO matchs (equipe_dom_id, equipe_ext_id, stade_id, date_match, phase, score_dom, score_ext)
            VALUES (:equipe_dom_id, :equipe_ext_id, :stade_id, :date_match, :phase, :score_dom, :score_ext)
        ");
        $stmt->execute([
            ':equipe_dom_id' => $equipe_dom_id,
            ':equipe_ext_id' => $equipe_ext_id,
            ':stade_id'      => $stade_id,
            ':date_match'    => $date_match,
            ':phase'         => $phase,
            ':score_dom'     => $score_dom,
            ':score_ext'     => $score_ext,
        ]);

        header('Location: /admin/matchs/liste.php?message=ajoute');
        exit;
    }
}
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>+ Ajouter un match</h2>
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

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/admin/matchs/ajout.php">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                        <div class="form-groupe">
                            <label for="equipe_dom_id">Équipe domicile *</label>
                            <select id="equipe_dom_id" name="equipe_dom_id" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($equipes as $equipe): ?>
                                    <option value="<?= $equipe['id'] ?>"
                                        <?= (($_POST['equipe_dom_id'] ?? '') == $equipe['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($equipe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="equipe_ext_id">Équipe extérieure *</label>
                            <select id="equipe_ext_id" name="equipe_ext_id" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($equipes as $equipe): ?>
                                    <option value="<?= $equipe['id'] ?>"
                                        <?= (($_POST['equipe_ext_id'] ?? '') == $equipe['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($equipe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="stade_id">Stade *</label>
                            <select id="stade_id" name="stade_id" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($stades as $stade): ?>
                                    <option value="<?= $stade['id'] ?>"
                                        <?= (($_POST['stade_id'] ?? '') == $stade['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($stade['nom']) ?> — <?= htmlspecialchars($stade['ville']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="phase">Phase *</label>
                            <select id="phase" name="phase" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($phases as $valeur => $label): ?>
                                    <option value="<?= $valeur ?>"
                                        <?= (($_POST['phase'] ?? '') === $valeur) ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="date_match">Date et heure *</label>
                            <input type="datetime-local" id="date_match" name="date_match"
                                   value="<?= htmlspecialchars($_POST['date_match'] ?? '') ?>" required>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                            <div class="form-groupe">
                                <label for="score_dom">Score domicile</label>
                                <input type="number" id="score_dom" name="score_dom" min="0"
                                       value="<?= htmlspecialchars($_POST['score_dom'] ?? '') ?>"
                                       placeholder="—">
                            </div>
                            <div class="form-groupe">
                                <label for="score_ext">Score extérieur</label>
                                <input type="number" id="score_ext" name="score_ext" min="0"
                                       value="<?= htmlspecialchars($_POST['score_ext'] ?? '') ?>"
                                       placeholder="—">
                            </div>
                        </div>

                    </div>

                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <button type="submit" class="btn btn-primary">Ajouter le match</button>
                        <a href="/admin/matchs/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Annuler</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>