'use strict';
angular.module('rootApp', ['ui.router',  'homeModule', 'ngDemoModule'])
    .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
        $stateProvider
            .state('home', {
                url: '/home',
                templateUrl: '/javascripts/home/home.html',
                controller: 'homeCtrl'
            })
            .state('ng-demo', {
                url: '/ng-demo',
                templateUrl: '/javascripts/ng-demo/ng-demo.html',
                controller: 'ngDemoCtrl'
            })
            .state('management.queryuser', {
                url: '/management/queryUser',
                templateUrl: 'management/user/queryUserindex.html',
                controller: 'indexCtrl'
            })
            .state('management.queryuser', {
                url: '/management/queryUser',
                templateUrl: 'management/user/queryUserindex.html',
                controller: 'indexCtrl'
            })
        ;
        $urlRouterProvider.otherwise('home');
    }]);