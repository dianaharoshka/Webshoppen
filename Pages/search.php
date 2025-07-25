<?php

require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");
require_once("Utils/SearchEngine.php");
require_once("components/SingleProduct.php");


$dbContext = new Database();

$q = $_GET['q'] ?? "";
$sortCol = $_GET['sortCol'] ?? "title";
$sortOrder = $_GET['sortOrder'] ?? "asc";



$searchEngine = new SearchEngine();


$results = $searchEngine->search($q, $sortCol, $sortOrder);
$products = $results["data"] ?? [];




$sortName = "Sort by";
if ($sortCol === "title" && $sortOrder === "asc") {
    $sortName = "Name A-Z";
} elseif ($sortCol === "title" && $sortOrder === "desc") {
    $sortName = "Name Z-A";
} elseif ($sortCol === "price" && $sortOrder === "asc") {
    $sortName = "Lowest Price";
} elseif ($sortCol === "price" && $sortOrder === "desc") {
    $sortName = "Highest Price";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Search - Forest Brew</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://kit.fontawesome.com/0defa46c74.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css" />
    <link rel="stylesheet" href="/css/category.css" />
</head>

<body>
    <?php Nav($dbContext); ?>

    <header class="category-hero">
        <h1>Search results for: "<?= htmlspecialchars($q) ?>"</h1>
    </header>

    <div class="sort-dropdown">
        <button class="sort-toggle"><?= $sortName ?>▾</button>
        <ul class="sort-menu">
            <li><a href="?q=<?= urlencode($q) ?>&sortCol=title&sortOrder=asc">Name A-Z</a></li>
            <li><a href="?q=<?= urlencode($q) ?>&sortCol=title&sortOrder=desc">Name Z-A</a></li>
            <li><a href="?q=<?= urlencode($q) ?>&sortCol=price&sortOrder=asc">Lowest Price</a></li>
            <li><a href="?q=<?= urlencode($q) ?>&sortCol=price&sortOrder=desc">Highest Price</a></li>
        </ul>
    </div>

    <section class="products">
        <div class="container">
            <div class="product-grid">
                <?php if (count($products) === 0): ?>
                    <p class="no-products">No products found.</p>
                <?php else: ?>
                    <?php foreach ($products as $prod): ?>

                        <?php SingleProduct($prod); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
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