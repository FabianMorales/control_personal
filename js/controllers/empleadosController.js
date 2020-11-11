(function($angular, _, $window){
    $window.$angular.config(['$routeProvider', function($routeProvider) {
       $routeProvider
       .when('/empleados', {
          templateUrl: 'templates/empleados/lista.html', controller: 'EmpleadosController'
       })
       .when('/empleados/crear', {
          templateUrl: 'templates/empleados/form.html', controller: 'EmpleadosController'
       })
       .when('/empleados/editar/:idEmpleado', {
        templateUrl: 'templates/empleados/form.html', controller: 'EmpleadosController'
       })
       .otherwise({
            templateUrl: 'templates/registro.html', controller: 'MainController'
       });
    }])
    .controller('EmpleadosController', ['$scope', '$http', '$routeParams', '$location','sesion', function ($scope, $http, $routeParams, $location, sesion) {
        $scope.cargos = [];
        $scope.empleados = [];
        $scope.empleado = {};
        $scope.sesion = { sesion: -1, empleado: null};
        
        $scope.init = function(){
            sesion(function($sesion, $usuario){
                $scope.sesion = { sesion: $sesion, empleado: $usuario };
                if ($sesion === 0){
                    $location.path('inicio');
                }
            });
            
            if ($routeParams !== 'undefined' && $routeParams.idEmpleado){
                $http({
                    method: 'GET',
                    url: './api/usuario/' + $routeParams.idEmpleado
                }).then(function (response) {
                    $scope.empleado = response.data;
                }, function (response) {

                });
                
                $http({
                    method: 'GET',
                    url: './api/cargo'
                }).then(function (response) {
                    $scope.cargos = response.data;
                }, function (response) {

                });
            }
            else if ($location.path() === '/empleados/crear'){
                $http({
                    method: 'GET',
                    url: './api/cargo'
                }).then(function (response) {
                    $scope.cargos = response.data;
                }, function (response) {

                });
            }
            else{
                $http({
                    method: 'GET',
                    url: './api/usuario'
                }).then(function (response) {
                    $scope.empleados = response.data;
                }, function (response) {

                });  
            };
        };

        $scope.guardar = function() {
            $http({
                method: 'POST',
                url: './api/usuario',
                data: $scope.empleado
            }).then(function (response) {
                $scope.empleados = response.data;
                $location.path('/empleados');
            }, function (response) {

            });
        };

        $scope.borrar = function($id) {
            if(!confirm('¿Está seguro de borrar este empleado?')){
                return;
            }
            
            $http({
                method: 'DELETE',
                url: './api/empleado/'+$id
            }).then(function (response) {
                if (response.data.ok === 1){
                    $scope.empleados = response.data.datos;
                    alert(response.data.mensaje);
                }
                else{
                    alert(response.data.mensaje);
                }
                
            }, function (response) {

            });
        };
    }]);
})(angular, window._, window);