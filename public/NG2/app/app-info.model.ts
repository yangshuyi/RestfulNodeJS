export class AppInfo {
    title:String = 'AngularJS2 cache manager';
    version:String = 'v1.0';
    siteHyperlink:String = 'http://www.echodram.com';

    menus:Object = [
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
    ]
}
