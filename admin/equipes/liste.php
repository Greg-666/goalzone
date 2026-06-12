<?php
$titre_page = 'Gestion des équipes';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$message = $_GET['message'] ?? '';

$equipes = $pdo->query("
    SELECT e.*, g.nom AS groupe, c.code AS confederation
    FROM equipes e
    JOIN groupes g ON e.groupe_id = g.id
    JOIN confederations c ON e.confederation_id = c.id
    ORDER BY g.nom, e.nom
")->fetchAll();
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>🏳️ Gestion des équipes</h2>
            <a href="/admin/equipes/ajout.php" class="btn btn-primary">+ Ajouter une équipe</a>
        </div>

        <?php if ($message === 'ajoute'): ?>
            <div class="alerte alerte-succes">✅ Équipe ajoutée avec succès.</div>
        <?php elseif ($message === 'modifie'): ?>
            <div class="alerte alerte-succes">✅ Équipe modifiée avec succès.</div>
        <?php elseif ($message === 'supprime'): ?>
            <div class="alerte alerte-succes">✅ Équipe supprimée avec succès.</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body" style="padding:0; overflow-x:auto;">
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Drapeau</th>
                            <th>Nom</th>
                            <th>Code</th>
                            <th>Groupe</th>
                            <th>Confédération</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipes as $equipe): ?>
                            <tr>
                                <td><?= $equipe['id'] ?></td>
                                <td>
                                    <img src="<?= htmlspecialchars($equipe['drapeau_url'] ?? '') ?>"
                                         alt="<?= htmlspecialchars($equipe['nom']) ?>"
                                         style="width:36px; height:24px; object-fit:contain;">
                                </td>
                                <td><strong><?= htmlspecialchars($equipe['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($equipe['code_pays']) ?></td>
                                <td>
                                    <span style="background:#1a1a2e; color:#fff; padding:0.2rem 0.5rem;
                                                 border-radius:4px; font-size:0.75rem;">
                                        Groupe <?= htmlspecialchars($equipe['groupe']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($equipe['confederation']) ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="/admin/equipes/edition.php?id=<?= $equipe['id'] ?>"
                                           class="btn btn-sm btn-secondary">Éditer</a>
                                        <a href="/admin/equipes/suppression.php?id=<?= $equipe['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer cette équipe ?')">
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