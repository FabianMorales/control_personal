<?php

if (!defined("DS")){
    define("DS", DIRECTORY_SEPARATOR);
    define('BASE_DIR', dirname(__DIR__));    
    
    $coreDir = __DIR__."/";
    $clasesDir = $coreDir."clases/";
    $libDir = $coreDir."lib/";
    $archivos = [
        $clasesDir."myApp.php",
        $clasesDir."myConfig.php",
        $clasesDir."myDocumento.php",
        $clasesDir."myFunciones.php",
        $clasesDir."myBaseDatos.php",
        $clasesDir."myModelo.php",
        $clasesDir."myControlador.php",
        $clasesDir."myAdminControlador.php",
        $clasesDir."myPeticion.php",
        $clasesDir."myEnrutador.php",
        $clasesDir."mySesion.php",
        $libDir."Slim/Slim.php"
    ];

    foreach ($archivos as $a){
        require_once $a;
    }
    
    mySesion::boot();
    myPeticion::boot();
    $app = myEnrutador::boot();
}