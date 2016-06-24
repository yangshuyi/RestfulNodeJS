var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
//One or more import statements to reference the things we need.
var core_1 = require('@angular/core');
var _ = require('lodash');
var redis_object_component_1 = require("./redis-object.component");
var redis_manager_service_1 = require("./redis-manager.service");
//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
var RedisManagerComponent = (function () {
    function RedisManagerComponent(redisManagerService) {
        this.redisManagerService = redisManagerService;
        //When we're ready to build a substantive application, we can expand this class with properties and application logic.
        this.title = 'Reids Manager';
        this.keyword = '';
        console.log('RedisManagerComponent constructor');
    }
    RedisManagerComponent.prototype.ngOnInit = function () {
        var _this = this;
        console.log('RedisManagerComponent ngOnInit');
        this.redisManagerService.listAll().then(function (redisObjects) {
            return _this.redisObjects = redisObjects;
        });
    };
    RedisManagerComponent.prototype.searchByKeyword = function () {
        var key = '';
        if (this.keyword instanceof HTMLInputElement) {
            key = keyword.value;
        }
        else {
            key = this.keyword;
        }
        if (!key) {
            this.filterRedisObjects = this.redisObjects;
        }
        else {
            var result = _.filter(this.redisObjects, function (item) {
                return item.key.indexOf(key) >= 0;
            });
            this.filterRedisObjects = result;
        }
    };
    RedisManagerComponent = __decorate([
        core_1.Component({
            selector: 'redis-manager',
            template: '' +
                '<h1>{{title}}</h1>' +
                '<label for="keyword">Search Keyword: </label><input id="keyword" [(ngModel)]="keyword" (change)="searchByKeyword()" placeholder="keyword">' +
                '<hr/>' +
                '<div *ngIf="keyword && filterRedisObjects">Find [{{filterRedisObjects.length}}] record(s) for Redis Object by keyword [{{keyword}}]</div>' +
                '<div *ngIf="filterRedisObjects" *ngFor="let redisObject of filterRedisObjects">' +
                '   <redis-object [redisObject]="redisObject"></redis-object>' +
                '</div>' +
                '',
            styles: [''],
            directives: [redis_object_component_1.RedisObjectComponent],
            providers: [redis_manager_service_1.RedisManagerService]
        }), 
        __metadata('design:paramtypes', [redis_manager_service_1.RedisManagerService])
    ], RedisManagerComponent);
    return RedisManagerComponent;
})();
exports.RedisManagerComponent = RedisManagerComponent;
//# sourceMappingURL=redis-manager.component.js.map