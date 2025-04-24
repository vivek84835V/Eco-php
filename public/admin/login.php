<?php
session_start();
require_once '../../config/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = hash('sha256', $_POST['password']);

  $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
  $stmt->execute([$username, $password]);
  $admin = $stmt->fetch();

  if ($admin) {
    $_SESSION['admin'] = $admin['username'];
    header('Location: dashboard.php');
    exit;
  }
  $error = 'Invalid credentials';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
  <style>
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      margin-top: 20px;
    }

    .back-button {
      position: relative;
      margin-top: 10px;
    }

    .header img {
      max-height: 50px;
    }

 
    .btn-primary {
      background-color: #555555;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>

<body>

  
  <header class="header">
    
    <div class="back-button">
      <a href="../index.php" class="btn-secondary">
        <button class="btn-primary">
          <span>Back to Frontend</span>
        </button>
      </a>
    </div>
  </header>

 
  <main class="login-wrapper">
    <section class="login-card">
      <h1>Welcome back<span>👋</span></h1>

      <?php if ($error): ?>
        <p class="alert error"><?= $error ?></p>
      <?php endif; ?>

      <form method="POST" autocomplete="off">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-primary">
          <span>Sign&nbsp;In</span>
        </button>
      </form>
    </section>
  </main>

  <footer class="footer">
    © <?= date('Y') ?> Your Company
  </footer>

</body>

</html>
