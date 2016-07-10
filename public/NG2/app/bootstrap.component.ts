//One or more import statements to reference the things we need.
import { Router, ActivatedRoute }       from '@angular/router';
import {Component} from '@angular/core';
import {OnInit} from '@angular/core';

import * as _ from 'lodash';
import {ImageProperties, StretchMode} from "./common/image-properties.model";
import {ImageThumbnailComponent} from "./common/image-thumbnail.component";
import {ImageService} from "./common/image.service";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'redis-manager', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div>please visit <a href="http://valor-software.com/ng2-bootstrap/index-bs4.html" target="_blank">http://valor-software.com/ng2-bootstrap/</a></div>' +
    '<div>About fontawesome</div>'+
    '<div>please visit <a href="http://fontawesome.io/icons/">http://fontawesome.io/icons/</a></div>'+
    '<br/>'+
    '<image-thumbnail [imageProperties]="imageProperties"></image-thumbnail>'+
    '<br/>'+
    ''+
    '',
    styles: [''],
    directives: [ImageThumbnailComponent],
    providers: []
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class BootstrapComponent implements OnInit {
    //When we're ready to build a substantive application, we can expand this class with properties and application logic.
    title:string = 'NATIVE ANGULAR 2 DIRECTIVES FOR BOOTSTRAP';

    imageProperties: ImageProperties;

    constructor(private imageService:ImageService) {
        console.log('BootstrapComponent constructor');
        
        this.imageProperties = this.imageService.createImageProperties(570,650,400,400);
        this.imageProperties.stretchMode = StretchMode.WHOLE;
        this.imageProperties.srcUrl = 'images/a.jpg';
        this.imageProperties.errorUrl = 'images/topic-thumbtail.jpg';
        this.imageService.buildImageProperties(this.imageProperties);
        


    }

    ngOnInit() {
        
    }

}


