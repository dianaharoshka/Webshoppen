<?php

require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");

$dbContext = new Database();

$productId = $_GET['id'] ?? null;

$catName = $_GET['catname'] ?? "";
$product = $dbContext->getProductWithCategoryNameById($productId);

if ($productId === null) {
    echo "Product not found.";
    exit;
}



if (!$product) {
    echo "Product not found.";
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forest Brew</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://kit.fontawesome.com/0defa46c74.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/styles.css" />
    <link rel="stylesheet" href="/css/product.css" />
</head>

<body>

    <?php Nav($dbContext); ?>

    <main class="product-page">
        <section class="product-container">
            <div class="product-image">
                <img src="<?= htmlspecialchars($product->image_url ?? 'assets/placeholder.jpg') ?>"
                    alt="<?= htmlspecialchars($product->title) ?>" />
            </div>
            <div class="product-details">
                <h1><?= htmlspecialchars($product->title) ?></h1>
                <p><strong>Category:</strong>
                    <a href="category?catname=<?= urlencode($product->categoryName) ?>">
                        <?= htmlspecialchars($product->categoryName) ?>
                    </a>
                </p>
                <p><strong>Price:</strong> <?= htmlspecialchars($product->price) ?> kr</p>
                <p><strong>Description:</strong><br>
                    <?= nl2br(htmlspecialchars($product->description ?? 'No description available')) ?></p>

                <button class="add-to-cart-btn" onclick="alert('Added to cart (not implemented yet)')">Add to
                    Cart</button>

            </div>
        </section>
    </main>



    <?php Footer(); ?>

    <script src="js/scripts.js"></script>
</body>

</html>