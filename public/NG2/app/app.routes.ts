import { provideRouter, RouterConfig } from '@angular/router';
import {RedisManagerComponent} from "./redis-manager.component";
import {BootstrapComponent} from "./bootstrap.component";


export const routes:RouterConfig = [
    {
        path: 'redisManager',
        component: RedisManagerComponent,
        //children: [
        //    {path: '2', component: SomeOtherComponent},
        //    {path: '', component: SomeOtherComponent}
        //]
    },
    {
        path: 'bootstrap',
        component: BootstrapComponent
    },
    {
        path: '',
        component: BootstrapComponent
    }
];

export const APP_ROUTER_PROVIDERS = [
    provideRouter(routes)

];