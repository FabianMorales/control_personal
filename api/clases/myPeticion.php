<?php

class myPeticion{
    static $vars;
    
    public static function boot(){   
        $j = file_get_contents('php://input');
        myPeticion::$vars = json_decode($j, true);
    }
    
    public static function getVar($key, $pred="", $filtro="string"){
        return isset(myPeticion::$vars[$key]) ? myPeticion::$vars[$key] : $pred;
    }

    public function get($var){
        return myPeticion::$vars[$key];
    }

    public function all(){
        return myPeticion::$vars;
    }
}
