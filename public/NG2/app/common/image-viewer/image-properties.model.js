var ImageProperties = (function () {
    function ImageProperties() {
        this.title = '';
        this.scale = 1;
        this.rotate = 0;
        this.stretchMode = StretchMode.INITIAL;
    }
    return ImageProperties;
})();
exports.ImageProperties = ImageProperties;
(function (StretchMode) {
    StretchMode[StretchMode["WHOLE"] = 1] = "WHOLE";
    StretchMode[StretchMode["FILL"] = 2] = "FILL";
    StretchMode[StretchMode["INITIAL"] = 3] = "INITIAL";
})(exports.StretchMode || (exports.StretchMode = {}));
var StretchMode = exports.StretchMode;
//# sourceMappingURL=image-properties.model.js.map