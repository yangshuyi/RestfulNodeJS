//One or more import statements to reference the things we need.
import {Component, Input} from '@angular/core';
import { Router }       from '@angular/router';
import {AppInfo} from "./app-info.model";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-header', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '<header>' +
    '<div class="top-bar">'+
    '   <div class="container">'+
    '       <div class="row">'+
    '           <div class="col-sm-12 col-xs-12">'+
    '               <div class="search">'+
    '                   <input type="text" autocomplete="off" placeholder="Search">'+
    '                   <span class="glyphicon glyphicon-search"></span>'+
    '               </div>'+
    '           </div>'+
    '       </div>'+
    '   </div>'+
    '</div>'+
    '<nav class="navbar navbar-inverse" role="banner">'+
    '    <div class="container">'+
    '       <div class="col-sm-3 col-xs-3 logo">'+
    '           <img src="images/logo.png" alt="logo">'+
    '       </div>'+
    '       <div class="col-sm-9 col-xs-9 navbar-right">'+
    '           <ul class="nav navbar-nav">'+
    '               <li *ngFor="let menu of appInfo.menus">'+
    '                   <a (click)="navigateToModule()" title="{{menu.name}}">{{menu.name}}</a>'+
    '               </li>'+
    '           </ul>'+
    '       </div>'+
    '   </div>'+
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


