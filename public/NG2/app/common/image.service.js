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
var ImageService = (function () {
    function ImageService() {
    }
    ImageService.prototype.createImageProperties = function (imageWidth, imageHeight, containerWidth, containerHeight) {
        return {
            imageWidth: imageWidth,
            imageHeight: imageHeight,
            containerWidth: containerWidth,
            containerHeight: containerHeight,
            scale: 1,
            rotate: 0,
            top: 0,
            left: 0,
            width: 0,
            height: 0,
        };
    };
    ;
    ImageService.prototype.buildImageProperties = function (imageProperties) {
        var stretchMode = imageProperties.stretchMode ? imageProperties.stretchMode : 1;
        if (stretchMode == 1) {
            //图片宽高计算
            if (imageProperties.imageWidth > 0 && imageProperties.imageHeight > 0) {
                if ((imageProperties.imageWidth / imageProperties.imageHeight) > (imageProperties.containerWidth / imageProperties.containerHeight)) {
                    //过宽
                    imageProperties.width = imageProperties.containerWidth;
                    imageProperties.height = imageProperties.imageHeight * (imageProperties.containerWidth / imageProperties.imageWidth);
                    imageProperties.left = 0;
                    imageProperties.top = (imageProperties.containerHeight - imageProperties.height) / 2;
                }
                else {
                    //过高
                    imageProperties.width = imageProperties.imageWidth * (imageProperties.containerHeight / imageProperties.imageHeight);
                    imageProperties.height = imageProperties.containerHeight;
                    imageProperties.left = (imageProperties.containerWidth - imageProperties.width) / 2;
                    imageProperties.top = 0;
                }
            }
            else {
                imageProperties.width = imageProperties.containerWidth;
                imageProperties.height = imageProperties.containerHeight;
                imageProperties.left = 0;
                imageProperties.top = 0;
            }
        }
        else if (stretchMode == 2) {
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