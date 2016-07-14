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
var core_2 = require('@angular/core');
var snapshot_component_1 = require("./snapshot.component");
var topic_service_1 = require("./topic.service");
var card_item_component_1 = require("./card-item.component");
var TopicSpaceListComponent = (function () {
    function TopicSpaceListComponent(element, topicService) {
        this.element = element;
        this.topicService = topicService;
    }
    TopicSpaceListComponent.prototype.ngOnInit = function () {
        var params = {};
        this.topicList = this.topicService.listTopicByPagination(params);
        this.monthlyHotestTopicList = this.topicService.listHotestTopic('monthly');
    };
    TopicSpaceListComponent.prototype.onTopicSelected = function (topic) {
        console.log('select ' + topic);
    };
    TopicSpaceListComponent = __decorate([
        core_1.Component({
            selector: 'topic-space-list-component',
            templateUrl: 'app/echodrama/topic/space-list.template.html',
            //host: {
            //    '(document:click)': 'handleClick($event)',
            //},
            styles: [''],
            directives: [card_item_component_1.TopicCardItemComponent, snapshot_component_1.TopicSnapshotComponent],
            providers: [topic_service_1.TopicService]
        }), 
        __metadata('design:paramtypes', [core_2.ElementRef, topic_service_1.TopicService])
    ], TopicSpaceListComponent);
    return TopicSpaceListComponent;
})();
exports.TopicSpaceListComponent = TopicSpaceListComponent;
//# sourceMappingURL=space-list.component.js.map