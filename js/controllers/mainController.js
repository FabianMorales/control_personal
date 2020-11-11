(function($angular, _, $window){
    $window.$angular.controller('MainController', ['$scope', '$http', 'sesion', '$location', function ($scope, $http, sesion, $location) {
        $scope.empleado = null;
        $scope.iniciar = 1;
        $scope.turno = null;
        $scope.sesion = { sesion: -1, empleado: null, cedula: '', clave: ''};

        $scope.menus = [
            { label: 'Inicio', clase:'fi-home', href: '#/', activo: false },
            { label: 'Gestión de cargos', clase:'fi-torsos-all', href: '#/cargos', activo: false },
            { label: 'Gestión de empleados', clase:'fi-torso', href: '#/empleados', activo: false },
            { label: 'Gestión de turnos', clase:'fi-clipboard-pencil', href: '#/turnos', activo: false },
            { label: 'Histórico', clase:'fi-clock', href: '#/historico', activo: false }
        ];
        
        $scope.init = function() {
            sesion(function($sesion, $usuario){
                $scope.sesion = { sesion: $sesion, empleado: $usuario };
                $scope.empleado = $usuario;
            });
        };

        $scope.activar = function(menu){
            _.forEach($scope.menus, function(value, key) {
                value.activo = false;
            });

            menu.activo = true;

            console.log($scope.menus);
        };

        $scope.autorizar = function() {
            $http({
                method: 'POST',
                url: './api/usuario/validar',
                data: { 'cedula': $scope.sesion.cedula, 'clave': $scope.sesion.clave }
            }).then(function (response) {
                if (response.data.ok === 1){
                    $scope.empleado = response.data.usuario;
                    $scope.sesion.sesion = 1;
                    
                    var controllerElement = document.querySelector('[ng-controller=MainController]');
                    var controllerScope = $angular.element(controllerElement).scope();
                    controllerScope.sesion = {sesion: 1, empleado: response.data.usuario};
                    
                    $scope.buscarTurno($scope.empleado.cedula);
                }
                else{
                    alert(response.data.mensaje);
                }
            }, function (response) {

            });
        };
        
        $scope.buscarTurno = function($cedula){
            $http({
                method: 'GET',
                url: './api/usuario/turno/' + $cedula
            }).then(function (response) {
                if (response.data.ok === 1){
                    $scope.iniciar = 0;
                    $scope.turno = response.data.turno;
                }
                else{
                    $scope.iniciar = 1;
                    $scope.turno = null;
                }
            }, function (response) {

            });
        };
        
        $scope.iniciarTurno = function($cedula){
            $http({
                method: 'GET',
                url: './api/usuario/iniciar/' + $cedula
            }).then(function (response) {
                $scope.iniciar = 0;
                $scope.turno = response.data.turno;
                alert(response.data.mensaje);
            }, function (response) {

            });
        };
        
        $scope.cerrarTurno = function($cedula){
            $http({
                method: 'GET',
                url: './api/usuario/cerrar/' + $cedula
            }).then(function (response) {
                $scope.iniciar = 1;
                $scope.turno = null;
                alert(response.data.mensaje);
            }, function (response) {

            });
        };

        $scope.buscarCargo = function($id){
            return "";
        };
        
        $scope.cerrarSesion = function(){
            $http({
                method: 'GET',
                url: './api/sesion/salir'
            }).then(function (response) {
                $scope.sesion = {sesion: 0, empleado: null};
                var controllerElement = document.querySelector('[ng-controller=MainController]');
                var controllerScope = $angular.element(controllerElement).scope();
                controllerScope.sesion = {sesion: 0, empleado: null};
                $location.path('inicio');
            }, function (response) {

            });
        };
    }]);
})(angular, window._, window);