<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once('Models/Database.php');

$id = $_GET['id'];
$dbContext = new Database();
// Hämta den produkt med detta ID
$product = $dbContext->getProductWithCategoryNameById($id);
$categories = $dbContext->getAllCategoriesAdmin();

// TODO felhantering om inget produkt


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Här kommer vi när man har tryckt  på SUBMIT
    // IMORGON TISDAG SÅ UPDATE PRODUCT SET title = $_POST['title'] WHERE id = $id
    $product->title = $_POST['title'];
    $product->stockLevel = $_POST['stockLevel'];

    $product->price = $_POST['price'];
    $product->category_id = $_POST['category_id'];
    $image_url = $_POST['image_url'] ?? '';
    $dbContext->updateProduct($product);
    header("Location: /admin/products");
    exit;
} else {
    // Det är INTE ett formulär som har postats - utan man har klickat in på länk tex edit.php?id=12
}

//Kunna lagra i databas


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Forest Brew</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://kit.fontawesome.com/0defa46c74.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/styles.css" />
    <link rel="stylesheet" href="/css/edit.css" />
</head>

<body>

    <?php Nav($dbContext); ?>

    <section class="edit-section">
        <div class="edit-container">
            <h2>Edit Product</h2>

            <form method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($product->title ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" value="<?= htmlspecialchars($product->price ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="stockLevel">Stock</label>
                    <input type="text" name="stockLevel" value="<?= htmlspecialchars($product->stockLevel ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select name="category_id">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat->id ?>" <?= ($cat->id == $product->category_id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image_url">Image URL (e.g. images/coffee.jpg):</label>
                    <input type="text" name="image_url" value="<?= htmlspecialchars($product->image_url ?? '') ?>">
                </div>



                <input type="submit" value="Update Product" class="submit-btn">
            </form>
        </div>
    </section>



    <?php Footer(); ?>

    <script src="/js/scripts.js"></script>

</body>

</html>

<!-- 
<input type="text" name="title" value="<?php echo $product->title ?>">
        <input type="text" name="price" value="<?php echo $product->price ?>">
        <input type="text" name="stockLevel" value="<?php echo $product->stockLevel ?>">
        <input type="text" name="categoryName" value="<?php echo $product->categoryName ?>">
        <input type="submit" value="Uppdatera"> -->