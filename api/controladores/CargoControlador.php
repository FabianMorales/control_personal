<?php

class CargoControlador extends myControlador {

    public function index() {
        $modelo = myApp::getModelo("Cargo");
        return $modelo->listarJson();
    }
    
    public function mostrarCargo($id){
        $modelo = myApp::getModelo("Cargo");
        $modelo->encontrar($id);
        
        if (sizeof($modelo)){
            return $modelo->json();
        }
        else{
            return json_encode([]);
        }
    }
    
    public function guardarCargo(){
        $req = myApp::getPeticion();
        $id = $req->getVar("id");
        
        $modelo = myApp::getModelo("Cargo");
        $modelo->encontrar($id);
        
        $modelo->asociar($req->all());
        
        $ret = [];
        if ($modelo->guardar()){
            
            $dirBase = BASE_DIR."/almacenamiento/cargos/cargo_".$modelo->id.".txt";
            $dirs = ["almacenamiento", "cargos"];
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
            fclose($file);
            
            $ret = ["ok" => 1, "mensaje" => "Cargo guardado exitosamente"];
        }
        else{
            $ret = ["ok" => 0, "mensaje" => "No se pudo guardar el cargo"];
        }
        
        return json_encode($ret);
    }
    
    public function borrarCargo($id){   
        $modelo = myApp::getModelo("Cargo");
        $modelo->encontrar($id);
        $ret = [];
        
        if (!$modelo->id){
            $ret = ["ok" => 0, "mensaje" => "Cargo no encontrado"];
        }
        else{
            if ($modelo->borrar()){
                $cargos = $modelo->listar();
                $ret = ["ok" => 1, "mensaje" => "Cargo borrado exitosamente", "datos" => $cargos];
            }
            else{
                $ret = ["ok" => 0, "mensaje" => "No se pudo borrar el cargo"];
            }
        }
        
        return json_encode($ret);
    }
    
    public function descargarCargo($id){
        $modelo = myApp::getModelo("Cargo");
        $modelo->encontrar($id);
        
        if ($modelo->id){
            $dirBase = BASE_DIR."/almacenamiento/cargos/cargo_".$id.".txt";
            $size = filesize($dirBase);
            header('Content-Description: File Transfer');
            header('Content-Type: text/txt');
            header('Content-Disposition: attachment; filename="cargos_'.$id.'.txt');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            readfile($dirBase);
        }
    }
    
    public function listarCargos(){
        $modelo = myApp::getModelo("Cargo");
        $cargos = $modelo->listar();
        $dirBase = BASE_DIR."/almacenamiento/cargos/".uniqid().".txt";
        $dirs = ["almacenamiento", "cargos"];
        $dir = BASE_DIR;
        foreach ($dirs as $d){
            $dir .= "/".$d;
            if (!is_dir($dir)){
                mkdir($dir);   
            }
        }

        $file = fopen($dirBase, "a");
        fwrite($file, "ID,Nombre\r\n");
        foreach($cargos as $c){
            fwrite($file, $c->id.",".$c->nombre."\r\n");
        }
        
        fclose($file);
        
        $size = filesize($dirBase);
        header('Content-Description: File Transfer');
        header('Content-Type: text/txt');
        header('Content-Disposition: attachment; filename="lista_cargos.txt"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        readfile($dirBase);
        
        die();
    }
}
