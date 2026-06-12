<?php
$titre_page = 'Connexion Admin';
require_once '../includes/header.php';
require_once '../includes/auth.php';

/** @var \PDO $pdo */

// Redirige si déjà connecté en tant qu'admin
if (est_connecte() && est_admin()) {
    header('Location: /admin/index.php');
    exit;
}

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email        = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if (empty($email) || empty($mot_de_passe)) {
        $erreurs[] = 'Veuillez remplir tous les champs.';
    }

    if (empty($erreurs)) {
        $utilisateur = authentifier_utilisateur($pdo, $email, $mot_de_passe);

        if ($utilisateur && $utilisateur['role'] === 'admin') {
            connecter_utilisateur($utilisateur);
            header('Location: /admin/index.php');
            exit;
        } else {
            $erreurs[] = 'Accès refusé. Identifiants incorrects ou droits insuffisants.';
        }
    }
}
?>

<div class="page-titre">
    <div class="container">
        <h1>Accès Backoffice</h1>
        <p>Réservé aux administrateurs GoalZone</p>
    </div>
</div>

<div class="container">
    <div class="form-card">
        <h2>Connexion Admin</h2>

        <div style="text-align:center; font-size:3rem; margin-bottom:1rem;">🔐</div>

        <?php if (!empty($erreurs)): ?>
            <div class="alerte alerte-erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <div>❌ <?= htmlspecialchars($erreur) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/connexion.php">

            <div class="form-groupe">
                <label for="email">Email admin *</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="admin@goalzone.be" required>
            </div>

            <div class="form-groupe">
                <label for="mot_de_passe">Mot de passe *</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe"
                       placeholder="Votre mot de passe" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                Accéder au backoffice
            </button>

        </form>

        <p class="text-center mt-3" style="font-size:0.9rem;">
            <a href="/index.php" style="color:#666;">← Retour au site</a>
        </p>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>