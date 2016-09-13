import {Component} from '@angular/core';

import {BUTTON_DIRECTIVES, CAROUSEL_DIRECTIVES, DROPDOWN_DIRECTIVES} from "ng2-bootstrap/ng2-bootstrap";
import {FORM_DIRECTIVES} from "@angular/forms";
import {CORE_DIRECTIVES} from "@angular/common";

@Component({
    selector: 'ng2-bootstrap-demo-dropdown-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-dropdown.template.html',
    styles: [''],
    directives: [DROPDOWN_DIRECTIVES, CORE_DIRECTIVES]
})
export class DemoDropdownComponent {
    public disabled:boolean = false;
    public status:{isopen:boolean} = {isopen: false};
    public items:Array<string> = ['The first choice!',
        'And another choice for you.', 'but wait! A third!'];

    public toggled(open:boolean):void {
        console.log('Dropdown is now: ', open);
    }

    public toggleDropdown($event:MouseEvent):void {
        $event.preventDefault();
        $event.stopPropagation();
        this.status.isopen = !this.status.isopen;
    }
}