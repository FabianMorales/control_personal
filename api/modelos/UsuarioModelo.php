<?php

class UsuarioModelo extends myModelo {
    public $id;
    public $nombres;
    public $cedula;
    public $clave;
    public $correo;
    public $telefono;
    public $salario;
    public $id_cargo;
    
    protected $tabla = 'par_usuario';
    protected $asociables = array('id', 'nombres', 'cedula', 'correo', 'telefono', 'id_cargo', 'salario');
}
