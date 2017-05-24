<?php

class myRoute {

    public static function boot() {
        Slim\Slim::registerAutoloader();
        $app = new Slim\Slim();
        myRequest::boot($app->request->params());
        $app->get('/', myController::_("home@index"));
        $app->get('/cargo', myController::_("cargo@index"));
        $app->get('/cargo/:id', myController::_("cargo@mostrarCargo"));
        $app->post('/cargo', myController::_("cargo@guardarCargo"));
        $app->delete('/cargo/:id', myController::_("cargo@borrarCargo"));

        $app->run();
        return $app;
    }

}
