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
var topic_service_1 = require("./echodrama/topic/topic.service");
var space_list_component_1 = require("./echodrama/topic/space-list.component");
var alert_dialog_component_1 = require("./common/dialog/alert-dialog.component");
require('$');
var BootstrapComponent = (function () {
    function BootstrapComponent() {
        //When we're ready to build a substantive application, we can expand this class with properties and application logic.
        this.title = 'NATIVE ANGULAR 2 DIRECTIVES FOR BOOTSTRAP';
        this.alerts = [
            {
                type: 'danger',
                msg: 'Oh snap! Change a few things up and try submitting again.'
            },
            {
                type: 'success',
                msg: 'Well done! You successfully read this important alert message.',
                closable: true
            }
        ];
        console.log('BootstrapComponent constructor');
    }
    BootstrapComponent.prototype.ngOnInit = function () {
    };
    BootstrapComponent.prototype.showAlertDialog = function () {
        $('body').append('<alert-dialog-component title="TITLE" message="helloworld" [dismissible]="true" ></alert-dialog-component>');
    };
    BootstrapComponent.prototype.closeAlert = function (i) {
        this.alerts.splice(i, 1);
    };
    BootstrapComponent.prototype.addAlert = function () {
        this.alerts.push({ msg: 'Another alert!', type: 'warning', closable: true });
    };
    BootstrapComponent = __decorate([
        core_1.Component({
            selector: 'bootstrap-component',
            templateUrl: 'app/bootstrap.template.html',
            styles: [''],
            directives: [space_list_component_1.TopicSpaceListComponent, alert_dialog_component_1.AlertDialogComponent],
            providers: [topic_service_1.TopicService]
        }), 
        __metadata('design:paramtypes', [])
    ], BootstrapComponent);
    return BootstrapComponent;
}());
exports.BootstrapComponent = BootstrapComponent;
//# sourceMappingURL=bootstrap.component.js.map