//One or more import statements to reference the things we need.
import {Component} from '@angular/core';
import { OnInit } from '@angular/core';
import {AppInfo} from "./app-info.model";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-header', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<h1>{{title}}</h1>' +
    '',
    styles: ['']
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppHeaderComponent implements OnInit {
    appInfo:AppInfo[];

    constructor() {
    }

    ngOnInit() {

    }

}


