<?php

require_once("Utils/router.php");
require_once("vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();



$router = new Router();
$router->addRoute('/', function () {
    require_once(__DIR__ . '/Pages/index.php');
});
$router->addRoute('/category', function () {
    require_once(__DIR__ . '/Pages/category.php');
});
$router->addRoute('/admin/products', function () {
    require_once(__DIR__ . '/Pages/admin.php');
});
$router->addRoute('/admin/edit', function () {
    require_once(__DIR__ . '/Pages/edit.php');
});
$router->addRoute('/admin/new', function () {
    require_once(__DIR__ . '/Pages/new.php');
});
$router->addRoute('/admin/delete', function () {
    require_once(__DIR__ . '/Pages/delete.php');
});
$router->addRoute('/product', function () {
    require_once(__DIR__ . '/Pages/product.php');
});
$router->addRoute('/search', function () {
    require_once(__DIR__ . '/Pages/search.php');
});
$router->addRoute('/about', function () {
    require_once(__DIR__ . '/Pages/about.php');
});
$router->addRoute('/api/addToCart', function () {
    require_once(__DIR__ . '/ApiCode/cart.php');
});

$router->addRoute('/cart', function () {
    require_once(__DIR__ . '/Pages/viewCart.php');
});

$router->addRoute('/addToCart', function () {
    require_once(__DIR__ . '/Pages/addToCart.php');
});

$router->dispatch();
?>