<?php
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/stades/liste.php');
    exit;
}

$id = (int) $_GET['id'];

// Vérifie que le stade existe
$stmt = $pdo->prepare("SELECT id FROM stades WHERE id = :id");
$stmt->execute([':id' => $id]);

if (!$stmt->fetch()) {
    header('Location: /admin/stades/liste.php');
    exit;
}

// Vérifie qu'aucun match n'utilise ce stade
$stmt = $pdo->prepare("SELECT COUNT(*) FROM matchs WHERE stade_id = :id");
$stmt->execute([':id' => $id]);
$nb_matchs = $stmt->fetchColumn();

if ($nb_matchs > 0) {
    header('Location: /admin/stades/liste.php?message=erreur_matchs');
    exit;
}

// Suppression
$stmt = $pdo->prepare("DELETE FROM stades WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: /admin/stades/liste.php?message=supprime');
exit;