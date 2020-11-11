(function($angular, _, $window){
    $window.$angular.config(['$routeProvider', function($routeProvider) {
       $routeProvider
       .when('/turnos', {
          templateUrl: 'templates/turnos/lista.html', controller: 'TurnosController'
       })
       .when('/turnos/crear', {
          templateUrl: 'templates/turnos/form.html', controller: 'TurnosController'
       })
       .when('/turnos/editar/:idTurno', {
          templateUrl: 'templates/turnos/form.html', controller: 'TurnosController'
       })
       .otherwise({
            templateUrl: 'templates/registro.html', controller: 'MainController'
       });
    }])
    .controller('TurnosController', ['$scope', '$http', '$routeParams', '$location', 'sesion', function ($scope, $http, $routeParams, $location, sesion) {
        $scope.turnos = [];
        $scope.turno = {};
        $scope.sesion = { sesion: -1, empleado: null};

        $scope.init = function(){
            sesion(function($sesion, $usuario){
                $scope.sesion = { sesion: $sesion, empleado: $usuario };
                if ($sesion === 0){
                    $location.path('inicio');
                }
            });
            
            if ($routeParams !== 'undefined' && $routeParams.idTurno){
                $http({
                    method: 'GET',
                    url: './api/turno/' + $routeParams.idTurno
                }).then(function (response) {
                    $scope.turno = response.data;
                }, function (response) {

                }); 
            }
            else{
                $http({
                    method: 'GET',
                    url: './api/turno'
                }).then(function (response) {
                    $scope.turnos = response.data;
                }, function (response) {

                });  
            };
        };

        $scope.guardar = function() {
            $http({
                method: 'POST',
                url: './api/turno',
                data: $scope.turno
            }).then(function (response) {
                $scope.turnos = response.data;
                $location.path('/turnos');
            }, function (response) {

            });
        };

        $scope.borrar = function($id) {
            if(!confirm('¿Está seguro de borrar este turno?')){
                return;
            }
            
            $http({
                method: 'DELETE',
                url: './api/turno/'+$id
            }).then(function (response) {
                if (response.data.ok === 1){
                    $scope.turnos = response.data.datos;
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