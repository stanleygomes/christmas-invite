App.controller('usersController', ['$scope', function ($scope) {

    $scope.showProducers = false;

    $scope.form = {};

    $scope.userInit = function () {

        // USUARIO PRODUTOR
        $scope.showProducers = $scope.form.type == 2 ? true : false;
    }
    
    $scope.onChangeType = function () {

        // USUARIO PRODUTOR
        $scope.showProducers = $scope.form.type == 2 ? true : false;
    }
}]);