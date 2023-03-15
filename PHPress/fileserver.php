<?php

class FileServer{
    private static array $static_folders;

    public static function serve_static(...$folders){
        if(!isset(self::$static_folders)){
            self::$static_folders = $folders;
        }
    }
    
    public function send_static_file(string $filename){
        $res = new Response();
        $exists = false;

        if(str_starts_with($filename, "/")){
            $filename = substr($filename, strlen("/"));
        }

        foreach(self::$static_folders as $folder){
            if(str_starts_with($filename, $folder)){
                $exists = true;
                break;
            };
        }

        if(!$exists) return;
        
        if(str_ends_with($filename, ".css")){
            $res->header .= "Content-Type: text/css\r\n";
            $res->send_file($filename);
        }
        elseif(str_ends_with($filename, ".js")){
            $res->header .= "Content-Type: text/javascript\r\n";
            $res->send_file($filename);
        }
        return $res;
    }

}

?>