<?php

namespace app\controllers;

use app\helpers\PaginationLinks;
use app\core\Router;
use app\models\Product;



class ProductController {

    public static function index(Router $router){
        // pagination
        $page = ISSET($_GET['page']) ? $_GET['page'] : null;

        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $result_per_page = 5;
        $skip = (($current_page - 1) * $result_per_page);

        $keyword = $_GET['search'] ?? '';
        $products = $router->database->getProducts($keyword);

        $rowCount = count($products);
        $num_pages = ceil($rowCount / $result_per_page);

        $statement = " LIMIT $skip,  $result_per_page";
        $products = $router->database->getProducts($keyword, $statement);

    

        if($num_pages > 1){
            // generate pagination links
            $pagination = new PaginationLinks($current_page, $num_pages);
            $links = $pagination->generate_page_links();
        } else {
            $links = '';
        }

      
        $router->renderView('products/index', [
            'products' => $products,
            'keyword' => $keyword,
            'links' => $links
        ]);
    }

    public static function create(Router $router){
        $productData = [
            'title' => '',
            'description' => '',
            'image' => '',
            'price' => ''
        ];

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            
            if(empty($errors)){
                header('Location: /products');
                exit;
            }
          
        }

        // echo '<pre>';
        // var_dump($productData);
        // echo '</pre>';

        $router->renderView('products/create', [
            'product' => $productData,
            'errors' => $errors
        ]);

    }

    public static function update(Router $router){
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit;
        }

        $productData = $router->database->getProductById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            $product = new Product();
            $product->load($productData);
            $product->save();
            header('Location: /products');
            exit;
        }

        $router->renderView('products/update', [
            'product' => $productData
        ]);
    }

    public static function delete(Router $router)
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit;
        }

        if ($router->database->deleteProduct($id)) {
            header('Location: /products');
            exit;
        }
    }
}