<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');

$id = $_GET['id'];
$confirmed = $_GET['confirmed'] ?? false;
$dbContext = new Database();

$product = $dbContext->getProduct($id);

if ($confirmed == true) {
    $dbContext->deleteProduct($id);
    header("Location: /admin/products");
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Forest Brew</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php Nav($dbContext); ?>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">

            <h1><?php echo $product->title; ?></h1>
            <h2>Är du säker att du vill ta bort?</h2>
            <a href="/admin/delete?id=<?php echo $id; ?>&confirmed=true" class="btn btn-danger">Ja</a>
            <a href="/admin/products" class="btn btn-primary">Nej</a>

        </div>
    </section>



    <?php Footer(); ?>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product: <strong><?php echo $product->title; ?></strong>?
                </div>
                <div class="modal-footer">

                    <a href="/admin/delete?id=<?php echo $id; ?>&confirmed=true" class="btn btn-danger">Yes, Delete</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>