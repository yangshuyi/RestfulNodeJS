import {Injectable} from '@angular/core'
import {Topic, Category, Type} from "./topic.model";

import * as _ from 'lodash';

@Injectable()
export class TopicService {

    loadTopicById(topicId:number):Topic {
        let topic:Topic = new Topic();
        topic.id = topicId;
        topic.number = 1000060;
        topic.typeId = 'single';
        topic.type = Type.getTypeById(topic.typeId);
        topic.singletonAlbum = true;

        topic.posterUrl = 'images/a.jpg';
        topic.subject = '《捡个娃娃来爱》第四集 大结局';
        topic.label = '耽美/近代/现代/爱情/轻松';
        topic.labelItemArray = _.split(topic.label, '/');
        topic.message = '';
        topic.categoryId = 4;
        topic.category = Category.getCategoryById(topic.categoryId);

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
    }

    listTopicByPagination(params):Topic[]{
        let topicList:Topic[] = [];
        for(let i:number=0;i<10;i++){
            topicList.push(this.loadTopicById(i));
        }
        return topicList;
    }

    listHotestTopic(type:string):Topic[]{
        let hotestTopicList:Topic[] = [];
        for(let i:number=0;i<10;i++){
            hotestTopicList.push(this.loadTopicById(i));
        }
        return hotestTopicList;
    }
    

}