<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

require_once '../../config/config.php';

$message = '';


$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: dashboard.php");
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
  header("Location: dashboard.php");
  exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $desc = trim($_POST['description']);
  $price = $_POST['price'];

  $imageName = $product['image'];
  if (!empty($_FILES['image']['name'])) {
    $imageName = time() . '_' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$imageName");
  }

  $pdo->prepare("UPDATE products SET name=?,description=?,price=?,image=? WHERE id=?")
    ->execute([$name, $desc, $price, $imageName, $id]);

  $message = "✅ Product updated successfully!";
 
  $stmt->execute([$id]);
  $product = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>

<body>

  <header class="dash-bar">
    <h1>Edit Product</h1>
    <nav>
      <a href="dashboard.php" class="btn-pill">Dashboard</a>
      <a href="logout.php" class="btn-pill danger">Logout</a>
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
          <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>

        <div class="field">
          <label>Description</label>
          <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="field">
          <label>Price ($)</label>
          <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
        </div>

        <div class="field">
          <label>Current Image</label><br>
          <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" width="120"
            style="border-radius:12px;margin:10px 0">
        </div>

        <div class="field">
          <label>New Image (optional)</label>
          <input type="file" name="image">
        </div>

        <button type="submit" class="btn-primary full">Update Product</button>
      </form>
    </section>

  </main>

</body>

</html>