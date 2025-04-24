<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

require_once '../../config/config.php';
require_once '../../app/Models/product.php';
$productModel = new Product($pdo);
$products = $productModel->getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <header class="dash-bar">
        <h1>Dashboard</h1>
        <nav>
            <a href="add_product.php" class="btn-pill primary">Add Product</a>
            <a href="./carousel_manager.php" class="btn-pill primary">Add carousel</a>
            <a href="themes.php" class="btn-pill primary">Theme&nbsp;Settings</a>
            <form action="reset_theme.php" method="POST" class="inline"
                onsubmit="return confirm('Reset to default theme?')">
                <button class="btn-pill" type="submit">Reset</button>
            </form>
            <a href="logout.php" class="btn-pill danger">Signout</a>
        </nav>
    </header>

    <main class="dash-wrapper">

        <?php if (isset($_SESSION['theme_reset_success'])): ?>
        <div class="alert success">
            <?= $_SESSION['theme_reset_success']; unset($_SESSION['theme_reset_success']); ?>
        </div>
        <?php endif; ?>

        
        <section class="table-card">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price ($)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td data-label="Image">
                            <img src="../uploads/<?= $p['image'] ?>" alt="Image" loading="lazy">
                        </td>
                        <td data-label="Name"><?= htmlspecialchars($p['name']) ?></td>
                        <td data-label="Description"><?= htmlspecialchars($p['description']) ?></td>
                        <td data-label="Price"><?= $p['price'] ?></td>
                        <td data-label="Actions">
                            <div class="btn-group">
                                <a href="edit_product.php?id=<?= $p['id'] ?>" class="tag edit">Edit</a>
                                <a href="delete_product.php?id=<?= $p['id'] ?>" class="tag delete"
                                    onclick="return confirm('Delete this product?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

</body>

</html>