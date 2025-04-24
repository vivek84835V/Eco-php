<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../../config/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price       = $_POST['price'];

    $imageName = '';
    if (!empty($_FILES['image']['name'])) {
        $imageName = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$imageName");
    }

    $pdo->prepare("INSERT INTO products (name,description,price,image) VALUES (?,?,?,?)")
        ->execute([$name,$description,$price,$imageName]);

    $message = "✅ Product added successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

  <header class="dash-bar">
    <h1>Add Product</h1>
    <nav>
      <a href="dashboard.php" class="btn-pill">Dashboard</a>
      <a href="logout.php"   class="btn-pill danger">Logout</a>
    </nav>
  </header>

  <main class="dash-wrapper">

    <?php if ($message): ?>
      <div class="alert success"><?= $message ?></div>
    <?php endif; ?>

    
    <section class="form-card">
      <form method="POST" enctype="multipart/form-data" class="prod-form">
        <div class="field">
          <label>Product Name</label>
          <input type="text" name="name" required>
        </div>

        <div class="field">
          <label>Description</label>
          <textarea name="description" rows="4" required></textarea>
        </div>

        <div class="field">
          <label>Price ($)</label>
          <input type="number" step="0.01" name="price" required>
        </div>

        <div class="field">
          <label>Product Image</label>
          <input type="file" name="image" required>
        </div>

        <button type="submit" class="btn-primary full">Add Product</button>
      </form>
    </section>

  </main>

</body>
</html>
