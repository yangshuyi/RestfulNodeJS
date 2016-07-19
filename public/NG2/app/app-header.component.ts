//One or more import statements to reference the things we need.
import {Component, Input} from '@angular/core';
import { Router }       from '@angular/router';
import {AppInfo} from "./app-info.model";
import {AuthService} from "./auth/auth.service";

//let template = require('./app-header.html');

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-header', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    templateUrl: 'app/app-header.html',
    styles: [''],
    providers: [AuthService]
})

//A component class that controls the appearance and behavior of a view through its template.
//AppComponent is the root of the application
export class AppHeaderComponent{
    @Input()
    private appInfo:AppInfo;


    constructor(
        private router: Router,
        private authService: AuthService
    ) {
    }

    navigateToModule(menu:{routerLink:string}){
        this.router.navigate([menu.routerLink, {}]);
    }

    openUserInfo(){
        let isUserLogin = this.authService.isLoggedIn;
        if(isUserLogin){
            alert("yangsh login in");
        }else{
            alert("please login in first");
        }
    }
}


