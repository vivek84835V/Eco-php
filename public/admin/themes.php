<?php
include_once('../../config/config.php');
$current = $pdo->query("SELECT * FROM themes WHERE is_active = 1 LIMIT 1")->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Theme Settings</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

  <!-- top bar -->
  <header class="dash-bar">
    <h1>Theme Settings</h1>
    <nav>
      <a href="dashboard.php" class="btn-pill">Dashboard</a>
      <a href="logout.php" class="btn-pill danger">Logout</a>
    </nav>
  </header>

  <main class="dash-wrapper">

    <!-- glassy settings card -->
    <section class="form-card" style="max-width:650px">
      <form action="update_theme.php" method="POST" class="theme-form">

        <!-- theme name -->
        <div class="field">
          <label>Theme Name</label>
          <input type="text" name="theme_name" value="<?= htmlspecialchars($current['theme_name']) ?>">
        </div>

        <!-- primary color -->
        <div class="field">
          <label>Primary Color</label>
          <div class="color-field">
            <input type="color" id="primary_color" name="primary_color" value="<?= $current['primary_color'] ?>">
            <span class="swatch" style="background:<?= $current['primary_color'] ?>"></span>
          </div>
        </div>

        <!-- background -->
        <div class="field">
          <label>Background Color</label>
          <div class="color-field">
            <input type="color" id="background_color" name="background_color" value="<?= $current['background_color'] ?>">
            <span class="swatch" style="background:<?= $current['background_color'] ?>"></span>
          </div>
        </div>

        <!-- text -->
        <div class="field">
          <label>Text Color</label>
          <div class="color-field">
            <input type="color" id="text_color" name="text_color" value="<?= $current['text_color'] ?>">
            <span class="swatch" style="background:<?= $current['text_color'] ?>"></span>
          </div>
        </div>

        <!-- header -->
        <div class="field">
          <label>Header Color</label>
          <div class="color-field">
            <input type="color" id="header_color" name="header_color" value="<?= $current['header_color'] ?>">
            <span class="swatch" style="background:<?= $current['header_color'] ?>"></span>
          </div>
        </div>

        <!-- card background -->
        <div class="field">
          <label>Card Background</label>
          <div class="color-field">
            <input type="color" id="card_background" name="card_background" value="<?= $current['card_background'] ?>">
            <span class="swatch" style="background:<?= $current['card_background'] ?>"></span>
          </div>
        </div>

        <!-- button color -->
        <div class="field">
          <label>Button Color</label>
          <div class="color-field">
            <input type="color" id="button_color" name="button_color" value="<?= $current['button_color'] ?>">
            <span class="swatch" style="background:<?= $current['button_color'] ?>"></span>
          </div>
        </div>

        <!-- button text -->
        <div class="field">
          <label>Button Text Color</label>
          <div class="color-field">
            <input type="color" id="button_text_color" name="button_text_color" value="<?= $current['button_text_color'] ?>">
            <span class="swatch" style="background:<?= $current['button_text_color'] ?>"></span>
          </div>
        </div>

        <!-- hover -->
        <div class="field">
          <label>Hover Color</label>
          <div class="color-field">
            <input type="color" id="hover_color" name="hover_color" value="<?= $current['hover_color'] ?>">
            <span class="swatch" style="background:<?= $current['hover_color'] ?>"></span>
          </div>
        </div>

        <!-- border -->
        <div class="field">
          <label>Border Color</label>
          <div class="color-field">
            <input type="color" id="border_color" name="border_color" value="<?= $current['border_color'] ?>">
            <span class="swatch" style="background:<?= $current['border_color'] ?>"></span>
          </div>
        </div>

        <!-- font -->
        <div class="field">
          <label>Font Family</label>
          <select name="font_family">
            <option value="'Outfit', sans-serif" <?= $current['font_family']==="'Outfit', sans-serif"?'selected':'' ?>>Outfit</option>
            <option value="'Roboto', sans-serif" <?= $current['font_family']==="'Roboto', sans-serif"?'selected':'' ?>>Roboto</option>
            <option value="'Poppins', sans-serif"<?= $current['font_family']==="'Poppins', sans-serif"?'selected':'' ?>>Poppins</option>
          </select>
        </div>

        <button class="btn-primary full" type="submit">Save Theme</button>
      </form>

      <form action="reset_theme.php" method="POST" style="margin-top:26px;text-align:center">
        <button class="btn-pill danger" type="submit">Reset to Default</button>
      </form>
    </section>

  </main>

  <!-- live‑update color swatch -->
  <script>
    document.querySelectorAll('.color-field input[type="color"]').forEach(inp=>{
      inp.addEventListener('input',e=>{
        e.target.parentElement.querySelector('.swatch').style.background = e.target.value;
      });
    });
  </script>

</body>
</html>
