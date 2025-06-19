<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("Models/Database.php");
require_once("components/Nav.php");
require_once("Models/Cart.php");

$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();

$dbContext = new Database();




$sessionId = session_id();
$dbContext = new Database();
$cart = new Cart($dbContext, $sessionId);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forest Brew</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/cart.css">
    <script src="https://kit.fontawesome.com/0defa46c74.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <?php Nav($dbContext); ?>

    <main class="cart-container">
        <h1>Your Shopping Cart</h1>

        <?php if (count($cart->getItems()) === 0): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart->getItems() as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item->productName) ?></td>
                            <td><?= $item->quantity ?></td>
                            <td><?= $item->productPrice ?> kr</td>
                            <td><?= $item->rowPrice ?> kr</td>
                            <td>
                                <a href="/removeFromCart?productId=<?= $item->productId ?>&fromPage=<?= urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>"
                                    class="btn">−</a>

                                <a href="/addToCart?productId=<?= $item->productId ?>&fromPage=<?= urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>"
                                    class="btn">+</a>

                                <a href="/removeFromCart?removeCount=<?= $item->quantity ?>&productId=<?= $item->productId ?>&fromPage=<?= urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>"
                                    class="btn danger">Remove</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td><strong><?= $cart->getTotalPrice() ?> kr</strong></td>
                        <td><a href="/checkout" class="btn checkout">Checkout</a></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </main>

    <?php Footer(); ?>