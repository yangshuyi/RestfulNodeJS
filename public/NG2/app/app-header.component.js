"use strict";
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
var app_info_model_1 = require("./app-info.model");
var auth_service_1 = require("./auth/auth.service");
//let template = require('./app-header.html');
//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
var AppHeaderComponent = (function () {
    function AppHeaderComponent(router, authService) {
        this.router = router;
        this.authService = authService;
    }
    AppHeaderComponent.prototype.navigateToModule = function (menu) {
        this.router.navigate([menu.routerLink, {}]);
    };
    AppHeaderComponent.prototype.openUserInfo = function () {
        var isUserLogin = this.authService.isLoggedIn;
        if (isUserLogin) {
            alert("yangsh login in");
        }
        else {
            alert("please login in first");
        }
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', app_info_model_1.AppInfo)
    ], AppHeaderComponent.prototype, "appInfo", void 0);
    AppHeaderComponent = __decorate([
        core_1.Component({
            selector: 'app-header',
            templateUrl: 'app/app-header.html',
            styles: [''],
            providers: [auth_service_1.AuthService]
        }), 
        __metadata('design:paramtypes', [router_1.Router, auth_service_1.AuthService])
    ], AppHeaderComponent);
    return AppHeaderComponent;
}());
exports.AppHeaderComponent = AppHeaderComponent;
//# sourceMappingURL=app-header.component.js.map