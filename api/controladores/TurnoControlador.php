<?php

class TurnoControlador extends myAdminControlador {

    public function index() {
        $modelo = myApp::getModelo("Turno");
        return $modelo->listarJson();
    }
    
    public function mostrarTurno($id){
        $modelo = myApp::getModelo("Turno");
        $modelo->encontrar($id);
        
        if (sizeof($modelo)){
            return $modelo->json();
        }
        else{
            return json_encode([]);
        }
    }
    
    public function guardarTurno(){
        $req = myApp::getPeticion();
        $id = $req->getVar("id");
        
        $modelo = myApp::getModelo("Turno");
        $modelo->encontrar($id);
        
        $modelo->asociar($req->all());
        
        $ret = [];
        if ($modelo->guardar()){
            $ret = ["ok" => 1, "mensaje" => "Turno guardado exitosamente"];
        }
        else{
            $ret = ["ok" => 0, "mensaje" => "No se pudo guardar el turno"];
        }
        
        return json_encode($ret);
    }
    
    public function borrarTurno($id){   
        $modelo = myApp::getModelo("Turno");
        $modelo->encontrar($id);
        $ret = [];
        
        if (!$modelo->id){
            $ret = ["ok" => 0, "mensaje" => "Turno no encontrado"];
        }
        else{
            if ($modelo->borrar()){
                $turnos = $modelo->listar();
                $ret = ["ok" => 1, "mensaje" => "Turno borrado exitosamente", "datos" => $turnos];
            }
            else{
                $ret = ["ok" => 0, "mensaje" => "No se pudo borrar el turno"];
            }
        }
        
        return json_encode($ret);
    }
    
    public function descargarTurno($id){
        $modelo = myApp::getModelo("Turno");
        $modelo->encontrar($id);
        
        if ($modelo->id){
            $dirBase = BASE_DIR."/almacenamiento/turnos/turno_".$id.".txt";
            $dirs = ["almacenamiento", "turnos"];
            $dir = BASE_DIR;
            foreach ($dirs as $d){
                $dir .= "/".$d;
                if (!is_dir($dir)){
                    mkdir($dir);   
                }
            }

            $file = fopen($dirBase, "w");
            fwrite($file, "ID: ".$modelo->id."\r\n");
            fwrite($file, "Nombre: ".$modelo->nombre."\r\n");
            fwrite($file, "Inicio: ".$modelo->inicio."\r\n");
            fwrite($file, "Fin: ".$modelo->fin."\r\n");
            fwrite($file, "Inicio receso: ".$modelo->inicio_receso."\r\n");
            fwrite($file, "Fin receso: ".$modelo->fin_receso."\r\n");
            fclose($file);

            $size = filesize($dirBase);
            header('Content-Description: File Transfer');
            header('Content-Type: text/txt');
            header('Content-Disposition: attachment; filename="turnos_'.$id.'.txt');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            readfile($dirBase);
        }
    }
    
    public function listarTurnos(){
        $modelo = myApp::getModelo("Turno");
        $cargos = $modelo->listar();
        $dirBase = BASE_DIR."/almacenamiento/turnos/".uniqid().".txt";
        $dirs = ["almacenamiento", "turnos"];
        $dir = BASE_DIR;
        foreach ($dirs as $d){
            $dir .= "/".$d;
            if (!is_dir($dir)){
                mkdir($dir);   
            }
        }

        $file = fopen($dirBase, "a");
        fwrite($file, "ID,Nombre,Inicio,Fin,Inicio Receso,Fin Receso\r\n");
        foreach($cargos as $c){
            fwrite($file, $c->id.",".$c->nombre.",".$c->inicio.",".$c->fin.",".$c->inicio_receso.",".$c->fin_receso."\r\n");
        }
        
        fclose($file);
        
        $size = filesize($dirBase);
        header('Content-Description: File Transfer');
        header('Content-Type: text/txt');
        header('Content-Disposition: attachment; filename="lista_turnos.txt"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        readfile($dirBase);
        
        die();
    }
}
