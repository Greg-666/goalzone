<?php
$titre_page = 'Gestion des joueurs';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$message = $_GET['message'] ?? '';

// Filtre par équipe si demandé
$equipe_filtre = (int) ($_GET['equipe_id'] ?? 0);

// Récupère toutes les équipes pour le filtre
$equipes = $pdo->query("SELECT id, nom FROM equipes ORDER BY nom")->fetchAll();

// Requête joueurs
$sql = "
    SELECT j.*, e.nom AS equipe
    FROM joueurs j
    JOIN equipes e ON j.equipe_id = e.id
";

if ($equipe_filtre) {
    $sql .= " WHERE j.equipe_id = :equipe_id";
}

$sql .= " ORDER BY e.nom, FIELD(j.poste, 'GB', 'DEF', 'MIL', 'ATT'), j.numero";

$stmt = $pdo->prepare($sql);
if ($equipe_filtre) {
    $stmt->bindValue(':equipe_id', $equipe_filtre, PDO::PARAM_INT);
}
$stmt->execute();
$joueurs = $stmt->fetchAll();

$labels_postes = [
    'GB'  => 'Gardien',
    'DEF' => 'Défenseur',
    'MIL' => 'Milieu',
    'ATT' => 'Attaquant'
];
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>👤 Gestion des joueurs</h2>
            <a href="/admin/joueurs/ajout.php" class="btn btn-primary">+ Ajouter un joueur</a>
        </div>

        <?php if ($message === 'ajoute'): ?>
            <div class="alerte alerte-succes">✅ Joueur ajouté avec succès.</div>
        <?php elseif ($message === 'modifie'): ?>
            <div class="alerte alerte-succes">✅ Joueur modifié avec succès.</div>
        <?php elseif ($message === 'supprime'): ?>
            <div class="alerte alerte-succes">✅ Joueur supprimé avec succès.</div>
        <?php endif; ?>

        <!-- Filtre par équipe -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="/admin/joueurs/liste.php"
                      style="display:flex; gap:1rem; align-items:flex-end;">
                    <div class="form-groupe" style="margin:0; flex:1;">
                        <label for="equipe_id">Filtrer par équipe</label>
                        <select id="equipe_id" name="equipe_id">
                            <option value="">-- Toutes les équipes --</option>
                            <?php foreach ($equipes as $equipe): ?>
                                <option value="<?= $equipe['id'] ?>"
                                    <?= $equipe_filtre == $equipe['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($equipe['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <?php if ($equipe_filtre): ?>
                        <a href="/admin/joueurs/liste.php" class="btn btn-outline"
                           style="border-color:#333; color:#333;">Réinitialiser</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="padding:0; overflow-x:auto;">
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Poste</th>
                            <th>Numéro</th>
                            <th>Équipe</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($joueurs as $joueur): ?>
                            <tr>
                                <td><?= $joueur['id'] ?></td>
                                <td><strong><?= htmlspecialchars($joueur['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                                <td>
                                    <span style="background:#1a1a2e; color:#fff; padding:0.2rem 0.5rem;
                                                 border-radius:4px; font-size:0.75rem;">
                                        <?= $labels_postes[$joueur['poste']] ?? $joueur['poste'] ?>
                                    </span>
                                </td>
                                <td><?= $joueur['numero'] ?? '—' ?></td>
                                <td><?= htmlspecialchars($joueur['equipe']) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="/admin/joueurs/edition.php?id=<?= $joueur['id'] ?>"
                                           class="btn btn-sm btn-secondary">Éditer</a>
                                        <a href="/admin/joueurs/suppression.php?id=<?= $joueur['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ce joueur ?')">
                                           Supprimer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>