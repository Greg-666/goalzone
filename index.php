<?php

$titre_page = 'Accueil';
require_once 'includes/header.php';

// Récupère les 6 prochains matchs
$stmt = $pdo->prepare("
    SELECT m.*, 
           ed.nom AS equipe_dom, ed.drapeau_url AS drapeau_dom,
           ee.nom AS equipe_ext, ee.drapeau_url AS drapeau_ext,
           s.nom AS stade, s.ville
    FROM matchs m
    JOIN equipes ed ON m.equipe_dom_id = ed.id
    JOIN equipes ee ON m.equipe_ext_id = ee.id
    JOIN stades s ON m.stade_id = s.id
    WHERE m.date_match >= NOW()
    ORDER BY m.date_match ASC
    LIMIT 6
");
$stmt->execute();
$prochains_matchs = $stmt->fetchAll();

// Récupère les groupes avec leurs équipes
$stmt = $pdo->prepare("
    SELECT g.nom AS groupe, e.id, e.nom, e.drapeau_url
    FROM groupes g
    JOIN equipes e ON e.groupe_id = g.id
    ORDER BY g.nom, e.nom
");
$stmt->execute();
$equipes_par_groupe = [];
foreach ($stmt->fetchAll() as $equipe) {
    $equipes_par_groupe[$equipe['groupe']][] = $equipe;
}

// Récupère les stats globales
$stats = [];
$stats['equipes'] = $pdo->query("SELECT COUNT(*) FROM equipes")->fetchColumn();
$stats['matchs']  = $pdo->query("SELECT COUNT(*) FROM matchs")->fetchColumn();
$stats['stades']  = $pdo->query("SELECT COUNT(*) FROM stades")->fetchColumn();
$stats['joueurs'] = $pdo->query("SELECT COUNT(*) FROM joueurs")->fetchColumn();
?>

<!-- Hero -->
<section class="hero">
    <div class="container">
        <h1>Coupe du Monde <span>2026</span></h1>
        <p>Suivez tous les matchs, équipes et résultats de la Coupe du Monde 2026 aux États-Unis, Canada et Mexique.</p>

        <div class="hero-badges">
            <span>🇺🇸 États-Unis</span>
            <span>🇨🇦 Canada</span>
            <span>🇲🇽 Mexique</span>
            <span>📅 11 juin — 19 juillet 2026</span>
            <span>⚽ 48 équipes</span>
        </div>

        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="/matchs.php" class="btn btn-primary">Voir les matchs</a>
            <a href="/equipes.php" class="btn btn-outline">Voir les équipes</a>
        </div>
    </div>
</section>

<!-- Stats -->
<section style="background-color:#16213e; padding:2rem 0;">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['equipes'] ?></div>
                <div class="stat-label">Équipes qualifiées</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['matchs'] ?></div>
                <div class="stat-label">Matchs au programme</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['stades'] ?></div>
                <div class="stat-label">Stades officiels</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['joueurs'] ?></div>
                <div class="stat-label">Joueurs référencés</div>
            </div>
        </div>
    </div>
</section>

<!-- Prochains matchs -->
<section style="padding:3rem 0;">
    <div class="container">
        <h2 style="font-family:'Oswald',sans-serif; font-size:2rem; margin-bottom:1.5rem; color:#1a1a2e;">
            Prochains matchs
        </h2>

        <?php if (empty($prochains_matchs)): ?>
            <div class="alerte alerte-info">Aucun match à venir pour le moment.</div>
        <?php else: ?>
            <div class="grid-3">
                <?php foreach ($prochains_matchs as $match): ?>
                    <a href="/match.php?id=<?= $match['id'] ?>" style="text-decoration:none; color:inherit;">
                        <div class="match-card">
                            <div class="match-phase"><?= ucfirst(htmlspecialchars($match['phase'])) ?></div>
                            <div class="match-equipes">
                                <div class="equipe">
                                    <img src="<?= htmlspecialchars($match['drapeau_dom']) ?>" 
                                         alt="<?= htmlspecialchars($match['equipe_dom']) ?>">
                                    <span><?= htmlspecialchars($match['equipe_dom']) ?></span>
                                </div>
                                <div class="score a-venir">
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
            <div class="text-center mt-4">
                <a href="/matchs.php" class="btn btn-primary">Tous les matchs</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Groupes -->
<section style="padding:3rem 0; background-color:#f0f2f5;">
    <div class="container">
        <h2 style="font-family:'Oswald',sans-serif; font-size:2rem; margin-bottom:1.5rem; color:#1a1a2e;">
            Les 12 groupes
        </h2>

        <div class="grid-4">
            <?php foreach ($equipes_par_groupe as $groupe => $equipes): ?>
                <div class="card">
                    <div class="card-header">Groupe <?= htmlspecialchars($groupe) ?></div>
                    <div class="card-body" style="padding:1rem;">
                        <?php foreach ($equipes as $equipe): ?>
                            <a href="/equipe.php?id=<?= $equipe['id'] ?>" 
                               style="display:flex; align-items:center; gap:0.6rem; padding:0.4rem 0; border-bottom:1px solid #eee; color:inherit;">
                                <img src="<?= htmlspecialchars($equipe['drapeau_url']) ?>" 
                                     alt="<?= htmlspecialchars($equipe['nom']) ?>"
                                     style="width:28px; height:20px; object-fit:contain;">
                                <span style="font-size:0.9rem;"><?= htmlspecialchars($equipe['nom']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>