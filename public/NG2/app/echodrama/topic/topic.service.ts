import {Injectable} from '@angular/core'
import {Topic} from "./topic.model";

@Injectable()
export class TopicService {

    loadTopicById(topicId:number):Topic {
        let topic:Topic = new Topic();
        topic.id = topicId;
        topic.posterUrl = 'images/a.jpg';
        topic.subject = 'subject';
        topic.number = topicId;
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
    }

    listHotestTopic(type:string):Topic[]{
        let hotestTopic:Topic[] = [];
        for(let i:number=0;i<10;i++){
            hotestTopic.push(this.loadTopicById(i));
        }
        return hotestTopic;
    }
}