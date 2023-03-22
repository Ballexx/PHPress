# PHPress
* A PHP web-framework designed to look like express
* Simple syntax and easy to use

# How to use
* To use PHPress, all you have to do is include "PHPress/loader.php" in your project
* Then create a router with "$router_name = Router::create_router();"
* Then create a server with "$server_name = new Server(host_of_choice, port_of_choice);"
* Then listen to the server by adding "$server_name->listen();", it is important that it is last else the program hangs

# Example code

```php
<?php
include "PHPress/loader.php";

$headers = array(
    "always"=>"here"
);

$router = Router::create_router();
Response::lock_header($headers);
FileServer::serve_static("public");

$server = new Server("127.0.0.1", 5000);

function jsontest($req, $res){
    $json = array(
        "it"=>"works"
    );
    
    $res->json($json);

}
function cookietest($req, $res){
    $res->set_cookie("thisisasecrettoken", "SameSite=None; Secure; HttpOnly; Max-Age=3600; Path=/index");
    print_r($req->get_cookie());
    $res->send_file("public/test.html");
}

function bodytest($req, $res){
    print_r($req->body["this is a body"]);
}

$router->get("/", "jsontest");
$router->get("/index", "cookietest");
$router->post("/index", "bodytest");

$server->listen();

?>
```
# Features
```php
<?php
$req->body; #gets request body

$res->setcookie("token", "attributes"); #sets cookie with attributes

$req->getcookie(); #gets cookie

$res->send("text"); #sends text as response body

$res->send_file("file"); #sends file as response body

$res->json("json"); #sends json as response body

$res->status("statuscode"); #sets response status 

$res->set_header("array of headers"); #sets headers on specific response

$res->redirect("url"); #redirects to given url

Router::create_router(); #creates a static router instance

Response::lock_headers("array of headers"); #creates a list of headers that will stay on every response

Fileserver::serve_static("foldername"); #supports serving several static folders

new Server("host", "port"); #hosts server on given host and port¨

$server_name->listen(); #listens to server

$name_of_router->get("route", "function"); #mounts function and method type to route

#the same syntax works for this list under
#post, delete, put, patch, connect, options, head, trace
?>
```
