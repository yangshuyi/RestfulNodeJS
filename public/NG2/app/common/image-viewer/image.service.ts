import {Injectable} from '@angular/core'
import {ImageProperties, StretchMode} from "./image-properties.model";

@Injectable()
export class ImageService {
    createImageProperties(imageWidth:number, imageHeight:number, containerWidth:number, containerHeight:number):ImageProperties {
        let imageProperties = new ImageProperties();
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

    buildImageProperties(imageProperties:ImageProperties):void {
        let stretchMode = imageProperties.stretchMode ? imageProperties.stretchMode : StretchMode.INITIAL;

        if (stretchMode == StretchMode.WHOLE) {
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
        } else if (stretchMode == StretchMode.FILL) {
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
        } else if(stretchMode == StretchMode.INITIAL){
            imageProperties.width = imageProperties.imageWidth;
            imageProperties.height = imageProperties.imageHeight;

            imageProperties.left = (imageProperties.containerWidth - imageProperties.width) / 2;
            imageProperties.top = (imageProperties.containerHeight - imageProperties.height) / 2;
        }
    };

}