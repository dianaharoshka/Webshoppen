<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("Models/Database.php");
require_once("Models/Cart.php");

$dbContext = new Database();

$productId = $_GET['productId'] ?? "";
$fromPage = $_GET['fromPage'] ?? "/";

$session_id = session_id();

$cart = new Cart($dbContext, $session_id);
$cart->addItem($productId, 1);

// if ($productId) {
//     $dbContext = new Database();
//     $cart = new Cart($dbContext, $session_id);
//     $cart->addItem($productId, 1);
// }

header("Location: $fromPage");
exit;