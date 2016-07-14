
import {EventEmitter} from "events";
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

export class ImageThumbnailComponent implements OnChanges, OnInit {
    @Input()
    private pageNum:number;

    @Input()
    private currentPageIdx:number;

    @Output()
    private onPageChanged:EventEmitter = new EventEmitter();

    private url:string;
    private isImageLoadedFlag:boolean = false;

    constructor() {
    }

    ngOnChanges(changes:{[propKey:string]:SimpleChange}) {
        console.log('ImageThumbnailComponent ngOnChanges' + this.imageProperties);
        if (!this.imageProperties) {
            return;
        }
    }

    ngOnInit() {
        console.log('ImageThumbnailComponent ngOnInit' + this.imageProperties);
    }
}
