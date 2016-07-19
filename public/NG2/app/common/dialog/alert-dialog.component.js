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
require('$');
var AlertDialogComponent = (function () {
    function AlertDialogComponent() {
        this.dismissible = true;
        this.onAlertDialogClose = new core_1.EventEmitter();
        this.containerTop = 0;
        this.containerLeft = 0;
    }
    AlertDialogComponent.prototype.ngOnChanges = function (changes) {
        console.log("ngOnChanges");
    };
    AlertDialogComponent.prototype.ngOnInit = function () {
        console.log("ngOnInit");
    };
    AlertDialogComponent.prototype.ngAfterContentInit = function () {
        console.log("ngOnInit");
    };
    AlertDialogComponent.prototype.ngAfterViewInit = function () {
        console.log("ngAfterViewInit");
        var containerWidth = this.alertComponentContainer.nativeElement.offsetWidth;
        var containerHeight = this.alertComponentContainer.nativeElement.offsetHeight;
        this.containerLeft = ($(window).width() - containerWidth) / 2;
        this.containerTop = ($(window).height() - containerHeight) / 2;
    };
    AlertDialogComponent.prototype.ngAfterViewChecked = function () {
        console.log("ngAfterViewChecked");
    };
    AlertDialogComponent.prototype.closeAlertDialog = function () {
        this.onAlertDialogClose.emit({});
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', String)
    ], AlertDialogComponent.prototype, "title", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', String)
    ], AlertDialogComponent.prototype, "message", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Boolean)
    ], AlertDialogComponent.prototype, "dismissible", void 0);
    __decorate([
        core_1.ViewChild('alertComponentContainer'), 
        __metadata('design:type', core_1.ElementRef)
    ], AlertDialogComponent.prototype, "alertComponentContainer", void 0);
    __decorate([
        core_1.ViewChild(ng2_bootstrap_1.AlertComponent), 
        __metadata('design:type', ng2_bootstrap_1.AlertComponent)
    ], AlertDialogComponent.prototype, "alertComponent", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', core_1.EventEmitter)
    ], AlertDialogComponent.prototype, "onAlertDialogClose", void 0);
    AlertDialogComponent = __decorate([
        core_1.Component({
            selector: 'alert-dialog-component',
            templateUrl: 'app/common/dialog/alert-dialog.template.html',
            styles: [],
            directives: [ng2_bootstrap_1.AlertComponent]
        }), 
        __metadata('design:paramtypes', [])
    ], AlertDialogComponent);
    return AlertDialogComponent;
}());
exports.AlertDialogComponent = AlertDialogComponent;
//# sourceMappingURL=alert-dialog.component.js.map