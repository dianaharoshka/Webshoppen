<?php


require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");


$dbContext = new Database();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forest Brew | About</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://kit.fontawesome.com/0defa46c74.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css" />
    <link rel="stylesheet" href="/css/about.css" />
</head>

<body>

    <?php Nav($dbContext); ?>

    <section class="about">
        <div class="about-content">
            <h1>Welcome to Forest Brew</h1>
            <p class="intro">
                Forest Brew is a place where nature and tea meet in perfect harmony. We bring you handpicked blends from
                the finest tea gardens, carefully selected to bring you the authentic taste of nature’s bounty. At
                Forest Brew, every sip is a step closer to serenity.
            </p>
            <h2>Our Story</h2>
            <p>
                Forest Brew began as a small idea on a crisp autumn day. As a lover of nature and tea, I wanted to
                create a place where people could experience the warmth and comfort of a perfectly brewed cup of tea,
                sourced from the purest leaves grown in harmony with the earth. Today, we continue to share our passion
                for tea, offering blends that bring people closer to nature, one cup at a time.
            </p>
            <h2>Our Mission</h2>
            <p>
                Our mission is to provide our customers with exceptional tea blends that are as pure as the forest. We
                believe in sustainability, ethical sourcing, and supporting local farmers who nurture their crops with
                love and care. Every product we offer is a testament to our commitment to quality and the environment.
            </p>
            <h2>Our Values</h2>
            <p>
                At Forest Brew, we value sustainability and respect for nature. Our teas are ethically sourced, and we
                strive to minimize our environmental impact by using eco-friendly packaging and promoting sustainable
                practices throughout our business. Every step we take is towards a greener, more mindful future.
            </p>
            <h2>Join Us</h2>
            <p>
                Explore our wide range of handpicked teas and find your perfect brew. Whether you’re looking for a
                soothing cup of herbal tea or a bold black blend, we have something for every tea lover. Join us in our
                journey to celebrate the beauty of nature in every sip.
            </p>
        </div>
    </section>

    <?php Footer(); ?>

</body>

</html>