//One or more import statements to reference the things we need.
import {Component} from '@angular/core';
import { OnInit } from '@angular/core';
import {AppInfo} from "./app-info.model";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-footer', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="container">' +
    '    <div class="row">' +
    '       <div class="col-sm-12 center">&copy; 2013 <a target="_blank" href="{{url}}" title="{{footName}}">{{footName}}</a>. All Rights Reserved.</div>' +
    '   </div>' +
    '</div>' +
    '',
    styles: ['']
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppFooterComponent implements OnInit {
    @Input()
    private appInfo:AppInfo;

    constructor() {
    }
}
