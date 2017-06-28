<?php

class FlujoControlador extends myControlador {

    public function index() {
        $turnos = myApp::getModelo("TurnoTrabajo")->listar();
        $empleados = myApp::getModelo("Usuario")->listar();
        
        foreach ($turnos as $i => $t){
            
            $filtroEmp = array_filter(
                $empleados,
                function ($e) use ($t) {                   
                    return (int)$e->id == (int)$t->id_usuario;
                }
            );

            $turnos[$i]->empleado = array_values($filtroEmp)[0];
        }
        
        $ret = ["empleados" => $empleados, "turnos" => $turnos];
        return json_encode($ret);
    }
    
    public function validar(){
        $req = myApp::getPeticion();
        $cedula = $req->getVar("cedula");
        $clave = $req->getVar("clave");
        
        $modelo = myApp::getModelo("Usuario");
        $usuarios = $modelo->adicionarCondicion("cedula", "=", $cedula)->listar();
        $ret = [];
        if(sizeof($usuarios)){
            if($usuarios[0]->clave != $clave){
                $ret = ["ok" => 0, "mensaje" => "Clave incorrecta"];
            }
            else{
                $ret = ["ok" => 1, "mensaje" => "Sesion iniciada", "usuario" => $usuarios[0]];
            }
        }
        else{
            $ret = ["ok" => 0, "mensaje" => "Usuario no encontrado"];
        }
        
        return json_encode($ret);
    }
    
    public function obtenerTurno($cedula){
        $ret = ["ok" => 0];
        $modelo = myApp::getModelo("Usuario");
        $usuarios = $modelo->adicionarCondicion("cedula", "=", $cedula)->listar();
        if(sizeof($usuarios)){
            $modelo = myApp::getModelo("TurnoTrabajo");
            $turnos = $modelo
                    ->adicionarCondicion("id_usuario", "=", $usuarios[0]->id)
                    ->adicionarCondicion("estado", "=", 0)
                    ->listar();
            
            if (sizeof($turnos)){
                $ret = ["ok" => 1, "turno" => $turnos[0]];
            }
        }
        
        return json_encode($ret);
    }
    
    public function iniciarTurno($cedula){
        $ret = [];
        $modelo = myApp::getModelo("Usuario");
        $usuarios = $modelo->adicionarCondicion("cedula", "=", $cedula)->listar();
        if(sizeof($usuarios)){
            $turno = myApp::getModelo("TurnoTrabajo");
            $turno->id_usuario = $usuarios[0]->id;
            $turno->id_tipo = 1;
            $turno->fecha_entrada = date('Y-m-d H:i:s');
            $turno->fecha_salida = date('Y-m-d H:i:s');
            $turno->estado = 0;
            
            if ($turno->guardar()){
                $ret = ["ok" => 1, "mensaje" => "Turno iniciado", "usuario" => $usuarios[0], "turno" => $turno];
            }
            else{
                $ret = ["ok" => 0, "mensaje" => "No se pudo iniciar el turno"];
            }
        }
        
        return json_encode($ret);
    }
    
    public function cerrarTurno($cedula){
        $ret = [];
        $modelo = myApp::getModelo("Usuario");
        $usuarios = $modelo->adicionarCondicion("cedula", "=", $cedula)->listar();
        if(sizeof($usuarios)){
            $modelo = myApp::getModelo("TurnoTrabajo");
            $turnos = $modelo
                    ->adicionarCondicion("id_usuario", "=", $usuarios[0]->id)
                    ->adicionarCondicion("estado", "=", 0)
                    ->listar();
            
            if (sizeof($turnos)){
                $turno = $turnos[0];
                $turno->fecha_salida = date('Y-m-d H:i:s');
                $turno->estado = 1;
                
                if ($turno->guardar()){
                    $ret = ["ok" => 1, "mensaje" => "Turno finalizado", "usuario" => $usuarios[0], "turno" => $turno];
                }
            else{
                $ret = ["ok" => 0, "mensaje" => "No se pudo iniciar el turno"];
            }
            }
            else{
                $ret = ["ok" => 0, "mensaje" => "No hay turnos iniciados"];
            }
        }
        
        return json_encode($ret);
    }
}
