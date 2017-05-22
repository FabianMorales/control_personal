(function($angular, _, $window){
    $angular    .config(['$routeProvider', function($routeProvider) {
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
    .controller('TurnosController', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.turnos = [
            { id: 1, nombre: 'Jornada continua', inicio: '08:00', fin: '16:30', recesoInicio:'00:00', recesoFin:'00:00' },
            { id: 2, nombre: 'Turno partido', inicio:'08:00', fin:'20:00', recesoInicio:'12:00', recesoFin:'16:00' },
            { id: 3, nombre: 'Turno vespertino', inicio:'12:00', fin:'20:00', recesoInicio:'00:00', recesoFin:'00:00' },

        ];

        if ($routeParams != 'undefined'){
            $scope.turno = $scope.turnos[$routeParams.idTurno - 1];
        }

        $scope.guardar = function() {
            alert('Esta funcionalidad no está implementada');
        };

        $scope.borrar = function() {
            alert('Esta funcionalidad no está implementada');
        };
    }]);
})(window.$angular, window._, window);