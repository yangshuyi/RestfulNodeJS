var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var core_1 = require('@angular/core');
var router_1 = require("@angular/router");
var platform_browser_1 = require("@angular/platform-browser");
// import moment = require("moment/moment");
var DemoTopMenuComponent = (function () {
    function DemoTopMenuComponent(renderer, document, router) {
        this.router = router;
        this.isShown = false;
        this.renderer = renderer;
        this.document = document;
    }
    DemoTopMenuComponent.prototype.ngAfterViewInit = function () {
        var _this = this;
        this.router.events.subscribe(function (event) {
            if (event instanceof router_1.NavigationEnd) {
                _this.toggle(false);
            }
        });
    };
    DemoTopMenuComponent.prototype.toggle = function (isShown) {
        this.isShown = typeof isShown === 'undefined' ? !this.isShown : isShown;
        if (this.document && this.document.body) {
            this.renderer.setElementClass(this.document.body, 'isOpenMenu', this.isShown);
            if (this.isShown === false) {
                this.renderer.setElementProperty(this.document.body, 'scrollTop', 0);
            }
        }
    };
    DemoTopMenuComponent = __decorate([
        core_1.Component({
            selector: 'ng2-bootstrap-demo-topmenu-component',
            templateUrl: 'app/ng2-bootstrap-demo/demo-topmenu.template.html',
            directives: [router_1.ROUTER_DIRECTIVES]
        }),
        __param(1, core_1.Inject(platform_browser_1.DOCUMENT)), 
        __metadata('design:paramtypes', [core_1.Renderer, Object, router_1.Router])
    ], DemoTopMenuComponent);
    return DemoTopMenuComponent;
})();
exports.DemoTopMenuComponent = DemoTopMenuComponent;
//# sourceMappingURL=demo-topmenu.component.js.map