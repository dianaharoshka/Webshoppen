<?php
require_once("vendor/autoload.php");



class Database
{
    public $pdo;

    function __construct()
    {
        $host = $_ENV['HOST'];
        $db = $_ENV['DB'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASSWORD'];
        $port = $_ENV['PORT'];

        $dsn = "mysql:host=$host:$port;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);

        $this->initDatabase();
        $this->initData();


    }





    function initDatabase()
    {
        $this->pdo->query('CREATE TABLE IF NOT EXISTS Products (
            id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        stockLevel INT NOT NULL,
        category_id INT,
        is_popular TINYINT,
        image_url VARCHAR(255)           
            )');
        $this->pdo->query('CREATE TABLE IF NOT EXISTS Categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50),
            description VARCHAR(255)           
            )');
    }


    public function initData()
    {
        // Категории
        $categories = [

            ['Coffee', 'Aromatic and energizing coffee for every taste.'],
            ['Coffee machines', 'Brew your favorite coffee at home.'],
            ['Herbal teas', 'Natural and calming herbal blends.'],
            ['Tea', 'Classic and specialty teas from around the world.'],
            ['Mugs', 'Your perfect companion for hot drinks.'],
            ['Teapots', 'Brew and serve tea with elegance.']
        ];

        foreach ($categories as [$name, $desc]) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Categories WHERE name = ?");
            $stmt->execute([$name]);
            if ($stmt->fetchColumn() == 0) {
                $insert = $this->pdo->prepare("INSERT INTO Categories (name, description) VALUES (?, ?)");
                $insert->execute([$name, $desc]);
            }
        }

        // Получаем id категорий
        $categoryMap = [];
        $stmt = $this->pdo->query("SELECT id, name FROM Categories");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoryMap[$row['name']] = $row['id'];
        }

        // Проверка продуктов
        $res = $this->pdo->query("SELECT COUNT(*) FROM Products");
        if ($res->fetchColumn() > 0) {
            return;
        }

        $products = [
            ["Earl Grey Tea", "A classic blend of black tea infused with natural bergamot oil, offering a bold, citrusy flavor and a fragrant aroma — perfect for a refined tea moment any time of day.", 49.00, 95, $categoryMap['Tea'], 1, 'images/Earl_Grey_Tea.jpg'],
            ["Matcha Green Tea", "Premium ceremonial-grade matcha powder made from finely ground green tea leaves. Rich in antioxidants, it delivers a vibrant color, smooth texture, and a slightly sweet, earthy taste.", 79.00, 50, $categoryMap['Tea'], 1, 'images/matcha_tea.jpg'],
            ["Organic Oolong Tea", "A traditional semi-oxidized Chinese tea, balancing the richness of black tea with the freshness of green tea. Floral aroma and smooth, roasted flavor in every sip.", 59.00, 70, $categoryMap['Tea'], 0, 'images/oolong_tea.jpg'],
            ["Classic Black Tea", "A robust, full-bodied black tea with deep, malty notes. Ideal for morning rituals or as a base for milk tea. A timeless favorite that never goes out of style.", 39.00, 90, $categoryMap['Tea'], 0, 'images/black_tea.jpg'],
            ["Chamomile Herbal Tea", "A soothing herbal infusion made from dried chamomile flowers, known for its calming properties. Gentle floral notes make it perfect for winding down in the evening.", 29.00, 60, $categoryMap['Herbal teas'], 1, 'images/chamomile_tea.webp'],
            ["Peppermint Tea", "A refreshing and naturally caffeine-free tea made from pure peppermint leaves. Cooling, invigorating, and great for digestion or a mid-day mental boost.", 34.00, 80, $categoryMap['Herbal teas'], 1, 'images/peppermint.jpg'],
            ["Jasmine Green Tea", "Delicate green tea leaves infused with the floral fragrance of fresh jasmine blossoms. A graceful and aromatic blend that soothes the senses and uplifts the spirit.", 69.00, 40, $categoryMap['Tea'], 1, 'images/jasmine_tea.jpg'],
            ["Rooibos Tea", "Naturally caffeine-free tea from South Africa with a smooth, earthy taste and hints of vanilla. Rich in antioxidants and perfect for a calming, anytime brew.", 44.00, 75, $categoryMap['Herbal teas'], 0, 'images/rooibos_tea.jpg'],
            ["Herbal Sleep Tea", "A relaxing blend of chamomile, valerian root, and lavender. Crafted to support a restful night’s sleep naturally and peacefully, without any additives or caffeine.", 19.00, 90, $categoryMap['Herbal teas'], 1, 'images/herbal_sleep_tea.jpeg'],
            ["Arabica Coffee Beans", "100% Arabica coffee beans selected for their smooth, rich flavor and subtle acidity. Roasted to perfection for a balanced cup with sweet and fruity notes.", 99.00, 40, $categoryMap['Coffee'], 0, 'images/arabica_coffee_beans.jpg'],
            ["Espresso Roast", "Finely ground, dark-roasted beans with a bold and intense flavor profile. Ideal for a traditional espresso or as a base for lattes and cappuccinos.", 89.00, 30, $categoryMap['Coffee'], 0, 'images/cappuccino_blend.jpeg'],
            ["Cold Brew Blend", "A medium-roast blend specially crafted for cold brewing. Smooth and refreshing with low acidity, chocolatey undertones, and a naturally sweet finish.", 94.00, 35, $categoryMap['Coffee'], 0, 'images/cold_brew_blend.jpeg'],
            ["Ceramic Coffee Mug", "A simple yet elegant ceramic mug with a smooth matte finish. Comfortable to hold and just the right size for your morning coffee or evening tea.", 14.00, 200, $categoryMap['Mugs'], 0, 'images/ceramic_coffee_mug.jpg'],
            ["Stainless Steel Teapot", "Durable and stylish teapot made from high-quality stainless steel. Retains heat well and features an easy-pour spout for effortless serving.", 49.00, 50, $categoryMap['Teapots'], 0, 'images/steel_teapot.jpg'],
            ["Glass Teapot", "Elegant teapot crafted from heat-resistant borosilicate glass. Perfect for showcasing the beauty of blooming teas or herbal infusions.", 39.00, 80, $categoryMap['Teapots'], 1, 'images/glass_teapot.jpeg'],
            ["Cold Brew Coffee Maker", "Designed specifically for brewing smooth, refreshing cold brew coffee at home. Easy to use and clean, with a sleek, space-saving design.", 89.00, 25, $categoryMap['Coffee machines'], 0, 'images/coldbrew-coffemaker.jpg'],
            ["Premium Coffee Machine", "A high-end coffee machine with programmable settings and professional-grade brewing. Enjoy café-quality coffee from the comfort of your kitchen.", 499.00, 15, $categoryMap['Coffee machines'], 0, 'images/premium_coffee_machine.jpg']
        ];

