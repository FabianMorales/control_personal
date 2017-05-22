(function($angular, _, $window){
    $angular.config(['$routeProvider', function($routeProvider) {
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
    .controller('EmpleadosController', ['$scope', '$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.empleados = [
            { id: 1, cedula: '0001', nombre: 'Empleado uno', idCargo: 1, salario: 123456, clave: 'abcd' },
            { id: 2, cedula: '0002', nombre: 'Empleado dos', idCargo: 2, salario: 123456, clave: 'abcd' },
            { id: 3, cedula: '0003', nombre: 'Empleado tres', idCargo: 3, salario: 123456, clave: 'abcd' },
            { id: 4, cedula: '0004', nombre: 'Empleado cuatro', idCargo: 4, salario: 123456, clave: 'abcd' },
            { id: 5, cedula: '0005', nombre: 'Empleado cinco', idCargo: 5, salario: 123456, clave: 'abcd' },
            { id: 6, cedula: '0006', nombre: 'Empleado seis', idCargo: 6, salario: 123456, clave: 'abcd' },
            { id: 7, cedula: '0007', nombre: 'Empleado siete', idCargo: 6, salario: 123456, clave: 'abcd' }
        ];

        $scope.cargos = [
            { id: 1, nombre: 'Gerente' },
            { id: 2, nombre: 'Coordinador' },
            { id: 3, nombre: 'Jefe' },
            { id: 4, nombre: 'Director' },
            { id: 5, nombre: 'Vendedor' },
            { id: 6, nombre: 'Operario' }        
        ];

        if ($routeParams != 'undefined'){
            $scope.empleado = $scope.empleados[$routeParams.idEmpleado - 1];
        }

        $scope.guardar = function() {
            alert('Esta funcionalidad no está implementada');
        };

        $scope.borrar = function() {
            alert('Esta funcionalidad no está implementada');
        };
    }]);
})(window.$angular, window._, window);