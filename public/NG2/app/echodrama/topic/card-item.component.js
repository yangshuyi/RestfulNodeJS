var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require('@angular/core');
var image_thumbnail_component_1 = require("../../common/image-viewer/image-thumbnail.component");
var topic_model_1 = require("./topic.model");
var image_service_1 = require("../../common/image-viewer/image.service");
var image_properties_model_1 = require("../../common/image-viewer/image-properties.model");
var TopicCardItemComponent = (function () {
    function TopicCardItemComponent(imageThumbnailContainerElement, imageService) {
        this.imageThumbnailContainerElement = imageThumbnailContainerElement;
        this.imageService = imageService;
        this.onTopicSelected = new core_1.EventEmitter();
        console.log('TopicCardItemComponent constructor el');
    }
    TopicCardItemComponent.prototype.ngOnChanges = function (changes) {
        console.log('TopicCardItemComponent ngOnChanges' + this.topic);
        buildThumbnailImageProperties();
    };
    TopicCardItemComponent.prototype.buildThumbnailImageProperties = function () {
        var imageContainerWidth = this.imageThumbnailContainerElement.nativeElement.offsetWidth;
        var imageContainerHeight = imageContainerWidth / 3 * 4;
        this.imageProperties = this.imageService.createImageProperties(null, null, imageContainerWidth, imageContainerHeight);
        this.imageProperties.stretchMode = image_properties_model_1.StretchMode.WHOLE;
        this.imageProperties.srcUrl = this.topic.posterUrl;
        this.imageProperties.errorUrl = 'images/topic-thumbnail.jpg';
    };
    TopicCardItemComponent.prototype.selectTopic = function () {
        if (this.topic) {
            console.log('selectTopic');
            this.onTopicSelected.emit(this.topic);
        }
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', topic_model_1.Topic)
    ], TopicCardItemComponent.prototype, "topic", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', core_1.EventEmitter)
    ], TopicCardItemComponent.prototype, "onTopicSelected", void 0);
    __decorate([
        core_1.ViewChild('imageThumbnail'), 
        __metadata('design:type', core_1.ElementRef)
    ], TopicCardItemComponent.prototype, "imageThumbnailContainerElement", void 0);
    TopicCardItemComponent = __decorate([
        core_1.Component({
            selector: 'topic-card-item',
            template: '' +
                '<div class="content" >' +
                '       <div class="row">' +
                '           <div #imageThumbnail>' +
                '               <image-thumbnail style="margin: 0 auto;" [imageProperties]="imageProperties" ></image-thumbnail>' +
                '           </div>' +
                '           <div>' +
                '               <div>subject</div>' +
                '               <div class="row">' +
                '                   <div class="col-md-5">' +
                '                       <span class="gray">作品类型：</span>1<br/>' +
                '                       <span class="gray">作品类型：</span>2<br/>' +
                '                       <span class="gray">作品类型：</span>3<br/>' +
                '                   </div>' +
                '                   <div class="col-md-5">' +
                '                       <span class="gray">作品类型：</span>1<br/>' +
                '                       <span class="gray">作品类型：</span>2<br/>' +
                '                       <span class="gray">作品类型：</span>3<br/>' +
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
            directives: [image_thumbnail_component_1.ImageThumbnailComponent]
        }), 
        __metadata('design:paramtypes', [core_1.ElementRef, image_service_1.ImageService])
    ], TopicCardItemComponent);
    return TopicCardItemComponent;
})();
exports.TopicCardItemComponent = TopicCardItemComponent;
//# sourceMappingURL=card-item.component.js.map