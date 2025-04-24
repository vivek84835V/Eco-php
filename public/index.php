<?php
include '../config/config.php';


$stmt = $pdo->prepare("SELECT image_path FROM carousel_images WHERE type = 'premium' ORDER BY uploaded_at DESC LIMIT 1");
$stmt->execute();
$premiumImage = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Luxury Goggles</title>
    <link rel="icon" type="image/png" href="./images/logo_goggles_transparent.png" sizes="50x50" />
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/theme-style.php?v=<?= time() ?>">
    <style>
        .product-section-wrapper {
            overflow: visible;
            position: relative;
        }

        .product-grid {
            display: flex;
            gap: 15px;
            padding: 30px 40px 40px 20px;
            margin-top: 30px;
            overflow-x: auto;
            overflow-y: visible;
            scroll-behavior: smooth;
        }

        .product-grid::-webkit-scrollbar {
            display: none;
        }

        .product-grid {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .card {
            flex: 0 0 auto;
            width: 250px;
            background-color: #fff;
            padding: 12px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            transform-origin: center center;
            z-index: 1;
        }

        .card:hover {
            transform: scale(1.05);
            z-index: 10;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        .carousel-container {
            width: 100%;
            overflow: hidden;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            min-width: 100%;
            height: 550px;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <h1>Luxury Goggles</h1>
            <a href="./admin/login.php" class="headerBtn">Admin Panel</a>
        </div>
    </header>

    <main class="main-content">
        <section class="hero-section">
            <div class="carousel-container">
                <div class="carousel">
                    <?php
                    $carouselImages = glob('./images/uploads/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
                    foreach ($carouselImages as $img): ?>
                        <div class="carousel-slide">
                            <a href="#product-grid">
                                <img src="<?= htmlspecialchars($img) ?>" alt="Carousel Image">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>


        <section>
            <div class="product-section-wrapper" id="product-grid">
                <div class="container">
                    <p class="intro-text">Discover Premium Eye-wear Crafted with Perfection</p>
                    <?php
                    require_once '../app/Models/product.php';
                    $productModel = new Product($pdo);
                    $products = $productModel->getAll();
                    ?>
                    <div class="product-section-wrapper">
                        <div class="product-grid">
                            <?php foreach ($products as $product): ?>
                                <div class="card">
                                <img src="./uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                    <h3><?= $product['name'] ?></h3>
                                    <p><?= $product['description'] ?></p>
                                    <strong>$<?= $product['price'] ?></strong>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    
        <section class="premium-hero background_color">
            <div class="container premium-hero-content">
                <div class="premium-image">
                    <?php if ($premiumImage): ?>
                        <img src="./images/uploads/<?= htmlspecialchars($premiumImage) ?>" alt="Premium Goggles"
                            loading="lazy">
                    <?php else: ?>
                        <p class="primary_color">No premium image available.</p>
                    <?php endif; ?>
                </div>
                <div class="premium-text primary_color">
                    <h2>Crafted for the Bold</h2>
                    <p>
                        Our luxury goggles combine elegance and performance to match your premium lifestyle. Each piece
                        is a masterpiece, crafted with the finest materials and cutting-edge design.
                    </p>
                    <a href="#product-grid" class="btn-primary">Explore Collection</a>
                </div>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="container">
            &copy; <?= date("Y") ?> Luxury Goggles
        </div>
    </footer>

    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach(slide => slide.style.display = 'none');
            slides[index].style.display = 'block';
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalSlides;
            showSlide(currentIndex);
        }

        showSlide(currentIndex);
        setInterval(nextSlide, 3000);
    </script>
</body>

</html>