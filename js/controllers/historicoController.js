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
        $scope.turnos = [
            { id: 1, idEmpleado: 1, inicio: '08:05', fin: '16:30' , fecha: '2017-04-01'},
            { id: 2, idEmpleado: 1, inicio: '08:00', fin: '16:30' , fecha: '2017-04-02'},
            { id: 3, idEmpleado: 1, inicio: '08:05', fin: '16:30' , fecha: '2017-04-03'},
            { id: 4, idEmpleado: 1, inicio: '08:10', fin: '16:30' , fecha: '2017-04-04'},
            { id: 5, idEmpleado: 2, inicio: '08:00', fin: '16:30' , fecha: '2017-04-01'},
            { id: 6, idEmpleado: 2, inicio: '08:03', fin: '16:30' , fecha: '2017-04-02'},
            { id: 7, idEmpleado: 2, inicio: '08:02', fin: '16:30' , fecha: '2017-04-03'},
            { id: 8, idEmpleado: 3, inicio: '08:00', fin: '16:30' , fecha: '2017-04-01'},
            { id: 9, idEmpleado: 3, inicio: '08:05', fin: '16:30' , fecha: '2017-04-02'},
            { id: 10, idEmpleado: 4, inicio: '12:00', fin: '20:30', fecha: '2017-04-01' },
            { id: 11, idEmpleado: 4, inicio: '08:01', fin: '16:30', fecha: '2017-04-02' },
            { id: 12, idEmpleado: 4, inicio: '08:05', fin: '16:30', fecha: '2017-04-03' },
            { id: 13, idEmpleado: 5, inicio: '08:06', fin: '16:30', fecha: '2017-04-01' },
            { id: 14, idEmpleado: 5, inicio: '08:05', fin: '16:30', fecha: '2017-04-02' },
            { id: 15, idEmpleado: 6, inicio: '08:01', fin: '16:30', fecha: '2017-04-01' },
            { id: 16, idEmpleado: 6, inicio: '08:05', fin: '16:30', fecha: '2017-04-02' },
            { id: 17, idEmpleado: 6, inicio: '08:02', fin: '16:30', fecha: '2017-04-03' },
            { id: 18, idEmpleado: 6, inicio: '08:05', fin: '16:30', fecha: '2017-04-04' },
            { id: 19, idEmpleado: 7, inicio: '08:15', fin: '16:30', fecha: '2017-04-01' },
            { id: 20, idEmpleado: 7, inicio: '08:10', fin: '16:30', fecha: '2017-04-02' },
            { id: 21, idEmpleado: 7, inicio: '08:01', fin: '16:30', fecha: '2017-04-03' },
            { id: 22, idEmpleado: 7, inicio: '08:00', fin: '16:30', fecha: '2017-04-04' },
            { id: 23, idEmpleado: 7, inicio: '08:00', fin: '16:30', fecha: '2017-04-05' },
            { id: 24, idEmpleado: 7, inicio: '08:02', fin: '16:30', fecha: '2017-04-06' },
            { id: 25, idEmpleado: 7, inicio: '08:05', fin: '16:30', fecha: '2017-04-07' },
            { id: 26, idEmpleado: 7, inicio: '08:07', fin: '16:30', fecha: '2017-04-08' },
            { id: 27, idEmpleado: 7, inicio: '08:09', fin: '16:30', fecha: '2017-04-09' },
            { id: 28, idEmpleado: 7, inicio: '08:10', fin: '16:30', fecha: '2017-04-10' },
            { id: 29, idEmpleado: 7, inicio: '08:01', fin: '16:30', fecha: '2017-04-11' },
            { id: 30, idEmpleado: 7, inicio: '08:00', fin: '16:30', fecha: '2017-04-12' },
            { id: 31, idEmpleado: 7, inicio: '08:02', fin: '16:30', fecha: '2017-04-13' },
            { id: 32, idEmpleado: 7, inicio: '08:00', fin: '16:30', fecha: '2017-04-14' },
        ];

        $scope.empleados = [
            { id: '' },
            { id: 1, cedula: '0001', nombre: 'Empleado uno', idCargo: 1, salario: 123456, clave: 'abcd' },
            { id: 2, cedula: '0002', nombre: 'Empleado dos', idCargo: 2, salario: 123456, clave: 'abcd' },
            { id: 3, cedula: '0003', nombre: 'Empleado tres', idCargo: 3, salario: 123456, clave: 'abcd' },
            { id: 4, cedula: '0004', nombre: 'Empleado cuatro', idCargo: 4, salario: 123456, clave: 'abcd' },
            { id: 5, cedula: '0005', nombre: 'Empleado cinco', idCargo: 5, salario: 123456, clave: 'abcd' },
            { id: 6, cedula: '0006', nombre: 'Empleado seis', idCargo: 6, salario: 123456, clave: 'abcd' },
            { id: 7, cedula: '0007', nombre: 'Empleado siete', idCargo: 6, salario: 123456, clave: 'abcd' }
        ];

        $scope.empleado = '';

        $scope.obtenerEmpleado = function($id){
            var $emp = _.findIndex($scope.empleados, function(o) { return o.id == $id; });        
            return $scope.empleados[$emp].nombre;
        }
    }]);
})(window.$angular, window._, window);