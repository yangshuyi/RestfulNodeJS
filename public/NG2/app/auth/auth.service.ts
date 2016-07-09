import {Injectable} from "@angular/core";
import {LogService} from "../common/log.service";

@Injectable()
export class AuthService {
    isLoggedIn:boolean = false;

    constructor(private logService:LogService) {
        this.logService.log('constructor AuthService');
    }

    login() {
        //TODO do is not valid
        //return Observable.of(true).delay(10000).do(val => this.isLoggedIn = true);
        return null;
    }

    logout() {
        this.isLoggedIn = false;
    }
}