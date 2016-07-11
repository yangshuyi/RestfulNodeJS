var router_1 = require('@angular/router');
var redis_manager_component_1 = require("./redis-manager.component");
var bootstrap_component_1 = require("./bootstrap.component");
var login_component_1 = require("./user/login.component");
exports.routes = [
    {
        path: 'redisManager',
        component: redis_manager_component_1.RedisManagerComponent,
    },
    {
        path: '',
        component: bootstrap_component_1.BootstrapComponent
    },
    {
        path: 'login',
        component: login_component_1.LoginComponent,
    }
];
exports.APP_ROUTER_PROVIDERS = [
    //provideRouter(routes), AuthGuard, AuthService
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map