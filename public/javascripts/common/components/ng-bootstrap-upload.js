angular.module('common.components')
    .directive('ngUpload', ['Upload', function (Upload) {
        var IMG_TYPE = ["bmp", "gif", "jpeg", "jpg", "png"];

        return {
            restrict: 'E',
            replace: true,
            scope: {
                options: '=',
                onDelete: '=',
                onUpload: '=',
                onFileClick: '='
            },
            link: function (scope, element, attrs) {
                scope.options.displaySize = scope.options || 10;
                scope.tdWidth = (100 / scope.options.displaySize) + "%";
                scope.options.caption = scope.options.caption || '附件上传';
                scope.options.uploadBtnCaption = scope.options.uploadBtnCaption || '上传';
                scope.options.deleteBtnCaption = scope.options.deleteBtnCaption || '删除';
                scope.options.data = scope.options.data || [];
                scope.init = function () {
                    // When refresh the UI the gallery don't back to first stage. Keep it in current stage.
                    scope.currentGroupNum = scope.currentGroupNum || 1;
                    scope.currentGroup = [];
                    scope.groupSize = scope.groupSize || 0;
                    if (scope.options.data.length > 0) {
                        _.forEach(scope.options.data, function (item) {
                            item._class = "img-div";
                            item._selection = false;
                            item[scope.options.widthField] = item[scope.options.widthField] || "600";
                        })
                        // separate group
                        var loopId = 0, groupId = 1;
                        scope.groups = _.groupBy(scope.options.data, function (n) {
                            if (loopId < scope.options.displaySize) {
                                loopId++;
                            } else {
                                loopId = 1;
                                groupId++;
                            }
                            return groupId;
                        });
                        scope.currentGroup = scope.groups[scope.currentGroupNum];
                        if (angular.isUndefined(scope.currentGroup)) {
                            scope.prev();
                        }
                        scope.groupSize = _.size(scope.groups);
                    }
                    genEmptyData(scope.currentGroup.length);
                }
                scope.prev = function () {
                    if (scope.currentGroupNum > 1) {
                        scope.currentGroupNum = scope.currentGroupNum - 1;
                        scope.currentGroup = scope.groups[scope.currentGroupNum];
                    }
                    genEmptyData(scope.currentGroup.length);
                }
                scope.next = function () {
                    if (scope.currentGroupNum < scope.groupSize) {
                        scope.currentGroupNum = scope.currentGroupNum + 1;
                        scope.currentGroup = scope.groups[scope.currentGroupNum];
                    }
                    genEmptyData(scope.currentGroup.length);
                }
                var genEmptyData = function (existedSize) {
                    var emptyDataNum = scope.options.displaySize - existedSize;
                    if (emptyDataNum > 0) {
                        scope.emptyData = _.range(emptyDataNum);
                    } else {
                        scope.emptyData = [];
                    }
                }
                scope.imgClick = function (item) {
                    item._selection = !item._selection;
                }
                scope.imgDblclick = function (item) {
                    var fileName = item[scope.options.imageNameField];
                    var extName = fileName.split('.').pop().toLowerCase();
                    if (_.includes(IMG_TYPE, extName)) {
                        scope.selectedItem = item;
                        var bgDiv = angular.element("#gallery-bg");
                        bgDiv.css("display", "block");
                        if (scope.options.parentDivId) {
                            bgDiv.css("height", angular.element("#" + scope.options.parentDivId).get(0).scrollHeight);
                        }
                        var showDiv = angular.element("#gallery-show");
                        showDiv.css("display", "block");
                        var size = $(window).width() - parseInt(item[scope.options.widthField]);
                        showDiv.css("left", size / 2);
                    } else {
                        if (scope.onFileClick) {
                            scope.onFileClick(item);
                        }
                    }
                }
                scope.hideFancyImg = function () {
                    scope.selectedItem = {};
                    angular.element("#gallery-bg").css("display", "none");
                    angular.element("#gallery-show").css("display", "none");
                }
                scope.getSelectedFiles = function () {
                    return _.filter(scope.options.data, {"_selection": true});
                }

                // upload function
                scope.upload = function (files) {
                    if (scope.onUpload && !_.isEmpty(files)) {
                        scope.onUpload(files);
                    }
                }
                // delete function
                scope.delete = function () {
                    if (scope.onDelete) {
                        scope.onDelete(scope.getSelectedFiles());
                    }
                }
                if (scope.options.onRegisterApi) {
                    scope.options.onRegisterApi({
                        getSelectedRows: function () {
                            return [];
                        },
                        refresh: function () {
                            scope.init();
                        }
                    });
                }
                scope.init();
            },
            template: '<div class="bootstrap-upload-gallery bootstrap-upload">' +
            '<label>{{options.caption}}</label>' +
            '<button class="btn btn-default upload-act-btn" type="button" ngf-select ngf-change="upload($files)" ngf-multiple="true">' +
            '   <span class="ng-bs-upload-button"></span>' +
            '</button>' +
            '<button class="btn btn-default upload-del-btn" type="button" ng-click="delete()">' +
            '   <span class="ng-bs-delete-button"></span>' +
            '</button>' +
            '<table class="image-gallery">' +
            '   <tr>' +
            '       <td class="nav-td"><span ng-class="currentGroupNum > 1 ? \'prev\' : \'prev-disable\'" ng-click="prev()"></span></td>' +
            '       <td width="{{tdWidth}}" ng-repeat="item in currentGroup track by $id(item)">' +
            '           <div>' +
            '               <div ng-class="item._selection ? \'img-div-selected\' : \'img-div\'">' +
            '                   <img ng-src="{{item[options.imageUrlField]}}" width="100%" height="100px" ng-click="imgClick(item)" ng-dblclick="imgDblclick(item)">' +
            '               </div>' +
            '               <div class="image-name" title="{{ item[options.imageNameField] }}">{{ item[options.imageNameField] }}</div>' +
            '           </div>' +
            '       </td>' +
            '       <td width="{{tdWidth}}" ng-repeat="ed in emptyData track by $id(ed)"></td>' +
            '       <td class="nav-td"><span ng-class="(currentGroupNum < groupSize) ? \'next\' : \'next-disable\'" ng-click="next()"></span></td>' +
            '   </tr>' +
            '</table>' +
            '<div id="gallery-bg" ng-click="hideFancyImg()"></div>' +
            '<div id="gallery-show" ng-dblclick="hideFancyImg()">' +
            '       <img src="{{ selectedItem[options.imageUrlField] }}" height="{{selectedItem[options.heightField]}}" width="{{selectedItem[options.widthField]}}">' +
            '       <a id="fbplus-close" style="display: block;" ng-click="hideFancyImg()"></a>' +
            '</div>' +
            '</div>'
        }
    }]);