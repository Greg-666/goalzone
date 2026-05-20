<?php
$page_admin = basename($_SERVER['PHP_SELF']);
$dossier_admin = basename(dirname($_SERVER['PHP_SELF']));
?>
<aside class="admin-sidebar">
    <div style="padding:1rem 1.5rem; border-bottom:1px solid rgba(255,255,255,0.1);">
        <a href="/index.php" style="color:#f5a623; font-family:'Oswald',sans-serif; font-size:1.2rem;">
            ← GoalZone
        </a>
    </div>

    <p class="sidebar-titre">Général</p>
    <ul>
        <li>
            <a href="/admin/index.php"
               class="<?= $page_admin === 'index.php' && $dossier_admin === 'admin' ? 'active' : '' ?>">
                📊 Tableau de bord
            </a>
        </li>
    </ul>

    <p class="sidebar-titre">Gestion</p>
    <ul>
        <li>
            <a href="/admin/matchs/liste.php"
               class="<?= $dossier_admin === 'matchs' ? 'active' : '' ?>">
                ⚽ Matchs
            </a>
        </li>
        <li>
            <a href="/admin/equipes/liste.php"
               class="<?= $dossier_admin === 'equipes' ? 'active' : '' ?>">
                🏳️ Équipes
            </a>
        </li>
        <li>
            <a href="/admin/joueurs/liste.php"
               class="<?= $dossier_admin === 'joueurs' ? 'active' : '' ?>">
                👤 Joueurs
            </a>
        </li>
        <li>
            <a href="/admin/stades/liste.php"
               class="<?= $dossier_admin === 'stades' ? 'active' : '' ?>">
                🏟️ Stades
            </a>
        </li>
        <li>
            <a href="/admin/messages/liste.php"
               class="<?= $dossier_admin === 'messages' ? 'active' : '' ?>">
                📩 Messages
            </a>
        </li>
    </ul>
</aside>