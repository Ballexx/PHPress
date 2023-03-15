<?php

class Response{
    public string $body;
    public string $header;
    public int $status_code;
    public static string $locked_header;

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
   
    private static function build_header(array $header) : string{
        $string_header = "";
        foreach($header as $key => $value){
            $string_header .= "{$key}: {$value}\r\n";
        }
        return $string_header;
    }
    
    public static function lock_header(array $header){
        if(!isset(self::$locked_header)){
            $string_header = "";
            foreach($header as $key => $value){
                $string_header .= "{$key}: {$value}\r\n";
            }
            self::$locked_header = $string_header;
        }
    }

    public function set_cookie(string $token, string $attributes){
        $this->header .= "Set-Cookie: token={$token}; {$attributes}\r\n";
    }

    public function set_header(array $header){
        $this->header .= $this->build_header($header);
    }

    public function redirect(string $path){
        $this->header .= "Location: {$path}\r\n";
        $this->status(303);
    }

    public function json(array $content){
        $this->header .= "Content-Type: application/json\r\n";
        $this->send(json_encode($content));
    }

    public function status(int $code){
        $this->status_code = $code;
    }
}

?>