export class AppInfo {
    title:String = 'AngularJS2 cache manager';
    version:String = 'v1.0';
    copyRight:String = 'copyright information';

    menus:Object = [
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
    ]
}
