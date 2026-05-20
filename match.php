<?php
$titre_page = 'Détail du match';
require_once 'includes/header.php';
require_once 'includes/ia.php';

/** @var \PDO $pdo */

// Vérifie que l'ID est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /matchs.php');
    exit;
}

$id = (int) $_GET['id'];

// Récupère le match complet
$stmt = $pdo->prepare("
    SELECT m.*,
           ed.nom AS equipe_dom, ed.drapeau_url AS drapeau_dom,
           ed.code_pays AS code_dom,
           ee.nom AS equipe_ext, ee.drapeau_url AS drapeau_ext,
           ee.code_pays AS code_ext,
           s.nom AS stade, s.ville, s.pays AS pays_stade, s.capacite
    FROM matchs m
    JOIN equipes ed ON m.equipe_dom_id = ed.id
    JOIN equipes ee ON m.equipe_ext_id = ee.id
    JOIN stades s ON m.stade_id = s.id
    WHERE m.id = :id
");
$stmt->execute([':id' => $id]);
$match = $stmt->fetch();

// Si match introuvable, redirige
if (!$match) {
    header('Location: /matchs.php');
    exit;
}

$titre_page = $match['equipe_dom'] . ' vs ' . $match['equipe_ext'];

// Récupère les joueurs des deux équipes
$stmt = $pdo->prepare("
    SELECT * FROM joueurs 
    WHERE equipe_id = :id 
    ORDER BY FIELD(poste, 'GB', 'DEF', 'MIL', 'ATT'), numero
");

$stmt->execute([':id' => $match['equipe_dom_id']]);
$joueurs_dom = $stmt->fetchAll();

$stmt->execute([':id' => $match['equipe_ext_id']]);
$joueurs_ext = $stmt->fetchAll();

$labels_phases = [
    'groupes'       => 'Phase de groupes',
    'huitieme'      => 'Huitième de finale',
    'quart'         => 'Quart de finale',
    'demi'          => 'Demi-finale',
    'finale_petite' => 'Match pour la 3e place',
    'finale'        => 'Finale'
];

$labels_postes = [
    'GB'  => 'Gardien',
    'DEF' => 'Défenseur',
    'MIL' => 'Milieu',
    'ATT' => 'Attaquant'
];
?>

<div class="page-titre">
    <div class="container">
        <p><a href="/matchs.php" style="color:rgba(255,255,255,0.7);">← Retour aux matchs</a></p>
        <h1><?= htmlspecialchars($match['equipe_dom']) ?> vs <?= htmlspecialchars($match['equipe_ext']) ?></h1>
        <p><?= $labels_phases[$match['phase']] ?? $match['phase'] ?> — <?= date('d/m/Y à H:i', strtotime($match['date_match'])) ?></p>
    </div>
</div>

<div class="container">

    <!-- Score principal -->
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="match-equipes" style="padding:2rem 0;">
                <div class="equipe" style="flex:1; text-align:center;">
                    <img src="<?= htmlspecialchars($match['drapeau_dom']) ?>"
                         alt="<?= htmlspecialchars($match['equipe_dom']) ?>"
                         style="width:100px; height:70px; object-fit:contain; margin:0 auto 1rem;">
                    <h2 style="font-family:'Oswald',sans-serif; font-size:1.8rem;">
                        <?= htmlspecialchars($match['equipe_dom']) ?>
                    </h2>
                    <small style="color:#666;"><?= htmlspecialchars($match['code_dom']) ?></small>
                </div>

                <div style="text-align:center; min-width:150px;">
                    <?php if ($match['score_dom'] !== null): ?>
                        <div style="font-family:'Oswald',sans-serif; font-size:4rem; font-weight:700; color:#1a1a2e;">
                            <?= $match['score_dom'] ?> - <?= $match['score_ext'] ?>
                        </div>
                        <span style="background:#e94560; color:#fff; padding:0.3rem 1rem; border-radius:20px; font-size:0.85rem;">
                            Terminé
                        </span>
                    <?php else: ?>
                        <div style="font-family:'Oswald',sans-serif; font-size:3rem; color:#999;">
                            VS
                        </div>
                        <span style="background:#f5a623; color:#1a1a2e; padding:0.3rem 1rem; border-radius:20px; font-size:0.85rem; font-weight:700;">
                            À venir
                        </span>
                    <?php endif; ?>

                    <div style="margin-top:1rem; font-size:0.85rem; color:#666;">
                        🏟️ <?= htmlspecialchars($match['stade']) ?><br>
                        📍 <?= htmlspecialchars($match['ville']) ?>, <?= htmlspecialchars($match['pays_stade']) ?><br>
                        👥 <?= number_format($match['capacite'], 0, ',', ' ') ?> places
                    </div>
                </div>

                <div class="equipe" style="flex:1; text-align:center;">
                    <img src="<?= htmlspecialchars($match['drapeau_ext']) ?>"
                         alt="<?= htmlspecialchars($match['equipe_ext']) ?>"
                         style="width:100px; height:70px; object-fit:contain; margin:0 auto 1rem;">
                    <h2 style="font-family:'Oswald',sans-serif; font-size:1.8rem;">
                        <?= htmlspecialchars($match['equipe_ext']) ?>
                    </h2>
                    <small style="color:#666;"><?= htmlspecialchars($match['code_ext']) ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Aperçu IA -->
    <div class="apercu-ia">
        <div class="ia-badge">⚡ Aperçu IA</div>
        <?php if ($match['apercu_genere'] && $match['apercu_ia']): ?>
            <p><?= nl2br(htmlspecialchars($match['apercu_ia'])) ?></p>
        <?php else: ?>
            <p style="color:rgba(255,255,255,0.6); font-style:italic;">
                L'aperçu tactique IA n'a pas encore été généré pour ce match.<br>
                <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] === 'admin'): ?>
                    <a href="/admin/matchs/edition.php?id=<?= $match['id'] ?>" 
                       style="color:#f5a623; margin-top:0.5rem; display:inline-block;">
                        → Générer l'aperçu depuis le backoffice
                    </a>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Compositions -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; margin-top:2rem;">

        <!-- Équipe domicile -->
        <div class="card">
            <div class="card-header">
                🏠 <?= htmlspecialchars($match['equipe_dom']) ?>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Joueur</th>
                            <th>Poste</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($joueurs_dom as $joueur): ?>
                            <tr>
                                <td><?= $joueur['numero'] ?? '—' ?></td>
                                <td><?= htmlspecialchars($joueur['prenom'] . ' ' . $joueur['nom']) ?></td>
                                <td>
                                    <span style="background:#1a1a2e; color:#fff; padding:0.2rem 0.5rem; 
                                                 border-radius:4px; font-size:0.75rem;">
                                        <?= $labels_postes[$joueur['poste']] ?? $joueur['poste'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Équipe extérieure -->
        <div class="card">
            <div class="card-header">
                ✈️ <?= htmlspecialchars($match['equipe_ext']) ?>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Joueur</th>
                            <th>Poste</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($joueurs_ext as $joueur): ?>
                            <tr>
                                <td><?= $joueur['numero'] ?? '—' ?></td>
                                <td><?= htmlspecialchars($joueur['prenom'] . ' ' . $joueur['nom']) ?></td>
                                <td>
                                    <span style="background:#1a1a2e; color:#fff; padding:0.2rem 0.5rem; 
                                                 border-radius:4px; font-size:0.75rem;">
                                        <?= $labels_postes[$joueur['poste']] ?? $joueur['poste'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="text-center mt-4 mb-4">
        <a href="/matchs.php" class="btn btn-outline" style="border-color:#333; color:#333;">
            ← Retour aux matchs
        </a>
    </div>

</div>

<?php require_once 'includes/footer.php'; ?>