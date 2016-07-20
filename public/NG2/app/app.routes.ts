import { provideRouter, RouterConfig } from '@angular/router';
import {RedisManagerComponent} from "./redis-manager.component";

import {LoginComponent} from "./user/login.component";
import {BootstrapComponent} from "./ng2-bootstrap-demo/bootstrap.component";

export const routes:RouterConfig = [
    {
        path: 'redisManager',
        component: RedisManagerComponent,
        //children: [
        //    {path: '2', component: SomeOtherComponent},
        //    {path: '', component: SomeOtherComponent}
        //]
        //canActivate: [AuthGuard]
    },
    {
        path: '',
        component: BootstrapComponent
    },
    {
        path: 'login',
        component: LoginComponent,
        //canActivate: [AuthGuard]
    }
];

export const APP_ROUTER_PROVIDERS = [
    //provideRouter(routes), AuthGuard, AuthService
    provideRouter(routes)
];