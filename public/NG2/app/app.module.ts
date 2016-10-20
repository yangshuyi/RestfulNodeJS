// import your new AppComponent and add it in the declarations and bootstrap fields in the NgModule decorator:
import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule }    from '@angular/forms';
import { RouterModule }   from '@angular/router';
import {ComponentResolver} from '@angular/core';

import { AppComponent }   from './app.component';
import {LoginComponent} from "./user/login.component";
import {RedisManagerComponent} from "./redis-manager.component";
import {AppFooterComponent} from "./app-footer.component";
import {AppHeaderComponent} from "./app-header.component";
import {RedisObjectComponent} from "./redis-object.component";
import {BootstrapComponent} from "./ng2-bootstrap-demo/bootstrap.component";
import {TopicSpaceListComponent} from "./echodrama/topic/space-list.component";
import {TopicSnapshotComponent} from "./echodrama/topic/snapshot.component";
import {PaginationComponent} from "./common/pagination/pagination.component";
import {ImageThumbnailComponent} from "./common/image-viewer/image-thumbnail.component";
import {AlertDialogComponent} from "./common/dialog/alert-dialog.component";
import {TopicCardItemComponent} from "./echodrama/topic/card-item.component";

@NgModule({
    imports: [
        BrowserModule,
        FormsModule,
        RouterModule.forRoot([
            {
                path: 'redisManager',
                component: RedisManagerComponent,
                //children: [
                //    {path: '2', component: SomeOtherComponent},
                //    {path: '', component: SomeOtherComponent}
                //]
            },
            {
                path: '',
                component: TopicSpaceListComponent
            },
            {
                path: 'login',
                component: LoginComponent,
                //canActivate: [AuthGuard]
            }
        ])
    ],
    declarations: [
        AppComponent, AppHeaderComponent, AppFooterComponent,
        AlertDialogComponent, ImageThumbnailComponent,
        LoginComponent,
        RedisManagerComponent, RedisObjectComponent,
        TopicSnapshotComponent, TopicSpaceListComponent, TopicCardItemComponent,
        BootstrapComponent
    ],
    providers: [
    ],
    bootstrap: [AppComponent]
})
export class AppModule {
}
