import { RouterConfig }          from '@angular/router';
import { RedisManagerComponent }     from './redis-manager.component';

export const RedisManagerRoutes: RouterConfig = [
    { path: 'redisManager',  component: RedisManagerComponent },
    { path: '',  component: RedisManagerComponent }
];