        $stmt = $this->pdo->prepare("INSERT INTO Products (title, description, price, stockLevel, category_id, is_popular, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($products as $product) {
            $stmt->execute($product);
        }
    }



    function getProduct($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM Products WHERE id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $query->fetch();
    }

    public function getProductWithCategoryNameById($id)
    {
        $stmt = $this->pdo->prepare("
        SELECT 
            p.id,
            p.title,
            p.description,
            p.price,
            p.stockLevel,
            p.is_popular,
            p.image_url,
            p.category_id,
            c.name AS categoryName
        FROM Products p
        LEFT JOIN Categories c ON p.category_id = c.id
        WHERE p.id = :id
    ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject('Product');
    }


    function updateProduct($product)
    {
        $s = "UPDATE Products SET 
                title = :title,
                price = :price,
                stockLevel = :stockLevel,
                category_id = :category_id,
                image_url = :image_url,
                is_popular = :is_popular
              WHERE id = :id";

        $query = $this->pdo->prepare($s);
        $query->execute([
            'title' => $product->title,
            'price' => $product->price,
            'stockLevel' => $product->stockLevel,
            'category_id' => $product->category_id,
            'image_url' => $product->image_url,
            'is_popular' => $product->is_popular,
            'id' => $product->id
        ]);
    }

    function deleteProduct($id)
    {
        $query = $this->pdo->prepare('DELETE FROM Products WHERE id = :id');
        $query->execute(['id' => $id]);
    }


    function insertProduct($title, $description, $stockLevel, $price, $category_id, $is_popular, $image_url)
    {
        $price = number_format((float) $price, 2, '.', '');
        $sql = "INSERT INTO Products (title, description, price, stockLevel, category_id, is_popular, image_url) VALUES (:title, :description, :price, :stockLevel, :category_id, :is_popular, :image_url)";
        $query = $this->pdo->prepare($sql);
        $query->execute([
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'stockLevel' => $stockLevel,
            'category_id' => $category_id,
            'is_popular' => $is_popular,
            'image_url' => $image_url
        ]);
    }

    function searchProducts($q, $sortCol, $sortOrder)
    { // $q = oo
        if (!in_array($sortCol, ["title", "price"])) {
            $sortCol = "title";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }

        $query = $this->pdo->prepare("SELECT * FROM Products WHERE title LIKE :q OR category_id LIKE :q ORDER BY $sortCol $sortOrder"); // Products är TABELL
        $query->execute(['q' => "%$q%"]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    }


    function getAllProducts($sortCol = "id", $sortOrder = "asc")
    {
        if (!in_array($sortCol, ["id", "title", "price", "stockLevel"])) {
            $sortCol = "id";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }


        $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder");
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    }

    public function getPopularProducts($limit = 10)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products ORDER BY is_popular DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    function getAllProductsWithCategoryName($sortCol = "id", $sortOrder = "asc")
    {
        if (!in_array($sortCol, ["id", "title", "price", "stockLevel", "categoryName", "is_popular", "image_url"])) {
            $sortCol = "id";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }

        $query = $this->pdo->query("
            SELECT 
                p.id,
                p.title,
                p.price,
                p.stockLevel,
                p.is_popular,
                p.image_url,
                c.name AS categoryName
            FROM Products p
            LEFT JOIN Categories c ON p.category_id = c.id
            ORDER BY $sortCol $sortOrder
        ");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }



    function getCategoryProducts($catName, $sortCol = "id", $sortOrder = "asc")
    {
        if (!in_array($sortCol, ["id", "title", "price", "stockLevel"])) {
            $sortCol = "id";
        }
        if (!in_array($sortOrder, ["asc", "desc"])) {
            $sortOrder = "asc";
        }

        if ($catName == "") {

            $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortCol $sortOrder");
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
        }


        $query = $this->pdo->prepare("
        SELECT Products.* 
        FROM Products 
        JOIN Categories ON Products.category_id = Categories.id 
        WHERE Categories.name = :categoryName
        ORDER BY $sortCol $sortOrder
    ");
        $query->execute(['categoryName' => $catName]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    }

    function getAllCategories()
    {
        // SELECT DISTINCT categoryName FROM Products
        $data = $this->pdo->query('SELECT DISTINCT name FROM Categories')->fetchAll(PDO::FETCH_COLUMN);
        return $data;
    }

    function getAllCategoriesAdmin()
    {
        $query = $this->pdo->query("SELECT id, name FROM Categories");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function getCategoryDetails($catName)
    {
        $query = $this->pdo->prepare("
        SELECT name, description
        FROM Categories
        WHERE name = :categoryName
    ");
        $query->execute(['categoryName' => $catName]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }


}


?>