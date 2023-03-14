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

    private static function build_header($header) : string{
        $string_header = "";
        foreach($header as $key => $value){
            $string_header .= "{$key}: {$value}\r\n";
        }
        return $string_header;
    }

    public function set_header($header){
        $this->header .= $this->build_header($header);
    }

    public function status_code($code){
        $this->status_code = $code;
    }
}

?>