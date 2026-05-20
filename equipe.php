<?php
$titre_page = 'Équipe';
require_once 'includes/header.php';

/** @var \PDO $pdo */

// Vérifie que l'ID est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /equipes.php');
    exit;
}

$id = (int) $_GET['id'];

// Récupère l'équipe complète
$stmt = $pdo->prepare("
    SELECT e.*, g.nom AS groupe, c.nom AS confederation, c.code AS code_confederation
    FROM equipes e
    JOIN groupes g ON e.groupe_id = g.id
    JOIN confederations c ON e.confederation_id = c.id
    WHERE e.id = :id
");
$stmt->execute([':id' => $id]);
$equipe = $stmt->fetch();

if (!$equipe) {
    header('Location: /equipes.php');
    exit;
}

$titre_page = $equipe['nom'];

// Récupère les joueurs par poste
$stmt = $pdo->prepare("
    SELECT * FROM joueurs
    WHERE equipe_id = :id
    ORDER BY FIELD(poste, 'GB', 'DEF', 'MIL', 'ATT'), numero
");
$stmt->execute([':id' => $id]);
$joueurs = $stmt->fetchAll();

$joueurs_par_poste = [];
foreach ($joueurs as $joueur) {
    $joueurs_par_poste[$joueur['poste']][] = $joueur;
}

// Récupère les matchs de cette équipe
$stmt = $pdo->prepare("
    SELECT m.*,
           ed.nom AS equipe_dom, ed.drapeau_url AS drapeau_dom,
           ee.nom AS equipe_ext, ee.drapeau_url AS drapeau_ext,
           s.nom AS stade, s.ville
    FROM matchs m
    JOIN equipes ed ON m.equipe_dom_id = ed.id
    JOIN equipes ee ON m.equipe_ext_id = ee.id
    JOIN stades s ON m.stade_id = s.id
    WHERE m.equipe_dom_id = :id OR m.equipe_ext_id = :id
    ORDER BY m.date_match ASC
");
$stmt->execute([':id' => $id]);
$matchs = $stmt->fetchAll();

$labels_postes = [
    'GB'  => '🧤 Gardiens',
    'DEF' => '🛡️ Défenseurs',
    'MIL' => '⚙️ Milieux',
    'ATT' => '⚡ Attaquants'
];

$labels_phases = [
    'groupes'       => 'Phase de groupes',
    'huitieme'      => 'Huitième de finale',
    'quart'         => 'Quart de finale',
    'demi'          => 'Demi-finale',
    'finale_petite' => 'Match pour la 3e place',
    'finale'        => 'Finale'
];
?>

<div class="page-titre">
    <div class="container">
        <p><a href="/equipes.php" style="color:rgba(255,255,255,0.7);">← Retour aux équipes</a></p>
        <h1><?= htmlspecialchars($equipe['nom']) ?></h1>
        <p>Groupe <?= htmlspecialchars($equipe['groupe']) ?> — <?= htmlspecialchars($equipe['confederation']) ?></p>
    </div>
</div>

<div class="container">

    <!-- Infos équipe -->
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div style="display:flex; align-items:center; gap:2rem; flex-wrap:wrap;">
                <img src="<?= htmlspecialchars($equipe['drapeau_url'] ?? '') ?>"
                     alt="<?= htmlspecialchars($equipe['nom']) ?>"
                     style="width:150px; height:100px; object-fit:contain;">
                <div>
                    <h2 style="font-family:'Oswald',sans-serif; font-size:2rem; color:#1a1a2e; margin-bottom:0.5rem;">
                        <?= htmlspecialchars($equipe['nom']) ?>
                    </h2>
                    <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                        <span style="background:#1a1a2e; color:#fff; padding:0.3rem 1rem; border-radius:20px; font-size:0.9rem;">
                            Groupe <?= htmlspecialchars($equipe['groupe']) ?>
                        </span>
                        <span style="background:#e94560; color:#fff; padding:0.3rem 1rem; border-radius:20px; font-size:0.9rem;">
                            <?= htmlspecialchars($equipe['code_confederation']) ?>
                        </span>
                        <span style="background:#f5a623; color:#1a1a2e; padding:0.3rem 1rem; border-radius:20px; font-size:0.9rem; font-weight:700;">
                            <?= htmlspecialchars($equipe['code_pays']) ?>
                        </span>
                    </div>
                    <p style="margin-top:0.8rem; color:#666;">
                        <?= htmlspecialchars($equipe['confederation']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem;">

        <!-- Joueurs -->
        <div>
            <h2 style="font-family:'Oswald',sans-serif; font-size:1.5rem;
                       color:#1a1a2e; margin-bottom:1rem; padding-bottom:0.5rem;
                       border-bottom:3px solid #e94560;">
                Effectif
            </h2>

            <?php if (empty($joueurs)): ?>
                <div class="alerte alerte-info">Aucun joueur référencé.</div>
            <?php else: ?>
                <?php foreach ($labels_postes as $poste => $label): ?>
                    <?php if (!empty($joueurs_par_poste[$poste])): ?>
                        <h3 style="font-family:'Oswald',sans-serif; font-size:1.1rem;
                                   color:#666; margin:1rem 0 0.5rem;">
                            <?= $label ?>
                        </h3>
                        <table class="tableau" style="margin-bottom:0.5rem;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($joueurs_par_poste[$poste] as $joueur): ?>
                                    <tr>
                                        <td><?= $joueur['numero'] ?? '—' ?></td>
                                        <td><strong><?= htmlspecialchars($joueur['nom']) ?></strong></td>
                                        <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Matchs de l'équipe -->
        <div>
            <h2 style="font-family:'Oswald',sans-serif; font-size:1.5rem;
                       color:#1a1a2e; margin-bottom:1rem; padding-bottom:0.5rem;
                       border-bottom:3px solid #e94560;">
                Matchs
            </h2>

            <?php if (empty($matchs)): ?>
                <div class="alerte alerte-info">Aucun match programmé.</div>
            <?php else: ?>
                <?php foreach ($matchs as $match): ?>
                    <a href="/match.php?id=<?= $match['id'] ?>" style="text-decoration:none; color:inherit;">
                        <div class="match-card" style="margin-bottom:1rem;">
                            <div class="match-phase">
                                <?= $labels_phases[$match['phase']] ?? $match['phase'] ?>
                            </div>
                            <div class="match-equipes">
                                <div class="equipe">
                                    <img src="<?= htmlspecialchars($match['drapeau_dom']) ?>"
                                         alt="<?= htmlspecialchars($match['equipe_dom']) ?>">
                                    <span><?= htmlspecialchars($match['equipe_dom']) ?></span>
                                </div>
                                <div class="score <?= $match['score_dom'] === null ? 'a-venir' : '' ?>">
                                    <?php if ($match['score_dom'] !== null): ?>
                                        <?= $match['score_dom'] ?> - <?= $match['score_ext'] ?>
                                    <?php else: ?>
                                        VS
                                    <?php endif; ?>
                                </div>
                                <div class="equipe">
                                    <img src="<?= htmlspecialchars($match['drapeau_ext']) ?>"
                                         alt="<?= htmlspecialchars($match['equipe_ext']) ?>">
                                    <span><?= htmlspecialchars($match['equipe_ext']) ?></span>
                                </div>
                            </div>
                            <div class="match-infos">
                                📅 <?= date('d/m/Y à H:i', strtotime($match['date_match'])) ?><br>
                                🏟️ <?= htmlspecialchars($match['stade']) ?>, <?= htmlspecialchars($match['ville']) ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

    <div class="text-center mt-4 mb-4">
        <a href="/equipes.php" class="btn btn-outline" style="border-color:#333; color:#333;">
            ← Retour aux équipes
        </a>
    </div>

</div>

<?php require_once 'includes/footer.php'; ?>