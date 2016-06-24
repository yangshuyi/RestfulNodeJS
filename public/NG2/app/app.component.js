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
var redis_object_1 = require("./redis-object");
var redis_object_component_1 = require("./redis-object-component");
//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
var AppComponent = (function () {
    function AppComponent() {
        //When we're ready to build a substantive application, we can expand this class with properties and application logic.
        this.title = 'Reids Manager';
        this.keyword = '';
        this.redisObjects = data;
    }
    AppComponent.prototype.searchByKeyword = function () {
        var key = '';
        if (this.keyword instanceof HTMLInputElement) {
            key = keyword.value;
        }
        else {
            key = this.keyword;
        }
        if (!key) {
            this.redisObjects = data;
        }
        else {
            var result = _.filter(data, function (item) {
                return item.key.indexOf(key) >= 0;
            });
            this.redisObjects = result;
        }
    };
    AppComponent = __decorate([
        core_1.Component({
            selector: 'my-app',
            template: '' +
                '<h1>{{title}}</h1>' +
                '<label for="keyword">Search Keyword: </label><input id="keyword" [(ngModel)]="keyword" (change)="searchByKeyword()" placeholder="keyword">' +
                '<hr/>' +
                '<div *ngIf="keyword && redisObjects">Find [{{redisObjects.length}}] record(s) for Redis Object by keyword [{{keyword}}]' +
                '<div *ngIf="redisObjects" *ngFor="let redisObject of redisObjects">' +
                '   <redis-object [redisObject]="redisObject"></redis-object>' +
                '</div>' +
                '',
            styles: [''],
            directives: [redis_object_component_1.RedisObjectComponent]
        }), 
        __metadata('design:paramtypes', [])
    ], AppComponent);
    return AppComponent;
})();
exports.AppComponent = AppComponent;
var data = [];
data.push(new redis_object_1.RedisObject('a', 'value1'));
data.push(new redis_object_1.RedisObject('aa', 'value2'));
data.push(new redis_object_1.RedisObject('aaa', 'value3'));
data.push(new redis_object_1.RedisObject('b', 'value4'));
data.push(new redis_object_1.RedisObject('bb', 'value5'));
data.push(new redis_object_1.RedisObject('bbb', 'value6'));
//# sourceMappingURL=app.component.js.map