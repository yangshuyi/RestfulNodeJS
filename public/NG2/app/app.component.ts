//One or more import statements to reference the things we need.
import {Component} from '@angular/core';
import { OnInit } from '@angular/core';
import { RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS } from '@angular/router-deprecated';

import * as _ from 'lodash';
import {RedisManagerComponent} from "./redis-manager.component";

@RouteConfig([
    {
        path: '/redisManager',
        name: 'RedisManager',
        component: RedisManagerComponent
    }
])

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'my-app', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<router-outlet></router-outlet>' +
    '',
    styles: [''],
    directives: [ROUTER_DIRECTIVES, RedisManagerComponent],
    providers: [
        ROUTER_PROVIDERS
    ]
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppComponent implements OnInit {

    constructor() {
        console.log('AppComponent constructor');
    }

    ngOnInit() {
      console.log('AppComponent ngOnInit');
    }

}


