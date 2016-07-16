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
var _ = require('lodash');
require('$');
var image_service_1 = require("./image.service");
var log_service_1 = require("../log.service");
var ImageThumbnailComponent = (function () {
    function ImageThumbnailComponent(imageService, logService) {
        this.imageService = imageService;
        this.logService = logService;
        this.isImageLoadedFlag = false;
        this.logService.log('ImageThumbnailComponent constructor' + this.imageProperties);
    }
    ImageThumbnailComponent.prototype.ngOnChanges = function (changes) {
        console.log('ImageThumbnailComponent ngOnChanges' + this.imageProperties);
        if (!this.imageProperties) {
            return;
        }
        this.url = this.imageProperties.srcUrl;
        _.each(changes, function (changedProp) {
            var from = changedProp.previousValue;
            var to = changedProp.currentValue;
            console.log('${propName} changed from ${from} to ${to}');
            console.log(changedProp + ' changed from ' + from + ' to ' + to);
        });
    };
    ImageThumbnailComponent.prototype.ngOnInit = function () {
        console.log('ImageThumbnailComponent ngOnInit' + this.imageProperties);
        //let imageSrc = element.all(by.tagName('img')).src;
    };
    ImageThumbnailComponent.prototype.ngAfterViewInit = function () {
        //$(this.imageElem.nativeElement).chosen().on('change', (e, args) => {
        //    this.selectedValue = args.selected;
        //});
    };
    ImageThumbnailComponent.prototype.onError = function () {
        if (!this.imageProperties) {
            return;
        }
        if (this.url != this.imageProperties.errorUrl) {
            this.url = this.imageProperties.errorUrl;
        }
    };
    ImageThumbnailComponent.prototype.onLoad = function ($event) {
        if (!this.imageProperties) {
            return;
        }
        if (!this.imageProperties.imageWidth) {
            this.imageProperties.imageWidth = $event.srcElement.naturalWidth;
        }
        if (!this.imageProperties.imageHeight) {
            this.imageProperties.imageHeight = $event.srcElement.naturalHeight;
        }
        this.imageService.buildImageProperties(this.imageProperties);
        this.isImageLoadedFlag = true;
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', image_properties_model_1.ImageProperties)
    ], ImageThumbnailComponent.prototype, "imageProperties", void 0);
    ImageThumbnailComponent = __decorate([
        core_1.Component({
            selector: 'image-thumbnail',
            template: '' +
                '<div class="content" [style.width.px]="imageProperties.containerWidth" [style.height.px]="imageProperties.containerHeight">' +
                '   <img #img src="{{url}}" alt="{{imageProperties.title}}" (error)="onError()" (load)="onLoad($event)" [style.display]="isImageLoadedFlag?\'block\':\'none\'" [style.top.px]="imageProperties.top" [style.left.px]="imageProperties.left" [style.width.px]="imageProperties.width" [style.height.px]="imageProperties.height"/>' +
                '</div>' +
                '',
            styles: [
                '.content { margin: 0 auto; position: relative; border: 1px solid darkgray; background: white;}' +
                    '.content > img{ position: absolute; }' +
                    ''
            ]
        }), 
        __metadata('design:paramtypes', [image_service_1.ImageService, log_service_1.LogService])
    ], ImageThumbnailComponent);
    return ImageThumbnailComponent;
}());
exports.ImageThumbnailComponent = ImageThumbnailComponent;
//# sourceMappingURL=image-thumbnail.component.js.map