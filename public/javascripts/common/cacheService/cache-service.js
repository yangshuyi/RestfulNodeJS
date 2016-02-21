angular.module('common.cacheService')
    .config(function (CacheFactoryProvider, RestangularProvider, $httpProvider) {
        RestangularProvider.setDefaultHttpFields({cache: false});
        $httpProvider.interceptors.push('CacheInterceptor');
    })

    .run(function (CacheService, $rootScope, $http, CacheFactory, CacheConst) {
        $http.defaults.cache = CacheFactory.get(CacheConst.cache_name);
    })

    .service('CacheInterceptor', function ($q, CacheFactory, CacheConst) {
        this.response = function (response) {
            var cacheVersionFromServer = response.headers()[CacheConst.header_name];
            var cache = CacheFactory.get(CacheConst.cache_name);
            if (cacheVersionFromServer) {
                if (cache.get(CacheConst.header_name) != cacheVersionFromServer) {
                    cache.removeAll();
                    cache.put(CacheConst.header_name, cacheVersionFromServer)
                }
            }

            return response;
        }
    })

    .service('CacheService', function (CacheFactory, Restangular, $http, CachedRestangular, CacheConst) {
        if (!CacheFactory.get(CacheConst.cache_name)) {

            CacheFactory.createCache(CacheConst.cache_name, {
                deleteOnExpire: 'aggressive',
                recycleFreq: 15 * 24 * 60 * 1000, // 15 days
                storageMode: 'localStorage'
            });
        }

    })

    .service('CachedRestangular', function (Restangular) {
        return Restangular.withConfig(function (RestangularConfigurer) {
            RestangularConfigurer.setDefaultHttpFields({cache: false});
        });
    })

    .constant('CacheConst', {
        header_name: 'cache_version',
        cache_name: 'bookCache'
    });