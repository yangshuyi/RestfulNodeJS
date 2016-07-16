import {Component} from '@angular/core';
import {OnInit, ElementRef} from '@angular/core';
import {TopicSnapshotComponent} from "./snapshot.component";
import {TopicService} from "./topic.service";
import {Topic} from "./topic.model";
import {TopicCardItemComponent} from "./card-item.component";

import { AlertComponent } from 'ng2-bootstrap/ng2-bootstrap';

@Component({
    selector: 'topic-space-list-component',
    templateUrl: 'app/echodrama/topic/space-list.template.html',
    //host: {
    //    '(document:click)': 'handleClick($event)',
    //},
    styles: [''],
    directives: [TopicCardItemComponent, TopicSnapshotComponent],
    providers: [TopicService]
})


export class TopicSpaceListComponent implements OnInit {
    private monthlyHotestTopicList: Topic[];
    private topicList: Topic[];
    private showSearchPanelFlag:boolean = false;

    constructor(private element: ElementRef, private topicService:TopicService) {
    
    }

    ngOnInit() {
        var params = {}
        this.topicList = this.topicService.listTopicByPagination(params);
        this.monthlyHotestTopicList = this.topicService.listHotestTopic('monthly');
    }

    onTopicSelected(topic:Topic){
        console.log('select '+topic);
    }

    setSearchPanelVisible(visible:boolean){
        this.showSearchPanelFlag = visible;
    }
}


