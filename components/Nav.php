<?php
function Nav(Database $dbContext)
{
    ?>
    <nav>
        <div class="nav-left">
            <a href="/" class="logo">
                <img src="../images/ForestBrew_logo.png" alt="Forest Brew Logo">
            </a>
            <button class="hamburger" id="hamburger">&#9776;</button>

            <div class="nav-links" id="nav-links">
                <a href="/category">All Products</a>

                <div class="dropdown">
                    <a href="#" class="dropdown-toggle">Categories ▾</a>
                    <ul class="dropdown-menu">
                        <?php foreach ($dbContext->getAllCategories() as $cat): ?>
                            <li><a href="/category?catname=<?= $cat ?>"><?= $cat ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="/about">About</a>
            </div>

        </div>
        </div>
        <div class="nav-right">
            <form action="/search" method="GET">
                <input type="text" name="q" placeholder="Search">
            </form>
            <form method="POST" action="/cart">
                <button class="btn-cart"><i class="fa-solid fa-cart-shopping"></i></button>
            </form>
        </div>
    </nav>

    <!-- hamburger-meny -->
    <script>
        document.getElementById('hamburger').addEventListener('click', () => {
            document.getElementById('nav-links').classList.toggle('active');
        });

        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        dropdownToggle.addEventListener('click', (e) => {
            e.preventDefault();
            dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            const navLinks = document.getElementById('nav-links');
            const hamburger = document.getElementById('hamburger');

            if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
                navLinks.classList.remove('active');
            }
        });


    </script>
    <?php
}
?>