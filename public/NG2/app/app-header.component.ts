//One or more import statements to reference the things we need.
import {Component, Input} from '@angular/core';
import {AppInfo} from "./app-info.model";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-header', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<header class="indexHead">'+
    '   <div class="headerWrap">'+
    '       <div class="logo_search">'+
    '           <h1 id="logo-flash" style="" class="logo">'+
    // '               <a href="http://www.smzdm.com/">'+
    // '                   <img alt="什么值得买" src="/resources/public/img/logo.png" style="width:172px;">'+
    // '               </a>'+
    '               {{appInfo.title}}'+
    '           </h1>'+
    '           <div style="width:168px;" class="cake"></div>'+
    '           <input type="hidden" name="c" value="home" readonly="readonly">'+
    '           <button type="submit" class="btn_search icon-search"></button>'+
    '       </div>'+
    '   </div>'+
    '   <div class="navBarWrap no_fixed">'+
    '       <div class="navBar">'+
    '           <nav>'+
    '               <a *ngFor="let menu of appInfo.menus" [routerLink]="[\'RedisManager\']" title="{{menu.name}}">{{menu.name}}</a>'+
    '           </nav>'+
    '       </div>'+
    '   </div>' +
    '</header>' +
    '',
    styles: ['']
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppHeaderComponent{
    @Input()
    appInfo:AppInfo;
}


