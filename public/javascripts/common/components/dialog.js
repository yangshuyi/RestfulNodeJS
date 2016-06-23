'use strict';
angular.module('common.components')
    .directive("dialog", ['$compile', '$timeout', function ($compile, $timeout) {
        var template = '' +
            '<div ng-show="options.isVisible" style="width:{{options.width}};height:{{options.height}};" class="dialog {{options.dialogCls}}">' +
            '   <div ng-if="options.hasHead" ng-mousedown="headMouseDown($event)" class="head {{options.headCls}}" style="display:flex;">' +
            '       <div style="flex:1">{{options.title}}</div>' +
            '       <div style="margin-left:15px;">' +
            '           <span ng-if="options.collapsible" ng-click="toggle()" ng-class="{true:\'glyphicon glyphicon-triangle-top\',false:\'glyphicon glyphicon-triangle-bottom\'}[options.collapsed]" style="cursor: pointer;"/>' +
            '           <span ng-if="options.closable" title="{{options.closeText}}" ng-click="close()" class="glyphicon glyphicon-remove" style="cursor: pointer;"/>' +
            '       </div>' +
            '   </div>' +
            '   <div ng-if="!options.hasHead" class="no-head">' +
            '       <span ng-if="options.closable" title="{{options.closeText}}" ng-click="close()" class="glyphicon glyphicon-remove" style="cursor: pointer;"/>' +
            '   </div>' +
            '   <div class="body {{options.bodyCls}}" style="overflow: auto; {{options.bodyStyle}}" ng-show="!options.collapsed">' +
            '       <div ng-transclude>/' +
            '   </div>' +
            '</div>';

        return {
            restrict: 'EA',
            scope: {
                options: '=',
                api: '='

            },
            replace: true,
            transclude: true,
            link: function ($scope, $element, attrs) {
                //Options
                if (!attrs.popupPanelId) {
                    attrs.$set('dialogId', 'dialog_' + (new Date()).getTime());
                }
                $scope.options.title = $scope.options.title || '';
                $scope.options.isVisible = $scope.options.isVisible!=null?$scope.options.isVisible:true;
                $scope.options.hasHead = $scope.options.hasHead!=null?$scope.options.hasHead:true;
                $scope.options.autoHide = $scope.options.autoHide!=null?$scope.options.autoHide:true;
                $scope.options.collapsible = $scope.options.collapsible!=null?$scope.options.collapsible:false;
                $scope.options.collapsed = $scope.options.collapsed!=null?$scope.options.collapsed:false;
                $scope.options.closable = $scope.options.closable!=null?$scope.options.closable:true;
                //$scope.options.destroyOnClose = $scope.options.destroyOnClose || true;
                $scope.options.closeText = $scope.options.closeText || '关闭';
                $scope.options.enableDrag = $scope.options.enableDrag!=null?$scope.options.enableDrag:true;
                $scope.options.modal = $scope.options.modal!=null?$scope.options.modal:true;
                //Class
                $scope.options.dialogCls = $scope.options.dialogCls || '';
                $scope.options.headCls = $scope.options.headCls || '';
                $scope.options.bodyCls = $scope.options.bodyCls || '';
                $scope.options.bodyStyle = $scope.options.bodyStyle || '';
                $scope.options.height = $scope.options.height || '300px';
                $scope.options.width = $scope.options.width || '400px';

                //public method
                $scope.headMouseDown = function ($event) {
                    $scope.setToTopLayer();

                    if ($scope.options.enableDrag) {
                        $scope.headMouseUp();

                        $scope.dragging = true;

                        var headEle = $('.head', $element);
                        headEle.css({'cursor': 'move'});
                        //设置捕获范围
                        if (headEle.setCapture) {
                            headEle.setCapture();
                        }

                        $scope.diviation.x = $event.pageX - $element.offset().left;
                        $scope.diviation.y = $event.pageY - $element.offset().top;

                        $scope.mouseMoveHandler = $(window).bind('mousemove', function ($event) {
                            $scope.headMouseMove($event);
                        });

                        $scope.mouseUpHandler = $(window).bind('mouseup', function ($event) {
                            $scope.headMouseUp($event);
                        });
                    }
                };

                $scope.headMouseMove = function ($event) {
                    if ($scope.options.enableDrag) {
                        if (!$scope.dragging) {
                            return;
                        }

                        var headEle = $('.head', $element);
                        headEle.css({'cursor': 'move'});

                        $element.css('left', $event.pageX - $scope.diviation.x + 'px');
                        $element.css('top', $event.pageY - $scope.diviation.y + 'px');
                    }
                };

                $scope.headMouseUp = function () {
                    if ($scope.options.enableDrag) {
                        $scope.dragging = false;

                        var headEle = $('.head', $element);
                        headEle.css({'cursor': 'auto'});

                        if ($scope.mouseMoveHandler != null) {
                            $(window).unbind('mousemove', $scope.mouseMoveHandler);
                            $scope.mouseMoveHandler = null;
                        }
                        if ($scope.mouseUpHandler != null) {
                            $(window).unbind('mouseup', $scope.mouseUpHandler);
                            $scope.mouseUpHandler = null;
                        }

                        //取消捕获范围
                        if (headEle.releaseCapture) {
                            headEle.releaseCapture();
                        }
                    }
                };

                $scope.toggle = function () {
                    if ($scope.options.collapsed) {
                        $scope.expand();
                    } else {
                        $scope.collapse();
                    }
                };

                $scope.expand = function () {
                    $scope.options.collapsed = false;
                };

                $scope.collapse = function () {
                    $scope.options.collapsed = true;
                };

                var initData = function () {
                    // init explore api
                    $scope.apiWatcher = $scope.$watch('api', function (newVal, oldVal) {
                        if ($scope.api) {
                            $scope.api.open = $scope.open;
                            $scope.api.isOpened = $scope.isOpened;
                            $scope.api.close = $scope.close;
                            $scope.api.setToTopLayer = $scope.setToTopLayer;
                            $scope.api.setToCenter = $scope.setToCenter;
                        }
                    });

                    $scope.collapseWatcher = $scope.$watch('options.collapsed', function (newValue, oldValue) {
                        if ($scope.options.collapsed) {
                            $element.css('height', 'auto');
                        } else {
                            $element.css('height', $scope.options.height);
                        }
                    });

                    $scope.maskElement = null;
                    $scope.diviation = {x: 0, y: 0};
                    $scope.mouseMoveHandler = null;
                    $scope.mouseUpHandler = null;

                    $timeout(function () {
                        $scope.open();
                        $scope.setToTopLayer();
                        $scope.setToCenter();
                    });
                };


                $scope.open = function () {
                    $scope.options.isVisible = true;

                    if ($scope.options.modal == true) {
                        if ($scope.maskElement == null) {
                            var maskElement = '<div class="dialogMask"></div>';
                            $scope.maskElement = $(maskElement);
                        }
                        var width = $(document).outerWidth() > $(window).width() ? $(document).outerWidth() : $(document.body).width();
                        var height = $(document).outerHeight() > $(window).height() ? $(document).outerHeight() : $(window).height();
                        $scope.maskElement.width(width);
                        $scope.maskElement.height(height);

                        $('body').append($scope.maskElement);
                    }

                    if($scope.options.autoHide == true){
                        var closeFun = function (e) {
                            var clickInside = $(e.target).closest('.dialog');
                            if (clickInside.length <= 0) {
                                $scope.close();
                            } else {
                                $(document).one("click", closeFun);
                            }
                        };

                        $timeout(function () {
                            $(document).one("click", closeFun);
                        }, 500);
                    }
                };

                $scope.isOpened = function () {
                    return $scope.options.isVisible;
                };

                $scope.close = function () {
                    //关闭对话框前检查
                    if ($scope.$parent && $scope.$parent.beforeDialogClose) {
                        var result = $scope.$parent.beforeDialogClose();
                        if (result != true) {
                            return;
                        }
                    }

                    $scope.options.isVisible = false;

                    if ($scope.options.modal == true && $scope.maskElement != null) {
                        $scope.maskElement.remove();
                        $scope.maskElement = null;
                    }
                    $element.remove();

                    if ($scope.apiWatcher) {
                        $scope.apiWatcher();
                    }

                    if ($scope.collapseWatcher) {
                        $scope.collapseWatcher();
                    }

                    if ($scope.$parent && $scope.$parent.onDialogClose) {
                        $scope.$parent.onDialogClose();
                    }
                };

                $scope.setToTopLayer = function () {
                    var dialogElements = $('.dialog');
                    if (dialogElements === 0) {
                        return;
                    }

                    dialogElements.removeClass('active');
                    $element.addClass('active');

                    var maxZIndexElement = _.max(dialogElements, function (divElement) {
                        var zIndex = parseInt(divElement.style.zIndex);
                        return isNaN(zIndex) ? 0 : zIndex;
                    });

                    var zIndex = parseInt(maxZIndexElement.style.zIndex);
                    zIndex = (isNaN(zIndex) ? 0 : zIndex)
                    if (zIndex === 0 || $(maxZIndexElement).attr('dialog-id') != $element.attr('dialog-id')) {
                        $element.css('z-index', zIndex + 1);
                    }
                };

                $scope.setToCenter = function () {
                    var windowWidth = $(window).width();
                    var windowHeight = $(window).height();
                    var dialogWidth = $element.width();
                    var dialogHeight = $element.height();
                    var left = (windowWidth - dialogWidth) / 2 + $(document).scrollLeft();
                    var top = (windowHeight - dialogHeight) / 2 + $(document).scrollTop();

                    $element.css({'left': left + 'px', 'top': top + 'px'});
                };

                initData();
            },
            template: template
        };
    }])
    .provider("dialogProvider", [function () {
        var defaultOptions = {
            title: '',
            isVisible: true,
            hasHead: true,
            autoHide: false,
            collapsible: true,  //Defines if to show collapsible button.
            collapsed: false, //Defines if the panel is collapsed at initialization.
            closable: true,
            closeText: 'close',
            enableDrag: true,
            modal: true,

            dialogCls: '',  //Add a CSS class to the dialog.
            headCls: '',  //Add a CSS class to the panel header.
            bodyCls: '', //Add a CSS class to the panel body.
            bodyStyle: '',

            height: '300px',
            width: '400px'
        };

        var dialogIdGenerator = 0;

        var nextDialogId = function () {
            dialogIdGenerator++;
            return 'dialog_' + dialogIdGenerator;
        };

        return {
            $get: function ($templateRequest, $controller, $rootScope, $compile, $document, $q, $timeout) {
                function getTemplatePromise(templateUrl) {
                    return $templateRequest(templateUrl);
                }

                function getResolvePromises(resolves) {
                    var promisesArr = [];
                    angular.forEach(resolves, function (value) {
                        //因为可能是单独的function，也有可能是需要Angular依赖注入function，所以有function和array两种类型，都需要当成function的方式处理
                        //如果需要传数组，需要将其做成一个obj，然后resolve
                        if (angular.isFunction(value) || angular.isArray(value)) {
                            promisesArr.push($q.when($injector.invoke(value)));
                        }
                        else {
                            promisesArr.push($q.when(value));
                        }
                    });
                    return promisesArr;
                }

                return {
                    //return as promise
                    openDialog: function (params) {
                        var templateUrl = params.templateUrl;
                        var controllerName = params.controllerName;
                        var options = _.assign(defaultOptions, params.options);
                        var resolves = params.resolves;

                        var $dialogScope = null;
                        var deferred = $q.defer();
                        var promise = deferred.promise;

                        $q.all([getTemplatePromise(templateUrl)].concat(getResolvePromises(resolves))).then(function (results) {
                            var tplContent = results[0];
                            var template = angular.element('<dialog api="dialogApi" options="options">' + tplContent + '</dialog>');

                            var $dialogScope = $rootScope.$new();
                            var ctrlLocals = { $scope: $dialogScope};
                            var idx = 1;
                            angular.forEach(resolves, function (value, key) {
                                ctrlLocals[key] = results[idx++];
                            });

                            $controller(controllerName, ctrlLocals);

                            $dialogScope.dialogId = nextDialogId();
                            $dialogScope.options = options;
                            $dialogScope.dialogApi = {};

                            var content = $compile(template)($dialogScope);
                            $('body').append(content);

                            $timeout(function () {
                                deferred.resolve($dialogScope);
                            });
                        });

                        return promise;
                    }
                };
            }
        };
    }]);