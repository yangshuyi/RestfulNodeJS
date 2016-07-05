<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: lang_cpmessage.php 12878 2009-07-24 05:59:38Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$_SGLOBAL['cplang'] = array(
	//common
	'do_success' => '���еĲ��������',
	'apply_submit_success' => '�����ύ�ɹ�����ȴ���ˡ�',

	//admincp.php
	'enter_the_password_is_incorrect' => '��������벻��ȷ�������³���',
	'excessive_number_of_attempts_to_sign' => '��30�����ڳ��Ե�¼����ƽ̨�Ĵ���������3�Σ�Ϊ�����ݰ�ȫ�����Ժ�����',

	//admincp.php

	//admin/admincp_ad.php
	'no_authority_management_operation' => '�Բ���,��û��Ȩ�޽��б��������',
	'please_check_whether_the_option_complete_required' => '�������ѡ���Ƿ���д����',
	'please_choose_to_remove_advertisements' => '������ѡ��һ��Ҫɾ���Ĺ��',
	'no_authority_management_operation_edittpl' => '��ȫ���ǣ����߱༭ģ�幦��Ĭ�Ϲرգ�����ֻ�д�ʼ�˿��Բ������������ʹ�ô˹��ܣ����޸�config.php�е�������á�',
	'no_authority_management_operation_backup' => '��ȫ���ǣ����ݿⱸ�ݻָ�����ֻ�д�ʼ�˿��Բ������������ʹ�ô˹��ܣ����޸�config.php�е�������á�',

	//admin/admincp_album.php
	'at_least_one_option_to_delete_albums' => '��������ȷѡ��һ��Ҫɾ�������',

	//admin/admincp_backup.php
	'data_import_failed_the_file_does_not_exist' => '���ݵ���ʧ��,�ļ�������',
	'start_transferring_data' => '���ݵ��뿪ʼ',
	'wrong_data_file_format_into_failure' => '���ݵ���ʧ��,�ļ���ʽ����',
	'documents_were_incorrect_length' => '�ļ������Ȳ���ȷ',
	'backup_table_wrong' => '���ݱ����',
	'failure_writes_the_document_check_file_permissions' => 'д���ļ�ʧ��,�����ļ�Ȩ��',
	'successful_data_compression_and_backup_server_to' => '���ݳɹ����ݲ�ѹ����������',
	'backup_file_compression_failure' => '�Բ���,���������ļ�ѹ��ʧ��,����Ŀ¼Ȩ��',
	'shell_backup_failure' => 'SHELL����ʧ��',
	'data_file_does_not_exist' => '�Բ���, �����ļ�������,����',
	'the_volumes_of_data_into_databases_success' => '�־����ݳɹ�����UCenter Home���ݿ�.',
	'data_file_does_not_exist' => '�Բ��������ļ�����������',
	'data_file_format_is_wrong_not_into' => '�����ļ��Ǹ�ʽ���޷����롣',
	'directory_does_not_exist_or_can_not_be_accessed' => 'Ŀ¼�����ڻ��޷����ʣ����� \\1 Ŀ¼��',
	'vol_backup_database' => '�־���: �����ļ� # \\1 �ɹ������������Զ�������',
	'complete_database_backup' => '��ϲ����ȫ�� \\1 �������ļ��ɹ�������������ɡ�',
	'decompress_data_files_success' => '�����ļ� # \\1 �ɹ���ѹ���������Զ�������',
	'data_files_into_success' => '�����ļ� # \\1 �ɹ����룬�����Զ�������',

	//admin/admincp_block.php
	'correctly_completed_module_name' => '����ȷ��д����ģ�������',
	'a_call_to_delete_the_specified_modules_success' => 'ָ�������ݵ���ģ��ɾ���ɹ���',
	'designated_data_transfer_module_does_not_exist' => 'ָ�������ݵ���ģ�鲻����',
	'sql_statements_can_not_be_completed_for_normal' => '��д��SQL��䲻��������ѯ���뷵�ؼ�顣<br>������������<br>ERROR: \\1<br>ERRNO. \\2',
	'enter_the_next_step' => '������һ������',
	'choose_to_delete_the_data_transfer_module' => '������ѡ��һ��Ҫɾ�������ݵ���ģ��',

	//admin/admincp_blog.php
	'the_correct_choice_to_delete_the_log' => '��������ȷѡ��һ��Ҫɾ�����ռ�',
	'the_correct_choice_to_add_topic' => '�Ƽ���ָ���ȵ������ȷ���Ƿ���ȷ����',
	'add_topic_success' => '�Ƽ����ȵ�����ˣ������� \\1 ����ض�̬',

	//admin/admincp_cache.php

	//admin/admincp_censor.php

	//admin/admincp_comment.php
	'the_correct_choice_to_delete_comments' => '��������ȷѡ��һ��Ҫɾ��������',
	'choice_batch_action' => '��ѡ��Ҫ���еĲ�������',

	//admin/admincp_config.php
	'ip_is_not_allowed_to_visit_the_area' => '��ǰ��IP( \\1 )����������ʵ�IP��Χ�ڣ���������',
	'the_prohibition_of_the_visit_within_the_framework_of_ip' => '��ǰ��IP( \\1 )�ڽ�ֹ���ʵ�IP��Χ�ڣ���������',

	'config_uc_dir_error' => '���õ�UCenter����·������ȷ���뷵�ؼ��',

	//admin/admincp_credit.php
	'rules_do_not_exist_points' => '�û��ֹ��򲻴���',

	//admin/admincp_cron.php
	'designated_script_file_incorrect' => 'ָ���Ľű��ļ�����ȷ',
	'implementation_cycle_incorrect_script' => '�趨�Ľű�ִ�����ڲ���ȷ',

	//admin/admincp_item.php
	'choose_to_delete_events' => '��������ȷѡ��һ��Ҫɾ�����¼�',

	//admin/admincp_mtag.php
	'choose_to_delete_the_columns_tag' => '��������ȷѡ��һ��Ҫɾ����Ⱥ��',
	'designated_to_merge_the_columns_do_not_exist' => 'Ҫ�ϲ�������Ⱥ�黹û�д������������д�����Ⱥ����ٽ��кϲ�',
	'the_successful_merger_of_the_designated_columns' => '�ϲ�ָ����Ⱥ��ɹ���',
	'columns_option_to_merge_the_tag' => '��������ȷѡ��һ��Ҫ�ϲ���Ⱥ��',
	'lock_open_designated_columns_tag_success' => '����/����ָ����Ⱥ��ɹ���',
	'recommend_designated_columns_tag_success' => '�Ƽ�/ȡ���Ƽ�ָ����Ⱥ��ɹ���',
	'choose_to_operate_columns_tag' => '��������ȷѡ��һ��Ҫ������Ⱥ��',

	'failed_to_change_the_length_of_columns' => '��Ŀ���ȱ��ʧ�ܣ���������ִ�������Ѿ������³���',

	//admin/admincp_pic.php
	'choose_to_delete_pictures' => '��������ȷѡ��һ��Ҫɾ����ͼƬ',

	//admin/admincp_post.php
	'choose_to_delete_the_topic' => '��������ȷѡ��һ��Ҫɾ���Ļ���',

	//admin/admincp_profield.php
	'there_is_no_designated_users_columns' => 'ָ��������Ⱥ����Ŀ������',
	'choose_to_delete_the_columns' => '����ȷѡ��Ҫɾ������Ŀ',
	'have_one_mtag' => 'ɾ��ʧ�ܣ�������Ҫ����һ��Ⱥ����Ŀ',
	
	//admin/admincp_poll.php
	'the_correct_choice_to_delete_the_poll' => '��������ȷѡ��һ��Ҫɾ����ͶƱ',

	//admin/admincp_report.php
	'the_right_to_report_the_specified_id' => '����ȷָ���ٱ�ID',

	//admin/admincp_share.php
	'please_delete_the_correct_choice_to_share' => '����ȷѡ��Ҫɾ���ķ���',

	//admin/admincp_space.php
	'designated_users_do_not_exist' => '��ָ�����û�������',
	'choose_to_delete_the_space' => '����ȷѡ��Ҫɾ���Ŀռ�',
	'not_have_permission_to_operate_founder' => '��û��Ȩ�޶Դ�ʼ�˽��в���',
	'uc_error' => '���û�����ͨ�ų������Ժ�����',

	//admin/admincp_stat.php
	'choose_to_reconsider_statistical_data_types' => '����ȷѡ��Ҫ����ͳ�Ƶ���������',
	'data_processing_please_wait_patiently' => '<a href="\\1">����������( \\2 )�������ĵȺ�...</a> (<a href="\\3">ǿ����ֹ</a>)',

	//admin/admincp_tag.php
	'choose_to_delete_the_tag' => '��������ȷѡ��һ��Ҫɾ���ı�ǩ',
	'to_merge_the_tag_name_of_the_length_discrepancies' => 'ָ����Ҫ�ϲ�����tag�����ַ����Ȳ�����Ҫ��(1~30���ַ�)',
	'the_tag_choose_to_merge' => '��������ȷѡ��һ��Ҫ�ϲ��ı�ǩ',
	'choose_to_operate_tag' => '��������ȷѡ��һ��Ҫ�����ı�ǩ',

	//admin/admincp_template.php
	'designated_template_files_can_not_be_restored' => 'ָ����ģ���ļ����ָܻ�',
	'template_files_editing_failure_check_directory_competence' => 'ָ����ģ���ļ��޷��༭,���� ./template Ŀ¼Ȩ������',

	//admin/admincp_thread.php
	'choosing_to_operate_the_topic' => '����ȷѡ��Ҫ�����Ļ���',

	//admin/admincp_usergroup.php
	'user_group_does_not_exist' => 'ָ���������û��鲻����',
	'user_group_were_not_empty' => 'ָ�����û���������Ϊ��',
	'integral_limit_duplication_with_other_user_group' => 'ָ���Ļ������޸������û����ظ�',
	'system_user_group_could_not_be_deleted' => 'ϵͳ�û��鲻��ɾ��',
	'integral_limit_error' => 'ָ���Ļ����������ܳ���999999999�����޲��ܵ���-999999998',

	//admin/admincp_userapp.php
	'my_register_sucess' => '�ɹ������û�Ӧ�÷���',
	'my_register_error' => '�����û�Ӧ�÷���ʧ�ܣ�ʧ��ԭ��<br>\\2 (ERRCODE:\\1)<br><br><a href="http://www.discuz.net/index.php?gid=141" target="_blank">��������ʣ���������ǵļ�����̳Ѱ�����</a>��',
	'sitefeed_error' => '����ȷ��Ӷ�̬���⡢��̬�������ύ����',

	//admin/admincp_event.php
	'choose_to_delete_the_columns_event'=>'��ѡ��Ҫɾ������ļ�',
	'choose_to_grade_the_columns_event'=>'��ѡ��Ҫ���õ���ļ�״̬����״̬���ܺ�ԭ״̬��ͬ',
	'have_no_jobclass'=>'ɾ��ʧ�ܣ��뱣������һ��ְ�����',
	'poster_only_jpg_allowed'=>'�������ķ�������֧����������ͼ�����ڴ˴�ֻ���ϴ� jpg ��ʽ��ͼƬ',
	
	
	//admin/admincp_topic.php
	'choose_to_delete_the_columns_topic'=>'��ѡ��Ҫɾ���Ĺ㲥��',
	'choose_to_audit_the_columns_topic'=>'��ѡ��Ҫ��˵Ĺ㲥��',


	'choose_to_delete_the_columns_tone'=>'��ѡ��Ҫɾ��������',
	'choose_to_rename_the_columns_tone'=>'��ѡ��Ҫ������������'

);

?>