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
var core_1 = require('@angular/core');
var ng2_bootstrap_1 = require("ng2-bootstrap/ng2-bootstrap");
var router_1 = require("@angular/router");
// import moment = require("moment/moment");
var DemoMainMenuComponent = (function () {
    function DemoMainMenuComponent(router) {
        var _this = this;
        this.router = router;
        this.isBs3 = ng2_bootstrap_1.Ng2BootstrapConfig.theme === ng2_bootstrap_1.Ng2BootstrapTheme.BS3;
        this.search = {};
        this.hash = '';
        this.routes = this.routes.filter(function (v) { return v.path !== '**'; });
        this.router.events.subscribe(function (event) {
            if (event instanceof router_1.NavigationEnd) {
                _this.hash = event.url;
            }
        });
    }
    DemoMainMenuComponent = __decorate([
        core_1.Component({
            selector: 'ng2-bootstrap-demo-mainmenu-component',
            templateUrl: 'app/ng2-bootstrap-demo/demo-mainmenu.template.html',
            directives: [router_1.ROUTER_DIRECTIVES],
            pipes: [SearchFilterPipe]
        }), 
        __metadata('design:paramtypes', [router_1.Router])
    ], DemoMainMenuComponent);
    return DemoMainMenuComponent;
}());
exports.DemoMainMenuComponent = DemoMainMenuComponent;
var SearchFilterPipe = (function () {
    function SearchFilterPipe() {
    }
    SearchFilterPipe.prototype.transform = function (value, text) {
        if (!text) {
            return value;
        }
        var items = value;
        var newItems = [];
        items.forEach(function (item) {
            if (item.data[0].toLowerCase().indexOf(text.toLowerCase()) !== -1) {
                newItems.push(item);
            }
        });
        return newItems;
    };
    SearchFilterPipe = __decorate([
        core_1.Pipe({ name: 'SearchFilter' }), 
        __metadata('design:paramtypes', [])
    ], SearchFilterPipe);
    return SearchFilterPipe;
}());
exports.SearchFilterPipe = SearchFilterPipe;
//# sourceMappingURL=demo-mainmenu.component.js.map