import {Component, PipeTransform, Pipe} from '@angular/core';

import {
    BUTTON_DIRECTIVES, CAROUSEL_DIRECTIVES, DATEPICKER_DIRECTIVES,
    Ng2BootstrapTheme, Ng2BootstrapConfig
} from "ng2-bootstrap/ng2-bootstrap";
import {FORM_DIRECTIVES} from "@angular/forms";
import {CORE_DIRECTIVES} from "@angular/common";
import {NavigationEnd, Router, ROUTER_DIRECTIVES} from "@angular/router";
// import moment = require("moment/moment");

@Component({
    selector: 'ng2-bootstrap-demo-mainmenu-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-mainmenu.template.html',
    directives: [ROUTER_DIRECTIVES],
    pipes: [SearchFilterPipe]
})

export class DemoMainMenuComponent {
    public isBs3:boolean = Ng2BootstrapConfig.theme === Ng2BootstrapTheme.BS3;
    public routes:any;
    public search:any = {};
    public hash:string = '';

    public constructor(private router:Router) {
        this.routes = this.routes.filter((v:any) => v.path !== '**');
        this.router.events.subscribe((event:any) => {
            if (event instanceof NavigationEnd) {
                this.hash = event.url;
            }
        });
    }
}

@Pipe({name: 'SearchFilter'})
export class SearchFilterPipe implements PipeTransform {
    public transform(value:any, text:any):any {
        if (!text) {
            return value;
        }

        const items:any = value;
        const newItems:any = [];

        items.forEach(function (item:any):void {
            if (item.data[0].toLowerCase().indexOf(text.toLowerCase()) !== -1) {
                newItems.push(item);
            }
        });

        return newItems;
    }
}