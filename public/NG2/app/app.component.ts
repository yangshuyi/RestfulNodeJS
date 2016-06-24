//One or more import statements to reference the things we need.
import {Component} from '@angular/core';
import * as _ from 'lodash';
import {RedisObject} from "./redis-object";
import {RedisObjectComponent} from "./redis-object-component";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'my-app', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template:  '' +
        '<h1>{{title}}</h1>' +
        '<label for="keyword">Search Keyword: </label><input id="keyword" [(ngModel)]="keyword" (change)="searchByKeyword()" placeholder="keyword">' +
        '<hr/>' +
        '<div *ngIf="keyword && redisObjects">Find [{{redisObjects.length}}] record(s) for Redis Object by keyword [{{keyword}}]'+
        '<div *ngIf="redisObjects" *ngFor="let redisObject of redisObjects">'+
        '   <redis-object [redisObject]="redisObject"></redis-object>'+
        '</div>'+
        '',
    styles: [''],
    directives: [RedisObjectComponent]

})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppComponent {
    //When we're ready to build a substantive application, we can expand this class with properties and application logic.
    title = 'Reids Manager';
    keyword = '';
    redisObjects= data;

    searchByKeyword() {
        let key = '';
        if(this.keyword instanceof HTMLInputElement){
            key = keyword.value;
        }else{
            key = this.keyword;
        }
        if(!key){
            this.redisObjects =  data;
        }else{
            var result:RedisObject[]=_.filter(data, function(item){
                return item.key.indexOf(key)>=0;
            });
            this.redisObjects = result;
        }
    }
}


var data:RedisObject[] = [];

data.push(new RedisObject('a','value1'));
data.push(new RedisObject('aa','value2'));
data.push(new RedisObject('aaa','value3'));
data.push(new RedisObject('b','value4'));
data.push(new RedisObject('bb','value5'));
data.push(new RedisObject('bbb','value6'));