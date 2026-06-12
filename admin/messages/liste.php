<?php
$titre_page = 'Gestion des messages';
require_once '../../includes/header.php';
require_once '../../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

$message = $_GET['message'] ?? '';

// Marque un message comme lu si demandé
if (isset($_GET['lire']) && is_numeric($_GET['lire'])) {
    $stmt = $pdo->prepare("UPDATE messages_contact SET lu = 1 WHERE id = :id");
    $stmt->execute([':id' => (int) $_GET['lire']]);
    header('Location: /admin/messages/liste.php');
    exit;
}

$messages = $pdo->query("
    SELECT * FROM messages_contact
    ORDER BY lu ASC, date_envoi DESC
")->fetchAll();

$sujets = [
    'signaler_erreur' => 'Signaler une erreur',
    'suggestion'      => 'Suggestion',
    'autre'           => 'Autre'
];
?>

<div class="admin-layout">
    <?php require_once '../../includes/admin_sidebar.php'; ?>

    <div class="admin-content">

        <div class="admin-header">
            <h2>📩 Gestion des messages</h2>
            <span style="color:#666; font-size:0.9rem;">
                <?= count(array_filter($messages, fn($m) => !$m['lu'])) ?> non lu(s)
            </span>
        </div>

        <?php if ($message === 'supprime'): ?>
            <div class="alerte alerte-succes">✅ Message supprimé avec succès.</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body" style="padding:0; overflow-x:auto;">
                <table class="tableau">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>De</th>
                            <th>Email</th>
                            <th>Sujet</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr style="<?= !$msg['lu'] ? 'background-color:#fffbf0;' : '' ?>">
                                <td><?= $msg['id'] ?></td>
                                <td><strong><?= htmlspecialchars($msg['nom']) ?></strong></td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($msg['email']) ?>">
                                        <?= htmlspecialchars($msg['email']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span style="background:#1a1a2e; color:#fff; padding:0.2rem 0.5rem;
                                                 border-radius:4px; font-size:0.75rem;">
                                        <?= htmlspecialchars($sujets[$msg['sujet']] ?? $msg['sujet']) ?>
                                    </span>
                                </td>
                                <td style="max-width:300px;">
                                    <p style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin:0;">
                                        <?= htmlspecialchars($msg['message']) ?>
                                    </p>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?></td>
                                <td>
                                    <?php if ($msg['lu']): ?>
                                        <span style="color:#28a745;">✅ Lu</span>
                                    <?php else: ?>
                                        <span style="color:#e94560; font-weight:700;">● Non lu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <?php if (!$msg['lu']): ?>
                                            <a href="/admin/messages/liste.php?lire=<?= $msg['id'] ?>"
                                               class="btn btn-sm btn-secondary">
                                               Marquer lu
                                            </a>
                                        <?php endif; ?>
                                        <a href="/admin/messages/suppression.php?id=<?= $msg['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ce message ?')">
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