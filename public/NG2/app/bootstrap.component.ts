//One or more import statements to reference the things we need.
import { Router, ActivatedRoute }       from '@angular/router';
import {Component} from '@angular/core';
import {OnInit} from '@angular/core';

import {TopicService} from "./echodrama/topic/topic.service";
import {TopicSpaceListComponent} from "./echodrama/topic/space-list.component";
import {AlertComponent} from "ng2-bootstrap/ng2-bootstrap";

@Component({
    selector: 'bootstrap-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/bootstrap.template.html',
    styles: [''],
    directives: [TopicSpaceListComponent, AlertComponent],
    providers: [TopicService]
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class BootstrapComponent implements OnInit {
    //When we're ready to build a substantive application, we can expand this class with properties and application logic.
    title:string = 'NATIVE ANGULAR 2 DIRECTIVES FOR BOOTSTRAP';

    constructor() {
        console.log('BootstrapComponent constructor');
    }

    ngOnInit() {
        
    }




    public alerts:Array<Object> = [
        {
            type: 'danger',
            msg: 'Oh snap! Change a few things up and try submitting again.'
        },
        {
            type: 'success',
            msg: 'Well done! You successfully read this important alert message.',
            closable: true
        }
    ];

    public closeAlert(i:number):void {
        this.alerts.splice(i, 1);
    }

    public addAlert():void {
        this.alerts.push({msg: 'Another alert!', type: 'warning', closable: true});
    }


}


