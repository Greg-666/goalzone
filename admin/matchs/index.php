<?php
session_start();
require_once('../../config/database.php');

// 🔒 Vérifier admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../connexion.php');
    exit();
}

// ✅ Récupérer tous les matchs
$stmt = $pdo->prepare("
    SELECT matchs.*, 
           equipe1.nom AS equipe1_nom, 
           equipe2.nom AS equipe2_nom
    FROM matchs
    JOIN equipes equipe1 ON matchs.equipe1_id = equipe1.id
    JOIN equipes equipe2 ON matchs.equipe2_id = equipe2.id
    ORDER BY date_match ASC
");

$stmt->execute();
$matchs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Matchs</title>
</head>
<body>

<h1>Gestion des matchs</h1>

<a href="create.php">➕ Ajouter un match</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Équipe 1</th>
        <th>Équipe 2</th>
        <th>Date</th>
        <th>Score</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($matchs as $match): ?>
    <tr>
        <td><?= $match['id'] ?></td>
        <td><?= htmlspecialchars($match['equipe1_nom']) ?></td>
        <td><?= htmlspecialchars($match['equipe2_nom']) ?></td>
        <td><?= $match['date_match'] ?></td>
        <td><?= $match['score_equipe1'] ?> - <?= $match['score_equipe2'] ?></td>

        <td>
            <!-- Modifier -->
            <a href="edit.php?id=<?= $match['id'] ?>">✏️ Modifier</a>

            <!-- Supprimer -->
            <a href="suppression.php?id=<?= $match['id'] ?>" 
               onclick="return confirm('Supprimer ce match ?');">
               🗑 Supprimer
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
