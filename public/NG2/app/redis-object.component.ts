
import {Component, Input} from '@angular/core';
import * as _ from 'lodash';
import {RedisObject} from "./redis-object";

@Component({
    selector: 'redis-object',
    template:  '' +
        '<div *ngIf="redisObject" [class.selected]="redisObject.selected" style="display: flex; width:100%;" (click)="onRedisObjectSelect()">' +
        '   <div style="width:300px;">{{redisObject.key}}</div>' +
        '   <div style="flex:1;">{{redisObject.value}}</div>' +
        '</div>',
    styles: [
        '.selected { background-color: green;}'
    ]
})

export class RedisObjectComponent {
    @Input()
    redisObject: RedisObject;

    onRedisObjectSelect (){
        this.redisObject.selected = !this.redisObject.selected;
    }
}
