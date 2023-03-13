<?php

include_once("request.php");
include_once("router.php");
include_once("response.php");

class Server{

    protected string $host;
    protected int $port;
    private $sock;
    private $router;

    function __construct($host, $port)
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

    private function search_path($path){
        $routes = $this->router->routes;
        $paths = array();
        
        foreach($routes as $route){
            array_push($paths, $route["path"]);
        }

        if(in_array($path, $paths)){
            return $routes[array_search($path, $paths)];
        }

        return false;
    }

    private function execute_handler($handler, $connection){
        $req = new Request();
        $res = new Response();
        
        call_user_func($handler, $req, $res);

        $response = "HTTP/1.1 {$res->status_code}\r\n{$res->header}\r\n{$res->body}";
        socket_write($connection, $response, strlen($response));
    }

    public function listen(){
        $this->bind_connection();

        while(true){
            try{
                $accept = socket_accept($this->sock);
                $request_content = socket_read($accept, 4096);
                $req = new Request();
                $req->request_parse($request_content);
                $request = $this->search_path($req->route);

                if($request){
                    $this->execute_handler($request["handler"], $accept);
                }

                socket_close($accept);

            }
            catch(Exception $err){
                echo $err, "\n";
            }
        }
    }
}

?>