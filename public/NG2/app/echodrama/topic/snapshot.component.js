"use strict";
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
//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
var TopicSnapshotComponent = (function () {
    function TopicSnapshotComponent(imageService) {
        this.imageService = imageService;
        this.onTopicSelected = new core_1.EventEmitter();
        console.log('TopicSnapshotComponent constructor' + this.topic);
    }
    TopicSnapshotComponent.prototype.ngOnChanges = function (changes) {
        console.log('TopicSnapshotComponent ngOnChanges' + this.topic);
        this.imageProperties = this.imageService.createImageProperties(null, null, 120, 160);
        this.imageProperties.stretchMode = image_properties_model_1.StretchMode.WHOLE;
        this.imageProperties.srcUrl = this.topic.posterUrl;
        this.imageProperties.errorUrl = 'images/topic-thumbnail.jpg';
    };
    TopicSnapshotComponent.prototype.selectTopic = function () {
        if (this.topic) {
            console.log('selectTopic');
            this.onTopicSelected.emit(this.topic);
        }
    };
    __decorate([
        core_1.Input(), 
        __metadata('design:type', topic_model_1.Topic)
    ], TopicSnapshotComponent.prototype, "topic", void 0);
    __decorate([
        core_1.Output(), 
        __metadata('design:type', core_1.EventEmitter)
    ], TopicSnapshotComponent.prototype, "onTopicSelected", void 0);
    TopicSnapshotComponent = __decorate([
        core_1.Component({
            selector: 'topic-snapshot',
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
            directives: [image_thumbnail_component_1.ImageThumbnailComponent]
        }), 
        __metadata('design:paramtypes', [image_service_1.ImageService])
    ], TopicSnapshotComponent);
    return TopicSnapshotComponent;
}());
exports.TopicSnapshotComponent = TopicSnapshotComponent;
//# sourceMappingURL=snapshot.component.js.map