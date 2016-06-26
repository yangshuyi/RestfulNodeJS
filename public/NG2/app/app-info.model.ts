export class AppInfo {
    title:String = 'AngularJS2 cache manager';
    version:String = 'v1.0';
    copyRight:String = 'copyright information';
    menus:Object = [
        {
            name: 'Redis Manager',
            routerLink: '"RedisManager"'
        },
        {
            name: 'MongoDB Manager',
            routerLink: '"MongoDBManager"'
        }
    ]
}
