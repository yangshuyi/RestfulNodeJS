import {Component, OnChanges, SimpleChange, Input, OnInit} from '@angular/core';
import {ImageProperties} from "./image-properties.model";

import * as _ from 'lodash';
import {ImageService} from "./image.service";
import {LogService} from "./log.service";

@Component({
    selector: 'image-thumbnail', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="content" [style.width.px]="imageProperties.containerHeight" [style.height.px]="imageProperties.containerHeight">' +
    '   <img src="{{url}}" (error)="onError()" (load)="onLoad()" [style.display]="isImageLoadedFlag?\'block\':\'none\'" [style.top.px]="imageProperties.top" [style.left.px]="imageProperties.left" [style.width.px]="imageProperties.width" [style.height.px]="imageProperties.height"/>' +
    '</div>' +
    '',
    styles: [
        '.content { position: relative; border: 1px solid darkgray; background: white;}'+
        '.content > img{ position: absolute; }'+
        ''
    ]
})

export class ImageThumbnailComponent implements OnInit, OnChanges {
    @Input()
    private imageProperties:ImageProperties;

    private url:string;
    private isImageLoadedFlag: boolean = false;

    constructor(private imageService:ImageService, private logService:LogService) {
        this.logService.log('ImageThumbnailComponent constructor'+this.imageProperties);

    }


    ngOnInit() {
        console.log('ImageThumbnailComponent ngOnInit'+this.imageProperties.srcUrl);
        //let imageSrc = element.all(by.tagName('img')).src;
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('ImageThumbnailComponent ngOnChanges'+this.imageProperties.srcUrl);
        this.url = this.imageProperties.srcUrl;
        _.each(changes, function (changedProp) {
            let from = changedProp.previousValue;
            let to = changedProp.currentValue;
            console.log('${propName} changed from ${from} to ${to}');
            console.log(changedProp+' changed from '+from+' to '+to);
        });
    }

    onError(){
        console.log('onError');
        // if(this.url != this.imageProperties.errorUrl){
        //     this.url = this.imageProperties.errorUrl;
        // }
    }

    onLoad(){
        console.log('onLoad');

        

        this.isImageLoadedFlag = true;
    }
}
