<?php
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

// Vérifie que l'ID est valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/matchs/liste.php');
    exit;
}

$id = (int) $_GET['id'];

// Vérifie que le match existe
$stmt = $pdo->prepare("SELECT id FROM matchs WHERE id = :id");
$stmt->execute([':id' => $id]);

if (!$stmt->fetch()) {
    header('Location: /admin/matchs/liste.php');
    exit;
}

// Suppression
$stmt = $pdo->prepare("DELETE FROM matchs WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: /admin/matchs/liste.php?message=supprime');
exit;