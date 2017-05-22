(function($angular, _, $window){
    $angular.controller('MainController', ['$scope', '$http', function ($scope, $http) {
        $scope.cedula = '';
        $scope.clave = '';
        $scope.empleado = null;

        $scope.menus = [
            { label: 'Inicio', clase:'fi-home', href: '#/', activo: false },
            { label: 'Gestión de cargos', clase:'fi-torsos-all', href: '#/cargos', activo: false },
            { label: 'Gestión de empleados', clase:'fi-torso', href: '#/empleados', activo: false },
            { label: 'Gestión de turnos', clase:'fi-clipboard-pencil', href: '#/turnos', activo: false },
            { label: 'Histórico', clase:'fi-clock', href: '#/historico', activo: false }
        ];

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

        $scope.activar = function(menu){
            _.forEach($scope.menus, function(value, key) {
                value.activo = false;
            });

            menu.activo = true;

            console.log($scope.menus);
        };

        $scope.autorizar = function() {
            console.log($scope.cedula);
            var $i = _.findIndex($scope.empleados, function(o) { return o.cedula == $scope.cedula; });
            console.log($i);

            var $emp = $scope.empleados[$i];

            if (_.isEmpty($emp)){
                alert('El empleado no existe');
                return;
            }

            if ($emp.clave !== $scope.clave){
                alert('La clave no es válida');
                return;
            }

            $scope.empleado = $emp;
        };

        $scope.buscarCargo = function($id){
            var $cargo = _.findIndex($scope.cargos, function(o) { return o.id === $id; });        
            return $scope.cargos[$cargo].nombre;
        };

        $scope.iniciar = function() {
            alert('Funcionalidad no implementada');
        };
    }]);
})(window.$angular, window._, window);