(function($angular, _, $window){
    $window.$angular.config(['$routeProvider', function($routeProvider) {
       $routeProvider
       .when('/historico', {
            templateUrl: 'templates/historico.html', controller: 'HistoricoController'
       })
       .otherwise({
            templateUrl: 'templates/registro.html', controller: 'MainController'
       });
    }])
    .controller('HistoricoController', ['$scope', '$http', '$routeParams', 'sesion', '$location', function ($scope, $http, $routeParams, sesion, $location) {        
        $scope.empleados = null;
        $scope.turnos = null;
        $scope.empleado = '';
        $scope.sesion = { sesion: -1, empleado: null};
        
        $scope.obtenerTurnos = function(){
            $http({
                method: 'GET',
                url: './api/historico/turno'
            }).then(function (response) {
                $scope.empleados = response.data.empleados;
                $scope.turnos = response.data.turnos;
            }, function (response) {

            });
        }
        
        $scope.init = function(){
            sesion(function($sesion, $usuario){
                $scope.sesion = { sesion: $sesion, empleado: $usuario };
                if ($sesion === 0){
                    $location.path('inicio');
                }
            });
            $scope.obtenerTurnos();
        };

        $scope.obtenerEmpleado = function($id){
            var $emp = _.findIndex($scope.empleados, function(o) { return o.id == $id; });
            $ret = '';
            if ($emp >= 0){
                $ret = $scope.empleados[$emp].nombres;
            }
            return $ret;
        }
    }]);
})(angular, window._, window);