<?php
$titre_page = 'Gestion des stades';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$message = $_GET['message'] ?? '';

$stades = $pdo->query("
    SELECT * FROM stades
    ORDER BY pays, ville
")->fetchAll();
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>🏟️ Gestion des stades</h2>
            <a href="/admin/stades/ajout.php" class="btn btn-primary">+ Ajouter un stade</a>
        </div>

        <?php if ($message === 'ajoute'): ?>
            <div class="alerte alerte-succes">✅ Stade ajouté avec succès.</div>
        <?php elseif ($message === 'modifie'): ?>
            <div class="alerte alerte-succes">✅ Stade modifié avec succès.</div>
        <?php elseif ($message === 'supprime'): ?>
            <div class="alerte alerte-succes">✅ Stade supprimé avec succès.</div>
        <?php elseif ($message === 'erreur_matchs'): ?>
            <div class="alerte alerte-erreur">
                ❌ Impossible de supprimer ce stade car des matchs y sont associés.
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body" style="padding:0; overflow-x:auto;">
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Ville</th>
                            <th>Pays</th>
                            <th>Capacité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stades as $stade): ?>
                            <tr>
                                <td><?= $stade['id'] ?></td>
                                <td><strong><?= htmlspecialchars($stade['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($stade['ville']) ?></td>
                                <td>
                                    <span style="background:#1a1a2e; color:#fff; padding:0.2rem 0.5rem;
                                                 border-radius:4px; font-size:0.75rem;">
                                        <?= htmlspecialchars($stade['pays']) ?>
                                    </span>
                                </td>
                                <td><?= number_format($stade['capacite'], 0, ',', ' ') ?> places</td>
                                <td>
                                    <div class="actions">
                                        <a href="/admin/stades/edition.php?id=<?= $stade['id'] ?>"
                                           class="btn btn-sm btn-secondary">Éditer</a>
                                        <a href="/admin/stades/suppression.php?id=<?= $stade['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ce stade ?')">
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