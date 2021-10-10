<?php

namespace app\core;
use app\core\db\Database;


class Router {
    public array $getRoutes = [];
    public array $postRoutes = [];

    public ?Database $database = null;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function get($url, $fn){
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn){
        $this->postRoutes[$url] = $fn;
    }

    public function resolve(){
        $currentUrl = $_SERVER['PATH_INFO'] ?? "/";
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === "GET"){
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if(!$fn){
            echo 'Page not found';
            exit;
        } 
        
        // allows static methods
        call_user_func($fn, $this);

    }

    public function RenderView($view, $params = []){
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include __DIR__."/../views/$view.php";
        $content = ob_get_clean();
        include __DIR__."/../views/layout.php";

    }

}