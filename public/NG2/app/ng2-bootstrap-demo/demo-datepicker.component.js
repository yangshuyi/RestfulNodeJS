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
// import moment = require("moment/moment");
var DemoDatepickerComponent = (function () {
    function DemoDatepickerComponent() {
        this.dt = new Date();
        this.minDate = void 0;
        this.formats = ['DD-MM-YYYY', 'YYYY/MM/DD', 'DD.MM.YYYY', 'shortDate'];
        this.format = this.formats[0];
        this.dateOptions = {
            formatYear: 'YY',
            startingDay: 1
        };
        this.opened = false;
        (this.tomorrow = new Date()).setDate(this.tomorrow.getDate() + 1);
        (this.afterTomorrow = new Date()).setDate(this.tomorrow.getDate() + 2);
        (this.minDate = new Date()).setDate(this.minDate.getDate() - 1000);
        this.events = [
            { date: this.tomorrow, status: 'full' },
            { date: this.afterTomorrow, status: 'partially' }
        ];
    }
    DemoDatepickerComponent.prototype.getDate = function () {
        return this.dt && this.dt.getTime() || new Date().getTime();
    };
    DemoDatepickerComponent.prototype.today = function () {
        this.dt = new Date();
    };
    DemoDatepickerComponent.prototype.d20090824 = function () {
        this.dt = new Date();
    };
    // todo: implement custom class cases
    DemoDatepickerComponent.prototype.getDayClass = function (date, mode) {
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0, 0, 0, 0);
            for (var i = 0; i < this.events.length; i++) {
                var currentDay = new Date(this.events[i].date).setHours(0, 0, 0, 0);
                if (dayToCheck === currentDay) {
                    return this.events[i].status;
                }
            }
        }
        return '';
    };
    DemoDatepickerComponent.prototype.disabled = function (date, mode) {
        return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
    };
    DemoDatepickerComponent.prototype.open = function () {
        this.opened = !this.opened;
    };
    DemoDatepickerComponent.prototype.clear = function () {
        this.dt = void 0;
    };
    DemoDatepickerComponent.prototype.toggleMin = function () {
        this.dt = new Date(this.minDate.valueOf());
    };
    DemoDatepickerComponent = __decorate([
        core_1.Component({
            selector: 'ng2-bootstrap-demo-datepicker-component',
            templateUrl: 'app/ng2-bootstrap-demo/demo-datepicker.template.html',
            directives: [ng2_bootstrap_1.DATEPICKER_DIRECTIVES, common_1.CORE_DIRECTIVES, forms_1.FORM_DIRECTIVES]
        }), 
        __metadata('design:paramtypes', [])
    ], DemoDatepickerComponent);
    return DemoDatepickerComponent;
})();
exports.DemoDatepickerComponent = DemoDatepickerComponent;
//# sourceMappingURL=demo-datepicker.component.js.map