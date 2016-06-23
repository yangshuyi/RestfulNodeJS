'use strict';
angular.module('common.components')
    .directive("checkbox", ['$timeout', function ($timeout) {
        var template = '' +
            '<div class="checkbox" ng-click="toggle()">' +
            '   <div ng-class="{' +
            '       field : (ngModel!=true && disabled!=\'true\'), ' +
            '       \'field checked\': (ngModel==true && disabled!=\'true\'),' +
            '       \'field disabled\': (ngModel!=true && disabled==\'true\'),' +
            '       \'field disabledchecked\': (ngModel==true && disabled==\'true\') ' +
            '       }">{{caption}}</div>' +
            '</div>';

        return {
            restrict: 'EA',
            scope: {
                caption: '@',
                disabled: '@',
                ngModel: '='
            },
            replace: false,
            link: function ($scope, $elem, attrs) {
                //Options
                $scope.caption = $scope.caption || '';

                //public method
                $scope.toggle = function () {
                    if($scope.disabled == 'true'){
                        return;
                    }
                    $scope.ngModel = !$scope.ngModel;
                };
            },
            template: template
        };
    }]);