<?php

namespace app\models;

use app\helpers\UtilHelper;
use app\core\db\Database;

class Product {
    public ?int $id = null;
    public string $title;
    public string $description;
    public float $price;
    public array $imageFile;
    public ?string $imagePath = null;

    
    public function load($data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'];
        $this->imageFile = $data['imageFile'] ?? null;
        $this->imagePath = $data['image'] ?? null;
    }

    public function save()
    {
        // echo dirname(__DIR__);
        // exit;
        $errors = [];
        if (!is_dir(dirname(__DIR__). '/../public/images')) {
            mkdir(dirname(__DIR__) . '/../public/images');
        }

        if (!$this->title) {
            $errors[] = 'Product title is required';
        }

        if (!$this->price) {
            $errors[] = 'Product price is required';
        }

        if (empty($errors)) {
            if ($this->imageFile && $this->imageFile['tmp_name']) {
                if ($this->imagePath) {
                    unlink(dirname(__DIR__) . '/../public/' . $this->imagePath);
                }
                $this->imagePath = 'images/' . UtilHelper::randomString(8) . '/' . $this->imageFile['name'];
                mkdir(dirname(dirname(__DIR__) . '/../public/' . $this->imagePath));
                move_uploaded_file($this->imageFile['tmp_name'], dirname(__DIR__) . '/../public/' . $this->imagePath);
            }

            $db = Database::$db;
            if ($this->id) {
                $db->updateProduct($this);
            } else {
                $db->createProduct($this);
            }

        }

        return $errors;
    }
}