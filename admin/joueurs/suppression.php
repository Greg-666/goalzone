<?php
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/joueurs/liste.php');
    exit;
}

$id = (int) $_GET['id'];

// Vérifie que le joueur existe
$stmt = $pdo->prepare("SELECT id FROM joueurs WHERE id = :id");
$stmt->execute([':id' => $id]);

if (!$stmt->fetch()) {
    header('Location: /admin/joueurs/liste.php');
    exit;
}

// Suppression
$stmt = $pdo->prepare("DELETE FROM joueurs WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: /admin/joueurs/liste.php?message=supprime');
exit;