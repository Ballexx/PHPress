<?php
include "PHPress/loader.php";

$headers = array(
    "always"=>"here"
);

$router = Router::create_router();
Response::lock_header($headers);
FileServer::serve_static("public");

$server = new Server("127.0.0.1", 5000);

function test($req, $res){
    $json = array(
        "cool"=>"Works"
    );
    
    $res->json($json);

}
function dogs($req, $res){
    $res->set_cookie("thisisasecrettoken", "SameSite=None; Secure; HttpOnly; Max-Age=3600; Path=/index");
    print_r($req->get_cookie());
    $res->send_file("public/test.html");
}

function cool($req, $res){
    print_r($req->body["cool"]);
}

$router->get("/", "test");
$router->get("/index", "dogs");
$router->post("/index", "cool");

$server->listen();

?>
