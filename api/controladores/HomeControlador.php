<?php

class HomeControlador extends myControlador {

    public function index() {
        $modelo = myApp::getModelo("Cargo");
        
        $modelo->encontrar(1);
        echo $modelo->json();
        
        
        /*$modelo->nombre = "Constructor";
        echo $modelo->guardar();
        die();
        $cargos = $modelo->listar();
        print_r($cargos);*/
    }

}
