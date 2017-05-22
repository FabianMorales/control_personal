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
            $ret = ["ok" => 2, "mensaje" => "No se pudo guardar el cargo"];
        }
        
        return json_encode($ret);
    }
}
