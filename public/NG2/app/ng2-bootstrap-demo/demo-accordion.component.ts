import {Component} from '@angular/core';

import {BUTTON_DIRECTIVES, CAROUSEL_DIRECTIVES, ACCORDION_DIRECTIVES} from "ng2-bootstrap/ng2-bootstrap";
import {FORM_DIRECTIVES} from "@angular/forms";
import {CORE_DIRECTIVES} from "@angular/common";

@Component({
    selector: 'ng2-bootstrap-demo-accordion-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-accordion.template.html',
    directives: [ACCORDION_DIRECTIVES, CORE_DIRECTIVES, FORM_DIRECTIVES]
})
export class DemoAccordionComponent {
    public oneAtATime:boolean = true;
    public items:Array<string> = ['Item 1', 'Item 2', 'Item 3'];

    public status:Object = {
        isFirstOpen: true,
        isFirstDisabled: false
    };

    public groups:Array<any> = [
        {
            title: 'Dynamic Group Header - 1',
            content: 'Dynamic Group Body - 1'
        },
        {
            title: 'Dynamic Group Header - 2',
            content: 'Dynamic Group Body - 2'
        }
    ];

    public addItem():void {
        this.items.push(`Items ${this.items.length + 1}`);
    }
}