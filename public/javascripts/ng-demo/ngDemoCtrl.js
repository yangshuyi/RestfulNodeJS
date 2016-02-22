angular.module('ngDemoModule').controller('ngDemoCtrl', ['$scope', 'dialogProvider', function ($scope, dialogProvider) {

        $scope.showDialog = function () {
            var dialogOptions = {
                title: 'cad'
            };

            dialogProvider.openDialog({
                templateUrl: 'javascripts/home/repairFacilityRemark.html',
                controllerName: 'repairFacilityRemarkCtrl',
                options: dialogOptions,
                resolves: {
                    cell1:'from outside cell1',
                    cell2:'from outside cell2'
                }
            }).then(function(result){
                $scope.$dialogScope = result;

                $scope.$dialogScope.onDialogClose = function(){
                    console.log('onDialogClose');
                }
            });
        }
    }])
    .controller('repairFacilityRemarkCtrl', ['$scope', function ($scope) {

        $scope.value = 'hello world';
        $scope.beforeDialogClose = function () {
            console.log('beforeDialogClose');
            return true;
        }
    }]);