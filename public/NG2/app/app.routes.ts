import { provideRouter, RouterConfig } from '@angular/router';
import {RedisManagerComponent} from "./redis-manager.component";

export const routes: RouterConfig = [
    {path: 'redisManager', component: RedisManagerComponent},
    {path: 'mongoDBManager', component: RedisManagerComponent}
];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)
];