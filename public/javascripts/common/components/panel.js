'use strict';
angular.module('common.components')
    .directive("panel", ['$timeout', function ($timeout) {
    var template = ''+
        '<div style="width:{{width}};{{panelStyle}}" class="panel panel-default {{panelCls}}">' +
        '   <div ng-if="!noHeader" class="head {{headCls}}" style="display:flex;">' +
        '       <div style="flex:1">{{title}}</div>' +
        '       <div>' +
        '           <span ng-if="collapsible==\'true\'" ng-click="toggle()" ng-class="{true:\'glyphicon glyphicon-triangle-top\',false:\'glyphicon glyphicon-triangle-bottom\'}[collapsed==\'true\']" style="cursor: pointer"/>' +
        '       </div>' +
        '   </div>' +
        '   <div class="body {{bodyCls}}" style="overflow: auto;{{bodyStyle}}" ng-show="collapsed==\'true\'">' +
        '       <div ng-transclude/>' +
        '   </div>' +
        '</div>';

    return {
        restrict: 'EA',
        scope: {
            title: '@',
            collapsible: '@',  //Defines if to show collapsible button.
            collapsed: '@', //Defines if the panel is collapsed at initialization.
            headCls: '@',  //Add a CSS class to the panel header.
            bodyCls: '@', //Add a CSS class to the panel body.
            bodyStyle: '@'
        },
        replace: false,
        transclude: true,
        link: function ($scope, $elem, attrs) {
            //Options
            $scope.title = $scope.title || 'title';
            $scope.width = $scope.width || '100%';
            $scope.collapsible = $scope.collapsible || 'true';
            $scope.collapsed = $scope.collapsed || 'false';

            //public method
            $scope.toggle = function () {
                if ($scope.collapsed == 'true') {
                    $scope.expand();
                } else {
                    $scope.collapse();
                }
            };

            $scope.expand = function () {
                $scope.collapsed = 'false';
            };

            $scope.collapse = function () {
                $scope.collapsed = 'true';
            };
        },
        template: template
    };
}])


    .directive("popup-panel", ['$timeout', function ($timeout) {
        var template = ''+
            '<div style="width:{{width}};{{panelStyle}}" class="popup-panel {{panelCls}}">' +
            '   <div class="body {{bodyCls}}" style="overflow: auto;{{bodyStyle}}" ng-show="collapsed==\'true\'">' +
            '       <div class="body {{bodyCls}}" style="{{bodyStyle}}" ng-transclude/>' +
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
            link: function ($scope, $elem, attrs) {
                //Options
                if (!attrs.popupPanelId) {
                    attrs.$set('popupPanelId', 'popup-panel_' + (new Date()).getTime());
                }
                $scope.options.isVisible = $scope.options.isVisible || true;
                $scope.options.closable = $scope.options.closable || true;
                $scope.options.autoHide = $scope.options.autoHide || true;
                $scope.options.modal = $scope.options.autoHide || true;
                $scope.options.bodyCls = $scope.options.bodyCls || '';
                $scope.options.bodyStyle = $scope.options.bodyStyle || '';
                $scope.options.height = $scope.options.height || '300px';
                $scope.options.width = $scope.options.width || '400px';

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
                            var maskElement = '<div class="popupPanelMask"></div>';
                            $scope.maskElement = $(maskElement);
                        }
                        var width = $(document).outerWidth() > $(window).width() ? $(document).outerWidth() : $(document.body).width();
                        var height = $(document).outerHeight() > $(window).height() ? $(document).outerHeight() : $(window).height();
                        $scope.maskElement.width(width);
                        $scope.maskElement.height(height);

                        $('body').append($scope.maskElement);
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
                    var popupPanelElements = $('.popup-panel');
                    if (popupPanelElements === 0) {
                        return;
                    }

                    popupPanelElements.removeClass('active');
                    $element.addClass('active');

                    var maxZIndexElement = _.max(popupPanelElements, function (divElement) {
                        var zIndex = parseInt(divElement.style.zIndex);
                        return isNaN(zIndex) ? 0 : zIndex;
                    });

                    var zIndex = parseInt(maxZIndexElement.style.zIndex);
                    zIndex = (isNaN(zIndex) ? 0 : zIndex)
                    if (zIndex === 0 || $(maxZIndexElement).attr('popup-panel-id') != $element.attr('popup-panel-id')) {
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

    .directive("tooltipPanel", ['$templateCache', '$timeout', function ($templateCache, $timeout) {
        var defaultTmplUrl = 'template/tooltipPanel.html';
        $templateCache.put(defaultTmplUrl,
            '<div ng-if="arrowFlag==\'true\' && direction==\'below\'" style="width:100%;text-align: center;line-height:0px;margin-top: 0px;position: absolute;color: #a7bac9;">&#9670;</div>'+
            '<div ng-if="arrowFlag==\'true\' && direction==\'below\'" style="width:100%;text-align: center;line-height:0px;margin-top: 2px;position: absolute;color: #edf6fb;">&#9670;</div>'+
            '<div class="{{panelCls}}" style="width:{{width}};overflow: hidden;" ng-transclude>' +
            '</div>'+
            '<div ng-if="arrowFlag==\'true\' && direction==\'above\'" style="width:100%;text-align: center;line-height:0px;margin-top: 1px;position: relative;color: #a7bac9;">&#9670;</div>'+
            '<div ng-if="arrowFlag==\'true\' && direction==\'above\'" style="width:100%;text-align: center;line-height:0px;margin-top: -1px;position: relative;color: #edf6fb;">&#9670;</div>'
        );

        return {
            restrict: 'E',
            replace: false,
            transclude: true,
            scope: {
                panelCls: '@',
                api: '=',
                direction: '@',//在当前元素上方或下方显示该PopupPanel[above|below]
                align: '@', //与当前元素水平对齐方式[left|center|right]
                arrowFlag: '@', //是否显示箭头标记[true|false]
                offset: '@' //弹出框与当前元素的偏差值[number]
            },
            link: function ($scope, $element, attrs) {
                $element.css("position", "absolute");
                $element.css("display", "none");
                $element.css("z-index", "1035");
                $('body').append($element);

                /**
                 *
                 * @param inputElement - 默认情况下，在当前控件的左下方展示popup panel
                 * @param panelHeight - panel高度，没有填的话，就是自适应高度
                 */
                $scope.api.popup = function (inputElement, panelWidth, panelHeight) {
                    $scope.show();
                    $scope.setPosition(inputElement, panelWidth, panelHeight);
                };

                $scope.api.closeWindow = function () {
                    $scope.hide();
                };

                /**
                 *
                 * @param inputElement: 默认基于inputElement的左侧进行popup
                 */
                $scope.api.setPosition = function (inputElement) {
                    $scope.setPosition(inputElement, null, null);
                };

                $scope.show = function () {
                    $element.show();

                    var closeFun = function (e) {
                        var clickInside = $(e.target).closest('popup-panel');
                        if (clickInside.length <= 0) {
                            $scope.hide();
                        } else {
                            $(document).one("click", closeFun);
                        }
                    };

                    $timeout(function () {
                        $(document).one("click", closeFun);
                    }, 500);
                };

                $scope.hide = function () {
                    $element.hide();
                };

                $scope.setPosition = function (inputElement, width, height) {
                    if (!inputElement) {
                        return;
                    }

                    var bodyOverflow = $('body').css('overflow');
                    $('body').css('overflow', 'hidden');
                    $element.css('visibility', 'hidden');

                    $timeout(function () {
                        var contentHeight = 0;
                        if (height > 0) {
                            contentHeight = height;
                        } else {
                            //auto height condition, 根据内容自动展开高度
                            contentHeight = $element.find('.popupPanel').height();
                        }

                        if($scope.align!='center' && $scope.align!='left' && $scope.align!='right'){
                            //默认值-相对位置，与inputElement靠左中右对齐
                            $scope.align = 'left';
                        }

                        var x = inputElement.offset().left - 1;
                        var y = inputElement.offset().top + inputElement.height();

                        if( $scope.align == 'left'){
                            x = inputElement.offset().left - 1;
                        }else if( $scope.align == 'center'){
                            x = inputElement.offset().left + inputElement.width()/2 - $element.width()/2;
                        }else if( $scope.align == 'right'){
                            x = inputElement.offset().left + inputElement.width() + 2;
                        }

                        if($scope.direction!='above' && $scope.direction!='below'){
                            //默认值-自适应方向的情况
                            if (y + contentHeight + 5 > $(window).height()){
                                $scope.direction = 'above';
                            }else{
                                $scope.direction = 'below';
                            }
                        }

                        if($scope.direction == 'above'){
                            //show dialog above
                            $element.removeClass('popupPanelBelow');
                            $element.addClass('popupPanelAbove');
                            y = inputElement.offset().top - contentHeight - 2 - ($scope.offset?parseInt($scope.offset):0);
                            $element.find('.popupPanel').css('box-shadow', '3px -3px 2px gray');
                        } else if($scope.direction == 'below'){
                            //show dialog below
                            $element.removeClass('popupPanelAbove');
                            $element.addClass('popupPanelBelow');
                            y = inputElement.offset().top + inputElement.height() + 2 + ($scope.offset?parseInt($scope.offset):0);
                            $element.find('.popupPanel').css('box-shadow', '3px 3px 2px gray');
                        }
                        $element.css({'left': x + 'px', 'top': y + 'px'});

                        //auto height condition, 根据内容自动展开高度
                        if (height) {
                            $($element.children()[0]).css('height', height + 'px');
                        }

                        //auto condition, 根据内容自动展开宽度
                        if (width) {
                            $($element.children()[0]).css('width', (width+2) + 'px'); //加上内部左右边框的距离
                        }

                        $element.css('visibility', 'visible');
                        $('body').css('overflow', bodyOverflow);
                    });
                };
            },
            templateUrl: function (element, attrs) {
                return defaultTmplUrl;
            }
        };
    }])

    .provider("popupPanelProvider", [function () {
        var defaultOptions = {
            isVisible: true,
            closable: true,
            bodyCls: '', //Add a CSS class to the panel body.
            bodyStyle: '',
            height: '300px',
            width: '400px'
        };

        var popupPanelIdGenerator = 0;

        var nextPopupPanelId = function () {
            popupPanelIdGenerator++;
            return 'popup-panel_' + popupPanelIdGenerator;
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
                    openPopupPanel: function (params) {
                        var templateUrl = params.templateUrl;
                        var controllerName = params.controllerName;
                        var options = _.assign(defaultOptions, params.options);
                        var resolves = params.resolves;

                        var $panelScope = null;
                        var deferred = $q.defer();
                        var promise = deferred.promise;

                        $q.all([getTemplatePromise(templateUrl)].concat(getResolvePromises(resolves))).then(function (results) {
                            var tplContent = results[0];
                            var template = angular.element('<popup-panel api="popupPanelApi" options="options">' + tplContent + '</popup-panel>');

                            var $popupPanelScope = $rootScope.$new();
                            var ctrlLocals = { $scope: $popupPanelScope};
                            var idx = 1;
                            angular.forEach(resolves, function (value, key) {
                                ctrlLocals[key] = results[idx++];
                            });

                            $controller(controllerName, ctrlLocals);

                            $popupPanelScope.popupPanelId = nextPopupPanelId();
                            $popupPanelScope.options = options;
                            $popupPanelScope.popupPanelApi = {};

                            var content = $compile(template)($popupPanelScope);
                            $('body').append(content);

                            $timeout(function () {
                                deferred.resolve($popupPanelScope);
                            });
                        });

                        return promise;
                    }
                };
            }
        };
    }]);