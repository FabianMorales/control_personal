<?php

class TurnoModelo extends myModelo {
    public $id;
    public $nombre;
    public $inicio;
    public $fin;
    public $inicio_receso;
    public $fin_receso;
    
    protected $tabla = 'tur_tipo';
    protected $asociables = array('id', 'nombre', 'inicio', 'fin', 'inicio_receso', 'fin_receso');
}
