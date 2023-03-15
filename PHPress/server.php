<?php

class Server{
    protected string $host;
    protected int $port;
    private $sock;
    private $router;

    function __construct($host = "127.0.0.1", $port = 3000)
    {
        $this->host = $host;
        $this->port = $port;
        $this->sock = socket_create(AF_INET, SOCK_STREAM, 0);
        $this->router = Router::create_router();
    }
    
    private function bind_connection(){
        socket_bind($this->sock, $this->host, $this->port) or die("Error binding socket.");
        socket_listen($this->sock, 1);
    }

    private function search_path($path, $method, $accept){
        $routes = $this->router->routes;

        if(str_ends_with($path, ".css") || str_ends_with($path, ".js")){
            $serve_static = new FileServer();
            $res = $serve_static->send_static_file($path);
            $this->write_response($res, $accept);
        }
        
        foreach($routes as $route){
            if($route["method"] == $method && $route["path"] == $path) return $route;
        }

        return false;
    }

    private function write_response($res, $connection){
        $locked_header = Response::$locked_header;
        $response = "HTTP/1.1 {$res->status_code}\r\n{$locked_header}{$res->header}\r\n{$res->body}";
        socket_write($connection, $response, strlen($response));
    }

    private function execute_handler($handler, $connection, $req){
        $res = new Response();
        call_user_func($handler, $req, $res);

        $this->write_response($res, $connection);
    }

    public function listen(){
        $this->bind_connection();

        while(true){
            try{
                $accept = socket_accept($this->sock);
                $request_content = socket_read($accept, 4096);
                $req = new Request();
                $req->request_parse($request_content);
                $request = $this->search_path($req->route, $req->method, $accept);

                if($request && is_array($request)){
                    $this->execute_handler($request["handler"], $accept, $req);
                }
                
                socket_close($accept);
            }
            catch(Exception $err){
                print_r($err, "\n");
            }
        }
    }
}

?>