</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            <div class="footer-col">
                <a href="/index.php" class="logo">
                    <span class="logo-goal">Goal</span><span class="logo-zone">Zone</span>
                </a>
                <p>Votre compagnon francophone pour suivre la Coupe du Monde 2026 aux États-Unis, Canada et Mexique.</p>
            </div>

            <div class="footer-col">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="/index.php">Accueil</a></li>
                    <li><a href="/matchs.php">Matchs</a></li>
                    <li><a href="/equipes.php">Équipes</a></li>
                    <li><a href="/contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Compte</h4>
                <ul>
                    <?php if (isset($_SESSION['utilisateur_id'])): ?>
                        <li><a href="/deconnexion.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="/connexion.php">Connexion</a></li>
                        <li><a href="/inscription.php">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Coupe du Monde 2026</h4>
                <ul>
                    <li>🇺🇸 États-Unis</li>
                    <li>🇨🇦 Canada</li>
                    <li>🇲🇽 Mexique</li>
                    <li>11 juin — 19 juillet 2026</li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> GoalZone — Projet réalisé dans le cadre de la formation PHP à l'IFAPME Charleroi.</p>
        </div>
    </div>
</footer>

<script src="/assets/js/main.js"></script>
</body>
</html>