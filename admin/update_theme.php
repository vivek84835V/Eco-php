<?php
include_once('../config/config.php');

// 1. Get active theme
$stmt = $pdo->query("SELECT * FROM themes WHERE is_active = 1 LIMIT 1");
$currentTheme = $stmt->fetch(PDO::FETCH_ASSOC);

// 2. Merge POST data with current theme values
$mergedTheme = [
    'theme_name'        => $_POST['theme_name'] ?? $currentTheme['theme_name'],
    'primary_color'     => $_POST['primary_color'] ?? $currentTheme['primary_color'],
    'background_color'  => $_POST['background_color'] ?? $currentTheme['background_color'],
    'font_family'       => $_POST['font_family'] ?? $currentTheme['font_family'],
    'text_color'        => $_POST['text_color'] ?? $currentTheme['text_color'],
    'header_color'      => $_POST['header_color'] ?? $currentTheme['header_color'],
    'card_background'   => $_POST['card_background'] ?? $currentTheme['card_background'],
    'button_color'      => $_POST['button_color'] ?? $currentTheme['button_color'],
    'button_text_color' => $_POST['button_text_color'] ?? $currentTheme['button_text_color'],
    'hover_color'       => $_POST['hover_color'] ?? $currentTheme['hover_color'],
    'border_color'      => $_POST['border_color'] ?? $currentTheme['border_color'],
];

// 3. Deactivate previous themes
$pdo->query("UPDATE themes SET is_active = 0");

// 4. Insert the new theme
$stmt = $pdo->prepare("INSERT INTO themes (
    theme_name, primary_color, background_color, font_family, text_color,
    header_color, card_background, button_color, button_text_color,
    hover_color, border_color, is_active
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");

$stmt->execute([
    $mergedTheme['theme_name'],
    $mergedTheme['primary_color'],
    $mergedTheme['background_color'],
    $mergedTheme['font_family'],
    $mergedTheme['text_color'],
    $mergedTheme['header_color'],
    $mergedTheme['card_background'],
    $mergedTheme['button_color'],
    $mergedTheme['button_text_color'],
    $mergedTheme['hover_color'],
    $mergedTheme['border_color'],
]);

header("Location: dashboard.php?page=themes");
exit;
