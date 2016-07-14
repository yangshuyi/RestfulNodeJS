
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

        this.url = this.imageProperties.srcUrl;
        _.each(changes, function (changedProp) {
            let from = changedProp.previousValue;
            let to = changedProp.currentValue;
            console.log('${propName} changed from ${from} to ${to}');
            console.log(changedProp + ' changed from ' + from + ' to ' + to);
        });
    }

    ngOnInit() {
        console.log('ImageThumbnailComponent ngOnInit' + this.imageProperties);
        //let imageSrc = element.all(by.tagName('img')).src;
    }

    ngAfterViewInit() {
        //$(this.imageElem.nativeElement).chosen().on('change', (e, args) => {
        //    this.selectedValue = args.selected;
        //});
    }

    onError() {
        if (!this.imageProperties) {
            return;
        }

        if (this.url != this.imageProperties.errorUrl) {
            this.url = this.imageProperties.errorUrl;
        }
    }

    onLoad($event) {
        if (!this.imageProperties) {
            return;
        }

        if (!this.imageProperties.imageWidth) {
            this.imageProperties.imageWidth = $event.srcElement.naturalWidth;
        }
        if (!this.imageProperties.imageHeight) {
            this.imageProperties.imageHeight = $event.srcElement.naturalHeight;
        }

        this.imageService.buildImageProperties(this.imageProperties);

        this.isImageLoadedFlag = true;
    }
}
