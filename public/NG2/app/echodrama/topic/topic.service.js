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
var topic_model_1 = require("./topic.model");
var TopicService = (function () {
    function TopicService() {
    }
    TopicService.prototype.loadTopicById = function (topicId) {
        var topic = new topic_model_1.Topic();
        topic.id = '1';
        topic.posterUrl = 'images/a.jpg';
        topic.subject = 'subject';
        topic.number = 'number';
        topic.cast = 'cast';
        topic.subject = 'xxxxx';
        topic.label = 'xxxxx';
        topic.productClassName = '';
        topic.club = 'club';
        topic.yuanzhu = 'yuanzhu';
        topic.director = 'director';
        topic.writer = 'writer';
        topic.effector = 'effector';
        return topic;
    };
    TopicService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [])
    ], TopicService);
    return TopicService;
})();
exports.TopicService = TopicService;
//# sourceMappingURL=topic.service.js.map