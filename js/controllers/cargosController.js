(function($angular, _, $window){
    $window.$angular.config(['$routeProvider', function($routeProvider) {
       $routeProvider
       .when('/cargos', {
          templateUrl: 'templates/cargos/lista.html', controller: 'CargosController'
       })
       .when('/cargos/crear', {
          templateUrl: 'templates/cargos/form.html', controller: 'CargosController'
       })
       .when('/cargos/editar/:idCargo', {
          templateUrl: 'templates/cargos/form.html', controller: 'CargosController'
       })
       .otherwise({
            templateUrl: 'templates/registro.html', controller: 'MainController'
       });
    }])
    .controller('CargosController', ['$scope', '$http', '$routeParams', '$location', 'sesion', function ($scope, $http, $routeParams, $location, sesion) {
        $scope.cargos = [];
        $scope.cargo = {};
        $scope.empleado = null;
        $scope.sesion = { sesion: -1, empleado: null};

        $scope.init = function(){
            sesion(function($sesion, $usuario){
                $scope.sesion = { sesion: $sesion, empleado: $usuario };
                if ($sesion === 0){
                    $location.path('inicio');
                }
            });
            
            if ($routeParams !== 'undefined' && $routeParams.idCargo){
                $http({
                    method: 'GET',
                    url: './api/cargo/' + $routeParams.idCargo
                }).then(function (response) {
                    $scope.cargo = response.data;
                }, function (response) {

                }); 
            }
            else{
                $http({
                    method: 'GET',
                    url: './api/cargo'
                }).then(function (response) {
                    $scope.cargos = response.data;
                }, function (response) {

                });  
            };
        };

        $scope.guardar = function() {
            $http({
                method: 'POST',
                url: './api/cargo',
                data: $scope.cargo
            }).then(function (response) {
                $scope.cargos = response.data;
                $location.path('/cargos');
            }, function (response) {

            });
        };

        $scope.borrar = function($id) {
            if(!confirm('¿Está seguro de borrar este cargo?')){
                return;
            }
            
            $http({
                method: 'DELETE',
                url: './api/cargo/'+$id
            }).then(function (response) {
                if (response.data.ok === 1){
                    $scope.cargos = response.data.datos;
                    console.log($scope.cargos);
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