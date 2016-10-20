var AppInfo = (function () {
    function AppInfo() {
        this.title = 'AngularJS2 cache manager';
        this.version = 'v1.0';
        this.siteHyperlink = 'http://www.echodram.com';
        this.menus = [
            {
                name: 'Redis',
                routerLink: '/redisManager'
            },
            {
                name: 'MongoDB',
                routerLink: '/mongoDBManager'
            },
            {
                name: 'Bootstrap',
                routerLink: '/bootstrap'
            }
        ];
    }
    return AppInfo;
})();
exports.AppInfo = AppInfo;
//# sourceMappingURL=app-info.model.js.map