<?php
$titre_page = 'Matchs';
require_once 'includes/header.php';

// Filtre par phase si demandé
$phase = isset($_GET['phase']) ? $_GET['phase'] : 'tous';
$phases_valides = ['tous', 'groupes', 'huitieme', 'quart', 'demi', 'finale_petite', 'finale'];
if (!in_array($phase, $phases_valides)) $phase = 'tous';

// Construction de la requête
$sql = "
    SELECT m.*,
           ed.nom AS equipe_dom, ed.drapeau_url AS drapeau_dom,
           ee.nom AS equipe_ext, ee.drapeau_url AS drapeau_ext,
           s.nom AS stade, s.ville
    FROM matchs m
    JOIN equipes ed ON m.equipe_dom_id = ed.id
    JOIN equipes ee ON m.equipe_ext_id = ee.id
    JOIN stades s ON m.stade_id = s.id
";

if ($phase !== 'tous') {
    $sql .= " WHERE m.phase = :phase";
}

$sql .= " ORDER BY m.date_match ASC";

$stmt = $pdo->prepare($sql);
if ($phase !== 'tous') {
    $stmt->bindValue(':phase', $phase);
}
$stmt->execute();
$matchs = $stmt->fetchAll();

// Regroupe par phase pour l'affichage
$matchs_par_phase = [];
foreach ($matchs as $match) {
    $matchs_par_phase[$match['phase']][] = $match;
}

$labels_phases = [
    'groupes'       => 'Phase de groupes',
    'huitieme'      => 'Huitièmes de finale',
    'quart'         => 'Quarts de finale',
    'demi'          => 'Demi-finales',
    'finale_petite' => 'Match pour la 3e place',
    'finale'        => 'Finale'
];
?>

<div class="page-titre">
    <div class="container">
        <h1>Matchs</h1>
        <p>Calendrier complet de la Coupe du Monde 2026</p>
    </div>
</div>

<div class="container">

    <!-- Filtres par phase -->
    <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-bottom:2rem;">
        <a href="/matchs.php" 
           class="btn btn-sm <?= $phase === 'tous' ? 'btn-primary' : 'btn-outline' ?>"
           style="<?= $phase !== 'tous' ? 'border-color:#333; color:#333;' : '' ?>">
            Tous
        </a>
        <?php foreach ($labels_phases as $cle => $label): ?>
            <a href="/matchs.php?phase=<?= $cle ?>" 
               class="btn btn-sm <?= $phase === $cle ? 'btn-primary' : 'btn-outline' ?>"
               style="<?= $phase !== $cle ? 'border-color:#333; color:#333;' : '' ?>">
                <?= $label ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($matchs)): ?>
        <div class="alerte alerte-info">Aucun match trouvé pour cette phase.</div>
    <?php else: ?>
        <?php foreach ($matchs_par_phase as $phase_cle => $liste): ?>
            <h2 style="font-family:'Oswald',sans-serif; font-size:1.5rem; 
                       color:#1a1a2e; margin-bottom:1rem; padding-bottom:0.5rem;
                       border-bottom:3px solid #e94560;">
                <?= $labels_phases[$phase_cle] ?? ucfirst($phase_cle) ?>
            </h2>

            <div class="grid-3" style="margin-bottom:2rem;">
                <?php foreach ($liste as $match): ?>
                    <a href="/match.php?id=<?= $match['id'] ?>" style="text-decoration:none; color:inherit;">
                        <div class="match-card">
                            <div class="match-phase"><?= $labels_phases[$match['phase']] ?? $match['phase'] ?></div>
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
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?php require_once 'includes/footer.php'; ?>