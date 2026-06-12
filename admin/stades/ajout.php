<?php
$titre_page = 'Ajouter un stade';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$erreurs = [];

$pays_disponibles = ['USA', 'Canada', 'Mexique'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom      = trim($_POST['nom'] ?? '');
    $ville    = trim($_POST['ville'] ?? '');
    $pays     = trim($_POST['pays'] ?? '');
    $capacite = (int) ($_POST['capacite'] ?? 0);

    // Validation
    if (empty($nom))                                $erreurs[] = 'Le nom est obligatoire.';
    if (empty($ville))                              $erreurs[] = 'La ville est obligatoire.';
    if (!in_array($pays, $pays_disponibles))        $erreurs[] = 'Le pays est invalide.';
    if ($capacite <= 0)                             $erreurs[] = 'La capacité doit être supérieure à 0.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            INSERT INTO stades (nom, ville, pays, capacite)
            VALUES (:nom, :ville, :pays, :capacite)
        ");
        $stmt->execute([
            ':nom'      => $nom,
            ':ville'    => $ville,
            ':pays'     => $pays,
            ':capacite' => $capacite,
        ]);

        header('Location: /admin/stades/liste.php?message=ajoute');
        exit;
    }
}
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>+ Ajouter un stade</h2>
            <a href="/admin/stades/liste.php" class="btn btn-outline"
               style="border-color:#333; color:#333;">← Retour</a>
        </div>

        <?php if (!empty($erreurs)): ?>
            <div class="alerte alerte-erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <div>❌ <?= htmlspecialchars($erreur) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/admin/stades/ajout.php">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                        <div class="form-groupe" style="grid-column:1/-1;">
                            <label for="nom">Nom du stade *</label>
                            <input type="text" id="nom" name="nom"
                                   value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                                   placeholder="ex: MetLife Stadium" required>
                        </div>

                        <div class="form-groupe">
                            <label for="ville">Ville *</label>
                            <input type="text" id="ville" name="ville"
                                   value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>"
                                   placeholder="ex: New York / New Jersey" required>
                        </div>

                        <div class="form-groupe">
                            <label for="pays">Pays *</label>
                            <select id="pays" name="pays" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($pays_disponibles as $pays): ?>
                                    <option value="<?= $pays ?>"
                                        <?= (($_POST['pays'] ?? '') === $pays) ? 'selected' : '' ?>>
                                        <?= $pays ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="capacite">Capacité *</label>
                            <input type="number" id="capacite" name="capacite"
                                   value="<?= htmlspecialchars($_POST['capacite'] ?? '') ?>"
                                   min="1" placeholder="ex: 82500" required>
                        </div>

                    </div>

                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <button type="submit" class="btn btn-primary">Ajouter le stade</button>
                        <a href="/admin/stades/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Annuler</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>