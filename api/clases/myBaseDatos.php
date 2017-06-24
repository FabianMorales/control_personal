<?php

class myBaseDatos{
    private $db;
    
    public function conectar(){
        $cfg = new myConfig();
        $this->db = new PDO('mysql:host='.$cfg->host.';dbname='.$cfg->database, $cfg->username, $cfg->password);
    }
    
    private function prepararSql($sql, $params = []){
        $query = $this->db->prepare($sql);
        if (sizeof($params)){
            foreach ($params as $i => $p){
                $tipoParam = gettype($p) == "integer" ? PDO::PARAM_INT : PDO::PARAM_STR;
                if (empty($p)){
                    $tipoParam = PDO::PARAM_NULL;
                }
                
                $query->bindValue($i, $p, $tipoParam);
            }
        }
        
        return $query;
    }
    
    public function ejecutar($sql, $params = []){        
        if (!sizeof($this->db)){
            $this->conectar();
        }
        
        $query = $this->prepararSql($sql, $params);
        
        $query->execute();
        return $query->rowCount();
    }
    
    public function consultar($sql, $params = [], $clase = ""){
        if (!sizeof($this->db)){
            $this->conectar();
        }
        
        $query = $this->prepararSql($sql, $params);
        $query->execute();
        if (!empty($clase)){
            $ret = $query->fetchAll(PDO::FETCH_CLASS, $clase);
        }
        else{
            $ret = $query->fetchAll(PDO::FETCH_OBJ);
        }
        
        return $ret;
    }
    
    public function obtenerId(){
        if (!sizeof($this->db)){
            $this->conectar();
        }
        
        return $this->db->lastInsertId();
    }
}
