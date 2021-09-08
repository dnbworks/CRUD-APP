<?php

namespace app\controllers;

use app\Router;
use app\models\Product;



class ProductController {

    public static function index(Router $router){
        $keyword = $_GET['search'] ?? '';
        $products = $router->database->getProducts($keyword);
        $router->renderView('products/index', [
            'products' => $products,
            'keyword' => $keyword
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