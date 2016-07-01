var AppInfo = (function () {
    function AppInfo() {
        this.title = 'AngularJS2 cache manager';
        this.version = 'v1.0';
        this.copyRight = 'copyright information';
        this.menus = [
            {
                name: 'Redis Manager',
                routerLink: '/RedisManager'
            },
            {
                name: 'MongoDB Manager',
                routerLink: '/MongoDBManager'
            },
            {
                name: 'Bootstrap',
                routerLink: '/Bootstrap'
            }
        ];
    }
    return AppInfo;
})();
exports.AppInfo = AppInfo;
//# sourceMappingURL=app-info.model.js.map