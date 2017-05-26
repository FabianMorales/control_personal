<?php

class Usuario extends myEloquent {    
    protected $table = 'par_usuario';
    protected $fillable = array('id', 'name', 'username', 'email', 'password');
}
