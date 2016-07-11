import {Component, Input, Output,EventEmitter} from '@angular/core';
import { OnInit } from '@angular/core';
import {Topic} from "./topic.model";
import {TopicService} from "./topic.service";
import {StretchMode} from "../../common/image-viewer/image-properties.model";
import {ImageService} from "../../common/image-viewer/image.service";
import {ImageThumbnailComponent} from "../../common/image-viewer/image-thumbnail.component";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'topic-snapshot', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="container">' +
    '   <div class="row">' +
    '       <image-thumbnail class="col-sm-12 center" [image-properties]="imageProperties" (click)="selectTopic()"></image-thumbnail>' +
    '   </div>' +
    '   <div class="row">' +
    '       <div class="col-sm-12 center">{{topic.subject}}</div>' +
    '   </div>' +
    '   <div class="row">' +
    '       <div class="col-sm-12 center" ><button (click)="aaa()">编号: {{topic.number}}</button></div>' +
    '   </div>' +
    '</div>' +
    '',
    styles: [''],
    directives: [ImageThumbnailComponent]
})


export class TopicSnapshotComponent implements OnChanges{
    @Input()
    private topic: Topic;

    @Output()
    private onTopicSelected: EventEmitter = new EventEmitter();

    constructor(private imageService:ImageService) {
        console.log('TopicSnapshotComponent constructor'+this.topic);
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('TopicSnapshotComponent ngOnChanges'+this.topic);

        if(this.topic) {
            this.imageProperties = this.imageService.createImageProperties(null, null, 400, 400);
            this.imageProperties.stretchMode = StretchMode.WHOLE;
            this.imageProperties.srcUrl = this.topic.posterUrl;
            this.imageProperties.errorUrl = 'images/topic-thumbtail.jpg';
        }
    }


    aaa(){
        if(this.topic) {
            this.imageProperties = this.imageService.createImageProperties(null, null, 400, 400);
            this.imageProperties.stretchMode = StretchMode.WHOLE;
            this.imageProperties.srcUrl = this.topic.posterUrl;
            this.imageProperties.errorUrl = 'images/topic-thumbtail.jpg';
        }
    }

    selectTopic(){
        if(this.topic){
            this.onTopicSelected.emit(this.topic);
        }
    }
}
