<?php
include "PHPress/loader.php";

$router = Router::create_router();
$server = new Server("127.0.0.1", 5000);

function test($req, $res){
    $json = array(
        "cool"=>"Works"
    );
    
    $res->json($json);

}
function dogs($req, $res){

    $headers = array(
        "Test"=>"Works",
        "Dogs"=>"Cool"
    );

    $res->set_header($headers);
    $res->send_file("test.html");
}

function cool($req, $res){
    print_r($req->body["cool"]);
}

$router->get("/", "test");
$router->get("/index", "dogs");
$router->post("/index", "cool");

$server->listen();

?>
