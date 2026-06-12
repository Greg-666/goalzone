<?php
$titre_page = 'Ajouter une équipe';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$erreurs = [];

// Récupère les groupes et confédérations pour les selects
$groupes       = $pdo->query("SELECT * FROM groupes ORDER BY nom")->fetchAll();
$confederations = $pdo->query("SELECT * FROM confederations ORDER BY code")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom              = trim($_POST['nom'] ?? '');
    $code_pays        = strtoupper(trim($_POST['code_pays'] ?? ''));
    $drapeau_url      = trim($_POST['drapeau_url'] ?? '');
    $groupe_id        = (int) ($_POST['groupe_id'] ?? 0);
    $confederation_id = (int) ($_POST['confederation_id'] ?? 0);

    // Validation
    if (empty($nom))              $erreurs[] = 'Le nom est obligatoire.';
    if (empty($code_pays))        $erreurs[] = 'Le code pays est obligatoire.';
    if (!$groupe_id)              $erreurs[] = 'Le groupe est obligatoire.';
    if (!$confederation_id)       $erreurs[] = 'La confédération est obligatoire.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            INSERT INTO equipes (nom, code_pays, drapeau_url, groupe_id, confederation_id)
            VALUES (:nom, :code_pays, :drapeau_url, :groupe_id, :confederation_id)
        ");
        $stmt->execute([
            ':nom'              => $nom,
            ':code_pays'        => $code_pays,
            ':drapeau_url'      => $drapeau_url ?: null,
            ':groupe_id'        => $groupe_id,
            ':confederation_id' => $confederation_id,
        ]);

        header('Location: /admin/equipes/liste.php?message=ajoute');
        exit;
    }
}
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>+ Ajouter une équipe</h2>
            <a href="/admin/equipes/liste.php" class="btn btn-outline"
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
                <form method="POST" action="/admin/equipes/ajout.php">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                        <div class="form-groupe">
                            <label for="nom">Nom de l'équipe *</label>
                            <input type="text" id="nom" name="nom"
                                   value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                                   placeholder="ex: France" required>
                        </div>

                        <div class="form-groupe">
                            <label for="code_pays">Code pays (3 lettres) *</label>
                            <input type="text" id="code_pays" name="code_pays"
                                   value="<?= htmlspecialchars($_POST['code_pays'] ?? '') ?>"
                                   placeholder="ex: FRA" maxlength="3" required>
                        </div>

                        <div class="form-groupe">
                            <label for="groupe_id">Groupe *</label>
                            <select id="groupe_id" name="groupe_id" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($groupes as $groupe): ?>
                                    <option value="<?= $groupe['id'] ?>"
                                        <?= (($_POST['groupe_id'] ?? '') == $groupe['id']) ? 'selected' : '' ?>>
                                        Groupe <?= htmlspecialchars($groupe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="confederation_id">Confédération *</label>
                            <select id="confederation_id" name="confederation_id" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($confederations as $conf): ?>
                                    <option value="<?= $conf['id'] ?>"
                                        <?= (($_POST['confederation_id'] ?? '') == $conf['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($conf['code']) ?> — <?= htmlspecialchars($conf['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe" style="grid-column:1/-1;">
                            <label for="drapeau_url">URL du drapeau</label>
                            <input type="url" id="drapeau_url" name="drapeau_url"
                                   value="<?= htmlspecialchars($_POST['drapeau_url'] ?? '') ?>"
                                   placeholder="https://flagcdn.com/fr.svg">
                            <small style="color:#666;">
                                Utilise <a href="https://flagcdn.com" target="_blank">flagcdn.com</a> 
                                — ex: https://flagcdn.com/fr.svg pour la France
                            </small>
                        </div>

                    </div>

                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <button type="submit" class="btn btn-primary">Ajouter l'équipe</button>
                        <a href="/admin/equipes/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Annuler</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>