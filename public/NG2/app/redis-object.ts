export class RedisObject{
    key: String;
    value: Object;

    constructor(key: String, value: Object){
        this.key = key;
        this.value = value;
    }
}
