<?php
class Product
{
    public $id;
    public $title;
    public $description;
    public $price;
    public $stockLevel;
    public $category_id;
    public $is_popular;
    public $image_url;
    public $categoryName;

}


// $prod = new Product(1,'Chai',18,39,'Beverages');
// $prod->title = "Stefan";
// echo $prod->title;
// a = new Product(1,'Chai',18,39,'Beverages');
// a.title = "Stefan"
// console,log(a.title)


#$allaNamn2 = Array("Stefan","Kalle","Olle")
// arr = ["Stefan","Kalle","Olle"]
// arr.forEach(function(name){console.log(name)})
// for(let name of arr){
//     console.log(name)    

// ta bort helt och hållet

// SEEDNING
// SELECT COUNT(*) FROM Products
// INSERT INTO PRODUCTS (title, price, stockLevel, categoryName) VALUES ('Chai',18,39,'Beverages')





//function getProduct($id)
//{    //function getProduct(int $id): Product | null{
// SELECT * FROM PRODUCTS WHERE ID = $id
// global $allaProdukter;

// return array_find($allaProdukter, function ($product) use ($id ) {
//     return $product->id == $id;
// });

//foreach ($allaProdukter as $product) {
//    if ($product->id == $id) {
//        return $product;
//    }
//}
// return null;
//}

// JAG SA: Arrayer = "lika" som  i JavaScript
// MAP = transformera varje element i en array till något annat
// FILTER = filtrera bort element i en array - MÅNGA
// FIND = - sök FÖRSTA elementet i en array som matchar




function getAllCategories()
{
    // SELECT DISTINCT categoryName FROM Products
// $data = $pdo->query('SELECT age FROM users')->fetchAll(PDO::FETCH_COLUMN);
/* array (
  0 => 'John',
  1 => 'Mike',
  2 => 'Mary',
  3 => 'Kathy',
)*/
    //global $allaProdukter;
    // $cats = array_map(function($product):string {return $product->categoryName;},$allaProdukter);
    // $cats = array_unique($cats);
//    cats är en array med alla produkters kategorier
    // $cats = [];
    // foreach(getAllProducts() as $product){    // en produklt i taget
    //     if(!in_array($product->categoryName,$cats)){ // finns denna produktens kategori i cats?
    //         $cats[] = $product->categoryName;     // om inte - lägg till
    //     }
    // }

    // getAllProducts()  "SSK", "Modo", "SSK", "DIF"
    // $lagen = [];
    // foreach(getAllProducts() as $lag){   // $lag = "Modo"
    //     // ! = not
    //     // if lag INTE in array
    //     if(!in_array($lag,$lagen)){
    //         array_push($lagen, $lag);   // $lagen=["SSK", "Modo", "DIF"]
    //     }
    // }






    $cats = [];
    foreach (getAllProducts() as $product) {
        if (!in_array($product->categoryName, $cats)) {
            array_push($cats, $product->categoryName);
        }
    }

    //var_dump($cats);
    return $cats;
}

function getAllProducts()
{
    // $dsn = "mysql:host=localhost;dbname=stefansshop";
    // $pdo = new PDO($dsn, "root", "hejsan123");
    // $query = $pdo->query('SELECT * FROM Products');
    // //                                  DETTA ÄR TABELLEN

    // return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
    // //                                         DETTA ÄR PHP KLASS 
//    DETTA SKA BLI EN SELECT * FROM Products
    global $allaProdukter;
    return $allaProdukter;
}
?>