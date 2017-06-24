<?php

abstract class myControlador {

    public function ejecutar($tarea = "index", $args = []) {
        if (!$tarea) {
            $tarea = "index";
        }

        if (method_exists($this, $tarea)) {
            $func = [$this, $tarea];
            echo call_user_func_array($func, $args);
        } else {
            echo "Opción no válida";
        }
    }

    public static function _($ruta) {
        list($controlador, $tarea) = explode("@", $ruta);
        $c = myApp::getControlador($controlador);
        return function() use ($c, $tarea) {
            echo $c->ejecutar($tarea, func_get_args());
        };
    }

    public abstract function index();
}
