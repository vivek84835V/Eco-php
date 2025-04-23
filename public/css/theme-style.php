<?php
header("Content-type: text/css");
include '../../config/config.php';
?>

body {
    background-color: <?= $theme['background_color'] ?>;
    color: <?= $theme['text_color'] ?>;
    font-family: <?= $theme['font_family'] ?>;
}

.background_color {
    background-color: <?= $theme['background_color'] ?>;
}

.text_color, .card h3, .intro-text, strong {
    color: <?= $theme['text_color'] ?>;
}

.card {
    background-color: <?= $theme['card_background'] ?>;
    border: 1px solid <?= $theme['border_color'] ?>;
    padding: 1rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-primary {
    padding: 10px 20px;
    font-size: 16px;
    font-weight: 600;
    color: <?= $theme['button_text_color'] ?>;
    background: <?= $theme['button_color'] ?>;
    border: none;
    border-radius: 12px;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    font-family: 'Outfit', sans-serif;
}

.btn-primary:hover {
    background-color: <?= $theme['hover_color'] ?>;
}

.header, .footer {
    background-color: <?= $theme['header_color'] ?>;
    color: <?= $theme['primary_color'] ?>;
}


