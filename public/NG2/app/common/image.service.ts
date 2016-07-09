import {Injectable} from '@angular/core'
import {ImageProperties} from "./image-properties.model";

@Injectable()
export class ImageService {
    createImageProperties(imageWidth:number, imageHeight:number, containerWidth:number, containerHeight:number):ImageProperties {
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
        }
    };

    buildImageProperties(imageProperties:ImageProperties):void {
        let stretchMode = imageProperties.stretchMode ? imageProperties.stretchMode : 1;

        if (stretchMode == 1) {
            //图片宽高计算
            if (imageProperties.imageWidth > 0 && imageProperties.imageHeight > 0) {
                if ((imageProperties.imageWidth / imageProperties.imageHeight) > ( imageProperties.containerWidth / imageProperties.containerHeight)) {
                    //过宽
                    imageProperties.width = imageProperties.containerWidth;
                    imageProperties.height = imageProperties.imageHeight * ( imageProperties.containerWidth / imageProperties.imageWidth);

                    imageProperties.left = 0;
                    imageProperties.top = (imageProperties.containerHeight - imageProperties.height) / 2;

                } else {
                    //过高
                    imageProperties.width = imageProperties.imageWidth * ( imageProperties.containerHeight / imageProperties.imageHeight);
                    imageProperties.height = imageProperties.containerHeight;

                    imageProperties.left = (imageProperties.containerWidth - imageProperties.width) / 2;
                    imageProperties.top = 0;
                }
            } else {
                imageProperties.width = imageProperties.containerWidth;
                imageProperties.height = imageProperties.containerHeight;

                imageProperties.left = 0;
                imageProperties.top = 0;
            }
        } else if (stretchMode == 2) {
            //图片宽高计算
            if (imageProperties.imageWidth > 0 && imageProperties.imageHeight > 0) {
                if ((imageProperties.imageWidth / imageProperties.imageHeight) > ( imageProperties.containerWidth / imageProperties.containerHeight)) {
                    //过宽,以高为准居中
                    imageProperties.width = imageProperties.imageWidth * ( imageProperties.containerHeight / imageProperties.imageHeight);
                    imageProperties.height = imageProperties.containerHeight;

                    imageProperties.left = (imageProperties.containerWidth - imageProperties.width) / 2;
                    imageProperties.top = 0;

                } else {
                    //过高
                    imageProperties.width = imageProperties.containerWidth;
                    imageProperties.height = imageProperties.imageHeight * ( imageProperties.containerWidth / imageProperties.imageWidth);

                    imageProperties.left = 0;
                    imageProperties.top = (imageProperties.containerHeight - imageProperties.height) / 2;
                }
            } else {
                imageProperties.width = imageProperties.containerWidth;
                imageProperties.height = imageProperties.containerHeight;

                imageProperties.left = 0;
                imageProperties.top = 0;
            }
        }
    };

}