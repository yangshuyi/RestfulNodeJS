//One or more import statements to reference the things we need.
import { Router, ActivatedRoute }       from '@angular/router';
import {Component} from '@angular/core';
import {OnInit} from '@angular/core';

import {ImageService} from "./common/image-viewer/image.service";
import {Topic} from "./echodrama/topic/topic.model";
import {TopicService} from "./echodrama/topic/topic.service";
import {TopicSpaceListComponent} from "./echodrama/topic/space-list.component";

@Component({
    selector: 'bootstrap-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div>https://github.com/twbs/bootstrap/tree/v4-dev</div>' +
    '<div>please visit <a href="http://valor-software.com/ng2-bootstrap/index-bs4.html" target="_blank">http://valor-software.com/ng2-bootstrap/</a></div>' +
    '<div>About fontawesome</div>'+
    '<div>please visit <a href="http://fontawesome.io/icons/">http://fontawesome.io/icons/</a></div>'+
    '<br/>'+
    '<topic-space-list-component></topic-space-list-component>'+
    '<br/>'+
    ''+
    '',
    styles: [''],
    directives: [TopicSpaceListComponent],
    providers: [TopicService]
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class BootstrapComponent implements OnInit {
    //When we're ready to build a substantive application, we can expand this class with properties and application logic.
    title:string = 'NATIVE ANGULAR 2 DIRECTIVES FOR BOOTSTRAP';

    topic: Topic;

    constructor(private imageService:ImageService, private topicService:TopicService) {
        console.log('BootstrapComponent constructor');
        this.topic = topicService.loadTopicById(1);



    }

    ngOnInit() {
        
    }

}


