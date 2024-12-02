<?php 

class Url{

    public static function redirecionar($url){

        header("location: " . URL_PROJETO . DIRECTORY_SEPARATOR . $url);
        exit;
        
    }
            
}