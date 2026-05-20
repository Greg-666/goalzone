<?php
$titre_page = 'Tableau de bord';
require_once '../includes/header.php';
require_once '../includes/auth.php';

/** @var \PDO $pdo */

exiger_admin();

// Statistiques globales
$stats = [
    'equipes'  => $pdo->query("SELECT COUNT(*) FROM equipes")->fetchColumn(),
    'matchs'   => $pdo->query("SELECT COUNT(*) FROM matchs")->fetchColumn(),
    'joueurs'  => $pdo->query("SELECT COUNT(*) FROM joueurs")->fetchColumn(),
    'stades'   => $pdo->query("SELECT COUNT(*) FROM stades")->fetchColumn(),
    'membres'  => $pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role = 'membre'")->fetchColumn(),
    'messages' => $pdo->query("SELECT COUNT(*) FROM messages_contact WHERE lu = 0")->fetchColumn(),
    'apercus'  => $pdo->query("SELECT COUNT(*) FROM matchs WHERE apercu_genere = 1")->fetchColumn(),
];

// 5 derniers messages non lus
$derniers_messages = $pdo->query("
    SELECT * FROM messages_contact
    WHERE lu = 0
    ORDER BY date_envoi DESC
    LIMIT 5
")->fetchAll();

// 5 prochains matchs sans aperçu IA
$matchs_sans_apercu = $pdo->query("
    SELECT m.*, 
           ed.nom AS equipe_dom,
           ee.nom AS equipe_ext
    FROM matchs m
    JOIN equipes ed ON m.equipe_dom_id = ed.id
    JOIN equipes ee ON m.equipe_ext_id = ee.id
    WHERE m.apercu_genere = 0
    ORDER BY m.date_match ASC
    LIMIT 5
")->fetchAll();
?>

<div class="admin-layout">

    <!-- Sidebar -->
    <?php require_once '../includes/admin_sidebar.php'; ?>

    <!-- Contenu -->
    <div class="admin-content">

        <div class="admin-header">
            <h2>Tableau de bord</h2>
            <span style="color:#666; font-size:0.9rem;">
                Bienvenue, <?= htmlspecialchars($_SESSION['utilisateur_email']) ?>
            </span>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['equipes'] ?></div>
                <div class="stat-label">Équipes</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['matchs'] ?></div>
                <div class="stat-label">Matchs</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['joueurs'] ?></div>
                <div class="stat-label">Joueurs</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['stades'] ?></div>
                <div class="stat-label">Stades</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre"><?= $stats['membres'] ?></div>
                <div class="stat-label">Membres inscrits</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre" style="color:#e94560;"><?= $stats['messages'] ?></div>
                <div class="stat-label">Messages non lus</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre" style="color:#f5a623;"><?= $stats['apercus'] ?></div>
                <div class="stat-label">Aperçus IA générés</div>
            </div>
            <div class="stat-card">
                <div class="stat-nombre" style="color:#28a745;">
                    <?= $stats['matchs'] - $stats['apercus'] ?>
                </div>
                <div class="stat-label">Aperçus IA manquants</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem;">

            <!-- Messages non lus -->
            <div class="card">
                <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                    <span>📩 Messages non lus</span>
                    <a href="/admin/messages/liste.php" style="color:#f5a623; font-size:0.85rem;">Voir tous →</a>
                </div>
                <div class="card-body" style="padding:0;">
                    <?php if (empty($derniers_messages)): ?>
                        <p style="padding:1rem; color:#666;">Aucun message non lu.</p>
                    <?php else: ?>
                        <table class="tableau">
                            <thead>
                                <tr>
                                    <th>De</th>
                                    <th>Sujet</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($derniers_messages as $msg): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($msg['nom']) ?></td>
                                        <td><?= htmlspecialchars($msg['sujet']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($msg['date_envoi'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Matchs sans aperçu IA -->
            <div class="card">
                <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                    <span>⚡ Matchs sans aperçu IA</span>
                    <a href="/admin/matchs/liste.php" style="color:#f5a623; font-size:0.85rem;">Voir tous →</a>
                </div>
                <div class="card-body" style="padding:0;">
                    <?php if (empty($matchs_sans_apercu)): ?>
                        <p style="padding:1rem; color:#666;">Tous les matchs ont un aperçu IA ✅</p>
                    <?php else: ?>
                        <table class="tableau">
                            <thead>
                                <tr>
                                    <th>Match</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($matchs_sans_apercu as $match): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($match['equipe_dom']) ?>
                                            vs
                                            <?= htmlspecialchars($match['equipe_ext']) ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($match['date_match'])) ?></td>
                                        <td>
                                            <a href="/admin/matchs/edition.php?id=<?= $match['id'] ?>"
                                               class="btn btn-sm btn-secondary">
                                               Générer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</div>

<?php require_once '../includes/footer.php'; ?>