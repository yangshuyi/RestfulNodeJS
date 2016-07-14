var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var events_1 = require("events");
var ImageThumbnailComponent = (function () {
    function ImageThumbnailComponent() {
        this.onPageChanged = new events_1.EventEmitter();
        this.isImageLoadedFlag = false;
    }
    ImageThumbnailComponent.prototype.ngOnChanges = function (changes) {
        console.log('ImageThumbnailComponent ngOnChanges' + this.imageProperties);
        if (!this.imageProperties) {
            return;
        }
        this.url = this.imageProperties.srcUrl;
        _.each(changes, function (changedProp) {
            var from = changedProp.previousValue;
            var to = changedProp.currentValue;
            console.log('${propName} changed from ${from} to ${to}');
            console.log(changedProp + ' changed from ' + from + ' to ' + to);
        });
    };
    ImageThumbnailComponent.prototype.ngOnInit = function () {
        console.log('ImageThumbnailComponent ngOnInit' + this.imageProperties);
        //let imageSrc = element.all(by.tagName('img')).src;
    };
    ImageThumbnailComponent.prototype.ngAfterViewInit = function () {
        //$(this.imageElem.nativeElement).chosen().on('change', (e, args) => {
        //    this.selectedValue = args.selected;
        //});
    };
    ImageThumbnailComponent.prototype.onError = function () {
        if (!this.imageProperties) {
            return;
        }
        if (this.url != this.imageProperties.errorUrl) {
            this.url = this.imageProperties.errorUrl;
        }
    };
    ImageThumbnailComponent.prototype.onLoad = function ($event) {
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
    };
    __decorate([
        Input(), 
        __metadata('design:type', Number)
    ], ImageThumbnailComponent.prototype, "pageNum", void 0);
    __decorate([
        Input(), 
        __metadata('design:type', Number)
    ], ImageThumbnailComponent.prototype, "currentPageIdx", void 0);
    __decorate([
        Output(), 
        __metadata('design:type', events_1.EventEmitter)
    ], ImageThumbnailComponent.prototype, "onPageChanged", void 0);
    ImageThumbnailComponent = __decorate([
        Component({
            selector: 'image-thumbnail',
            template: '' +
                '<ul class="pagination">' +
                '   <li><a href="#">&laquo;</a></li>' +
                '   <li><a href="#">1</a></li>' +
                '   <li><a href="#">2</a></li>' +
                '   <li><a href="#">3</a></li>' +
                '   <li><a href="#">4</a></li>' +
                '   <li><a href="#">5</a></li>' +
                '   <li><a href="#">&raquo;</a></li>' +
                '   </ul>' +
                '',
            styles: [
                '.content { margin: 0 auto; position: relative; border: 1px solid darkgray; background: white;}' +
                    '.content > img{ position: absolute; }' +
                    ''
            ]
        }), 
        __metadata('design:paramtypes', [])
    ], ImageThumbnailComponent);
    return ImageThumbnailComponent;
})();
exports.ImageThumbnailComponent = ImageThumbnailComponent;
//# sourceMappingURL=pagination.component.js.map