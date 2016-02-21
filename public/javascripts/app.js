'use strict';
angular.module('rootApp', ['ui.router',  'homeModule'])
    .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {
        $stateProvider
            .state('home', {
                url: '/home',
                templateUrl: '/javascripts/home/home.html',
                controller: 'homeCtrl'
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