var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require('@angular/core');
var redis_object_1 = require("./redis-object");
var RedisManagerService = (function () {
    function RedisManagerService() {
    }
    RedisManagerService.prototype.listAll = function () {
        var RPC_FALG = false;
        if (RPC_FALG) {
            return new Promise(function (resolve) {
                return setTimeout(function () { return resolve(HEROES); }, 2000);
            } // 2 seconds
             // 2 seconds
            );
        }
        else {
            var redisObjects = [];
            redisObjects.push(new redis_object_1.RedisObject('a', 'value1'));
            redisObjects.push(new redis_object_1.RedisObject('aa', 'value2'));
            redisObjects.push(new redis_object_1.RedisObject('aaa', 'value3'));
            redisObjects.push(new redis_object_1.RedisObject('b', 'value4'));
            redisObjects.push(new redis_object_1.RedisObject('bb', 'value5'));
            redisObjects.push(new redis_object_1.RedisObject('bbb', 'value6'));
            return Promise.resolve(redisObjects);
        }
    };
    RedisManagerService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [])
    ], RedisManagerService);
    return RedisManagerService;
})();
exports.RedisManagerService = RedisManagerService;
//# sourceMappingURL=redis-manager.service.js.map