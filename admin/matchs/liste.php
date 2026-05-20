<?php
$titre_page = 'Gestion des matchs';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

// Message de succès après action
$message = $_GET['message'] ?? '';

// Récupère tous les matchs
$matchs = $pdo->query("
    SELECT m.*,
           ed.nom AS equipe_dom,
           ee.nom AS equipe_ext,
           s.nom AS stade, s.ville
    FROM matchs m
    JOIN equipes ed ON m.equipe_dom_id = ed.id
    JOIN equipes ee ON m.equipe_ext_id = ee.id
    JOIN stades s ON m.stade_id = s.id
    ORDER BY m.date_match ASC
")->fetchAll();

$labels_phases = [
    'groupes'       => 'Groupes',
    'huitieme'      => '1/8',
    'quart'         => '1/4',
    'demi'          => '1/2',
    'finale_petite' => '3e place',
    'finale'        => 'Finale'
];
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>⚽ Gestion des matchs</h2>
            <a href="/admin/matchs/ajout.php" class="btn btn-primary">+ Ajouter un match</a>
        </div>

        <?php if ($message === 'ajoute'): ?>
            <div class="alerte alerte-succes">✅ Match ajouté avec succès.</div>
        <?php elseif ($message === 'modifie'): ?>
            <div class="alerte alerte-succes">✅ Match modifié avec succès.</div>
        <?php elseif ($message === 'supprime'): ?>
            <div class="alerte alerte-succes">✅ Match supprimé avec succès.</div>
        <?php elseif ($message === 'apercu'): ?>
            <div class="alerte alerte-succes">✅ Aperçu IA généré avec succès.</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body" style="padding:0; overflow-x:auto;">
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Match</th>
                            <th>Phase</th>
                            <th>Date</th>
                            <th>Stade</th>
                            <th>Score</th>
                            <th>IA</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matchs as $match): ?>
                            <tr>
                                <td><?= $match['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($match['equipe_dom']) ?></strong>
                                    vs
                                    <strong><?= htmlspecialchars($match['equipe_ext']) ?></strong>
                                </td>
                                <td>
                                    <span style="background:#1a1a2e; color:#fff; padding:0.2rem 0.5rem;
                                                 border-radius:4px; font-size:0.75rem;">
                                        <?= $labels_phases[$match['phase']] ?? $match['phase'] ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($match['date_match'])) ?></td>
                                <td><?= htmlspecialchars($match['stade']) ?></td>
                                <td>
                                    <?php if ($match['score_dom'] !== null): ?>
                                        <strong><?= $match['score_dom'] ?> - <?= $match['score_ext'] ?></strong>
                                    <?php else: ?>
                                        <span style="color:#999;">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($match['apercu_genere']): ?>
                                        <span style="color:#28a745;">✅</span>
                                    <?php else: ?>
                                        <span style="color:#dc3545;">❌</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="/admin/matchs/edition.php?id=<?= $match['id'] ?>"
                                           class="btn btn-sm btn-secondary">Éditer</a>
                                        <a href="/admin/matchs/suppression.php?id=<?= $match['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ce match ?')">
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