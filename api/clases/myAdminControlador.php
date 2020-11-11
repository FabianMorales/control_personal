<?php

abstract class myAdminControlador extends myControlador{
    public function ejecutar($tarea = "index", $args = []){
        $sesion = myApp::getSesion();
        $usuario = $sesion->get("sesion.usuario");
        
        if (sizeof($usuario) && !empty($usuario)){
            parent::ejecutar($tarea, $args);
        }
        else{
            echo json_encode(["ok" => 0, "mensaje" => "Debes iniciar sesión para ejecutar esta acción"]);
        }
    }
    
    public function index() { }
}

