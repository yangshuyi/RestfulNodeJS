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
var app_info_model_1 = require("./app-info.model");
//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
var AppHeaderComponent = (function () {
    function AppHeaderComponent() {
    }
    __decorate([
        core_1.Input(), 
        __metadata('design:type', app_info_model_1.AppInfo)
    ], AppHeaderComponent.prototype, "appInfo", void 0);
    AppHeaderComponent = __decorate([
        core_1.Component({
            selector: 'app-header',
            template: '' +
                '<header class="indexHead">' +
                '   <div class="headerWrap">' +
                '       <div class="logo_search">' +
                '           <h1 id="logo-flash" style="" class="logo">' +
                // '               <a href="http://www.smzdm.com/">'+
                // '                   <img alt="什么值得买" src="/resources/public/img/logo.png" style="width:172px;">'+
                // '               </a>'+
                '               {{appInfo.title}}' +
                '           </h1>' +
                '           <div style="width:168px;" class="cake"></div>' +
                '           <input type="hidden" name="c" value="home" readonly="readonly">' +
                '           <button type="submit" class="btn_search icon-search"></button>' +
                '       </div>' +
                '   </div>' +
                '   <div class="navBarWrap no_fixed">' +
                '       <div class="navBar">' +
                '           <nav>' +
                '               <a *ngFor="let menu of appInfo.menus" [routerLink]="[\'RedisManager\']" title="{{menu.name}}">{{menu.name}}</a>' +
                '           </nav>' +
                '       </div>' +
                '   </div>' +
                '</header>' +
                '',
            styles: ['']
        }), 
        __metadata('design:paramtypes', [])
    ], AppHeaderComponent);
    return AppHeaderComponent;
}());
exports.AppHeaderComponent = AppHeaderComponent;
//# sourceMappingURL=app-header.component.js.map