<?php

use \Illuminate\Database\Capsule\Manager as Capsule;

class myApp{
    static $documento;
    static $modelo;
    static $func;	
    static $peticion;
    static $eloquent;
    static $bd;

    public static function getControlador($nombre = ""){
        if (empty($nombre)){
            $req = myApp::getPeticion();
            $nombre = $req->getVar("controlador");
        }
        
        $rutaControlador = dirname(__DIR__)."/controladores/".$nombre."Controlador.php";
        
        $clase = $nombre."Controlador";
        if (!class_exists($clase) && is_file($rutaControlador)){
            require_once($rutaControlador);
        }
        
        return new $clase();
    }
    
    public static function getModelo($nombre){
        $clase = $nombre."Modelo";
        $rutaModelo = dirname(__DIR__)."/modelos/".$clase.".php";
        
        if (!class_exists($clase) && is_file($rutaModelo)){
            require_once($rutaModelo);
        }
        
        return new $clase();
    }
    
    public static function redirigir($url, $mensaje=""){
        header('Location: '.$url);
    }
    
    public static function getUrlBase(){
        $cfg = new myConfig();
        return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $cfg->urlSitio;
    }
    
    public static function getBaseDatos(){
        if(!myApp::$bd){
            myApp::$bd = new myBaseDatos();
        }
        
        return myApp::$bd;
    }
   
    public static function getDocumento(){
        if (!myApp::$documento){
            myApp::$documento = new myDocumento();
        }
        return myApp::$documento;
    }

    public static function getFunciones(){
        if (!myApp::$func){
            myApp::$func = new myFunciones();
        }
        return myApp::$func;
    }

    public static function getPeticion(){
        if (!myApp::$peticion){
            myApp::$peticion = new myPeticion();
        }
        return myApp::$peticion;
    }

    public static function getRutaImagenes(){
        return BASE_DIR.DS."myImagenes";
    }

    public static function getUrlImagenes(){
        return myApp::getUrlBase()."myImagenes/";
    }
    
    public static function getRutaDocumentos(){
        $dir = dirname(BASE_DIR).DS."myArchivos";
        if(!is_dir($dir)){ 
            @mkdir($dir);
        }
        return $dir.DS."documentos";
    }
}