<?php
$titre_page = 'Éditer une équipe';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/equipes/liste.php');
    exit;
}

$id      = (int) $_GET['id'];
$erreurs = [];

// Récupère l'équipe
$stmt = $pdo->prepare("SELECT * FROM equipes WHERE id = :id");
$stmt->execute([':id' => $id]);
$equipe = $stmt->fetch();

if (!$equipe) {
    header('Location: /admin/equipes/liste.php');
    exit;
}

// Récupère les groupes et confédérations
$groupes        = $pdo->query("SELECT * FROM groupes ORDER BY nom")->fetchAll();
$confederations = $pdo->query("SELECT * FROM confederations ORDER BY code")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom              = trim($_POST['nom'] ?? '');
    $code_pays        = strtoupper(trim($_POST['code_pays'] ?? ''));
    $drapeau_url      = trim($_POST['drapeau_url'] ?? '');
    $groupe_id        = (int) ($_POST['groupe_id'] ?? 0);
    $confederation_id = (int) ($_POST['confederation_id'] ?? 0);

    // Validation
    if (empty($nom))        $erreurs[] = 'Le nom est obligatoire.';
    if (empty($code_pays))  $erreurs[] = 'Le code pays est obligatoire.';
    if (!$groupe_id)        $erreurs[] = 'Le groupe est obligatoire.';
    if (!$confederation_id) $erreurs[] = 'La confédération est obligatoire.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            UPDATE equipes SET
                nom              = :nom,
                code_pays        = :code_pays,
                drapeau_url      = :drapeau_url,
                groupe_id        = :groupe_id,
                confederation_id = :confederation_id
            WHERE id = :id
        ");
        $stmt->execute([
            ':nom'              => $nom,
            ':code_pays'        => $code_pays,
            ':drapeau_url'      => $drapeau_url ?: null,
            ':groupe_id'        => $groupe_id,
            ':confederation_id' => $confederation_id,
            ':id'               => $id,
        ]);

        header('Location: /admin/equipes/liste.php?message=modifie');
        exit;
    }
}

$valeurs = $_POST ?: $equipe;
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>✏️ Éditer l'équipe #<?= $id ?></h2>
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
                <form method="POST" action="/admin/equipes/edition.php?id=<?= $id ?>">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                        <div class="form-groupe">
                            <label for="nom">Nom de l'équipe *</label>
                            <input type="text" id="nom" name="nom"
                                   value="<?= htmlspecialchars($valeurs['nom'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="form-groupe">
                            <label for="code_pays">Code pays (3 lettres) *</label>
                            <input type="text" id="code_pays" name="code_pays"
                                   value="<?= htmlspecialchars($valeurs['code_pays'] ?? '') ?>"
                                   maxlength="3" required>
                        </div>

                        <div class="form-groupe">
                            <label for="groupe_id">Groupe *</label>
                            <select id="groupe_id" name="groupe_id" required>
                                <?php foreach ($groupes as $groupe): ?>
                                    <option value="<?= $groupe['id'] ?>"
                                        <?= ($valeurs['groupe_id'] ?? $equipe['groupe_id']) == $groupe['id'] ? 'selected' : '' ?>>
                                        Groupe <?= htmlspecialchars($groupe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="confederation_id">Confédération *</label>
                            <select id="confederation_id" name="confederation_id" required>
                                <?php foreach ($confederations as $conf): ?>
                                    <option value="<?= $conf['id'] ?>"
                                        <?= ($valeurs['confederation_id'] ?? $equipe['confederation_id']) == $conf['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($conf['code']) ?> — <?= htmlspecialchars($conf['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe" style="grid-column:1/-1;">
                            <label for="drapeau_url">URL du drapeau</label>
                            <input type="url" id="drapeau_url" name="drapeau_url"
                                   value="<?= htmlspecialchars($valeurs['drapeau_url'] ?? '') ?>"
                                   placeholder="https://flagcdn.com/fr.svg">
                            <?php if (!empty($equipe['drapeau_url'])): ?>
                                <div style="margin-top:0.5rem; display:flex; align-items:center; gap:0.5rem;">
                                    <img src="<?= htmlspecialchars($equipe['drapeau_url']) ?>"
                                         alt="drapeau actuel"
                                         style="width:48px; height:32px; object-fit:contain;">
                                    <small style="color:#666;">Drapeau actuel</small>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <button type="submit" class="btn btn-primary">
                            Enregistrer les modifications
                        </button>
                        <a href="/admin/equipes/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Annuler</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>