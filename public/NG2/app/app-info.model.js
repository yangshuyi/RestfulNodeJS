"use strict";
var AppInfo = (function () {
    function AppInfo() {
        this.title = 'AngularJS2 cache manager';
        this.version = 'v1.0';
        this.siteHyperlink = 'http://www.echodram.com';
        this.menus = [
            {
                name: 'Redis Manager',
                routerLink: '/redisManager'
            },
            {
                name: 'MongoDB Manager',
                routerLink: '/mongoDBManager'
            },
            {
                name: 'Bootstrap',
                routerLink: '/bootstrap'
            }
        ];
    }
    return AppInfo;
}());
exports.AppInfo = AppInfo;
//# sourceMappingURL=app-info.model.js.map