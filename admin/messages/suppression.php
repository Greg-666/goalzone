<?php
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/messages/liste.php');
    exit;
}

$id = (int) $_GET['id'];

// Vérifie que le message existe
$stmt = $pdo->prepare("SELECT id FROM messages_contact WHERE id = :id");
$stmt->execute([':id' => $id]);

if (!$stmt->fetch()) {
    header('Location: /admin/messages/liste.php');
    exit;
}

// Suppression
$stmt = $pdo->prepare("DELETE FROM messages_contact WHERE id = :id");
$stmt->execute([':id' => $id]);

header('Location: /admin/messages/liste.php?message=supprime');
exit;