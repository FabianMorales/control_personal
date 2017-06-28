(function($angular, _, $window){
    $angular.controller('MainController', ['$scope', '$http', function ($scope, $http) {
        $scope.cedula = '';
        $scope.clave = '';
        $scope.empleado = null;
        $scope.iniciar = 1;
        $scope.turno = null;

        $scope.menus = [
            { label: 'Inicio', clase:'fi-home', href: '#/', activo: false },
            { label: 'Gestión de cargos', clase:'fi-torsos-all', href: '#/cargos', activo: false },
            { label: 'Gestión de empleados', clase:'fi-torso', href: '#/empleados', activo: false },
            { label: 'Gestión de turnos', clase:'fi-clipboard-pencil', href: '#/turnos', activo: false },
            { label: 'Histórico', clase:'fi-clock', href: '#/historico', activo: false }
        ];

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
                data: { 'cedula': $scope.cedula, 'clave': $scope.clave }
            }).then(function (response) {
                if (response.data.ok === 1){
                    $scope.empleado = response.data.usuario;
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
    }]);
})(window.$angular, window._, window);