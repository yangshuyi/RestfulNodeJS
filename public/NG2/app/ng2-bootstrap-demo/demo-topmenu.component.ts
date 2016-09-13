import {Component, PipeTransform, Pipe, Inject, Renderer, AfterViewInit} from '@angular/core';

import {
    BUTTON_DIRECTIVES, CAROUSEL_DIRECTIVES, DATEPICKER_DIRECTIVES,
    Ng2BootstrapTheme, Ng2BootstrapConfig
} from "ng2-bootstrap/ng2-bootstrap";
import {FORM_DIRECTIVES} from "@angular/forms";
import {CORE_DIRECTIVES} from "@angular/common";
import {NavigationEnd, Router, ROUTER_DIRECTIVES} from "@angular/router";
import {DOCUMENT} from "@angular/platform-browser";
// import moment = require("moment/moment");

@Component({
    selector: 'ng2-bootstrap-demo-topmenu-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-topmenu.template.html',
    directives: [ROUTER_DIRECTIVES]
})
export class DemoTopMenuComponent implements AfterViewInit {
    public isShown:boolean = false;

    private renderer:Renderer;
    private document:any;

    public constructor(renderer:Renderer, @Inject(DOCUMENT) document:any, private router:Router) {
        this.renderer = renderer;
        this.document = document;
    }

    public ngAfterViewInit():any {
        this.router.events.subscribe((event:any) => {
            if (event instanceof NavigationEnd) {
                this.toggle(false);
            }
        });
    }

    public toggle(isShown?:boolean):void {
        this.isShown = typeof isShown === 'undefined' ? !this.isShown : isShown;
        if (this.document && this.document.body) {
            this.renderer.setElementClass(this.document.body, 'isOpenMenu', this.isShown);
            if (this.isShown === false) {
                this.renderer.setElementProperty(this.document.body, 'scrollTop', 0);
            }
        }
    }
}