import {Component, Input, Output, OnChanges, SimpleChange, EventEmitter} from '@angular/core';
import {ImageThumbnailComponent} from "../../common/image-viewer/image-thumbnail.component";
import {Topic} from "./topic.model";
import {ImageService} from "../../common/image-viewer/image.service";
import {StretchMode, ImageProperties} from "../../common/image-viewer/image-properties.model";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'topic-snapshot', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="content container" (click)="selectTopic()">' +
    '   <div class="row">' +
    '       <image-thumbnail class="col-sm-12 center" style="margin: 0 auto;" [imageProperties]="imageProperties" ></image-thumbnail>' +
    '   </div>' +
    '   <div class="row">' +
    '       <div class="col-sm-12 center">{{topic.subject}}</div>' +
    '   </div>' +
    '   <div class="row">' +
    '       <div class="col-sm-12 center">编号: {{topic.number}}</div>' +
    '   </div>' +
    '</div>' +
    '',
    styles: [
        '.content { cursor: pointer;}' +
        ''
    ],
    directives: [ImageThumbnailComponent]
})


export class TopicSnapshotComponent implements OnChanges {
    @Input()
    private topic:Topic;

    private imageProperties:ImageProperties;

    @Output()
    private onTopicSelected:EventEmitter = new EventEmitter();

    constructor(private imageService:ImageService) {
        console.log('TopicSnapshotComponent constructor' + this.topic);
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('TopicSnapshotComponent ngOnChanges' + this.topic);

        this.imageProperties = this.imageService.createImageProperties(null, null, 120, 160);
        this.imageProperties.stretchMode = StretchMode.WHOLE;
        this.imageProperties.srcUrl = this.topic.posterUrl;
        this.imageProperties.errorUrl = 'images/topic-thumbnail.jpg';
    }

    selectTopic() {
        if (this.topic) {
            console.log('selectTopic');
            this.onTopicSelected.emit(this.topic);
        }
    }
}
