<?php
// Démarre la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclut la connexion à la base de données
require_once __DIR__ . '/db.php';

// Détermine la page active pour le menu
$page_actuelle = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titre_page) ? htmlspecialchars($titre_page) . ' — GoalZone' : 'GoalZone — Coupe du Monde 2026' ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="/index.php" class="logo">
            <span class="logo-goal">Goal</span><span class="logo-zone">Zone</span>
            <small>Coupe du Monde 2026</small>
        </a>

        <nav class="nav-principale">
            <ul>
                <li>
                    <a href="/index.php" <?= $page_actuelle === 'index.php' ? 'class="active"' : '' ?>>
                        Accueil
                    </a>
                </li>
                <li>
                    <a href="/matchs.php" <?= $page_actuelle === 'matchs.php' ? 'class="active"' : '' ?>>
                        Matchs
                    </a>
                </li>
                <li>
                    <a href="/equipes.php" <?= $page_actuelle === 'equipes.php' ? 'class="active"' : '' ?>>
                        Équipes
                    </a>
                </li>
                <li>
                    <a href="/contact.php" <?= $page_actuelle === 'contact.php' ? 'class="active"' : '' ?>>
                        Contact
                    </a>
                </li>
            </ul>
        </nav>

        <div class="nav-user">
            <?php if (isset($_SESSION['utilisateur_id'])): ?>
                <span class="user-email"><?= htmlspecialchars($_SESSION['utilisateur_email']) ?></span>
                <?php if ($_SESSION['utilisateur_role'] === 'admin'): ?>
                    <a href="/admin/index.php" class="btn btn-admin">Admin</a>
                <?php endif; ?>
                <a href="/deconnexion.php" class="btn btn-outline">Déconnexion</a>
            <?php else: ?>
                <a href="/connexion.php" class="btn btn-outline">Connexion</a>
                <a href="/inscription.php" class="btn btn-primary">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="site-main">