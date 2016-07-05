function AutoScrollClass(_moduleName, _interval, _height) {
	//ģ����
	this.moduleName = _moduleName;
	//������ͣ���
	this.interval = _interval;
	
	//��ת����
	this.container = $(this.moduleName+'_container');
	//��תԪ��
	this.rowArray=new Array();

	//��ʼ������þ��Ը߶ȣ����ø���Ԫ�س�ʼλ��
	this.offsetTop = getoffset(this.container)[0];
	this.height = _height;
	
	for(var i = 0; i < this.container.children.length; i++) {
		var e = this.container.children[i];
		if(e.id.indexOf(this.moduleName+'_div')>=0) {
			e.style.top = (this.offsetTop + 9999)+"px";
			this.rowArray.push(e);
		}
	}

	//��ǰ��ת�����е�Ԫ��
	this.currentRowItem = null;
	//����ɷ�ת��Ԫ��
	this.perviousRowItem = null;
	//��ǰ��ת�����е�Ԫ��INDEX
	this.currentRowIndex = -1;
	//����ɷ�תԪ�ص�TOPλ��
	this.perviousStartTop = 0;
	//��ǰ��תԪ�ص�TOPλ��
	this.currentStartTop = 100;
	//����handler
	this.animator = null;
}

//׼����ÿ�η�תԪ��ʱ����

//��ǰԪ��/�����Ԫ�ط�ת�ƶ�

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
	//���㵱ǰԪ��INDEX���õ���ǰԪ��
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