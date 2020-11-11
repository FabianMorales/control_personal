<?php

class SesionControlador extends myControlador {

    public function index() {
        $sesion = myApp::getSesion();
        $usuario = $sesion->get("sesion.usuario");
        $ret = [];
        
        if (sizeof($usuario) && !empty($usuario)){
            $ret = ["sesion" => 1, "usuario" => $usuario];
        }
        else{
            $ret = ["sesion" => 0];
        }
        
        return json_encode($ret);
    }
    
    public function iniciarSesion(){
        $req = myApp::getPeticion();
        $cedula = $req->getVar("cedula");
        $clave = sha1($req->getVar("clave"));
        
        $modelo = myApp::getModelo("Usuario");
        $usuarios = $modelo->adicionarCondicion("cedula", "=", $cedula)->listar();
        
        $ret = [];
        if(sizeof($usuarios)){
            if($usuarios[0]->clave != $clave){
                $ret = ["ok" => 0, "mensaje" => "Clave incorrecta"];
            }
            else{
                $sesion = myApp::getSesion();
                $sesion->set("sesion.usuario", $usuarios[0]);
                $ret = ["ok" => 1, "mensaje" => "Sesion iniciada", "usuario" => $usuarios[0]];
            }
        }
        else{
            $ret = ["ok" => 0, "mensaje" => "Usuario no encontrado"];
        }
        
        return json_encode($ret);
    }
    
    public function finalizarSesion(){
        $sesion = myApp::getSesion();
        $sesion->borrar("sesion.usuario");
        return json_encode(["ok" => 1]);
    }
}
