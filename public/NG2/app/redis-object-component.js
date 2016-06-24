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
var RedisObjectComponent = (function () {
    function RedisObjectComponent() {
    }
    RedisObjectComponent.prototype.onRedisObjectSelect = function () {
        this.redisObject.selected = !this.redisObject.selected;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', redis_object_1.RedisObject)
    ], RedisObjectComponent.prototype, "redisObject", void 0);
    RedisObjectComponent = __decorate([
        core_1.Component({
            selector: 'redis-object',
            template: '' +
                '<div *ngIf="redisObject" [class.selected]="redisObject.selected" style="display: flex; width:100%;" (click)="onRedisObjectSelect()">' +
                '   <div style="width:300px;">{{redisObject.key}}</div>' +
                '   <div style="flex:1;">{{redisObject.value}}</div>' +
                '</div>',
            styles: [
                '.selected { background-color: green;}'
            ]
        }), 
        __metadata('design:paramtypes', [])
    ], RedisObjectComponent);
    return RedisObjectComponent;
})();
exports.RedisObjectComponent = RedisObjectComponent;
//# sourceMappingURL=redis-object-component.js.map