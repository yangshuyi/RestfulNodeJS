export class ImageProperties {
    srcUrl:string;
    errorUrl:string;
    title:string = '';

    width:number;
    height:number;
    left:number;
    top:number;

    imageWidth:number;
    imageHeight:number;

    containerWidth:number;
    containerHeight:number;
    scale:number = 1;
    rotate:number = 0;
    stretchMode:StretchMode = StretchMode.INITIAL;
}

export enum StretchMode {
    WHOLE = 1,
    FILL = 2,
    INITIAL = 3
}
