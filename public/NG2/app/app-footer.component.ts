//One or more import statements to reference the things we need.
import {Component, Input} from '@angular/core';
import { Router }       from '@angular/router';
import {AppInfo} from "./app-info.model";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-footer', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="container">' +
    '    <div class="row">' +
    '       <div class="col-sm-12 center">&copy; 2016 <a target="_blank" href="{{url}}" title="{{appInfo.siteHyperlink}}">{{appInfo.siteHyperlink}}</a>. All Rights Reserved.Version {{appInfo.version}}</div>' +
    '   </div>' +
    '</div>' +
    '',
    styles: ['']
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppFooterComponent {
    @Input()
    private appInfo:AppInfo;

    constructor() {
    }
}


