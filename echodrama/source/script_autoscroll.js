function AutoScrollClass(_moduleName, _interval, _height) {
	//模块名
	this.moduleName = _moduleName;
	//动画暂停间隔
	this.interval = _interval;
	
	//翻转容器
	this.container = $(this.moduleName+'_container');
	//翻转元素
	this.rowArray=new Array();

	//初始化，获得绝对高度，设置各个元素初始位置
	this.offsetTop = getoffset(this.container)[0];
	this.height = _height;
	
	for(var i = 0; i < this.container.children.length; i++) {
		var e = this.container.children[i];
		if(e.id.indexOf(this.moduleName+'_div')>=0) {
			e.style.top = (this.offsetTop + 9999)+"px";
			this.rowArray.push(e);
		}
	}

	//当前翻转进行中的元素
	this.currentRowItem = null;
	//已完成翻转的元素
	this.perviousRowItem = null;
	//当前翻转进行中的元素INDEX
	this.currentRowIndex = -1;
	//已完成翻转元素的TOP位置
	this.perviousStartTop = 0;
	//当前翻转元素的TOP位置
	this.currentStartTop = 100;
	//动画handler
	this.animator = null;
}

//准备，每次翻转元素时进行

//当前元素/已完成元素翻转移动

function execute_AutoScrollClass(obj){
	if( obj.animator==null ){
		prepare_AutoScrollClass(obj);
		if( obj.currentRowItem == null ){
			return;
		}
		if(obj.currentRowItem == obj.perviousRowItem ){
			obj.currentRowItem.top = (0)+"px";
			return;
		}
		obj.animator = window.setInterval( function(){move_AutoScrollClass.apply(this,new Array(obj));}, obj.interval);
		setTimeout( function(){execute_AutoScrollClass.apply(this,new Array(obj));}, 10000);
	}
	else{
		setTimeout( function(){execute_AutoScrollClass.apply(this,new Array(obj));}, 1000);
	}
}

function prepare_AutoScrollClass(obj){
	//计算当前元素INDEX，得到当前元素
	if(obj.currentRowIndex == -1){
		obj.currentRowIndex = 0;
	}
	else if(obj.currentRowIndex >= (obj.rowArray.length - 1) ){
		obj.currentRowIndex = 0;
	}
	else{
		obj.currentRowIndex = obj.currentRowIndex+1;
	}
		
	obj.perviousRowItem = obj.currentRowItem;

	for(var i = 0; i < obj.container.children.length; i++) {
		var e = obj.container.children[i];
		if( e.id == (obj.moduleName+'_div_'+obj.currentRowIndex) ) {
			obj.currentRowItem = e;
			break;
		}
	}
	
	obj.perviousStartTop = 0;
	obj.currentStartTop = obj.height;
}

function move_AutoScrollClass(obj){
	if(obj.currentStartTop > 0){
		if(obj.perviousRowItem != null){
			obj.perviousStartTop = obj.perviousStartTop - 5;
			obj.perviousRowItem.style.top = obj.perviousStartTop + "px";
		}
		obj.currentStartTop = obj.currentStartTop - 5;
		obj.currentRowItem.style.top = obj.currentStartTop + "px";
	}
	else{
		obj.currentRowItem.style.top = (0)+"px";
		if(obj.perviousRowItem!=null){
			obj.perviousRowItem.style.top = obj.height+"px";
		}
		if(obj.animator!=null){
			window.clearInterval(obj.animator);
			obj.animator = null;
		}
	}
}