<?php

class Request{
    public string $method;
    public string $route;
    public $body;
    public $headers;

    function __construct()
    {
        $this->method = "";
        $this->route = "";
        $this->headers = array();
        $this->body = "";
    }

    function request_parse($request){
        $split_double_line = explode("\r\n\r\n", $request);

        if($split_double_line[1] != ""){
            $this->body = $split_double_line[1];
        }
        
        $headers = explode("\r\n", $split_double_line[0]);
        $pre_headers = explode(" ", $headers[0]);
        unset($headers[0]);

        $this->method = $pre_headers[0];
        $this->route = $pre_headers[1];

        foreach($headers as $header){
            $split_header = explode(": ",$header, 2);
            $this->headers[$split_header[0]] = $split_header[1];
        }
    }
}

?>