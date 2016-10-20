var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
// import your new AppComponent and add it in the declarations and bootstrap fields in the NgModule decorator:
var core_1 = require('@angular/core');
var platform_browser_1 = require('@angular/platform-browser');
var forms_1 = require('@angular/forms');
var router_1 = require('@angular/router');
var app_component_1 = require('./app.component');
var login_component_1 = require("./user/login.component");
var redis_manager_component_1 = require("./redis-manager.component");
var app_footer_component_1 = require("./app-footer.component");
var app_header_component_1 = require("./app-header.component");
var redis_object_component_1 = require("./redis-object.component");
var bootstrap_component_1 = require("./ng2-bootstrap-demo/bootstrap.component");
var space_list_component_1 = require("./echodrama/topic/space-list.component");
var snapshot_component_1 = require("./echodrama/topic/snapshot.component");
var image_thumbnail_component_1 = require("./common/image-viewer/image-thumbnail.component");
var alert_dialog_component_1 = require("./common/dialog/alert-dialog.component");
var card_item_component_1 = require("./echodrama/topic/card-item.component");
var AppModule = (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        core_1.NgModule({
            imports: [
                platform_browser_1.BrowserModule,
                forms_1.FormsModule,
                router_1.RouterModule.forRoot([
                    {
                        path: 'redisManager',
                        component: redis_manager_component_1.RedisManagerComponent,
                    },
                    {
                        path: '',
                        component: space_list_component_1.TopicSpaceListComponent
                    },
                    {
                        path: 'login',
                        component: login_component_1.LoginComponent,
                    }
                ])
            ],
            declarations: [
                app_component_1.AppComponent, app_header_component_1.AppHeaderComponent, app_footer_component_1.AppFooterComponent,
                alert_dialog_component_1.AlertDialogComponent, image_thumbnail_component_1.ImageThumbnailComponent,
                login_component_1.LoginComponent,
                redis_manager_component_1.RedisManagerComponent, redis_object_component_1.RedisObjectComponent,
                snapshot_component_1.TopicSnapshotComponent, space_list_component_1.TopicSpaceListComponent, card_item_component_1.TopicCardItemComponent,
                bootstrap_component_1.BootstrapComponent
            ],
            providers: [],
            bootstrap: [app_component_1.AppComponent]
        }), 
        __metadata('design:paramtypes', [])
    ], AppModule);
    return AppModule;
})();
exports.AppModule = AppModule;
//# sourceMappingURL=app.module.js.map