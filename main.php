<?php
include "PHPress/loader.php";

$router = Router::create_router();
$server = new Server("127.0.0.1", 5000);

function test(){
    echo "in test func";
}
function dogs($req, $res){

    $headers = array(
        "Test"=>"Works",
        "Dogs"=>"Cool"
    );

    $res->set_header($headers);
    $res->send_file("test.html");
}

$router->get("/", "test");
$router->get("/index", "dogs");

$server->listen();

?>
