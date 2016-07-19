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
var core_1 = require("@angular/core");
var PaginationComponent = (function () {
    function PaginationComponent() {
        this.onPageChanged = new core_1.EventEmitter();
    }
    PaginationComponent.prototype.ngOnChanges = function (changes) {
    };
    PaginationComponent.prototype.ngOnInit = function () {
    };
    PaginationComponent.prototype.gotoPage = function () {
        this.onPageChanged.emit(this.currentPageIdx);
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Number)
    ], PaginationComponent.prototype, "pageNum", void 0);
    __decorate([
        core_1.Input(), 
        __metadata('design:type', Number)
    ], PaginationComponent.prototype, "currentPageIdx", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', core_1.EventEmitter)
    ], PaginationComponent.prototype, "onPageChanged", void 0);
    PaginationComponent = __decorate([
        core_1.Component({
            selector: 'image-thumbnail',
            template: '' +
                '<ul class="pagination">' +
                '   <li><a href="#">&laquo;</a></li>' +
                '   <li><a href="#">1</a></li>' +
                '   <li><a href="#">2</a></li>' +
                '   <li><a href="#">3</a></li>' +
                '   <li><a href="#">4</a></li>' +
                '   <li><a href="#">5</a></li>' +
                '   <li><a href="#">&raquo;</a></li>' +
                '   </ul>' +
                '',
            styles: [
                '.content { margin: 0 auto; position: relative; border: 1px solid darkgray; background: white;}' +
                    '.content > img{ position: absolute; }' +
                    ''
            ]
        }), 
        __metadata('design:paramtypes', [])
    ], PaginationComponent);
    return PaginationComponent;
}());
exports.PaginationComponent = PaginationComponent;
//# sourceMappingURL=pagination.component.js.map