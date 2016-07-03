"use strict";
var platform_browser_dynamic_1 = require('@angular/platform-browser-dynamic'); //Angular's browser bootstrap function
var app_component_1 = require('./app.component'); //The application root component, AppComponent
var app_routes_1 = require('./app.routes'); //Next we open main.ts where we must register our router providers in the bootstrap method.
platform_browser_dynamic_1.bootstrap(app_component_1.AppComponent, [
    app_routes_1.APP_ROUTER_PROVIDERS
])
    .catch(function (err) { return console.error(err); });
//# sourceMappingURL=main.js.map