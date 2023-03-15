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

    public function put($path, $handler){
        $route = $this->create_route($path, $handler, "PUT");
        array_push($this->routes, $route);
    }

    public function delete($path, $handler){
        $route = $this->create_route($path, $handler, "DELETE");
        array_push($this->routes, $route);
    }

    public function head($path, $handler){
        $route = $this->create_route($path, $handler, "HEAD");
        array_push($this->routes, $route);
    }

    public function options($path, $handler){
        $route = $this->create_route($path, $handler, "OPTIONS");
        array_push($this->routes, $route);
    }

    public function connect($path, $handler){
        $route = $this->create_route($path, $handler, "CONNECT");
        array_push($this->routes, $route);
    }

    public function trace($path, $handler){
        $route = $this->create_route($path, $handler, "TRACE");
        array_push($this->routes, $route);
    }

    public function patch($path, $handler){
        $route = $this->create_route($path, $handler, "PATCH");
        array_push($this->routes, $route);
    }
    
}

?>