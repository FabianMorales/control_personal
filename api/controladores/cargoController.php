<?php

class cargoController extends myController {

    public function index() {
        $cargos = Cargo::all();
        return $cargos->toJson();
    }
    
    public function mostrarCargo($id){
        $cargo = Cargo::find($id);
        if (sizeof($cargo)){
            return $cargo->toJson();
        }
        else{
            return json_encode([]);
        }
    }
    
    public function guardarCargo(){
        $req = myApp::getRequest();
        $id = $req->getVar("id");
        
        $cargo = Cargo::find($id);
        if (!sizeof($cargo)){
            $cargo = new Cargo();
        }
        
        $cargo->fill($req->all());
        
        $ret = [];
        if ($cargo->save()){
            $ret = ["ok" => 1, "mensaje" => "Cargo guardado exitosamente"];
        }
        else{
            $ret = ["ok" => 0, "mensaje" => "No se pudo guardar el cargo"];
        }
        
        return json_encode($ret);
    }
    
    public function borrarCargo($id){   
        $cargo = Cargo::find($id);
        $ret = [];
        
        if (!sizeof($cargo)){
            $ret = ["ok" => 0, "mensaje" => "Cargo no encontrado"];
        }
        else{
            if ($cargo->delete()){
                $cargos = Cargo::all();
                $ret = ["ok" => 1, "mensaje" => "Cargo borrado exitosamente", "datos" => $cargos];
            }
            else{
                $ret = ["ok" => 0, "mensaje" => "No se pudo borrar el cargo"];
            }
        }
        
        return json_encode($ret);
    }
    
    public function listarCargos(){
        $cargos = Cargo::all();
        $dirBase = BASE_DIR."/almacenamiento/cargos".uniqid().".txt";
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
