import {Component, ViewChild} from '@angular/core';

import {
    BUTTON_DIRECTIVES, CAROUSEL_DIRECTIVES, ModalDirective, BS_VIEW_PROVIDERS,
    MODAL_DIRECTIVES
} from "ng2-bootstrap/ng2-bootstrap";
import {FORM_DIRECTIVES} from "@angular/forms";
import {CORE_DIRECTIVES} from "@angular/common";

@Component({
    selector: 'ng2-bootstrap-demo-modal-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-modal.template.html',
    directives: [MODAL_DIRECTIVES, CORE_DIRECTIVES],
    viewProviders:[BS_VIEW_PROVIDERS]
})
export class DemoModalComponent {
    @ViewChild('childModal')
    public childModal: ModalDirective;

    public showChildModal():void {
        this.childModal.show();
    }

    public hideChildModal():void {
        this.childModal.hide();
    }
}