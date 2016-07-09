//One or more import statements to reference the things we need.
import { Router, ActivatedRoute }       from '@angular/router';
import {Component, OnInit, OnDestroy} from '@angular/core';
import {RedisObject} from "./redis-object";

import * as _ from 'lodash';
import {RedisObjectComponent} from "./redis-object.component";
import {RedisManagerService} from "./redis-manager.service";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'redis-manager', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div [class.default]="true" >' +
    '   <h1>{{title}}</h1>' +
    '   <label for="keyword">Search Keyword: </label><input id="keyword" [(ngModel)]="keyword" (change)="searchByKeyword()" placeholder="keyword">' +
    '   <hr/>' +
    '   <div *ngIf="keyword && filterRedisObjects">Find [{{filterRedisObjects.length}}] record(s) for Redis Object by keyword [{{keyword}}]</div>' +
    '   <div *ngFor="let redisObject of filterRedisObjects">' +
    '       <redis-object [redisObject]="redisObject"></redis-object>' +
    '   </div>' +
    '</div>' +
    '',
    styles: [
        '.default { background-color: green;}'
    ],
    directives: [RedisObjectComponent],
    providers: [RedisManagerService]
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class RedisManagerComponent implements OnInit, OnDestroy {
    //When we're ready to build a substantive application, we can expand this class with properties and application logic.
    title:string = 'Reids Manager';
    keyword:string = '';
    redisObjects:RedisObject[];
    filterRedisObjects:RedisObject[];

    private routeSubsriber:any;

    constructor(private route:ActivatedRoute,
                private router:Router,
                private redisManagerService:RedisManagerService) {
        console.log('RedisManagerComponent constructor');
    }

    ngOnInit() {
        console.log('RedisManagerComponent ngOnInit');
        this.routeSubsriber = this.route.params.subscribe(params => {
            console.log('RedisManagerComponent ngOnInit params:'+params);
        });

        this.redisManagerService.listAll().then(redisObjects =>
            this.redisObjects = redisObjects);
    }

    ngOnDestroy() {
        if (this.routeSubsriber) {
            this.routeSubsriber.unsubscribe();
        }
    }

    searchByKeyword() {
        let key:string = this.keyword;
        if (!key) {
            this.filterRedisObjects = this.redisObjects;
        } else {
            var result:RedisObject[] = _.filter(this.redisObjects, function (item) {
                return item.key.indexOf(key) >= 0;
            });
            this.filterRedisObjects = result;
        }
    }
}


