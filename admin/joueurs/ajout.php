<?php
$titre_page = 'Ajouter un joueur';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$erreurs = [];

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
            INSERT INTO joueurs (nom, prenom, poste, numero, equipe_id)
            VALUES (:nom, :prenom, :poste, :numero, :equipe_id)
        ");
        $stmt->execute([
            ':nom'       => $nom,
            ':prenom'    => $prenom,
            ':poste'     => $poste,
            ':numero'    => $numero,
            ':equipe_id' => $equipe_id,
        ]);

        header('Location: /admin/joueurs/liste.php?message=ajoute');
        exit;
    }
}
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>+ Ajouter un joueur</h2>
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
                <form method="POST" action="/admin/joueurs/ajout.php">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

                        <div class="form-groupe">
                            <label for="nom">Nom *</label>
                            <input type="text" id="nom" name="nom"
                                   value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                                   placeholder="ex: Mbappé" required>
                        </div>

                        <div class="form-groupe">
                            <label for="prenom">Prénom *</label>
                            <input type="text" id="prenom" name="prenom"
                                   value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                                   placeholder="ex: Kylian" required>
                        </div>

                        <div class="form-groupe">
                            <label for="poste">Poste *</label>
                            <select id="poste" name="poste" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($postes as $valeur => $label): ?>
                                    <option value="<?= $valeur ?>"
                                        <?= (($_POST['poste'] ?? '') === $valeur) ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-groupe">
                            <label for="numero">Numéro de maillot</label>
                            <input type="number" id="numero" name="numero"
                                   value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>"
                                   min="1" max="99" placeholder="ex: 10">
                        </div>

                        <div class="form-groupe" style="grid-column:1/-1;">
                            <label for="equipe_id">Équipe *</label>
                            <select id="equipe_id" name="equipe_id" required>
                                <option value="">-- Choisir une équipe --</option>
                                <?php foreach ($equipes as $equipe): ?>
                                    <option value="<?= $equipe['id'] ?>"
                                        <?= (($_POST['equipe_id'] ?? '') == $equipe['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($equipe['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <button type="submit" class="btn btn-primary">Ajouter le joueur</button>
                        <a href="/admin/joueurs/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Annuler</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>