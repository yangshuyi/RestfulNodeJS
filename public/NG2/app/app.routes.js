"use strict";
var router_1 = require('@angular/router');
var redis_manager_component_1 = require("./redis-manager.component");
exports.routes = [
    { path: 'redisManager', component: redis_manager_component_1.RedisManagerComponent },
    { path: 'mongoDBManager', component: redis_manager_component_1.RedisManagerComponent }
];
exports.APP_ROUTER_PROVIDERS = [
    router_1.provideRouter(exports.routes)
];
//# sourceMappingURL=app.routes.js.map