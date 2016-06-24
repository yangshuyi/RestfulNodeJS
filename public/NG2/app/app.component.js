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
var router_deprecated_1 = require('@angular/router-deprecated');
var redis_manager_component_1 = require("./redis-manager.component");
var AppComponent = (function () {
    function AppComponent() {
        console.log('AppComponent constructor');
    }
    AppComponent.prototype.ngOnInit = function () {
        console.log('AppComponent ngOnInit');
    };
    AppComponent = __decorate([
        router_deprecated_1.RouteConfig([
            {
                path: '/redisManager',
                name: 'RedisManager',
                component: redis_manager_component_1.RedisManagerComponent
            }
        ]),
        core_1.Component({
            selector: 'my-app',
            template: '' +
                '<router-outlet></router-outlet>' +
                '',
            styles: [''],
            directives: [router_deprecated_1.ROUTER_DIRECTIVES, redis_manager_component_1.RedisManagerComponent],
            providers: [
                router_deprecated_1.ROUTER_PROVIDERS
            ]
        }), 
        __metadata('design:paramtypes', [])
    ], AppComponent);
    return AppComponent;
})();
exports.AppComponent = AppComponent;
//# sourceMappingURL=app.component.js.map