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
var image_service_1 = require("./common/image-viewer/image.service");
var topic_service_1 = require("./echodrama/topic/topic.service");
var space_list_component_1 = require("./echodrama/topic/space-list.component");
var BootstrapComponent = (function () {
    function BootstrapComponent(imageService, topicService) {
        this.imageService = imageService;
        this.topicService = topicService;
        //When we're ready to build a substantive application, we can expand this class with properties and application logic.
        this.title = 'NATIVE ANGULAR 2 DIRECTIVES FOR BOOTSTRAP';
        console.log('BootstrapComponent constructor');
        this.topic = topicService.loadTopicById(1);
    }
    BootstrapComponent.prototype.ngOnInit = function () {
    };
    BootstrapComponent = __decorate([
        core_1.Component({
            selector: 'bootstrap-component',
            template: '' +
                '<div>please visit <a href="http://valor-software.com/ng2-bootstrap/index-bs4.html" target="_blank">http://valor-software.com/ng2-bootstrap/</a></div>' +
                '<div>About fontawesome</div>' +
                '<div>please visit <a href="http://fontawesome.io/icons/">http://fontawesome.io/icons/</a></div>' +
                '<br/>' +
                '<topic-space-list-component></topic-space-list-component>' +
                '<br/>' +
                '' +
                '',
            styles: [''],
            directives: [space_list_component_1.TopicSpaceListComponent],
            providers: [topic_service_1.TopicService]
        }), 
        __metadata('design:paramtypes', [image_service_1.ImageService, topic_service_1.TopicService])
    ], BootstrapComponent);
    return BootstrapComponent;
}());
exports.BootstrapComponent = BootstrapComponent;
//# sourceMappingURL=bootstrap.component.js.map