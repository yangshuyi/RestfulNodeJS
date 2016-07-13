import {Component, Input, Output, OnChanges, SimpleChange, EventEmitter, ElementRef, ViewChild} from '@angular/core';
import {ImageThumbnailComponent} from "../../common/image-viewer/image-thumbnail.component";
import {Topic} from "./topic.model";
import {ImageProperties} from "../../common/image-viewer/image-properties.model";
import {ImageService} from "../../common/image-viewer/image.service";
import {StretchMode} from "../../common/image-viewer/image-properties.model";

@Component({
    selector: 'topic-card-item',
    template: '' +
    '<div class="content" >' +
    '       <div class="row">' +
    '           <div #imageThumbnail>' +
    '               <image-thumbnail style="margin: 0 auto;" [imageProperties]="imageProperties" ></image-thumbnail>' +
    '           </div>' +
    '           <div>' +
    '               <div>subject</div>' +
    '               <div class="row">'+
    '                   <div class="col-md-5">'+
    '                       <span class="gray">作品类型：</span>1<br/>'+
    '                       <span class="gray">作品类型：</span>2<br/>'+
    '                       <span class="gray">作品类型：</span>3<br/>'+
    '                   </div>' +
    '                   <div class="col-md-5">'+
    '                       <span class="gray">作品类型：</span>1<br/>'+
    '                       <span class="gray">作品类型：</span>2<br/>'+
    '                       <span class="gray">作品类型：</span>3<br/>'+
    '                   </div>' +
    '               </div>' +
    '           </div>' +
    '       </div>' +
    '       <div class="row">' +
    '           <div>{{topic.subject}}</div>' +
    '           <div class="center">编号: {{topic.number}}</div>' +
    '       </div>' +
    '</div>' +
    '',
    styles: [
        '.content { }' +
        ''
    ],
    directives: [ImageThumbnailComponent]
})


export class TopicCardItemComponent implements OnChanges {
    @Input()
    private topic:Topic;

    @Output()
    private onTopicSelected:EventEmitter = new EventEmitter();

    @ViewChild('imageThumbnail')
    private imageThumbnailContainerElement:ElementRef;

    private imageProperties:ImageProperties;

    constructor(private imageThumbnailContainerElement: ElementRef, private imageService:ImageService) {
        console.log('TopicCardItemComponent constructor el');
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('TopicCardItemComponent ngOnChanges' + this.topic);

        buildThumbnailImageProperties();
    }

    buildThumbnailImageProperties():void{
        let imageContainerWidth = this.imageThumbnailContainerElement.nativeElement.offsetWidth;
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
