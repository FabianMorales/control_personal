<?php

class usuarioController extends myController {

    public function index() {
        $usuarios = Usuario::all();
        return $usuarios->toJson();
    }
    
    public function mostrarUsuario($id){
        $usuario = Usuario::find($id);
        if (sizeof($usuario)){
            return $usuario->toJson();
        }
        else{
            return json_encode([]);
        }
    }
    
    public function guardarUsuario(){
        $req = myApp::getRequest();
        $id = $req->getVar("id");
        
        $usuario = Usuario::find($id);
        if (!sizeof($usuario)){
            $usuario = new Usuario();
        }
        
        $usuario->fill($req->all());
        
        $ret = [];
        if ($usuario->save()){
            $ret = ["ok" => 1, "mensaje" => "Usuario guardado exitosamente"];
        }
        else{
            $ret = ["ok" => 0, "mensaje" => "No se pudo guardar el usuario"];
        }
        
        return json_encode($ret);
    }
    
    public function borrarUsuario($id){   
        $usuario = Usuario::find($id);
        $ret = [];
        
        if (!sizeof($usuario)){
            $ret = ["ok" => 0, "mensaje" => "Usuario no encontrado"];
        }
        else{
            if ($usuario->delete()){
                $usuarios = Usuario::all();
                $ret = ["ok" => 1, "mensaje" => "Usuario borrado exitosamente", "datos" => $usuarios];
            }
            else{
                $ret = ["ok" => 0, "mensaje" => "No se pudo borrar el usuario"];
            }
        }
        
        return json_encode($ret);
    }
    
    public function listarUsuarios(){
        $cargos = Usuario::all();
        $dirBase = BASE_DIR."/almacenamiento/usuarios".uniqid().".txt";
        $dirs = ["almacenamiento", "usuarios"];
        $dir = BASE_DIR;
        foreach ($dirs as $d){
            $dir .= "/".$d;
            if (!is_dir($dir)){
                mkdir($dir);   
            }
        }

        $file = fopen($dirBase, "a");
        fwrite($file, "ID,Nombre\r\n");
        foreach($usuarios as $u){
            fwrite($file, $u->id.",".$u->nombre."\r\n");
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
}
