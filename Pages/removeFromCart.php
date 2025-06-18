<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("Models/Database.php");
require_once("Models/Cart.php");



$productId = $_GET['productId'] ?? null;
$removeCount = $_GET['removeCount'] ?? 1;
$fromPage = $_GET['fromPage'] ?? '/';
$session_id = session_id();

if ($productId) {
    $dbContext = new Database();
    $cart = new Cart($dbContext, $session_id);

    if (isset($_GET['removeCount'])) {
        $dbContext->deleteCartItemBySession($session_id, $productId);
    } else {
        $cart->removeItem($productId, 1);
    }
}

header("Location: $fromPage");
exit;
