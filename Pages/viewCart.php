<?php

require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("Models/Database.php");
require_once("components/Nav.php");

$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();

$dbContext = new Database();


$userId = $_SESSION['user_id'] ?? null;
$sessionId = session_id();
$cartItems = $db->getCartItems($userId, $sessionId);
$totalPrice = 0;
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