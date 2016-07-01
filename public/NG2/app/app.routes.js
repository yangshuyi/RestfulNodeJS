var router_1 = require('@angular/router');
var redis_manager_component_1 = require("./redis-manager.component");
var bootstrap_component_1 = require("./bootstrap.component");
exports.routes = [
    {
        path: 'redisManager',
        component: redis_manager_component_1.RedisManagerComponent,
    },
    {
        path: 'bootstrap',
        component: bootstrap_component_1.BootstrapComponent
    },
    {
        path: '',
        component: bootstrap_component_1.BootstrapComponent
    }
];
exports.APP_ROUTER_PROVIDERS = [
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map