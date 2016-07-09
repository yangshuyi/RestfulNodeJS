
import {Component} from "@angular/core";
import {Router} from "@angular/router";
import {AuthService} from "../auth/auth.service";

@Component({
    template: ''+
    '<div>'+
    '   <h2>Login</h2>'+
    '   <button (click)="login()" *ngIf="!authService.isLoggedIn">Login</button>'+
    '   <button (click)="logout()" *ngIf="authService.isLoggedIn">Logout</button>'+
    '</div>',


})

export class LoginComponent{
    message: string;

    constructor(public authService: AuthService, public router: Router){
        this.setMessage();
    }

    setMessage(){
        this.message = "logged"+(this.authService.isLoggedIn?"in":"out");
    }

    login(){
        this.message="trying to log in...";

        this.authService.login().subscribe(()=>{
            this.router.navigate(['/redisManager']);
        });
    }

    logout(){
        this.authService.logout();
        this.setMessage();
    }

}