
import {Component, OnChanges, OnInit, Input, Output, SimpleChange, EventEmitter} from "@angular/core";
@Component({
    selector: 'image-thumbnail', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<ul class="pagination">'+
    '   <li><a href="#">&laquo;</a></li>'+
    '   <li><a href="#">1</a></li>'+
    '   <li><a href="#">2</a></li>'+
    '   <li><a href="#">3</a></li>'+
    '   <li><a href="#">4</a></li>'+
    '   <li><a href="#">5</a></li>'+
    '   <li><a href="#">&raquo;</a></li>'+
    '   </ul>' +
    '',
    styles: [
        '.content { margin: 0 auto; position: relative; border: 1px solid darkgray; background: white;}' +
        '.content > img{ position: absolute; }' +
        ''
    ]
})

export class PaginationComponent implements OnChanges, OnInit {
    @Input()
    private pageNum:number;

    @Input()
    private currentPageIdx:number;

    @Output()
    private onPageChanged:EventEmitter<any> = new EventEmitter();

    constructor() {
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {

    }

    ngOnInit() {
    }

    gotoPage(){
        this.onPageChanged.emit(this.currentPageIdx);
    }
}
