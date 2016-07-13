export class Topic {
    id:number;
    number:number;
    typeId:string;
    type:Type;
    singletonAlbum:boolean;
    
    posterUrl:string;
    subject:string;
    label:string;
    message:string;
    categoryId:number;
    category:Category;
    club:string;
    clubTagId:number;
    cast:string;
    yuanzhu:string;
    director:string;
    cehua:string;
    producer:string;
    writer:string;
    effector:string;
    photographer:string;
    produceDate:number;
    
    
    replyNum:number=0;
    viewNum:number=0;
    downloadNum:number=0;
    joinNum:number=0;
    poll_1:number=0;
    poll_2:number=0;
    poll_3:number=0;
    poll_4:number=0;
    poll_5:number=0;

    dateline:number;
    uId:number;
    userName:string;
}

export class Type {
    id:string;
    key:string;
    text:string;
    orderIdx:number;

    static getTypeById(id:string):Type {
        if(!id){
            return null;
        }

        let type:Type = new Type();
        switch (id) {
            case 'single':
                type.id = 'single';
                type.key = 'single';
                type.text = '广播剧';
                type.orderIdx = 1;
                break;
            case 'album':
                type.id = 'album';
                type.key = 'album';
                type.text = '广播剧专辑';
                type.orderIdx = 2;
                break;
            default:
                type.id = 'other';
                type.key = 'OTHER';
                type.text = '其它';
                type.orderIdx = 99;
                break;

        }
        return type;
    }
}


export class Category {
    id:number;
    key:string;
    text:string;
    orderIdx:number;

    static getCategoryById(id:number):Category {
        if(!id){
            return null;
        }

        let category:Category = new Category();
        switch (id) {
            case 1:
                category.id = 1;
                category.key = 'BG';
                category.text = 'BG广播剧';
                category.orderIdx = 1;
                break;
            case 2:
                category.id = 2;
                category.key = 'DM-BL';
                category.text = 'BL广播剧';
                category.orderIdx = 2;
                break;
            case 3:
                category.id = 3;
                category.key = 'DM-GL';
                category.text = 'GL广播剧';
                category.orderIdx = 3;
                break;
            case 4:
                category.id = 4;
                category.key = 'ALL-AGE';
                category.text = '全年龄';
                category.orderIdx = 4;
                break;
            case 5:
                category.id = 5;
                category.key = 'EG';
                category.text = '恶搞';
                category.orderIdx = 5;
                break;
            default:
                category.id = 99;
                category.key = 'OTHER';
                category.text = '其它';
                category.orderIdx = 99;
                break;

        }
        return category;
    }
}

