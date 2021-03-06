<?php

class mySesion {

    public static function boot() {
        session_start();
    }

    public static function get($var, $default='') {
        return !empty($_SESSION[$var]) ? $_SESSION[$var] : $default;
    }

    public static function set($var, $valor) {
        $_SESSION[$var] = $valor;
    }

    public static function borrar($var) {
        unset($_SESSION[$var]);
    }

}
