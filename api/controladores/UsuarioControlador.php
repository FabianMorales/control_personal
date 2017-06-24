<?php

class UsuarioControlador extends myControlador {

    public function index() {
        $modelo = myApp::getModelo("Usuario");
        return $modelo->listarJson();
    }
    
    public function mostrarUsuario($id){
        $modelo = myApp::getModelo("Usuario");
        $modelo->encontrar($id);
        
        if (sizeof($modelo)){
            return $modelo->json();
        }
        else{
            return json_encode([]);
        }
    }
    
    public function guardarUsuario(){
        $req = myApp::getPeticion();
        $id = $req->getVar("id");
        
        $modelo = myApp::getModelo("Usuario");
        $modelo->encontrar($id);
        
        $modelo->asociar($req->all());
        
        $ret = [];
        if ($modelo->guardar()){
            $ret = ["ok" => 1, "mensaje" => "Usuario guardado exitosamente"];
        }
        else{
            $ret = ["ok" => 0, "mensaje" => "No se pudo guardar el usuario"];
        }
        
        return json_encode($ret);
    }
    
    public function borrarUsuario($id){   
        $modelo = myApp::getModelo("Usuario");
        $modelo->encontrar($id);
        $ret = [];
        
        if (!$modelo->id){
            $ret = ["ok" => 0, "mensaje" => "Usuario no encontrado"];
        }
        else{
            if ($modelo->borrar()){
                $usuarios = $modelo->listar();
                $ret = ["ok" => 1, "mensaje" => "Usuario borrado exitosamente", "datos" => $usuarios];
            }
            else{
                $ret = ["ok" => 0, "mensaje" => "No se pudo borrar el usuario"];
            }
        }
        
        return json_encode($ret);
    }
    
    public function descargarUsuario($id){
        $modelo = myApp::getModelo("Usuario");
        $modelo->encontrar($id);
        
        if ($modelo->id){
            $dirBase = BASE_DIR."/almacenamiento/usuarios/usuarios_".$id.".txt";
            $dirs = ["almacenamiento", "usuarios"];
            $dir = BASE_DIR;
            foreach ($dirs as $d){
                $dir .= "/".$d;
                if (!is_dir($dir)){
                    mkdir($dir);   
                }
            }

            $file = fopen($dirBase, "w");
            fwrite($file, "ID: ".$modelo->id."\r\n");
            fwrite($file, "Nombres: ".$modelo->nombres."\r\n");
            fwrite($file, "Correo: ".$modelo->correo."\r\n");
            fwrite($file, "Clave: ".$modelo->clave."\r\n");
            fwrite($file, "Telefono: ".$modelo->telefono."\r\n");
            fclose($file);

            $size = filesize($dirBase);
            header('Content-Description: File Transfer');
            header('Content-Type: text/txt');
            header('Content-Disposition: attachment; filename="usuario_'.$id.'.txt');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            readfile($dirBase);
        }
    }
    
    public function listarUsuarios(){
        $modelo = myApp::getModelo("Usuario");
        $usuarios = $modelo->listar();
        $dirBase = BASE_DIR."/almacenamiento/usuarios/".uniqid().".txt";
        $dirs = ["almacenamiento", "usuarios"];
        $dir = BASE_DIR;
        foreach ($dirs as $d){
            $dir .= "/".$d;
            if (!is_dir($dir)){
                mkdir($dir);   
            }
        }

        $file = fopen($dirBase, "a");
        fwrite($file, "ID,Nombres,Correo,Clave,Telefono\r\n");
        foreach($usuarios as $u){
            fwrite($file, $u->id.",".$u->nombres.",".$u->correo.",".$u->clave.",".$u->telefono."\r\n");
        }
        
        fclose($file);
        
        $size = filesize($dirBase);
        header('Content-Description: File Transfer');
        header('Content-Type: text/txt');
        header('Content-Disposition: attachment; filename="lista_usuarios.txt"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        readfile($dirBase);
        
        die();
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
}
