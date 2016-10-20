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
var common_1 = require("@angular/common");
var DemoModalComponent = (function () {
    function DemoModalComponent() {
    }
    DemoModalComponent.prototype.showChildModal = function () {
        this.childModal.show();
    };
    DemoModalComponent.prototype.hideChildModal = function () {
        this.childModal.hide();
    };
    __decorate([
        core_1.ViewChild('childModal'), 
        __metadata('design:type', ng2_bootstrap_1.ModalDirective)
    ], DemoModalComponent.prototype, "childModal", void 0);
    DemoModalComponent = __decorate([
        core_1.Component({
            selector: 'ng2-bootstrap-demo-modal-component',
            templateUrl: 'app/ng2-bootstrap-demo/demo-modal.template.html',
            directives: [ng2_bootstrap_1.MODAL_DIRECTIVES, common_1.CORE_DIRECTIVES],
            viewProviders: [ng2_bootstrap_1.BS_VIEW_PROVIDERS]
        }), 
        __metadata('design:paramtypes', [])
    ], DemoModalComponent);
    return DemoModalComponent;
})();
exports.DemoModalComponent = DemoModalComponent;
//# sourceMappingURL=demo-modal.component.js.map