(function($angular, $window){
    $window.$angular = $angular.module('controlPersonal', ['ngRoute', '720kb.tooltips', 'moment-picker'])
    .config(['$httpProvider', function($httpProvider) {
        if (!$httpProvider.defaults.headers.get) {
            $httpProvider.defaults.headers.get = {};    
        }

        $httpProvider.defaults.headers.get['If-Modified-Since'] = 'Mon, 26 Jul 1997 05:00:00 GMT';

        $httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache';
        $httpProvider.defaults.headers.get['Pragma'] = 'no-cache';
        
        $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    }])
    .config(['$locationProvider', function($locationProvider) {
        $locationProvider.hashPrefix('');
    }])
    .factory('sesion', ['$http', function($http) {
        var $sesion = 0;
        var $usuario = {};
        return function($fn) {
            $http({
                method: 'GET',
                url: './api/sesion'
            }).then(function (response) {
                $sesion = response.data.sesion;
                if ($sesion === 1){
                    $usuario = response.data.usuario;
                }
                
                var controllerElement = document.querySelector('[ng-controller=MainController]');
                var controllerScope = $angular.element(controllerElement).scope();
                controllerScope.sesion = {sesion: $sesion, empleado: $usuario};
                
                $fn($sesion, $usuario);
            }, function (response) {

            });
        };
    }])
})(angular, window);
