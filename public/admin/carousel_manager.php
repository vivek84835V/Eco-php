<?php
require_once '../../config/config.php'; // Make sure you have a working PDO instance in this file

$uploadDir = __DIR__ . '/../images/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$error = '';
$success = '';

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['carousel_image'])) {
    $file = $_FILES['carousel_image'];
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    $imageType = $_POST['image_type'] ?? 'main';

    if (in_array($file['type'], $allowed)) {
        $filename = time() . '_' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            $stmt = $pdo->prepare("INSERT INTO carousel_images (image_path, type, uploaded_at) VALUES (?, ?, NOW())");
            $stmt->execute([$filename, $imageType]);
            $success = "Image uploaded successfully.";
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "Invalid file type. Please upload JPG, PNG, GIF, or WEBP images.";
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $fileToDelete = basename($_GET['delete']);
    $path = $uploadDir . $fileToDelete;
    if (file_exists($path)) {
        unlink($path);
        $stmt = $pdo->prepare("DELETE FROM carousel_images WHERE image_path = ?");
        $stmt->execute([$fileToDelete]);
        $success = "Image deleted successfully.";
        header("Location: carousel_manager.php");
        exit;
    } else {
        $error = "Image not found.";
    }
}

// Fetch all images
$stmt = $pdo->query("SELECT * FROM carousel_images ORDER BY uploaded_at DESC");
$carouselImages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the latest premium image
$premiumImage = null;
foreach ($carouselImages as $img) {
    if ($img['type'] === 'premium') {
        $premiumImage = $img['image_path'];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Carousel Manager</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <div class="dash-bar">
        <h1>Carousel Manager</h1>
        <nav>
            <a href="dashboard.php" class="btn-pill">Dashboard</a>
        </nav>
    </div>

    <div class="dash-wrapper">
        <?php if (!empty($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert" style="background:#e0f8e9;color:#27ae60;border:1px solid #bfe6c5">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($premiumImage): ?>
            <div class="form-card">
                <h3>Premium Hero Image</h3>
                <img src="./images/uploads/<?= htmlspecialchars($premiumImage) ?>" alt="Premium Goggles" style="width:100%;max-width:500px;border-radius:6px;">
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form class="prod-form" action="" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <label>Upload Image</label>
                    <input type="file" name="carousel_image" required accept="image/*">
                </div>
                <div class="field">
                    <label>Image Type</label>
                    <select name="image_type">
                        <option value="main">Main Carousel</option>
                        <option value="premium">Premium Hero</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary full">Upload</button>
            </form>
        </div>

        <br><br>

        <div class="table-card">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Filename</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($carouselImages)): ?>
                        <tr>
                            <td colspan="4">No carousel images uploaded yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($carouselImages as $img): ?>
                            <tr>
                                <td>
                                    <img src="./images/uploads/<?= htmlspecialchars($img['image_path']) ?>" alt="Carousel Image" style="height:60px;border-radius:4px;">
                                </td>
                                <td><?= htmlspecialchars($img['image_path']) ?></td>
                                <td><?= htmlspecialchars($img['type']) ?></td>
                                <td>
                                    <a href="?delete=<?= urlencode($img['image_path']) ?>" class="tag delete" onclick="return confirm('Are you sure you want to delete this image?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">© <?= date('Y') ?> Luxury Goggles. All rights reserved.</div>
</body>
</html>
