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
    .controller('CargosController', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.cargos = [];

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
                url: './api/cargo/guardar',
                data: $scope.cargo
            }).then(function (response) {
                $scope.cargos = response.data;
            }, function (response) {

            });
        };

        $scope.borrar = function() {
            alert('Esta funcionalidad no está implementada');
        };
    }]);
})(window.$angular, window._, window);