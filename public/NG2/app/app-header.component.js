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
var template = require('./app-header.html');
//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
var AppHeaderComponent = (function () {
    function AppHeaderComponent(router) {
        this.router = router;
    }
    AppHeaderComponent.prototype.navigateToModule = function (menu) {
        this.router.navigate([menu.routerLink, {}]);
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', app_info_model_1.AppInfo)
    ], AppHeaderComponent.prototype, "appInfo", void 0);
    AppHeaderComponent = __decorate([
        core_1.Component({
            selector: 'app-header',
            templateUrl: 'app-header.html',
            atemplate: '<header>' +
                '<div class="top-bar">' +
                '   <div class="container">' +
                '       <div class="row">' +
                '           <div class="col-sm-12 col-xs-12">' +
                '               <div class="search">' +
                '                   <input type="text" autocomplete="off" placeholder="Search">' +
                '                   <i class="fa fa-search fa-lg"></i>' +
                '               </div>' +
                '           </div>' +
                '       </div>' +
                '   </div>' +
                '</div>' +
                '<nav class="navbar navbar-static-top navbar-dark bg-inverse">' +
                '           <img src="images/logo.png" alt="logo">' +
                '           <ul class="nav navbar-nav">' +
                '               <li *ngFor="let menu of appInfo.menus" class="nav-item active">' +
                '                   <a class="nav-link" (click)="navigateToModule()" title="{{menu.name}}">{{menu.name}}</a>' +
                '               </li>' +
                '           </ul>' +
                '</nav>' +
                '</header>',
            styles: ['']
        }), 
        __metadata('design:paramtypes', [router_1.Router])
    ], AppHeaderComponent);
    return AppHeaderComponent;
})();
exports.AppHeaderComponent = AppHeaderComponent;
//# sourceMappingURL=app-header.component.js.map