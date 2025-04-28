<?php
require_once("Models/Product.php");
require_once("components/Footer.php");
require_once("components/Nav.php");
require_once("Models/Database.php");

$dbContext = new Database();

$sortCol = $_GET['sortCol'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";

function toggleSortOrder($col, $currentCol, $currentOrder)
{
    if ($col === $currentCol) {
        return $currentOrder === "asc" ? "desc" : "asc";
    }
    return "asc";
}

$products = $dbContext->getAllProductsWithCategoryName($sortCol, $sortOrder);
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
    <link rel="stylesheet" href="/css/admin.css" />
</head>

<body>
    <?php Nav($dbContext); ?>

    <section class="admin-section">
        <div class="admin-container">
            <a href="/admin/new" class="custom-btn create-btn">Create new</a>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>
                            Name
                            <a href="?sortCol=title&sortOrder=asc">↑</a>
                            <a href="?sortCol=title&sortOrder=desc">↓</a>
                        </th>
                        <th>
                            Category
                            <a href="?sortCol=categoryName&sortOrder=asc">↑</a>
                            <a href="?sortCol=categoryName&sortOrder=desc">↓</a>
                        </th>
                        <th>
                            Price
                            <a href="?sortCol=price&sortOrder=asc">↑</a>
                            <a href="?sortCol=price&sortOrder=desc">↓</a>
                        </th>
                        <th>
                            Stock
                            <a href="?sortCol=stockLevel&sortOrder=asc">↑</a>
                            <a href="?sortCol=stockLevel&sortOrder=desc">↓</a>
                        </th>
                        <th>Popular</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $prod) { ?>
                        <tr>
                            <td><?= htmlspecialchars($prod->title); ?></td>
                            <td><?= htmlspecialchars($prod->categoryName ?? ''); ?></td>
                            <td><?= $prod->price; ?> kr</td>
                            <td><?= $prod->stockLevel; ?></td>
                            <td><?= $prod->is_popular ? '✔️' : '❌'; ?></td>
                            <td>
                                <a href="edit?id=<?= $prod->id; ?>" class="custom-btn edit-btn">Edit</a>
                                <button class="custom-btn delete-btn"
                                    onclick="openModal(<?= $prod->id; ?>, '<?= htmlspecialchars($prod->title); ?>')">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>


    <!-- Custom Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <p>Are you sure you want to delete <strong id="modalProductTitle"></strong>?</p>
            <div class="modal-actions">
                <a id="confirmDeleteBtn" class="custom-btn delete-confirm-btn" href="#">Yes</a>
                <button class="custom-btn cancel-btn" onclick="closeModal()">Cancel</button>
            </div>
        </div>
    </div>

    <?php Footer(); ?>
    <script>
        function openModal(id, title) {
            document.getElementById("modal").style.display = "block";
            document.getElementById("modalProductTitle").textContent = title;
            document.getElementById("confirmDeleteBtn").href = `/admin/delete?id=${id}&confirmed=true`;
        }

        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }

        // Закрыть модал при клике вне окна
        window.onclick = function (event) {
            const modal = document.getElementById("modal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>