import {Component, Input, Output, OnChanges, SimpleChange, EventEmitter, ElementRef, ViewChild} from '@angular/core';
import {ImageThumbnailComponent} from "../../common/image-viewer/image-thumbnail.component";
import {Topic} from "./topic.model";
import {ImageService} from "../../common/image-viewer/image.service";
import {StretchMode, ImageProperties} from "../../common/image-viewer/image-properties.model";

@Component({
    selector: 'topic-snapshot', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="content" (click)="selectTopic()">' +
    '       <div class="image-thumbnail-content">' +
    '           <div #imageThumbnail>' +
    '               <image-thumbnail style="margin: 0 auto;" [imageProperties]="imageProperties" ></image-thumbnail>' +
    '           </div>' +
    '       </div>' +
    '       <div class="center">{{topic.subject}}</div>' +
    '       <div class="center">编号: {{topic.number}}</div>' +
    '</div>' +
    '',
    styles: [
        '.content { cursor: pointer; margin-bottom:20px;}' +
        '.content>.image-thumbnail-content { border: 1px solid transparent}' +
        '.content:hover>.image-thumbnail-content { border-color: blue}' +
        ''
    ],
    directives: [ImageThumbnailComponent]
})
export class TopicSnapshotComponent implements OnChanges {
    @Input()
    private topic:Topic;

    @Output()
    private onTopicSelected:EventEmitter<any> = new EventEmitter();

    @ViewChild('imageThumbnail') el:ElementRef;
    private imageProperties:ImageProperties;

    constructor(private element: ElementRef, private imageService:ImageService) {
        console.log('TopicSnapshotComponent constructor el');
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('TopicSnapshotComponent ngOnChanges' + this.topic);

        let imageContainerWidth = this.el.nativeElement.offsetWidth;
        let imageContainerHeight = imageContainerWidth / 3 * 4;
        this.imageProperties = this.imageService.createImageProperties(null, null, imageContainerWidth, imageContainerHeight);
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
