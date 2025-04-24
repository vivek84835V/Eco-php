<?php
$host = getenv('MYSQL_ADDON_HOST');
$db = getenv('MYSQL_ADDON_DB');
$user = getenv('MYSQL_ADDON_USER');
$pass = getenv('MYSQL_ADDON_PASSWORD');
$charset = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);


    $stmt = $pdo->query("SELECT * FROM themes WHERE is_active = 1 LIMIT 1");
    $theme = $stmt->fetch();

    if (!$theme) {
        $theme = [
            'background_color' => '#f8f8f8',
            'text_color' => '#333333',
            'header_color' => '#0d0d0d',
            'card_background' => '#ffffff',
            'primary_color' => '#555555',
            'button_color' => '#111111',
            'button_text_color' => '#ffffff',
            'hover_color' => '#444444',
            'border_color' => '#cccccc',
            'font_family' => "'Outfit', sans-serif"
        ];
    }

} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>