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
var image_properties_model_1 = require("./image-properties.model");
var angular_js_1 = require("@angular/upgrade/esm/src/angular_js");
var _ = require('lodash');
var ImageThumbnail = (function () {
    function ImageThumbnail() {
    }
    ImageThumbnail.prototype.init = function () {
        var imageSrc = angular_js_1.element.all(by.tagName('img')).src;
    };
    ImageThumbnail.prototype.ngOnChanges = function (changes) {
        _.each(changes, function (changedProp) {
            var from = changedProp.previousValue;
            var to = changedProp.currentValue;
            console.log('${propName} changed from ${from} to ${to}');
        });
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', image_properties_model_1.ImageProperties)
    ], ImageThumbnail.prototype, "imageProperties", void 0);
    ImageThumbnail = __decorate([
        core_1.Component({
            selector: 'image-thumbnail',
            template: '' +
                '<div class="content">' +
                '   <img src="{{url}}" draggable="false" style="width:{{imageProperties.width}}px;height:{{imageProperties.height}}px;top:{{imageProperties.top}}px;left:{{imageProperties.left}}px;"/>' +
                '</div>' +
                '',
            styles: ['']
        }), 
        __metadata('design:paramtypes', [])
    ], ImageThumbnail);
    return ImageThumbnail;
}());
exports.ImageThumbnail = ImageThumbnail;
//# sourceMappingURL=image-thumbnail.component.js.map