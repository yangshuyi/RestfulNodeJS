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
var router_1 = require('@angular/router');
var redis_manager_component_1 = require("./redis-manager.component");
var app_info_model_1 = require("./app-info.model");
var app_header_component_1 = require("./app-header.component");
var log_service_1 = require("./common/log.service");
var image_service_1 = require("./common/image-viewer/image.service");
//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
var AppComponent = (function () {
    function AppComponent() {
        this.appInfo = new app_info_model_1.AppInfo();
    }
    AppComponent.prototype.ngOnInit = function () {
    };
    AppComponent = __decorate([
        core_1.Component({
            selector: 'my-app',
            template: '<app-header [appInfo]="appInfo"></app-header>' +
                '<div class="container"><router-outlet></router-outlet></div>' +
                '<app-footer [appInfo]="appInfo"></app-footer>',
            styles: [''],
            providers: [{ provide: log_service_1.LogService, useClass: log_service_1.LogService }, image_service_1.ImageService],
            directives: [app_header_component_1.AppHeaderComponent, redis_manager_component_1.RedisManagerComponent, router_1.ROUTER_DIRECTIVES]
        }), 
        __metadata('design:paramtypes', [])
    ], AppComponent);
    return AppComponent;
})();
exports.AppComponent = AppComponent;
//# sourceMappingURL=app.component.js.map