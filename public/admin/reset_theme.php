<?php
session_start();
require_once '../../config/config.php';

$defaultTheme = [
    'theme_name'       => 'Default Theme',
    'primary_color'    => '#FFFFFF',
    'background_color' => '#f8f8f8',
    'font_family'      => "'Outfit', sans-serif",
    'text_color'       => '#333333',
    'header_color'     => '#0d0d0d',
    'card_background'  => '#ffffff',
    'button_color'     => '#111111',
    'button_text_color'=> '#ffffff',
    'hover_color'      => '#444444',
    'border_color'     => '#cccccc',
];

$pdo->exec("UPDATE themes SET is_active = 0");

$sql = "INSERT INTO themes (
    theme_name, primary_color, background_color, font_family,
    text_color, header_color, card_background, button_color,
    button_text_color, hover_color, border_color, is_active
) VALUES (
    :theme_name, :primary_color, :background_color, :font_family,
    :text_color, :header_color, :card_background, :button_color,
    :button_text_color, :hover_color, :border_color, 1
)";

$stmt = $pdo->prepare($sql);
$stmt->execute($defaultTheme);

$_SESSION['theme_reset_success'] = "Theme has been reset to default.";
header("Location: dashboard.php?page=themes");
exit;