import {Injectable} from "@angular/core";

@Injectable()
export class LogService {
    log(message:string) {
        console.log('log ' + message);
    }
}