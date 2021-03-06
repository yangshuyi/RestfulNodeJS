//One or more import statements to reference the things we need.
import {NgModule, Component} from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import {OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES } from '@angular/router';

import {RedisManagerComponent} from "./redis-manager.component";
import {AppInfo} from "./app-info.model";
import {AppHeaderComponent} from "./app-header.component";
import {LogService} from "./common/log.service";
import {ImageService} from "./common/image-viewer/image.service";

//This is the entry point to your application.

@NgModule({
    imports: [BrowserModule]
})

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'my-app', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<app-header [appInfo]="appInfo"></app-header>' +
    '<div class="container"><router-outlet></router-outlet></div>' +
    '<app-footer [appInfo]="appInfo"></app-footer>',
    styles: [''],
    providers: [{provide: LogService, useClass: LogService}, ImageService],
    directives: [AppHeaderComponent, RedisManagerComponent, ROUTER_DIRECTIVES]
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppComponent implements OnInit {
    appInfo:AppInfo = new AppInfo();

    constructor() {
    }

    ngOnInit() {

    }

}


