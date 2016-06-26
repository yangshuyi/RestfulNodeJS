export class RedisObject{
    key: string;
    value: Object;
    selected: boolean;

    constructor(key: string, value: Object){
        this.key = key;
        this.value = value;
    }
}
