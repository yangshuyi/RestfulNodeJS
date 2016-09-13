import {Component} from '@angular/core';

import {BUTTON_DIRECTIVES, CAROUSEL_DIRECTIVES, DATEPICKER_DIRECTIVES} from "ng2-bootstrap/ng2-bootstrap";
import {FORM_DIRECTIVES} from "@angular/forms";
import {CORE_DIRECTIVES} from "@angular/common";
// import moment = require("moment/moment");

@Component({
    selector: 'ng2-bootstrap-demo-datepicker-component', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/ng2-bootstrap-demo/demo-datepicker.template.html',
    directives: [DATEPICKER_DIRECTIVES, CORE_DIRECTIVES, FORM_DIRECTIVES]
})
export class DemoDatepickerComponent {
    public dt:Date = new Date();
    public minDate:Date = void 0;
    public events:Array<any>;
    public tomorrow:Date;
    public afterTomorrow:Date;
    public formats:Array<string> = ['DD-MM-YYYY', 'YYYY/MM/DD', 'DD.MM.YYYY', 'shortDate'];
    public format:string = this.formats[0];
    public dateOptions:any = {
        formatYear: 'YY',
        startingDay: 1
    };
    private opened:boolean = false;

    public constructor() {
        (this.tomorrow = new Date()).setDate(this.tomorrow.getDate() + 1);
        (this.afterTomorrow = new Date()).setDate(this.tomorrow.getDate() + 2);
        (this.minDate = new Date()).setDate(this.minDate.getDate() - 1000);
        this.events = [
            {date: this.tomorrow, status: 'full'},
            {date: this.afterTomorrow, status: 'partially'}
        ];
    }
    public getDate():number {
        return this.dt && this.dt.getTime() || new Date().getTime();
    }
    public today():void {
        this.dt = new Date();
    }

    public d20090824():void {
        this.dt = new Date();
    }

    // todo: implement custom class cases
    public getDayClass(date:any, mode:string):string {
        if (mode === 'day') {
            let dayToCheck = new Date(date).setHours(0, 0, 0, 0);

            for (let i = 0; i < this.events.length; i++) {
                let currentDay = new Date(this.events[i].date).setHours(0, 0, 0, 0);

                if (dayToCheck === currentDay) {
                    return this.events[i].status;
                }
            }
        }

        return '';
    }

    public disabled(date:Date, mode:string):boolean {
        return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
    }

    public open():void {
        this.opened = !this.opened;
    }

    public clear():void {
        this.dt = void 0;
    }

    public toggleMin():void {
        this.dt = new Date(this.minDate.valueOf());
    }
}