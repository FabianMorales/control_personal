(function($angular, _, $window){
    $angular.config(['$routeProvider', function($routeProvider) {
       $routeProvider
       .when('/historico', {
            templateUrl: 'templates/historico.html', controller: 'HistoricoController'
       })
       .otherwise({
            templateUrl: 'templates/registro.html', controller: 'MainController'
       });
    }])
    .controller('HistoricoController', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {        
        $scope.empleados = null;
        $scope.turnos = null;
        $scope.empleado = '';
        
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
})(window.$angular, window._, window);