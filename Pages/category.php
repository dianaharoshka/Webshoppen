<?php
// ONCE = en gång även om det blir cirkelreferenser
#include_once("Models/Products.php") - OK även om filen inte finns
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("Models/Database.php");
require_once("components/Nav.php");

$dotenv = Dotenv\Dotenv::createImmutable("."); // . is  current folder for the PAGE
$dotenv->load();

$dbContext = new Database();

$catName = $_GET['catname'] ?? "";


$sortName = "Sort by";
$sortCol = $_GET['sortCol'] ?? "id";
$sortOrder = $_GET['sortOrder'] ?? "asc";



// $products = $dbContext->getAllProducts($sortCol, $sortOrder);
$products = $dbContext->getCategoryProducts($catName, $sortCol, $sortOrder);




// $header = $catName;
// if ($catName == "") {
//     $header = "All Products";
// }

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

    <!-- Header -->
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


    <!-- Section -->
    <section class="products">
        <div class="container">
            <div class="product-grid">
                <?php foreach ($products as $prod): ?>
                    <div class="product-card">
                        <a href="/product?id=<?= $prod->id ?>">
                            <?php
                            $imageSrc = !empty($prod->image_url) ? htmlspecialchars($prod->image_url) : '/images/default.png';
                            ?>
                            <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($prod->title ?? '') ?>">
                            <h3><?= htmlspecialchars($prod->title ?? '') ?></h3>
                        </a>
                        <p class="product-price"><?= $prod->price ?> kr</p>
                        <div class="product-footer">
                            <div class="button-wrapper">
                                <a class="add-to-cart-btn" href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
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