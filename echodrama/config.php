<?php
/*
	[Ucenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: config.new.php 10855 2008-12-29 08:10:45Z liguode $
*/

//Ucenter Home���ò���
$_SC = array();
$_SC['dbhost']  		= 'localhost:3306'; //��������ַ
//$_SC['dbuser']  		= 'root'; //�û�
//$_SC['dbpw'] 	 		= 'vennise'; //����
$_SC['dbuser']                = 'upload'; //�û�
$_SC['dbpw']                  = 'qqq111```'; //����
$_SC['dbcharset'] 		= 'gbk'; //�ַ���
$_SC['pconnect'] 		= 0; //�Ƿ��������
$_SC['dbname']  		= 'ysys'; //���ݿ�
$_SC['tablepre'] 		= 'ysys_'; //����ǰ׺
$_SC['charset'] 		= 'gbk'; //ҳ���ַ���
$_SC['memcacheSetting'] = '1'; //ҳ���ַ���

//CONSOLE DB
$_SC['console_dbhost']  		= 'localhost:3306'; //��������ַ
#$_SC['console_dbuser']  		= 'root'; //�û�
#$_SC['console_dbpw'] 	 		= 'vennise'; //����
$_SC['console_dbuser']                  = 'upload'; //�û�
$_SC['console_dbpw']                    = 'qqq111```'; //����
$_SC['console_dbcharset'] 		= 'gbk'; //�ַ���
$_SC['console_pconnect'] 		= 0; //�Ƿ��������
$_SC['console_dbname']  		= 'console'; //���ݿ�
$_SC['console_tablepre'] 		= 'console_'; //����ǰ׺

$_SC['gzipcompress'] 	= 0; //����gzip

$_SC['cookiepre'] 		= 'uchome_'; //COOKIEǰ׺
$_SC['cookiedomain'] 	= ''; //COOKIE������
$_SC['cookiepath'] 		= '/'; //COOKIE����·��

$_SC['attachdir']		= './attachment/'; //�������ر���λ��(������·��, ���� 777, ����Ϊ web �ɷ��ʵ���Ŀ¼, ���Ŀ¼����� "./" ��ͷ, ĩβ�� "/")
$_SC['attachurl']		= 'attachment/'; //��������URL��ַ(��Ϊ��ǰ URL �µ���Ե�ַ�� http:// ��ͷ�ľ��Ե�ַ, ĩβ�� "/")

$_SC['siteurl']			= ''; //վ��ķ���URL��ַ(http:// ��ͷ�ľ��Ե�ַ, ĩβ�� "/")��Ϊ�յĻ���ϵͳ���Զ�ʶ��

$_SC['tplrefresh']		= 0; //�ж�ģ���Ƿ���µ�Ч�ʵȼ�����ֵԽ��Ч��Խ��; ����Ϊ0�����ò��ж�

//Ucenter Home��ȫ���
$_SC['founder'] 		= '1'; //��ʼ�� UID, ����֧�ֶ����ʼ�ˣ�֮��ʹ�� ��,�� �ָ������ֹ�����ֻ�д�ʼ�˲ſɲ�����
$_SC['allowedittpl']	= 0; //�Ƿ��������߱༭ģ�塣Ϊ�˷�������ȫ��ǿ�ҽ���ر�

//Ӧ�õ�UCenter������Ϣ(���Ե�UCenter��̨->Ӧ�ù���->�鿴��Ӧ��->���������Ӧ��������Ϣ�����滻)
define('UC_CONNECT', 'mysql'); // ���� UCenter �ķ�ʽ: mysql/NULL, Ĭ��Ϊ��ʱΪ fscoketopen(), mysql ��ֱ�����ӵ����ݿ�, Ϊ��Ч��, ������� mysql
define('UC_DBHOST', 'localhost:3306'); // UCenter ���ݿ�����
define('UC_DBUSER', 'upload'); // UCenter ���ݿ��û���
define('UC_DBPW', 'qqq111```'); // UCenter ���ݿ�����
define('UC_DBNAME', 'console'); // UCenter ���ݿ�����
define('UC_DBCHARSET', 'gbk'); // UCenter ���ݿ��ַ���
define('UC_DBTABLEPRE', '`console`.console_'); // UCenter ���ݿ��ǰ׺
define('UC_DBCONNECT', '0'); // UCenter ���ݿ�־����� 0=�ر�, 1=��
define('UC_KEY', '5l9ebg1S8wa82U7Oe0c7aM1m8j83fp0PdHai559gfp0f6o196Ce8bDf07Rcg7f82'); // �� UCenter ��ͨ����Կ, Ҫ�� UCenter ����һ��
//define('UC_KEY', '293dULUWDf8KBswHZLFBTL3O+nZD6/pl4li6QZZJoAzv2+BnxYnwq9bhII1a0Jd9MHIvu5ktFHKN0D3ZxTzOlwidjmo2RUpfDKG9BdayiFvCLfytZRSvUJl4HBST'); // �� UCenter ��ͨ����Կ, Ҫ�� UCenter ����һ��
define('UC_API', 'http://s-35118.gotocdn.com/console'); // UCenter �� URL ��ַ, �ڵ���ͷ��ʱ�����˳���
define('UC_CHARSET', 'gbk'); // UCenter ���ַ���
define('UC_IP', '125.65.108.224'); // UCenter �� IP, �� UC_CONNECT Ϊ�� mysql ��ʽʱ, ���ҵ�ǰӦ�÷�������������������ʱ, �����ô�ֵ
define('UC_APPID', '1'); // ��ǰӦ�õ� ID
define('UC_PPP', 20);

define('memcache', 0);

define('FORUM_TAGID', 1);
define('ECHODRAMA_TAGID', 8);
define('FORUM_JISHUJIAOLIU_CLASSID', 11);
define('FORUM_ZIYUANHUZHU_CLASSID', 12);
define('FORUM_XILIJUPING_CLASSID', 13);
define('FORUM_QIZUIBASHE_CLASSID', 14);

define('WB_AKEY', '1240041875');
define('WB_SKEY', 'a81ba3842faa0d06d563f7230be1f606');

