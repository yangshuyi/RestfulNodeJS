import {Component} from '@angular/core';

import {BUTTON_DIRECTIVES, CAROUSEL_DIRECTIVES} from "ng2-bootstrap/ng2-bootstrap";
import {FORM_DIRECTIVES} from "@angular/forms";
import {CORE_DIRECTIVES} from "@angular/common";

@Component({
    selector: 'ng2-bootstrap-demo-carousel-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-carousel.template.html',
    styles: [''],
    directives: [CAROUSEL_DIRECTIVES, CORE_DIRECTIVES, FORM_DIRECTIVES]
})
export class DemoCarouselComponent {
    public myInterval:number = 5000;
    public noWrapSlides:boolean = false;
    public slides:Array<any> = [];

    public constructor() {
        for (let i = 0; i < 4; i++) {
            this.addSlide();
        }
    }

    public addSlide():void {
        let newWidth = 600 + this.slides.length + 1;
        this.slides.push(
            {
                image: 'images/advisement/portal_index_adv_20110406.jpg',
                text: 'text'
            },
            {
                image: 'images/advisement/portal_index_adv_20110412.jpg',
                text: 'text'
            }
        );
    }

    public removeSlide(index:number):void {
        this.slides.splice(index, 1);
    }
}
