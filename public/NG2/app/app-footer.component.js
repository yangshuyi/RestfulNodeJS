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
var AppFooterComponent = (function () {
    function AppFooterComponent() {
    }
    __decorate([
        Input(), 
        __metadata('design:type', app_info_model_1.AppInfo)
    ], AppFooterComponent.prototype, "appInfo", void 0);
    AppFooterComponent = __decorate([
        core_1.Component({
            selector: 'app-footer',
            template: '' +
                '<div class="container">' +
                '    <div class="row">' +
                '       <div class="col-sm-12 center">&copy; 2013 <a target="_blank" href="{{url}}" title="{{footName}}">{{footName}}</a>. All Rights Reserved.</div>' +
                '   </div>' +
                '</div>' +
                '',
            styles: ['']
        }), 
        __metadata('design:paramtypes', [])
    ], AppFooterComponent);
    return AppFooterComponent;
})();
exports.AppFooterComponent = AppFooterComponent;
//# sourceMappingURL=app-footer.component.js.map