<?php
// ============================================
// Fonctions d'authentification
// ============================================

/**
 * Vérifie si l'utilisateur est connecté
 * Redirige vers la page de connexion si ce n'est pas le cas
 */
function exiger_connexion(): void
{
    if (!isset($_SESSION['utilisateur_id'])) {
        header('Location: /connexion.php');
        exit;
    }
}

/**
 * Vérifie si l'utilisateur est admin
 * Redirige vers l'accueil si ce n'est pas le cas
 */
function exiger_admin(): void
{
    exiger_connexion();
    if ($_SESSION['utilisateur_role'] !== 'admin') {
        header('Location: /index.php');
        exit;
    }
}

/**
 * Connecte un utilisateur en session
 */
function connecter_utilisateur(array $utilisateur): void
{
    $_SESSION['utilisateur_id']    = $utilisateur['id'];
    $_SESSION['utilisateur_email'] = $utilisateur['email'];
    $_SESSION['utilisateur_role']  = $utilisateur['role'];
}

/**
 * Déconnecte l'utilisateur et détruit la session
 */
function deconnecter_utilisateur(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    session_destroy();
}

/**
 * Inscrit un nouvel utilisateur en base
 * Retourne true si succès, false si email déjà utilisé
 */
function inscrire_utilisateur(PDO $pdo, string $email, string $mot_de_passe): bool
{
    // Vérifie si l'email existe déjà
    $stmt = $pdo->prepare('SELECT id FROM utilisateurs WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return false;
    }

    // Hash du mot de passe
    $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Insertion
    $stmt = $pdo->prepare('INSERT INTO utilisateurs (email, mot_de_passe_hash) VALUES (?, ?)');
    $stmt->execute([$email, $hash]);

    return true;
}

/**
 * Tente de connecter un utilisateur
 * Retourne le tableau utilisateur si succès, null sinon
 */
function authentifier_utilisateur(PDO $pdo, string $email, string $mot_de_passe): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?');
    $stmt->execute([$email]);
    $utilisateur = $stmt->fetch();

    if (!$utilisateur) {
        return null;
    }

    if (!password_verify($mot_de_passe, $utilisateur['mot_de_passe_hash'])) {
        return null;
    }

    return $utilisateur;
}

/**
 * Retourne true si l'utilisateur est connecté
 */
function est_connecte(): bool
{
    return isset($_SESSION['utilisateur_id']);
}

/**
 * Retourne true si l'utilisateur est admin
 */
function est_admin(): bool
{
    return isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] === 'admin';
}