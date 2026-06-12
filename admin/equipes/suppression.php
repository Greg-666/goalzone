<?php
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/equipes/liste.php');
    exit;
}

$id = (int) $_GET['id'];

// Vérifie que l'équipe existe
$stmt = $pdo->prepare("SELECT id FROM equipes WHERE id = :id");
$stmt->execute([':id' => $id]);

if (!$stmt->fetch()) {
    header('Location: /admin/equipes/liste.php');
    exit;
}

// Suppression
$stmt = $pdo->prepare("DELETE FROM equipes WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: /admin/equipes/liste.php?message=supprime');
exit;