<?php
$titre_page = 'Connexion';
require_once 'includes/header.php';
require_once 'includes/auth.php';

/** @var \PDO $pdo */

// Redirige si déjà connecté
if (est_connecte()) {
    header('Location: /index.php');
    exit;
}

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email        = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    // Validation basique
    if (empty($email) || empty($mot_de_passe)) {
        $erreurs[] = 'Veuillez remplir tous les champs.';
    }

    if (empty($erreurs)) {
        $utilisateur = authentifier_utilisateur($pdo, $email, $mot_de_passe);

        if ($utilisateur) {
            connecter_utilisateur($utilisateur);

            // Redirige selon le rôle
            if ($utilisateur['role'] === 'admin') {
                header('Location: /admin/index.php');
            } else {
                header('Location: /index.php');
            }
            exit;
        } else {
            $erreurs[] = 'Email ou mot de passe incorrect.';
        }
    }
}
?>

<div class="page-titre">
    <div class="container">
        <h1>Connexion</h1>
        <p>Accédez à votre compte GoalZone</p>
    </div>
</div>

<div class="container">
    <div class="form-card">
        <h2>Se connecter</h2>

        <?php if (!empty($erreurs)): ?>
            <div class="alerte alerte-erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <div>❌ <?= htmlspecialchars($erreur) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/connexion.php">

            <div class="form-groupe">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="jean.dupont@email.com" required>
            </div>

            <div class="form-groupe">
                <label for="mot_de_passe">Mot de passe *</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe"
                       placeholder="Votre mot de passe" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                Se connecter
            </button>

        </form>

        <p class="text-center mt-3" style="font-size:0.9rem; color:#666;">
            Pas encore de compte ? <a href="/inscription.php">S'inscrire</a>
        </p>

        <div class="alerte alerte-info mt-3" style="font-size:0.85rem;">
            <strong>Comptes de test :</strong><br>
            👑 Admin : admin@goalzone.be<br>
            👤 Membre : membre1@goalzone.be<br>
            🔑 Mot de passe : password (à remplacer en prod)
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>