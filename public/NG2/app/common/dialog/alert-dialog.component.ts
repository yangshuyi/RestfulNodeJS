import {
    Component, Input, OnInit, OnChanges, SimpleChange, Output, EventEmitter, ViewChild, ElementRef,
    AfterViewInit, AfterContentInit, AfterViewChecked
} from '@angular/core';
import {AlertComponent} from "ng2-bootstrap/ng2-bootstrap";

import '$';

@Component({
    selector: 'alert-dialog-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/common/dialog/alert-dialog.template.html',
    styles: [],

    directives: [AlertComponent]
})

export class AlertDialogComponent implements OnChanges, OnInit, AfterContentInit, AfterViewInit, AfterViewChecked{
    @Input()
    private title:String;

    @Input()
    private message:String;

    @Input()
    private dismissible:boolean = true;

    @ViewChild('alertComponentContainer')
    private alertComponentContainer:ElementRef;


    @ViewChild(AlertComponent)
    private alertComponent:AlertComponent;

    @Output()
    private onAlertDialogClose:EventEmitter<any> = new EventEmitter();

    private containerTop: number = 0;
    private containerLeft: number = 0;
    constructor() {
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log("ngOnChanges");
    }

    ngOnInit() {
        console.log("ngOnInit");
     }

    ngAfterContentInit() {
        console.log("ngOnInit");

    }

    ngAfterViewInit(){
        console.log("ngAfterViewInit");
        let containerWidth = this.alertComponentContainer.nativeElement.offsetWidth;
        let containerHeight = this.alertComponentContainer.nativeElement.offsetHeight;
        this.containerLeft = ($(window).width() - containerWidth) /2;
        this.containerTop= ($(window).height() - containerHeight) /2;


    }

    ngAfterViewChecked(){
        console.log("ngAfterViewChecked");
    }



    closeAlertDialog() {
        this.onAlertDialogClose.emit({});
    }

}
