angular.module('common.components').directive('paginationGrid', ['$timeout', '$window', function ($timeout, $window) {

    var template = "<div class='table-responsive pagination-grid'>\n" +
        "   <table class='table table-bordered table-hover table-striped'>\n" +
        "       <thead>\n" +
        "           <tr>\n" +
        "               <th ng-if='options.rowCheckable' class='grid-checkbox-cell'>" +
        "                   <input type='checkbox' ng-click='checkAllRows(isCheckAllRow)' ng-model='isCheckAllRow' ng-checked='options.allRowCheckedFlag'>" +
        "               </th>" +
        "               <th ng-repeat='col in columns' ng-if='col.headerColSpan>0' colspan = '{{::col.headerColSpan}}' style='{{::col.headStyle}}' ng-class='col.enableSorting ? \"sortable-head\" : \"\"' ng-click='sortData(col, columns)'>" +
        "                   <div ng-if='col.headTemplate' compile='col.headTemplate' cell-template-$scope='col.headTemplateScope'></div>" +
        "                   <div ng-if='!col.headTemplate' style='display:inline;'>{{col.headTemplate || col.displayName || col.field}}</div>" +
        "                   <div ng-if='col.sort == \"asc\"' style='display:inline;'><i class='glyphicon' ng-class='\"glyphicon glyphicon-triangle-bottom\"'></i></div>" +
        "                   <div ng-if='col.sort == \"desc\"' style='display:inline;'><i class='glyphicon' ng-class='\"glyphicon glyphicon-triangle-top\"'></i></div>" +
        "               </th>\n" +
        "           </tr>\n" +
        "       </thead>\n" +
        "       <tbody>\n" +
        "           <tr ng-repeat='item in options.data' ng-click='selecrRow(item)' ng-dblclick='doubleClick(item)' ng-class='item.$rowHighlighted ? \"row-highlight\" : \"\"'>\n" +
        "               <td ng-if='options.rowCheckable' class='grid-checkbox-cell'><input type='checkbox' ng-model='item.$checked' class='childChk' ng-click='checkRow(item)'></td>" +
        "               <td ng-repeat='col in columns' class='{{::col.cellClass}}' style='{{::col.cellStyle}}' >\n" +
        "                   <div ng-if='col.cellTemplate' compile='col.cellTemplate' cell-template-$scope='col.cellTemplateScope'></div>\n" +
        "                   <div ng-if='!col.cellTemplate' title='{{ ::item[col.field] }}'>{{ ::(col.filter ? $filter(col.filter)(item[col.field]) : item[col.field]) }}</div>\n" +
        "               </td>\n" +
        "           </tr>\n" +
        "           <tr ng-if='options.data == null || options.data.length == 0'>" +
        "               <td colspan='{{columnNumber}}' class='no-data'>{{options.noDataMessage}}</td>" +
        "           </tr>" +
        "           <tr ng-if='options.useExternalPagination'>" +
        "               <td colspan='{{maxColumnNum}}'>" +
        "                   <div paged-grid-bar></div>" +
        "               </td>" +
        "           </tr>" +
        "       </tbody>\n" +
        "   </table>\n" +
        "</div>\n";


    return {
        restrict: 'E',
        replace: true,
        scope: {
            options: '=',
            onRowSelected: '=',
            onRowChecked: '=',
            onRowDbClicked: '=',
            onPaginationChange: '=',
            onSortChanged: '=',
            api: '='
        },
        link: function ($scope, element, attrs) {
            $scope.options.rowSelectable = $scope.options.rowSelectable || false;
            $scope.options.rowCheckable = $scope.options.rowCheckable || true;
            $scope.options.multiRowCheckable = $scope.options.multiRowCheckable || false;
            $scope.options.allRowCheckedFlag = $scope.options.allRowCheckedFlag || false;
            if (!$scope.options.multiRowCheckable) {
                $scope.options.allRowCheckedFlag = false;
            }

            $scope.options.useExternalPagination = $scope.options.useExternalPagination || false;
            $scope.options.noDataMessage = $scope.options.noDataMessage || '没有找到匹配的结果。';

            $scope.appScope = $scope.$parent;

            $scope.setGridData = function (gridData, totalRecordCount) {
                $scope.options.data = gridData;
                $scope.dataBackup = angular.copy($scope.options.data);
                $scope.options.totalRecordCount = totalRecordCount;
                updateRowCheckedFlag();
            };

            $scope.sortData = function (col, columns) {
                if (!col.enableSorting) {
                    return;
                }
                var sortedData = {};

                _.forEach(columns, function (otherCol) {
                    if (col.field != otherCol.field) {
                        otherCol.sort = null;
                    }
                });

                if (col.sort == null) {
                    col.sort = 'desc';
                } else if (col.sort == 'desc') {
                    col.sort = 'asc';
                } else if (col.sort == 'asc') {
                    col.sort = null;
                }

                if ($scope.options.useExternalPagination) {
                    if ($scope.onSortChanged) {
                        var sortField = col.sort == null ? null : col.field;
                        $scope.onSortChanged($scope.options.currentPage, $scope.options.paginationPageSize, sortField, col.sort);
                    }
                } else {
                    if (col.sort == null) {
                        sortedData = $scope.dataBackup;
                    } else if (col.sort == 'asc') {
                        sortedData = _.sortBy($scope.options.data, col.field);
                    } else if (col.sort == 'desc') {
                        sortedData = _.sortBy($scope.options.data, col.field).reverse();
                    }
                    angular.copy(sortedData, $scope.options.data);
                }
            };

            /**
             *
             */
            $scope.checkAllRows = function (isAllRowChecked) {
                _.forEach($scope.options.data, function (row) {
                    if (row.$checkable != false) {
                        row.$checked = isAllRowChecked;
                    }
                });
                $scope.options.allRowCheckedFlag = isAllRowChecked;
            };

            $scope.checkRow = function (row) {
                if ($scope.onRowChecked) {
                    $scope.onRowChecked(row);
                }
                updateRowCheckedFlag();
            };

            $scope.selectRow = function (row, rows) {
                if ($scope.onRowSelected && !$scope.options.rowSelectable) {
                    cleanRows(rows);
                    row.$rowHighlighted = true;

                    $scope.onRowSelected(row);
                }
            };

            $scope.doubleSelectSingleRow = function (row, rows) {
                if ($scope.onRowDbClicked) {
                    cleanRows(rows);
                    $scope.onRowDbClicked(row);
                }
            };

            $scope.unSelectedSingleRow = function () {
                cleanRows($scope.options.data);
            };

            var cleanRows = function (rows) {
                _.forEach(rows, function (row) {
                    row.$rowHighlighted = false;
                });
            };

            var updateRowCheckedFlag = function () {
                //checkbox的全选和全不选的问题
                if ($scope.options.data == null || $scope.options.data.length == 0) {
                    $scope.options.allRowCheckedFlag = false;
                    return;
                }
                var uncheckedRow = _.find($scope.options.data, function (row) {
                    return row.$checked == false || row.$checked == null;
                });
                $scope.options.allRowCheckedFlag = (uncheckedRow == null);
            }


            $scope.getCheckedRows = function () {
                var checkedRows = [];
                _.forEach($scope.options.data, function (item) {
                    if (item.$checked) {
                        checkedRows.push(item);
                    }
                });
                return checkedRows;
            };

            $scope.doubleClick = function (item) {
                if ($scope.options.onDoubleClick) {
                    $scope.options.onDoubleClick(item);
                }
            };

            $scope.clickSingleRow = function (item) {
                if ($scope.options.onDoubleClick) {
                    $scope.options.onDoubleClick(item);
                }
            };

            /**
             * 初始化列
             **/
            var initColumns = function () {
                $scope.columns = _.filter($scope.options.columnDefs, function (item) {
                    if (item.hidden == true) {
                        return false;
                    } else {
                        return true;
                    }
                });
                if ($scope.options.rowCheckable) {
                    $scope.maxColumnNum = $scope.columns.length + 1;
                } else {
                    $scope.maxColumnNum = $scope.columns.length;
                }


                var headerColSpan = 1;
                _.forEach($scope.columns, function (col) {
                    //处理ColSpan, ColSpan的列不支持排序
                    if (headerColSpan > 1) {
                        //被之前的列融合
                        headerColSpan--;
                        col.headerColSpan = -1;
                        col.enableSorting = false;
                    } else {
                        //没有被之前的列融合
                        if (col.headerColSpan == null) {
                            col.headerColSpan = 1;
                        }
                        if (col.headerColSpan > 1) {
                            headerColSpan = col.headerColSpan;
                            col.enableSorting = false;
                        }
                    }

                    //处理sorting
                    if (angular.isUndefined(col.enableSorting)) {
                        col.enableSorting = true;
                    }
                });
            };

            var initData = function () {
                initColumns();

                // init explore api
                $scope.$watch('api', function (newVal, oldVal) {
                    if ($scope.api) {
                        $scope.api.getCheckedRows = $scope.getCheckedRows;
                        $scope.api.checkAllRows = $scope.checkAllRows;
                        $scope.api.setGridData = $scope.setGridData;
                    }
                });
            };

            initData();
        },
        template: template
    }
}])
    .directive('pagedGridBar', function () {
        return {
            restrict: 'A',
            link: function link($scope, el, attrs) {
                $scope.options.currentPage = 1;
                $scope.options.currentGroup = 0;

                $scope.$watch('options.totalRecordCount', function () {
                    pageChange();
                }, true);

                $scope.$watch('options.paginationPageSize', function () {
                    $scope.options.currentPage = 1;
                    $scope.options.currentGroup = 0;
                    $scope.paged($scope.options.currentPage);
                    pageChange();
                }, true);

                var pageChange = function () {
                    $scope.options.paginationPageSizes = $scope.options.paginationPageSizes || [10, 25, 50];
                    $scope.options.paginationPageSize = $scope.options.paginationPageSize || 10;
                    $scope.options.totalRecordCount = $scope.options.totalRecordCount || 0;
                    var maxSize = $scope.options.totalRecordCount / $scope.options.paginationPageSize;
                    if (parseInt(maxSize) == maxSize) {
                        $scope.maxNum = parseInt(maxSize);
                    } else {
                        $scope.maxNum = parseInt(maxSize) + 1;
                    }
                    /*console.log('$scope.maxNum is ' + $scope.maxNum)*/
                    var numArray = [], itemArray = [], groupId = 0, itemId = 1, loopId = 1;
                    while (itemId <= $scope.maxNum) {
                        itemArray.push(itemId++);
                        loopId++;
                        if (itemId > $scope.maxNum) {
                            numArray.push(itemArray);
                        } else {
                            if (loopId == 11) {
                                groupId++;
                                loopId = 1;
                                numArray.push(itemArray);
                                itemArray = [];
                            }
                        }
                    }
                    $scope.maxGroup = groupId;
                    $scope.pageNums = numArray;
                    $scope.itemNumberStart = function () {
                        if ($scope.options.totalRecordCount == 0) {
                            return 0;
                        }
                        return ($scope.options.currentPage - 1) * $scope.options.paginationPageSize + 1;
                    };
                    $scope.itemNumberEnd = function () {
                        var endNum = ($scope.options.currentPage - 1) * $scope.options.paginationPageSize + $scope.options.paginationPageSize;
                        if (endNum > $scope.options.totalRecordCount) {
                            return $scope.options.totalRecordCount;
                        } else {
                            return endNum;
                        }
                    };
                    $scope.paged = function (pageNum) {
                        $scope.options.currentPage = pageNum;
                        if (!angular.isUndefined($scope.onPaginationChange)) {
                            $scope.onPaginationChange($scope.options.currentPage, $scope.options.paginationPageSize);
                        }
                        $scope.options.allRowCheckedFlag = false;
                    };
                    var getGroup = function (page) {
                        var returnGroup = 0, group = 0;
                        _.forEach($scope.pageNums, function (groups) {
                            if (_.includes(groups, page)) {
                                returnGroup = group;
                            }
                            group++;
                        });
                        return returnGroup;
                    };
                    $scope.previous = function () {
                        $scope.options.currentPage--;
                        $scope.options.currentGroup = getGroup($scope.options.currentPage);
                        $scope.paged($scope.options.currentPage);
                    };
                    $scope.next = function () {
                        $scope.options.currentPage++;
                        $scope.options.currentGroup = getGroup($scope.options.currentPage);
                        $scope.paged($scope.options.currentPage);
                    };
                    $scope.first = function () {
                        $scope.options.currentGroup = 0;
                        $scope.paged(1);
                    };
                    $scope.last = function () {
                        /*$scope.options.currentPage = $scope.maxNum;*/
                        $scope.options.currentGroup = $scope.maxGroup;
                        $scope.paged($scope.maxNum);
                    };
                    $scope.nextGroup = function () {
                        $scope.options.currentGroup++;
                        $scope.paged($scope.options.currentGroup * 10 + 1);
                    };
                    $scope.previousGroup = function () {
                        $scope.paged($scope.options.currentGroup * 10);
                        $scope.options.currentGroup--;
                    };
                };
            },
            template: '' +
            '<div class="grid-page-bar">' +
            '   <a href="javascript:void(0)" class="glyphicon glyphicon-step-backward paged-grid-ctrl-link paged-grid-link" ng-click="first()" ng-class="options.currentPage==1?\'not-active\':\'\'"></a>' +
            '   <a href="javascript:void(0)" class="glyphicon glyphicon-triangle-left paged-grid-ctrl-link2 paged-grid-link" ng-click="previous()" ng-class="options.currentPage==1?\'not-active\':\'\'"></a>' +
            '   <a href="javascript:void(0)" class="paged-grid-num-link paged-grid-link" ng-if="options.currentGroup > 0" ng-click="previousGroup()">...</a>' +
            '   <a href="javascript:void(0)" class="paged-grid-num-link paged-grid-link" ng-repeat="pageNum in pageNums[options.currentGroup]" ng-click="paged(pageNum)" ng-class="pageNum == options.currentPage ? \'paged-grid-link-active\' : \'\'">{{pageNum}}</a>' +
            '   <a href="javascript:void(0)" class="paged-grid-num-link paged-grid-link" ng-if="options.currentGroup < maxGroup" ng-click="nextGroup()">...</a>' +
            '   <a href="javascript:void(0)" class="glyphicon glyphicon-triangle-right paged-grid-ctrl-link3 paged-grid-link" ng-click="next()" ng-class="(options.currentPage == maxNum || maxNum == 0)?\'not-active\':\'\'"></a>' +
            '   <a href="javascript:void(0)" class="glyphicon glyphicon-step-forward paged-grid-ctrl-link paged-grid-link" ng-click="last()" ng-class="(options.currentPage==maxNum || maxNum == 0)?\'not-active\':\'\'"></a>' +
            '   <span class="data-count-desc">当前 {{itemNumberStart()}} - {{itemNumberEnd()}} 条，总共 {{options.totalRecordCount}} 条</span>' +
            '   <div class="pull-right paged-display-list">' +
            '       <span>每页显示</span>' +
            '       <select ng-model="options.paginationPageSize" ng-options="di for di in options.paginationPageSizes"></select>' +
            '    </div>' +
            '</div>'
        };
    })
    .directive('compile', [
        '$compile',
        function ($compile) {
            return {
                /*require: '^form',*/
                restrict: 'A',
                link: function (scope, element, attrs) {
                    scope.cellTemplateScope = scope.$eval(attrs.cellTemplateScope);
                    // Watch for changes to expression.
                    scope.$watch(attrs.compile, function (new_val) {
                        var new_element = angular.element(new_val);
                        element.append(new_element);
                        $compile(new_element)(scope);
                    });
                }
            };
        }
    ]);