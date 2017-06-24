<?php

class CargoModelo extends myModelo {
    public $id;
    public $nombre;
    
    protected $tabla = 'par_cargo';
    protected $asociables = array('id', 'nombre');
}
