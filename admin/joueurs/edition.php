<?php
$titre_page = 'Éditer un joueur';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /admin/joueurs/liste.php');
    exit;
}

$id      = (int) $_GET['id'];
$erreurs = [];

// Récupère le joueur
$stmt = $pdo->prepare("SELECT * FROM joueurs WHERE id = :id");
$stmt->execute([':id' => $id]);
$joueur = $stmt->fetch();

if (!$joueur) {
    header('Location: /admin/joueurs/liste.php');
    exit;
}

$equipes = $pdo->query("SELECT id, nom FROM equipes ORDER BY nom")->fetchAll();

$postes = [
    'GB'  => 'Gardien',
    'DEF' => 'Défenseur',
    'MIL' => 'Milieu',
    'ATT' => 'Attaquant'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom       = trim($_POST['nom'] ?? '');
    $prenom    = trim($_POST['prenom'] ?? '');
    $poste     = trim($_POST['poste'] ?? '');
    $numero    = $_POST['numero'] !== '' ? (int) $_POST['numero'] : null;
    $equipe_id = (int) ($_POST['equipe_id'] ?? 0);

    // Validation
    if (empty($nom))                        $erreurs[] = 'Le nom est obligatoire.';
    if (empty($prenom))                     $erreurs[] = 'Le prénom est obligatoire.';
    if (!array_key_exists($poste, $postes)) $erreurs[] = 'Le poste est invalide.';
    if (!$equipe_id)                        $erreurs[] = 'L\'équipe est obligatoire.';

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            UPDATE joueurs SET
                nom       = :nom,
                prenom    = :prenom,
                poste     = :poste,
                numero    = :numero,
                equipe_id = :equipe_id
            WHERE id = :id
        ");
        $stmt->execute([
            ':nom'       => $nom,
            ':prenom'    => $prenom,
            ':poste'     => $poste,
            ':numero'    => $numero,
            ':equipe_id' => $equipe_id,
            ':id'        => $id,
        ]);

        header('Location: /admin/joueurs/liste.php?message=modifie');
        exit;
    }
}

$valeurs = $_POST ?: $joueur;
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>✏️ Éditer le joueur #<?= $id ?></h2>
            <a href="/admin/joueurs/liste.php" class="btn btn-outline"
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
                <form method="POST" action="/admin/joueurs/edition.php?id=<?= $id ?>">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                        <div class="form-groupe">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom"
                                   value="<?= htmlspecialchars($valeurs['nom'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="form-groupe">
                            <label for="prenom">Prénom *</label>
                            <input type="text" id="prenom" name="prenom"
                                   value="<?= htmlspecialchars($valeurs['prenom'] ?? '') ?>"
                                   required>
                        </div>

                        <div class="form-groupe">
                            <label for="poste">Poste *</label>
                            <select id="poste" name="poste" required>
                                <?php foreach ($postes as $valeur_poste => $label): ?>
                                    <option value="<?= $valeur_poste ?>"
                                        <?= ($valeurs['poste'] ?? $joueur['poste']) === $valeur_poste ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="numero">Numéro de maillot</label>
                            <input type="number" id="numero" name="numero"
                                   value="<?= htmlspecialchars($valeurs['numero'] ?? '') ?>"
                                   min="1" max="99">
                        </div>

                        <div class="form-groupe" style="grid-column:1/-1;">
                            <label for="equipe_id">Équipe *</label>
                            <select id="equipe_id" name="equipe_id" required>
                                <?php foreach ($equipes as $equipe): ?>
                                    <option value="<?= $equipe['id'] ?>"
                                        <?= ($valeurs['equipe_id'] ?? $joueur['equipe_id']) == $equipe['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($equipe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <button type="submit" class="btn btn-primary">
                            Enregistrer les modifications
                        </button>
                        <a href="/admin/joueurs/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Annuler</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>