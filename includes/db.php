// Rend $pdo accessible globalement pour Intelephense
global $pdo;
define('DB_HOST', 'adresse-ip-du-serveur');
define('DB_NAME', '5BX75_K7M_db');
define('DB_USER', '5BX75_K7M');
define('DB_PASS', 'pH3v_Wn8aF6sZ1cR');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Erreur de connexion à la base : ' . $e->getMessage());
}