<?php

class Parser{
    private function toJSON($content) : array{
        $data = "";
        $split_and_sign = explode("&", $content);
        
        foreach($split_and_sign as $key=>$value){
            $kvp = explode("=", $value, 2);
            if($key === count($split_and_sign) - 1){
                $data .= "    \"{$kvp[0]}\":\"{$kvp[1]}\"\r\n";
            }
            else{
                $data .= "    \"{$kvp[0]}\":\"{$kvp[1]}\",\r\n";
            }
        }

        $data = "{\r\n{$data}}";
        return json_decode($data, 1);
    }
    
    public function content_parse($content) : array{
        json_decode($content);

        if(json_last_error() === JSON_ERROR_NONE){
            return json_decode($content, 1);
        }
        return $this->toJSON($content);
    }

    public function cookie_parse($cookie) : array{
        $kvp = explode("=",$cookie, 2);
        return array(
            $kvp[0] => $kvp[1]
        );
    }
}
?>