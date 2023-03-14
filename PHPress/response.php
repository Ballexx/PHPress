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

    public function send_file(string $filename){
        $filecontent = fopen($filename, "r");
        $this->body = fread($filecontent, filesize($filename));
        fclose($filecontent);
    }

    public function send_static_file(string $filename){
        if(str_starts_with($filename, "/")){
            $filename = substr($filename, strlen("/"));
        }
        if(str_ends_with($filename, ".css")){
            $this->header .= "Content-Type: text/css\r\n";
            $this->send_file($filename);
        }
        elseif(str_ends_with($filename, ".js")){
            $this->header .= "Content-Type: text/javascript\r\n";
            $this->send_file($filename);
        }
    }   

    private static function build_header(array $header) : string{
        $string_header = "";
        foreach($header as $key => $value){
            $string_header .= "{$key}: {$value}\r\n";
        }
        return $string_header;
    }

    public function redirect(string $path){
        $this->header .= "Location: {$path}\r\n";
        $this->status_code(303);
    }

    public function json(array $content){
        $this->header .= "Content-Type: application/json\r\n";
        $this->send(json_encode($content));
    }

    public function set_header(array $header){
        $this->header .= $this->build_header($header);
    }

    public function status_code(int $code){
        $this->status_code = $code;
    }
}

?>