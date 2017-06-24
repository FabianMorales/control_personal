<?php

class myEnrutador {

    public static function boot() {
        Slim\Slim::registerAutoloader();
        $app = new Slim\Slim();
        myPeticion::boot($app->request->params());
        $app->get('/', myControlador::_("Home@index"));
        
        $app->get('/cargo', myControlador::_("Cargo@index"));
        $app->get('/cargo/:id', myControlador::_("Cargo@mostrarCargo"));
        $app->post('/cargo', myControlador::_("Cargo@guardarCargo"));
        $app->delete('/cargo/:id', myControlador::_("Cargo@borrarCargo"));
        
        $app->get('/usuario', myControlador::_("Usuario@index"));
        $app->get('/usuario/:id', myControlador::_("Usuario@mostrarUsuario"));
        $app->post('/usuario', myControlador::_("Usuario@guardarUsuario"));
        $app->post('/usuario/validar', myControlador::_("Usuario@validar"));
        $app->delete('/usuario/:id', myControlador::_("Usuario@borrarUsuario"));
        
        $app->get('/turno', myControlador::_("Turno@index"));
        $app->get('/turno/:id', myControlador::_("Turno@mostrarTurno"));
        $app->post('/turno', myControlador::_("Turno@guardarTurno"));
        $app->delete('/turno/:id', myControlador::_("Turno@borrarTurno"));
        
        $app->get('/files/cargo', myControlador::_("Cargo@listarCargos"));
        $app->get('/files/cargo/:id', myControlador::_("Cargo@descargarCargo"));
        $app->get('/files/usuario', myControlador::_("Usuario@listarUsuarios"));
        $app->get('/files/usuario/:id', myControlador::_("Usuario@descargarUsuario"));
        $app->get('/files/turno', myControlador::_("Turno@listarTurnos"));
        $app->get('/files/turno/:id', myControlador::_("Turno@descargarTurno"));
        $app->run();
        return $app;
    }

}
