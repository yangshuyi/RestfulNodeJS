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
var ImageService = (function () {
    function ImageService() {
    }
    ImageService.prototype.createImageProperties = function (imageWidth, imageHeight, containerWidth, containerHeight) {
        var imageProperties = new image_properties_model_1.ImageProperties();
        imageProperties.id = (new Date()).getTime();
        imageProperties.imageWidth = imageWidth;
        imageProperties.imageHeight = imageHeight;
        imageProperties.containerWidth = containerWidth;
        imageProperties.containerHeight = containerHeight;
        imageProperties.scale = 1;
        imageProperties.rotate = 0;
        imageProperties.top = 0;
        imageProperties.left = 0;
        imageProperties.width = 0;
        imageProperties.height = 0;
        return imageProperties;
    };
    ;
    ImageService.prototype.buildImageProperties = function (imageProperties) {
        var stretchMode = imageProperties.stretchMode ? imageProperties.stretchMode : image_properties_model_1.StretchMode.INITIAL;
        if (stretchMode == image_properties_model_1.StretchMode.WHOLE) {
            //图片宽高计算
            if (imageProperties.imageWidth > 0 && imageProperties.imageHeight > 0) {
                if ((imageProperties.imageWidth / imageProperties.imageHeight) > (imageProperties.containerWidth / imageProperties.containerHeight)) {
                    //过宽
                    imageProperties.width = imageProperties.containerWidth - 2;
                    imageProperties.height = imageProperties.imageHeight * (imageProperties.containerWidth / imageProperties.imageWidth) - 2;
                    imageProperties.left = 0;
                    imageProperties.top = (imageProperties.containerHeight - imageProperties.height) / 2;
                }
                else {
                    //过高
                    imageProperties.width = imageProperties.imageWidth * (imageProperties.containerHeight / imageProperties.imageHeight) - 2;
                    imageProperties.height = imageProperties.containerHeight - 2;
                    imageProperties.left = (imageProperties.containerWidth - imageProperties.width) / 2;
                    imageProperties.top = 0;
                }
            }
            else {
                imageProperties.width = imageProperties.containerWidth - 2;
                imageProperties.height = imageProperties.containerHeight - 2;
                imageProperties.left = 0;
                imageProperties.top = 0;
            }
        }
        else if (stretchMode == image_properties_model_1.StretchMode.FILL) {
            //图片宽高计算
            if (imageProperties.imageWidth > 0 && imageProperties.imageHeight > 0) {
                if ((imageProperties.imageWidth / imageProperties.imageHeight) > (imageProperties.containerWidth / imageProperties.containerHeight)) {
                    //过宽,以高为准居中
                    imageProperties.width = imageProperties.imageWidth * (imageProperties.containerHeight / imageProperties.imageHeight);
                    imageProperties.height = imageProperties.containerHeight;
                    imageProperties.left = (imageProperties.containerWidth - imageProperties.width) / 2;
                    imageProperties.top = 0;
                }
                else {
                    //过高
                    imageProperties.width = imageProperties.containerWidth;
                    imageProperties.height = imageProperties.imageHeight * (imageProperties.containerWidth / imageProperties.imageWidth);
                    imageProperties.left = 0;
                    imageProperties.top = (imageProperties.containerHeight - imageProperties.height) / 2;
                }
            }
            else {
                imageProperties.width = imageProperties.containerWidth;
                imageProperties.height = imageProperties.containerHeight;
                imageProperties.left = 0;
                imageProperties.top = 0;
            }
        }
        else if (stretchMode == image_properties_model_1.StretchMode.INITIAL) {
            imageProperties.width = imageProperties.imageWidth;
            imageProperties.height = imageProperties.imageHeight;
            imageProperties.left = (imageProperties.containerWidth - imageProperties.width) / 2;
            imageProperties.top = (imageProperties.containerHeight - imageProperties.height) / 2;
        }
    };
    ;
    ImageService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [])
    ], ImageService);
    return ImageService;
}());
exports.ImageService = ImageService;
//# sourceMappingURL=image.service.js.map