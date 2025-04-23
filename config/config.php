<?php
// Connection URI
$uri = 'mysql://u8edijfv6lwwq9d5:WXm4IWfTsnYMHO6vZJyy@bae1lbwkaijfipy2atrl-mysql.services.clever-cloud.com:3306/bae1lbwkaijfipy2atrl';

// Parse URI into its components
$parsed_url = parse_url($uri);

// Extract components from parsed URI
$host = $parsed_url['host'];
$port = $parsed_url['port'];
$user = $parsed_url['user'];
$pass = $parsed_url['pass'];
$db = ltrim($parsed_url['path'], '/'); // Remove leading slash
$charset = 'utf8mb4';

// ✅ Create DSN (Data Source Name)
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // ✅ Attempt connection to the database
    $pdo = new PDO($dsn, $user, $pass, $options);

    // ✅ Fetch active theme from the database
    $stmt = $pdo->query("SELECT * FROM themes WHERE is_active = 1 LIMIT 1");
    $theme = $stmt->fetch();

    // ✅ Fallback default theme values if no active theme is found
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
    // Improved error handling: log or echo the error for debugging
    die("Database connection failed: " . $e->getMessage());
}
?>
