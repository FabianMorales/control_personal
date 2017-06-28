<?php

class TurnoTrabajoModelo extends myModelo {
    public $id;
    public $id_tipo;
    public $id_usuario;
    public $fecha_entrada;
    public $fecha_salida;
    public $estado;
    
    protected $tabla = 'tur_turno';
    protected $asociables = array('id', 'id_tipo', 'id_usuario', 'fecha_entrada', 'fecha_salida', 'estado');
}
