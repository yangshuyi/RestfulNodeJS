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
require('$');
var ng2BootstrapDemo_model_1 = require("./ng2BootstrapDemo.model");
var BootstrapComponent = (function () {
    function BootstrapComponent() {
        this.ng2BootstrapDemo = new ng2BootstrapDemo_model_1.NG2BootstrapDemo();
        console.log('BootstrapComponent constructor');
    }
    BootstrapComponent.prototype.showDemo = function (demo) {
        var _this = this;
        if (demo && demo.componentSelector) {
            this.resolver.resolveComponent(demo.componentClass).then(function (factory) {
                _this.cmpRef = _this.target.createComponent(factory);
            });
        }
    };
    __decorate([
        core_1.ViewChild('demoContent', { read: core_1.ViewContainerRef }), 
        __metadata('design:type', Object)
    ], BootstrapComponent.prototype, "target", void 0);
    BootstrapComponent = __decorate([
        core_1.Component({
            selector: 'bootstrap-component',
            templateUrl: 'app/ng2-bootstrap-demo/bootstrap.template.html',
            styles: [''],
            directives: [],
            providers: []
        }), 
        __metadata('design:paramtypes', [])
    ], BootstrapComponent);
    return BootstrapComponent;
})();
exports.BootstrapComponent = BootstrapComponent;
//# sourceMappingURL=bootstrap.component.js.map