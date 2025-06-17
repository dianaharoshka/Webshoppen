<?php

require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("Models/Database.php");
require_once("components/Nav.php");
require_once("components/SingleProduct.php");


$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();

$dbContext = new Database();

$catName = $_GET['catname'] ?? "";


$sortName = "Sort by";
$sortCol = $_GET['sortCol'] ?? "id";
$sortOrder = $_GET['sortOrder'] ?? "asc";




$products = $dbContext->getCategoryProducts($catName, $sortCol, $sortOrder);

$categoryDetails = $dbContext->getCategoryDetails($catName);
$header = $catName ? $categoryDetails['name'] : "All Products";
$description = $catName ? $categoryDetails['description'] : "";





if ($sortCol && $sortOrder) {
    if ($sortCol === "title" && $sortOrder === "asc") {
        $sortName = "Name A-Z";
    } elseif ($sortCol === "title" && $sortOrder === "desc") {
        $sortName = "Name Z-A";
    } elseif ($sortCol === "price" && $sortOrder === "asc") {
        $sortName = "Lowest Price";
    } elseif ($sortCol === "price" && $sortOrder === "desc") {
        $sortName = "Highest Price";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forest Brew</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/category.css">
    <script src="https://kit.fontawesome.com/0defa46c74.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <?php Nav($dbContext); ?>

    <header class="category-hero">
        <h1><?= htmlspecialchars($header); ?></h1>
        <?php if ($description): ?>
            <p><?= htmlspecialchars($description); ?></p>
        <?php endif; ?>
    </header>


    <div class="sort-dropdown">
        <button class="sort-toggle"><?= $sortName ?>▾</button>
        <ul class="sort-menu">
            <li><a href="?catname=<?= htmlspecialchars($catName) ?>&sortCol=title&sortOrder=asc">Name A-Z</a></li>
            <li><a href="?catname=<?= htmlspecialchars($catName) ?>&sortCol=title&sortOrder=desc">Name Z-A</a></li>
            <li><a href="?catname=<?= htmlspecialchars($catName) ?>&sortCol=price&sortOrder=asc">Lowest Price</a></li>
            <li><a href="?catname=<?= htmlspecialchars($catName) ?>&sortCol=price&sortOrder=desc">Highest Price</a></li>
        </ul>
    </div>

    <section class="products">
        <div class="container">
            <div class="product-grid">
                <?php foreach ($products as $prod): ?>


                    <?php SingleProduct($prod); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php Footer(); ?>

    <!-- sort by -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.querySelector(".sort-toggle");
            const menu = document.querySelector(".sort-menu");

            toggle.addEventListener("click", function (e) {
                e.stopPropagation();
                menu.classList.toggle("show");
            });

            document.addEventListener("click", function (e) {
                if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove("show");
                }
            });
        });

    </script>




</body>

</html>