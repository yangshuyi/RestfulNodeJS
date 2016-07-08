//One or more import statements to reference the things we need.
import {Component, Input} from '@angular/core';
import { Router }       from '@angular/router';
import {AppInfo} from "./app-info.model";

let template = require('./app-header.html');

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-header', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app-header.html',
    atemplate: '<header>' +
    '<div class="top-bar">'+
    '   <div class="container">'+
    '       <div class="row">'+
    '           <div class="col-sm-12 col-xs-12">'+
    '               <div class="search">'+
    '                   <input type="text" autocomplete="off" placeholder="Search">'+
    '                   <i class="fa fa-search fa-lg"></i>'+
    '               </div>'+
    '           </div>'+
    '       </div>'+
    '   </div>'+
    '</div>'+
    '<nav class="navbar navbar-static-top navbar-dark bg-inverse">'+
    '           <img src="images/logo.png" alt="logo">'+
    '           <ul class="nav navbar-nav">'+
    '               <li *ngFor="let menu of appInfo.menus" class="nav-item active">'+
    '                   <a class="nav-link" (click)="navigateToModule()" title="{{menu.name}}">{{menu.name}}</a>'+
    '               </li>'+
    '           </ul>'+
    '</nav>'+
    '</header>',
    styles: ['']
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppHeaderComponent{
    @Input()
    private appInfo:AppInfo;

    constructor(
        private router: Router
    ) {
    }

    navigateToModule(menu:Object){
        this.router.navigate([menu.routerLink, {}]);
    }
}


