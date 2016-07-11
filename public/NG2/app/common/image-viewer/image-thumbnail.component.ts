import {Component, Input, OnInit, OnChanges, SimpleChange} from '@angular/core';
import {ImageProperties} from "./image-properties.model";

import * as _ from 'lodash';
declare var $:JQueryStatic;

import {ImageService} from "./image.service";
import {LogService} from "../log.service";

@Component({
    selector: 'image-thumbnail', //The selector specifies a simple CSS selector for an HTML element that represents the component.
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
})

export class ImageThumbnailComponent implements OnChanges, OnInit {
    @Input()
    private imageProperties:ImageProperties;

    private url:string;
    private isImageLoadedFlag:boolean = false;

    constructor(private imageService:ImageService, private logService:LogService) {
        this.logService.log('ImageThumbnailComponent constructor' + this.imageProperties);
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('ImageThumbnailComponent ngOnChanges' + this.imageProperties);
        if (!this.imageProperties) {
            return;
        }

        this.url = this.imageProperties.srcUrl;
        _.each(changes, function (changedProp) {
            let from = changedProp.previousValue;
            let to = changedProp.currentValue;
            console.log('${propName} changed from ${from} to ${to}');
            console.log(changedProp + ' changed from ' + from + ' to ' + to);
        });
    }

    ngOnInit() {
        console.log('ImageThumbnailComponent ngOnInit' + this.imageProperties);
        //let imageSrc = element.all(by.tagName('img')).src;
    }

    ngAfterViewInit() {
        //$(this.imageElem.nativeElement).chosen().on('change', (e, args) => {
        //    this.selectedValue = args.selected;
        //});
    }

    onError() {
        if (!this.imageProperties) {
            return;
        }

        if (this.url != this.imageProperties.errorUrl) {
            this.url = this.imageProperties.errorUrl;
        }
    }

    onLoad($event) {
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
    }
}
