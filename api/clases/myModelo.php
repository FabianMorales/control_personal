<?php

abstract class myModelo{
    protected $tabla = '';
    protected $asociables = array();
    
    private $condiciones = array();
    private $camposSelect = array();
    
    public function asociar($params){
        $vars = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($vars as $v){
            $nombre = $v->name;
            if (!sizeof($this->asociables) || (sizeof($this->asociables) && in_array($nombre, $this->asociables))){
                if (isset($params[$nombre])){
                    $this->$nombre = $params[$nombre];
                }
            }
        }
    }
    
    public function adicionarCampo($nombre){
        $this->camposSelect[] = $nombre;
        return $this;
    }
    
    public function adicionarCondicion($campo, $operador, $valor){
        $condicion = [
            "campo" => $campo,
            "op" => $operador,
            "valor" => $valor
        ];
        
        $this->condiciones[] = $condicion;
        return $this;
    }
    
    public function encontrar($id){       
        $bd = myApp::getBaseDatos();
        $sql = "select * from sis_".$this->tabla." where id = :id";
        
        $clase = get_called_class();
        $ret = $bd->consultar($sql, [":id" => $id], $clase);
        
        if (sizeof($ret)){
            $vars = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
            foreach($vars as $v){
                $campo = $v->name;
                $this->$campo = $ret[0]->$campo;
            }
        }
        
        return $this;
    }
    
    public function json(){
        $vars = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
        $ret = [];
        
        foreach ($vars as $v){
            $nombre = $v->name;
            $ret[$nombre] = $this->$nombre;
        }
        
        return json_encode($ret);
    }
       
    public function listar(){       
        $bd = myApp::getBaseDatos();
        $camposStr = sizeof($this->camposSelect) ? implode(", ", $this->camposSelect): " * ";
        $condiciones = "";
        $condVal = [];
        
        if (sizeof($this->condiciones)){
            $condStr = [];
            foreach ($this->condiciones as $c){
                $condStr[] = $c["campo"]." ".$c["op"]." :".$c["campo"];
                $condVal[":".$c["campo"]] = $c["valor"];
            }
            
            $condiciones = " where ".implode(" and ", $condStr);
        }
        
        $clase = get_called_class();
        $ret = $bd->consultar("select ".$camposStr." from sis_".$this->tabla.$condiciones, $condVal, $clase);
        return $ret;
    }
    
    public function listarJson(){
        $lista = $this->listar();
        $ret = [];
        
        foreach ($lista as $l){
            $vars = (new ReflectionObject($l))->getProperties(ReflectionProperty::IS_PUBLIC);
            $obj = [];

            foreach ($vars as $v){
                $nombre = $v->name;
                $obj[$nombre] = $l->$nombre;
            }
            
            $ret[] = $obj;
        }
        
        return json_encode($ret);
    }
    
    public function guardar(){
        $bd = myApp::getBaseDatos();
        $vars = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);
        $camposInsert = [];
        $camposInsertParam = [];
        $camposUpdate = [];
        $valores = [];
        
        foreach($vars as $v){
            $campo = $v->name;
            
            if ($campo != "id"){
                $camposInsert[] = $campo;
                $camposInsertParam[] = ":".$campo;
                $camposUpdate[] = $campo." = :".$campo;
                $valores[":".$campo] = empty($this->$campo) && $this->campo != 0 ? null : $this->$campo;
            }
        }
        
        $insertar = true;
        $sql = "";
        
        if (!empty($this->id)){
            $sql = "select count(*) cnt from sis_".$this->tabla." where id = :id";
            $ret = $bd->consultar($sql, [":id" => $this->id]);
            if (sizeof($ret) && $ret[0]->cnt > 0){
                $insertar = false;
            }
        }
        
        if ($insertar){
            $sql = "insert into sis_".$this->tabla."(".implode(", ", $camposInsert).") values (".implode(", ", $camposInsertParam).")";
        }
        else{
            $valores[":id"] = $this->id;
            $sql = "update sis_".$this->tabla." set ".implode(", ", $camposUpdate)." where id = :id";
        }
        
        $ret = $bd->ejecutar($sql, $valores);
        
        if (empty($this->id)){
            $this->id = $bd->obtenerId();
        }
        
        return $ret;
    }
    
    public function borrar(){       
        $bd = myApp::getBaseDatos();
        $sql = "delete from sis_".$this->tabla." where id = :id";
        
        $ret = $bd->ejecutar($sql, [":id" => $this->id]);
        
        return $ret;
    }
}