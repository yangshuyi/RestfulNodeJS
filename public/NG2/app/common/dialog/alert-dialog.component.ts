import {Component, Input, OnInit, OnChanges, SimpleChange, Output, EventEmitter} from '@angular/core';
import {AlertComponent} from "ng2-bootstrap/ng2-bootstrap";


@Component({
    selector: 'alert-dialog-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/common/dialog/alert-dialog.template.html',
    styles: [],

    directives: [AlertComponent]
})

export class AlertDialogComponent implements OnChanges, OnInit {
    @Input()
    private title:String;

    @Input()
    private message:String;

    @Input()
    private dismissible:boolean = true;

    @Output()
    private onAlertDialogClose:EventEmitter<any> = new EventEmitter();

    constructor() {
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {

    }

    ngOnInit() {
    }


    closeAlertDialog() {
        this.onAlertDialogClose.emit({});
    }

}
