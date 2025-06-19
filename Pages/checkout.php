<?php

require_once("vendor/autoload.php");
require_once("Models/Product.php");
require_once("Models/Database.php");
require_once("Models/Cart.php");

$dbContext = new Database();




$session_id = null;

$session_id = session_id();

$cart = new Cart($dbContext, $session_id);


\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET']);

$lineitems = [];
foreach ($cart->getItems() as $cartitem) {
    array_push($lineitems, [
        "quantity" => $cartitem->quantity,
        "price_data" => [
            "currency" => "sek",
            "unit_amount" => $cartitem->productPrice * 100,
            "product_data" => [
                "name" => $cartitem->productName
            ]
        ]

    ]);
}

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => $_ENV['STRIPE_SUCCESS_URL'],
    "cancel_url" => $_ENV['STRIPE_CANCEL_URL'],
    "locale" => "auto",
    "line_items" => $lineitems
]);

http_response_code(303);
header("Location: " . $checkout_session->url);
