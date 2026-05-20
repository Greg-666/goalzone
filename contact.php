<?php
$titre_page = 'Contact';
require_once 'includes/header.php';

/** @var \PDO $pdo */

$erreurs  = [];
$succes   = false;
$sujets   = ['signaler_erreur' => 'Signaler une erreur', 'suggestion' => 'Suggestion', 'autre' => 'Autre'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données
    $nom     = trim($_POST['nom'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $sujet   = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($nom))                          $erreurs[] = 'Le nom est obligatoire.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                                              $erreurs[] = 'L\'email est invalide.';
    if (!array_key_exists($sujet, $sujets))   $erreurs[] = 'Le sujet est invalide.';
    if (empty($message) || strlen($message) < 10)
                                              $erreurs[] = 'Le message doit faire au moins 10 caractères.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            INSERT INTO messages_contact (nom, email, sujet, message)
            VALUES (:nom, :email, :sujet, :message)
        ");
        $stmt->execute([
            ':nom'     => htmlspecialchars($nom),
            ':email'   => htmlspecialchars($email),
            ':sujet'   => $sujet,
            ':message' => htmlspecialchars($message),
        ]);
        $succes = true;
    }
}
?>

<div class="page-titre">
    <div class="container">
        <h1>Contact</h1>
        <p>Une question, une erreur à signaler ? Écrivez-nous !</p>
    </div>
</div>

<div class="container">
    <div class="form-card" style="max-width:600px;">
        <h2>Nous contacter</h2>

        <?php if ($succes): ?>
            <div class="alerte alerte-succes">
                ✅ Votre message a bien été envoyé. Merci !
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
            <form method="POST" action="/contact.php">

                <div class="form-groupe">
                    <label for="nom">Nom complet *</label>
                    <input type="text" id="nom" name="nom"
                           value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                           placeholder="Jean Dupont" required>
                </div>

                <div class="form-groupe">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           placeholder="jean.dupont@email.com" required>
                </div>

                <div class="form-groupe">
                    <label for="sujet">Sujet *</label>
                    <select id="sujet" name="sujet" required>
                        <option value="">-- Choisir un sujet --</option>
                        <?php foreach ($sujets as $valeur => $label): ?>
                            <option value="<?= $valeur ?>"
                                <?= (($_POST['sujet'] ?? '') === $valeur) ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-groupe">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message"
                              placeholder="Votre message..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">
                    Envoyer le message
                </button>

            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>