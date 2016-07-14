import {Component, Input, Output, OnChanges, SimpleChange, EventEmitter, ElementRef, ViewChild} from '@angular/core';
import {ImageThumbnailComponent} from "../../common/image-viewer/image-thumbnail.component";
import {Topic} from "./topic.model";
import {ImageProperties} from "../../common/image-viewer/image-properties.model";
import {ImageService} from "../../common/image-viewer/image.service";
import {StretchMode} from "../../common/image-viewer/image-properties.model";
import {DatePipe} from "@angular/common";

@Component({
    selector: 'topic-card-item',
    template: '' +
    '<div class="card" >' +
    //'<div class="right-corner"></div>'+
    '<h6 class="right-corner-label">{{topic.category.text}}</h6>'+
    '<div class="content">'+
    '   <div class="container" >' +
    '           <div class="row">' +
    '               <div #imageThumbnail style="width:132px;">' +
    '                   <image-thumbnail style="margin: 0 auto;" [imageProperties]="imageProperties" ></image-thumbnail>' +
    '              </div>' +
    '              <div style="padding-left:20px;width:calc( 100% - 132px );">' +
    '                   <h5 class="orange">{{topic.subject}}</h5>' +
    '                   <div class="gray" style="margin-bottom:10px;">'+
    '                      <span  *ngIf="topic.singletonAlbum" class="mark">全一期</span>' +
    '                      <span *ngFor="let labelItem of topic.labelItemArray" class="mark">{{labelItem}}</span>' +
    '                   </div>' +
    '                   <ul class="list-inline" style="margin-bottom:initial;">' +
    '                     <li class="list-inline-item" style="vertical-align: top; width:48%;">' +
    '                           <ul class="list-unstyled"  style="vertical-align: top; vertical-align: top">' +
    '                               <li><span class="gray">作品类型：</span>{{topic.category.text}}</li>' +
    '                               <li><span class="gray">所属团队：</span>{{topic.club}}</li>' +
    '                               <li><span class="gray">原著　　：</span>{{topic.yuanzhu}}</li>' +
    '                               <li><span class="gray">发布时间：</span>{{topic.dateline|date:"yyyy年MM月dd日"}}</li>' +
    '                         </ul>' +
    '                       </li>' +
    '                       <li class="list-inline-item" style="vertical-align: top; width:50%;">' +
    '                           <ul class="list-unstyled">' +
    '                               <li><span class="gray">导演：</span>{{topic.director}}</li>' +
    '                               <li><span class="gray">编剧：</span>{{topic.writer}}</li>' +
    '                               <li><span class="gray">后期：</span>{{topic.effector}}</li>' +
    '                               <li><span class="gray">海报：</span>{{topic.photographer}}</li>' +
    '                          </ul>' +
    '                       </li>' +
    '                   </ul>' +
    '                </div>' +
    '          </div>' +
    '          <div class="row description">' +
    '               <div class="text-sm-center text-md-center " style="width:132px;">编号: {{topic.number}}</div>' +
    '               <div class="text-sm-right text-md-right " style="padding-left:20px;;width:calc( 100% - 132px );">'+
    '                   <span class="orange">{{topic.viewNum}}</span>次访问,　'+
    '                   <span class="orange">{{topic.joinNum}}</span>次收藏, '+
    '　                 <span class="orange">{{topic.downloadNum}}</span>次下载,　'+
    '                   <span class="orange">{{topic.replyNum}}</span>次评论'+
    '               </div>' +
    '       </div>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '',
    styles: [
        '.card { border: 1px solid lightgray; margin-bottom: 20px; border-radius: 10px; }' +
        //'.right-corner {position:absolute; right:0px; border-top: 40px solid orange; border-left: 40px solid transparent; border-bottom: 40px solid transparent; border-right: 40px solid orange;}' +
        // '.right-corner-label {position:absolute; right:5px; top: 5px; font-weight: bold; color:white;}' +
        '.right-corner-label {position: absolute; right: 0px;top: 0px;background: orange;border-bottom-left-radius: 10px;font-weight: bold;color: white;padding: 10px;border-top-right-radius: 10px;}' +
        '.content {padding: 10px 10px 0px 10px;}' +
        '.orange {color:orange;}'+
        '.gray {color:gray;}'+
        '.mark {border:1px solid orange; font-size: 12px; margin-right:10px;}'+
        '.description {font-size: 14px;}'+
        ''
    ],
    directives: [ImageThumbnailComponent],
    pipe: [DatePipe]
})


export class TopicCardItemComponent implements OnChanges {
    @Input()
    private topic:Topic;

    @Output()
    private onTopicSelected:EventEmitter = new EventEmitter();

    @ViewChild('imageThumbnail')
    private imageThumbnailContainerElement:ElementRef;

    private imageProperties:ImageProperties;

    constructor(private imageThumbnailContainerElement:ElementRef, private imageService:ImageService) {
        console.log('TopicCardItemComponent constructor el');
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('TopicCardItemComponent ngOnChanges' + this.topic);

        this.buildThumbnailImageProperties();
    }

    buildThumbnailImageProperties():void {
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

    //transform: perspective(600px) rotateY(45deg); */
}
