<?php

class Router{
    public $routes;
    private static $instance;

    public function __construct()
    {
        $this->routes = array();
    }

    public static function create_router(){
        if(!isset(self::$instance)){
            self::$instance = new Router();
        }
        return self::$instance;
    }

    function create_route($path, $handler, $method){
        return [
            "path" => $path,
            "handler" => $handler,
            "method" => $method
        ];
    }
    
    public function get($path, $handler){
        $route = $this->create_route($path, $handler, "GET");
        array_push($this->routes, $route);
    }
    public function post($path, $handler){
        $route = $this->create_route($path, $handler, "POST");
        array_push($this->routes, $route);
    }
}

?>