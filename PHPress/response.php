<?php

class Response{

    public string $body;
    public string $header;
    public int $status_code;

    function __construct()
    {
        $this->body = "";
        $this->status_code = 200;
        $this->header = "";
    }
    
    public function send($body){
        $this->body = $body;
    }
    
    public function send_file($filename){
        $filecontent = fopen($filename, "r");
        $this->body = fread($filecontent, filesize($filename));
        fclose($filecontent);
    }

    public function set_header($header){
        $string_header = "";
        foreach($header as $key => $value){
            $string_header .= "{$key}: {$value}\r\n";
        }
        $this->header = $string_header;
    }

    public function status_code($code){
        $this->status_code = $code;
    }

}

?>