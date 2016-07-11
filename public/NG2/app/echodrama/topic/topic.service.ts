import {Injectable} from '@angular/core'
import {Topic} from "./topic.model";

@Injectable()
export class TopicService {

    loadTopicById(topicId:number):Topic {
        let topic:Topic = new Topic();
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
    }
}