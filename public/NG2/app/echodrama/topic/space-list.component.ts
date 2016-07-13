import {Component} from '@angular/core';
import {OnInit, ElementRef} from '@angular/core';
import {TopicSnapshotComponent} from "./snapshot.component";
import {TopicService} from "./topic.service";
import {Topic} from "./topic.model";

@Component({
    selector: 'topic-space-list-component',
    templateUrl: 'app/echodrama/topic/space-list.template.html',
    //host: {
    //    '(document:click)': 'handleClick($event)',
    //},
    styles: [''],
    directives: [TopicSnapshotComponent],
    providers: [TopicService]
})


export class TopicSpaceListComponent implements OnInit {
    monthlyHotestTopicList: Topic[];

    constructor(private element: ElementRef, private topicService:TopicService) {
    
    }

    ngOnInit() {
        this.monthlyHotestTopicList = this.topicService.listHotestTopic('monthly');
    }

    onTopicSelected(topic:Topic){
        console.log('select '+topic);
    }
}


