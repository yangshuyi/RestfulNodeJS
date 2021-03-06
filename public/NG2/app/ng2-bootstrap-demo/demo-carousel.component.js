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
var forms_1 = require("@angular/forms");
var common_1 = require("@angular/common");
var DemoCarouselComponent = (function () {
    function DemoCarouselComponent() {
        this.myInterval = 5000;
        this.noWrapSlides = false;
        this.slides = [];
        for (var i = 0; i < 4; i++) {
            this.addSlide();
        }
    }
    DemoCarouselComponent.prototype.addSlide = function () {
        var newWidth = 600 + this.slides.length + 1;
        this.slides.push({
            image: 'images/advisement/portal_index_adv_20110406.jpg',
            text: 'text'
        }, {
            image: 'images/advisement/portal_index_adv_20110412.jpg',
            text: 'text'
        });
    };
    DemoCarouselComponent.prototype.removeSlide = function (index) {
        this.slides.splice(index, 1);
    };
    DemoCarouselComponent = __decorate([
        core_1.Component({
            selector: 'ng2-bootstrap-demo-carousel-component',
            templateUrl: 'app/ng2-bootstrap-demo/demo-carousel.template.html',
            styles: [''],
            directives: [ng2_bootstrap_1.CAROUSEL_DIRECTIVES, common_1.CORE_DIRECTIVES, forms_1.FORM_DIRECTIVES]
        }), 
        __metadata('design:paramtypes', [])
    ], DemoCarouselComponent);
    return DemoCarouselComponent;
})();
exports.DemoCarouselComponent = DemoCarouselComponent;
//# sourceMappingURL=demo-carousel.component.js.map