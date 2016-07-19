var Topic = (function () {
    function Topic() {
        this.replyNum = 0;
        this.viewNum = 0;
        this.downloadNum = 0;
        this.joinNum = 0;
        this.poll_1 = 0;
        this.poll_2 = 0;
        this.poll_3 = 0;
        this.poll_4 = 0;
        this.poll_5 = 0;
    }
    return Topic;
})();
exports.Topic = Topic;
var Type = (function () {
    function Type() {
    }
    Type.getTypeById = function (id) {
        if (!id) {
            return null;
        }
        var type = new Type();
        switch (id) {
            case 'single':
                type.id = 'single';
                type.key = 'single';
                type.text = '广播剧';
                type.orderIdx = 1;
                break;
            case 'album':
                type.id = 'album';
                type.key = 'album';
                type.text = '广播剧专辑';
                type.orderIdx = 2;
                break;
            default:
                type.id = 'other';
                type.key = 'OTHER';
                type.text = '其它';
                type.orderIdx = 99;
                break;
        }
        return type;
    };
    return Type;
})();
exports.Type = Type;
var Category = (function () {
    function Category() {
    }
    Category.getCategoryById = function (id) {
        if (!id) {
            return null;
        }
        var category = new Category();
        switch (id) {
            case 1:
                category.id = 1;
                category.key = 'BG';
                category.text = 'BG';
                category.orderIdx = 1;
                break;
            case 2:
                category.id = 2;
                category.key = 'DM-BL';
                category.text = 'BL';
                category.shortText = 'BL';
                category.orderIdx = 2;
                break;
            case 3:
                category.id = 3;
                category.key = 'DM-GL';
                category.text = 'GL';
                category.shortText = 'GL';
                category.orderIdx = 3;
                break;
            case 4:
                category.id = 4;
                category.key = 'ALL-AGE';
                category.text = '全年龄';
                category.orderIdx = 4;
                break;
            case 5:
                category.id = 5;
                category.key = 'EG';
                category.text = '恶搞';
                category.orderIdx = 5;
                break;
            default:
                category.id = 99;
                category.key = 'OTHER';
                category.text = '其它';
                category.orderIdx = 99;
                break;
        }
        return category;
    };
    return Category;
})();
exports.Category = Category;
//# sourceMappingURL=topic.model.js.map