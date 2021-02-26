App.controller('sugarcaneInputController', [
    '$scope', 'bo', 'utils',
    function ($scope, bo, utils) {

        $scope.form = {};

        $scope.form.atrf = 0;
        $scope.form.atrq = 0;
        $scope.form.atrp = 0;
        $scope.form.atrrel = 0;
        $scope.form.date = '';

        $scope.atrTableLookup = function () {
            var params = {
                date: $scope.form.date
            };

            bo.AtrTable.lookupByDate(params).then(function (response) {
                console.log(response)
                // validar se os dados vieram
                $scope.atrTableLoaded = true;
            });
        }

        $scope.atrTableLoaded = false;

        $scope.onChangeATR = function () {

            $scope.form.atrrel = Number($scope.form.atrf) + Number($scope.form.atrq) + Number($scope.form.atrp);
        }
    }
]);
