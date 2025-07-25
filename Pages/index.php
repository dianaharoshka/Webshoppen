<?php

require_once(__DIR__ . "/../Models/Product.php");
require_once(__DIR__ . "/../Models/Database.php");
require_once(__DIR__ . "/../components/Footer.php");
require_once(__DIR__ . "/../components/Nav.php");
require_once(__DIR__ . "/../components/SingleProduct.php");


$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();

$dbContext = new Database();


$popularProducts = $dbContext->getPopularProducts();
$imageSrc = !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : '/images/default.png';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forest Brew</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/header_video.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/0defa46c74.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php Nav($dbContext); ?>

    <header class="header">
        <video autoplay muted loop playsinline class="background-video">
            <source src="../video/header_video.mp4" type="video/mp4">
        </video>
        <div class="header-content">
            <h1>Forest Brew</h1>
        </div>
    </header>

    <main>
        <section class="popular-products-carousel">
            <h2>Popular Products</h2>
            <div class="carousel-wrapper">
                <button class="carousel-btn prev" aria-label="Scroll left"><i
                        class="fa-solid fa-chevron-left carousel-arrow"></i>
                </button>

                <div class="carousel-track">
                    <?php foreach ($dbContext->getPopularProducts(10) as $product): ?>

                        <?php SingleProduct($product); ?>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-btn next" aria-label="Scroll right"><i
                        class="fa-solid fa-chevron-right carousel-arrow"></i>
                </button>
            </div>
        </section>

    </main>


    <?php Footer(); ?>


    <!-- popular-products-carousel -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const track = document.querySelector('.carousel-track');
            const prevBtn = document.querySelector('.carousel-btn.prev');
            const nextBtn = document.querySelector('.carousel-btn.next');
            const scrollAmount = 270;

            let autoScroll;


            prevBtn.addEventListener('click', () => {
                track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });

            nextBtn.addEventListener('click', () => {
                track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });


            function startAutoScroll() {
                autoScroll = setInterval(() => {
                    const maxScrollLeft = track.scrollWidth - track.clientWidth;
                    if (Math.ceil(track.scrollLeft) >= maxScrollLeft) {

                        track.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    }
                }, 4000);
            }


            track.addEventListener('mouseenter', () => clearInterval(autoScroll));
            track.addEventListener('mouseleave', startAutoScroll);

            startAutoScroll();


            const cards = document.querySelectorAll('.product-card');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            cards.forEach(card => observer.observe(card));
        });
    </script>



</body>



</html>