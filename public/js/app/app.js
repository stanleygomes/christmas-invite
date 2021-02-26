var App = angular.module('app', [
    'ngRoute',
    'ngResource',
    'ngSanitize',
    'ui.router',
    'ui.bootstrap'
]);

App.constant('URL_API', '/api/v2/')

App.run(['$rootScope', '$state', '$stateParams', '$window', '$http', '$filter', '$interval', '$q', 'bo', 'utils',
    function ($rootScope, $state, $stateParams, $window, $http, $filter, $interval, $q, bo, utils) {
        
    }
]);

App.controller('appController', ['$scope', function ($scope) {

}])