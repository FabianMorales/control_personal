(function($angular, _, $window){
    $angular.config(['$routeProvider', function($routeProvider) {
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
    .controller('CargosController', ['$scope', '$http', '$routeParams', '$location', function ($scope, $http, $routeParams, $location) {
        $scope.cargos = [];
        $scope.cargo = {};

        $scope.init = function(){
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
})(window.$angular, window._, window);