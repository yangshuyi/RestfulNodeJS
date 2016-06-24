import {Injectable} from '@angular/core'
import {RedisObject} from "./redis-object";

@Injectable()
export class RedisManagerService{
    listAll(){
        const RPC_FALG = false;
        if(RPC_FALG){
            return new Promise<Hero[]>(resolve =>
                setTimeout(() => resolve(HEROES), 2000) // 2 seconds
            );
        }else{
            var redisObjects:RedisObject[] = [];
            redisObjects.push(new RedisObject('a','value1'));
            redisObjects.push(new RedisObject('aa','value2'));
            redisObjects.push(new RedisObject('aaa','value3'));
            redisObjects.push(new RedisObject('b','value4'));
            redisObjects.push(new RedisObject('bb','value5'));
            redisObjects.push(new RedisObject('bbb','value6'));

            return Promise.resolve(redisObjects);
        }
    }
}