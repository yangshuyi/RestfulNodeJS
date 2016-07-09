import {Component, Input, OnChanges, SimpleChange} from '@angular/core';
import {ImageProperties} from "./image-properties.model";
import {element} from "@angular/upgrade/esm/src/angular_js";

import * as _ from 'lodash';

@Component({
    selector: 'image-thumbnail', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="content">' +
    '   <img src="{{url}}" draggable="false" style="width:{{imageProperties.width}}px;height:{{imageProperties.height}}px;top:{{imageProperties.top}}px;left:{{imageProperties.left}}px;"/>' +
    '</div>' +
    '',
    styles: ['']
})

export class ImageThumbnail implements OnChanges {
    @Input()
    private imageProperties:ImageProperties;

    private url:string;

    constructor() {
    }


    init() {
        let imageSrc = element.all(by.tagName('img')).src;
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        _.each(changes, function (changedProp) {
            let from = changedProp.previousValue;
            let to = changedProp.currentValue;
            console.log('${propName} changed from ${from} to ${to}');
        });
    }
}
