<?php

function SingleProduct($prod)
{
    $id = is_array($prod) ? $prod['id'] : $prod->id;
    $title = is_array($prod) ? $prod['title'] : $prod->title;
    $price = is_array($prod) ? $prod['price'] : $prod->price;
    $image_url = is_array($prod) ? $prod['image_url'] : $prod->image_url;

    $imageSrc = !empty($image_url) ? htmlspecialchars($image_url) : '/images/default.png';
    ?>
    <div class="product-card">
        <a href="/product?id=<?= $id ?>">
            <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($title ?? '') ?>">
            <h3><?= htmlspecialchars($title ?? '') ?></h3>
        </a>
        <p class="product-price"><?= htmlspecialchars($price) ?> kr</p>
        <div class="product-footer">
            <div class="button-wrapper">
                <a class="add-to-cart-btn"
                    href="/addToCart?productId=<?= $id ?>&fromPage=<?= urlencode($_SERVER['REQUEST_URI']) ?>">
                    Add to cart
                </a>
            </div>
        </div>
    </div>
    <?php
}
?>