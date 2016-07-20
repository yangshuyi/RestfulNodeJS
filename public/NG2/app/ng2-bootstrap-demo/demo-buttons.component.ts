import { Component } from '@angular/core';

import {BUTTON_DIRECTIVES} from "ng2-bootstrap/ng2-bootstrap";

@Component({
    selector: 'ng2-bootstrap-demo-buttons-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-buttons.template.html',
    styles: [''],
    directives: [BUTTON_DIRECTIVES],
    providers: []
})

export class DemoButtonsComponent {

    public singleModel:string = '1';
    public radioModel:string = 'Middle';
    public checkModel:any = {left: false, middle: true, right: false};

}


