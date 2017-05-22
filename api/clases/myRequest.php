<?php
/*    Héctor Fabián Morales Ramírez
    Tecnólogo en Ingeniería de Sistemas
    Agosto 2012*/

class myRequest{
    static $vars;
    
    public static function boot($vars){   
        $j = file_get_contents('php://input');
        
        myRequest::$vars = json_decode($j, true);
    }
    
    public static function getVar($key, $pred="", $filtro="string"){
        
        return isset(myRequest::$vars[$key]) ? myRequest::$vars[$key] : $pred;
    }

    public function get($var){
        return myRequest::$vars[$key];
    }

    public function all(){
        return myRequest::$vars;
    }
}
