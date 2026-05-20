<?php
$titre_page = 'Équipes';
require_once 'includes/header.php';

/** @var \PDO $pdo */

// Filtre par groupe si demandé
$groupe_filtre = isset($_GET['groupe']) ? strtoupper(trim($_GET['groupe'])) : 'tous';

// Récupère tous les groupes pour le filtre
$groupes = $pdo->query("SELECT * FROM groupes ORDER BY nom")->fetchAll();

// Récupère les équipes avec leur groupe et confédération
$sql = "
    SELECT e.*, g.nom AS groupe, c.nom AS confederation, c.code AS code_confederation
    FROM equipes e
    JOIN groupes g ON e.groupe_id = g.id
    JOIN confederations c ON e.confederation_id = c.id
";

if ($groupe_filtre !== 'tous') {
    $sql .= " WHERE g.nom = :groupe";
}

$sql .= " ORDER BY g.nom, e.nom";

$stmt = $pdo->prepare($sql);
if ($groupe_filtre !== 'tous') {
    $stmt->bindValue(':groupe', $groupe_filtre);
}
$stmt->execute();
$equipes = $stmt->fetchAll();

// Regroupe par groupe
$equipes_par_groupe = [];
foreach ($equipes as $equipe) {
    $equipes_par_groupe[$equipe['groupe']][] = $equipe;
}
?>

<div class="page-titre">
    <div class="container">
        <h1>Équipes</h1>
        <p>Les 48 équipes qualifiées pour la Coupe du Monde 2026</p>
    </div>
</div>

<div class="container">

    <!-- Filtres par groupe -->
    <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-bottom:2rem;">
        <a href="/equipes.php"
           class="btn btn-sm <?= $groupe_filtre === 'tous' ? 'btn-primary' : 'btn-outline' ?>"
           style="<?= $groupe_filtre !== 'tous' ? 'border-color:#333; color:#333;' : '' ?>">
            Tous
        </a>
        <?php foreach ($groupes as $groupe): ?>
            <a href="/equipes.php?groupe=<?= $groupe['nom'] ?>"
               class="btn btn-sm <?= $groupe_filtre === $groupe['nom'] ? 'btn-primary' : 'btn-outline' ?>"
               style="<?= $groupe_filtre !== $groupe['nom'] ? 'border-color:#333; color:#333;' : '' ?>">
                Groupe <?= htmlspecialchars($groupe['nom']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($equipes)): ?>
        <div class="alerte alerte-info">Aucune équipe trouvée.</div>
    <?php else: ?>
        <?php foreach ($equipes_par_groupe as $groupe => $liste): ?>
            <h2 style="font-family:'Oswald',sans-serif; font-size:1.5rem;
                       color:#1a1a2e; margin-bottom:1rem; padding-bottom:0.5rem;
                       border-bottom:3px solid #e94560;">
                Groupe <?= htmlspecialchars($groupe) ?>
            </h2>

            <div class="grid-4" style="margin-bottom:2rem;">
                <?php foreach ($liste as $equipe): ?>
                    <a href="/equipe.php?id=<?= $equipe['id'] ?>" style="text-decoration:none; color:inherit;">
                        <div class="equipe-card">
                            <img src="<?= htmlspecialchars($equipe['drapeau_url'] ?? '') ?>"
                                 alt="<?= htmlspecialchars($equipe['nom']) ?>">
                            <h3><?= htmlspecialchars($equipe['nom']) ?></h3>
                            <span class="groupe-badge">Groupe <?= htmlspecialchars($equipe['groupe']) ?></span>
                            <div class="confederation">
                                <?= htmlspecialchars($equipe['code_confederation']) ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?php require_once 'includes/footer.php'; ?>