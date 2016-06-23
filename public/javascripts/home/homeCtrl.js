angular.module('homeModule').controller('homeCtrl', ['$scope', 'dialogProvider', function ($scope, dialogProvider) {

        $scope.checkboxModel = false;
        $scope.showDialog = function () {
            var dialogOptions = {
                title: 'cad',
                hasHead: false,
                autoHide: true,
                modal: false
            };

            dialogProvider.openDialog({
                templateUrl: 'javascripts/home/repairFacilityRemark.html',
                controllerName: 'repairFacilityRemarkCtrl',
                options: dialogOptions,
                resolves: {
                    'cell1':'from outside cell1',
                    'cell2':'from outside cell2'
                }
            }).then(function(result){
                $scope.$dialogScope = result;



                $scope.$dialogScope.onDialogClose = function(){
                    //alert($scope.$dialogScope.x);
                    console.log('onDialogClose');
                }
            });
        };

        $scope.estimateTotalAmountParticular = {};

        /**
         * 鼠标进入时获取定损金额的具体内容
         * @param $event
         */
        $scope.showEstimateTotalAmountParticular = function($event){
            var columnElement = $($event.currentTarget);
            $scope.estimateTotalAmountParticular.popup(columnElement, null, null);
        };

        /**
         * 鼠标离开时把定损金额的具体内容隐藏
         */
        $scope.hideEstimateTotalAmountParticular = function () {
            $scope.estimateTotalAmountParticular.closeWindow();
        };
    }])
    .controller('repairFacilityRemarkCtrl', ['$scope', 'cell1', 'cell2', function ($scope, cell1, cell2) {

        $scope.cell1 = cell1;
        $scope.cell2 = cell2;$scope.x = 0;

        $scope.value = 'hello world';
        $scope.beforeDialogClose = function () {
            console.log('beforeDialogClose');

            return true;
        }

        $scope.click = function(){
            $scope.x = 1;

            $scope.dialogApi.close();
        }

    }]);