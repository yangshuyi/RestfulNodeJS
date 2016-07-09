"use strict";
var ImageProperties = (function () {
    function ImageProperties() {
        this.title = '';
        this.scale = 1;
        this.rotate = 0;
        this.stretchMode = StretchMode.INITIAL;
    }
    return ImageProperties;
}());
exports.ImageProperties = ImageProperties;
var StretchMode;
(function (StretchMode) {
    StretchMode[StretchMode["WHOLE"] = 1] = "WHOLE";
    StretchMode[StretchMode["STETCHER"] = 2] = "STETCHER";
    StretchMode[StretchMode["INITIAL"] = 3] = "INITIAL";
})(StretchMode || (StretchMode = {}));
//# sourceMappingURL=image-properties.model.js.map