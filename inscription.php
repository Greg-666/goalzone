<?php
$titre_page = 'Inscription';
require_once 'includes/header.php';
require_once 'includes/auth.php';

/** @var \PDO $pdo */

// Redirige si déjà connecté
if (est_connecte()) {
    header('Location: /index.php');
    exit;
}

$erreurs = [];
$succes  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email            = trim($_POST['email'] ?? '');
    $mot_de_passe     = $_POST['mot_de_passe'] ?? '';
    $mot_de_passe_bis = $_POST['mot_de_passe_bis'] ?? '';

    // Validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $erreurs[] = 'L\'email est invalide.';

    if (strlen($mot_de_passe) < 8)
        $erreurs[] = 'Le mot de passe doit faire au moins 8 caractères.';

    if ($mot_de_passe !== $mot_de_passe_bis)
        $erreurs[] = 'Les mots de passe ne correspondent pas.';

    if (empty($erreurs)) {
        $resultat = inscrire_utilisateur($pdo, $email, $mot_de_passe);

        if ($resultat) {
            $succes = true;
        } else {
            $erreurs[] = 'Cet email est déjà utilisé.';
        }
    }
}
?>

<div class="page-titre">
    <div class="container">
        <h1>Inscription</h1>
        <p>Créez votre compte GoalZone</p>
    </div>
</div>

<div class="container">
    <div class="form-card">
        <h2>Créer un compte</h2>

        <?php if ($succes): ?>
            <div class="alerte alerte-succes">
                ✅ Compte créé avec succès !
                <a href="/connexion.php" style="font-weight:700;">→ Se connecter</a>
            </div>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div class="alerte alerte-erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <div>❌ <?= htmlspecialchars($erreur) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!$succes): ?>
            <form method="POST" action="/inscription.php">

                <div class="form-groupe">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           placeholder="jean.dupont@email.com" required>
                </div>

                <div class="form-groupe">
                    <label for="mot_de_passe">Mot de passe *</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe"
                           placeholder="Minimum 8 caractères" required>
                </div>

                <div class="form-groupe">
                    <label for="mot_de_passe_bis">Confirmer le mot de passe *</label>
                    <input type="password" id="mot_de_passe_bis" name="mot_de_passe_bis"
                           placeholder="Répétez le mot de passe" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">
                    Créer mon compte
                </button>

            </form>

            <p class="text-center mt-3" style="font-size:0.9rem; color:#666;">
                Déjà un compte ? <a href="/connexion.php">Se connecter</a>
            </p>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>