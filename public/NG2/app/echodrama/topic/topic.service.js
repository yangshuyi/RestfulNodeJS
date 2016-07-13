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
var topic_model_1 = require("./topic.model");
var TopicService = (function () {
    function TopicService() {
    }
    TopicService.prototype.loadTopicById = function (topicId) {
        var topic = new topic_model_1.Topic();
        topic.id = topicId;
        topic.number = 1000060;
        topic.typeId = 'single';
        topic.type = topic_model_1.Type.getTypeById(topic.typeId);
        topic.singletonAlbum = false;
        topic.posterUrl = 'images/a.jpg';
        topic.subject = '《捡个娃娃来爱》第四集 大结局';
        topic.label = '耽美/近代/现代/爱情/轻松';
        topic.message = '';
        topic.categoryId = 2;
        topic.category = topic_model_1.Category.getCategoryById(topic.categoryId);
        topic.club = '优声由色';
        topic.cast = '东京以东/钻石星尘/包子/小优/yita';
        topic.yuanzhu = 'yuanzhu';
        topic.director = '龙海包公子';
        topic.producer = '';
        topic.writer = '龙海包公子';
        topic.effector = '抹茶雪糕';
        topic.photographer = '祭CC';
        topic.produceDate = 1127404800;
        topic.viewNum = 101;
        topic.downloadNum = 202;
        topic.joinNum = 303;
        topic.replyNum = 505;
        topic.poll_1 = 10;
        topic.poll_2 = 10;
        topic.poll_3 = 10;
        topic.poll_4 = 10;
        topic.poll_5 = 10;
        topic.dateline = 1276180424;
        topic.uId = 6;
        topic.userName = '默默';
        return topic;
    };
    TopicService.prototype.listTopicByPagination = function (params) {
        var topicList = [];
        for (var i = 0; i < 10; i++) {
            topicList.push(this.loadTopicById(i));
        }
        return topicList;
    };
    TopicService.prototype.listHotestTopic = function (type) {
        var hotestTopicList = [];
        for (var i = 0; i < 10; i++) {
            hotestTopicList.push(this.loadTopicById(i));
        }
        return hotestTopicList;
    };
    TopicService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [])
    ], TopicService);
    return TopicService;
}());
exports.TopicService = TopicService;
//# sourceMappingURL=topic.service.js.map