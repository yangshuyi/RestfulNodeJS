<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: lang_showmessage.php 13183 2009-08-17 04:35:11Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$_SGLOBAL['msglang'] = array(

	'box_title' => '��Ϣ',

	//common
	'do_success' => '���еĲ��������',
	'no_privilege' => '��Ŀǰû��Ȩ�޽��д˲���',
	'no_privilege_realname' => '����Ҫ��д���ų�Ա������ܽ��е�ǰ������<a href="cp.php?ac=profile">�������������ų�Ա��</a>',
	'no_privilege_videophoto' => '����Ҫ��Ƶ��֤ͨ������ܽ��е�ǰ������<a href="cp.php?ac=videophoto">�����������Ƶ��֤</a>',
	'no_open_videophoto' => 'Ŀǰվ���Ѿ��ر���Ƶ��֤����',
	'is_blacklist' => '�ܶԷ�����˽����Ӱ�죬��Ŀǰû��Ȩ�޽��б�����',
	'no_privilege_newusertime' => '��Ŀǰ���ڼ�ϰ�ڼ䣬��Ҫ�ȴ� \\1 Сʱ����ܽ��б�����',
	'no_privilege_avatar' => '����Ҫ�����Լ���ͷ�����ܽ��б�������<a href="cp.php?ac=avatar">����������</a>',
	'no_privilege_friendnum' => '����Ҫ��� \\1 ������֮�󣬲��ܽ��б�������<a href="cp.php?ac=friend&op=find">��������Ӻ���</a>',
	'no_privilege_email' => '����Ҫ��֤�����Լ����������ܽ��б�������<a href="cp.php?ac=profile&op=contact">�����Ｄ������</a>',
	'uniqueemail_check' => '������������ַ�Ѿ���ռ�ã��볢��ʹ����������',
	'uniqueemail_recheck' => '��Ҫ��֤�������ַ�Ѿ�������ˣ����������������������Լ�������',
	'you_do_not_have_permission_to_visit' => '���ѱ���ֹ���ʡ�',

	//mt.php
	'designated_election_it_does_not_exist' => 'ָ����Ⱥ�鲻���ڣ������Գ��Դ���',
	'mtag_tagname_error' => '���õ�Ⱥ�����Ʋ�����Ҫ��',
	'mtag_join_error' => '����ָ����Ⱥ��ʧ�ܣ��볢���������е����Ⱥ�飬������Ӧ��Ⱥ���������Ϊ��Ա',
	'mtag_join_field_error' => 'Ⱥ����� \\1 �������ֻ������� \\2 ��Ⱥ�飬���Ѿ���������',
	'mtag_creat_error' => '��Ҫ�鿴��Ⱥ��Ŀǰ��û�б�����',

	//index.php
	'enter_the_space' => '������˿ռ�ҳ��',

	//network.php
	'points_deducted_yes_or_no' => '���β������ۼ��� \\1 �����֣�\\2 ������ֵ��ȷ�ϼ�����<br><br><a href="\\3" class="submit">��������</a> &nbsp; <a href="javascript:history.go(-1);" class="button">ȡ��</a>',
	'points_search_error' => "�����ڵĻ��ֻ���ֵ���㣬�޷���ɱ�������",

	//source/cp_album.php
	'photos_do_not_support_the_default_settings' => 'Ĭ����᲻֧�ֱ�����',
	'album_name_errors' => '��û����ȷ���������',

	//source/space_app.php
	'correct_choice_for_application_show' => '��ѡ����ȷ��Ӧ�ý��в鿴',

	//source/do_login.php
	'users_were_not_empty_please_re_login' => '�Բ����û�������Ϊ�գ������µ�¼',
	'login_failure_please_re_login' => '�Բ���,��¼ʧ��,�����µ�¼',

	//source/cp_blog.php
	'no_authority_expiration_date' => '����ǰȨ���ѱ�����Ա��ʱ���ƣ��ָ���ʱ��Ϊ��\\1',
	'no_authority_expiration' => '����ǰȨ���ѱ�����Ա���ƣ���������ǵĹ���',
	'no_authority_to_add_log' => '��Ŀǰû��Ȩ������ռ�',
	'no_authority_operation_of_the_log' => '��û��Ȩ�޲������ռ�',
	'that_should_at_least_write_things' => '����Ӧ��дһ�㶫��',
	'failed_to_delete_operation' => 'ɾ��ʧ�ܣ��������',

	'click_error' => 'û�н��������ı�̬����',
	'click_item_error' => 'Ҫ��̬�Ķ��󲻴���',
	'click_no_self' => '�Լ����ܸ��Լ���̬',
	'click_have' => '���Ѿ����̬��',
	'click_success' => '�����̬�����',

	//source/cp_repaste.php
	'no_authority_to_add_repaste' => '��Ŀǰû��Ȩ�����ת��',
	'no_authority_operation_of_the_log' => '��û��Ȩ�޲�����ת��',
	
	//source/cp_class.php
	'did_not_specify_the_type_of_operation' => 'û����ȷָ��Ҫ�����ķ���',
	'enter_the_correct_class_name' => '����ȷ���������',

	'note_wall_reply_success' => '�Ѿ��ظ��� \\1 �����԰�',

	//source/cp_comment.php

	'operating_too_fast' => "���η�������̫���ˣ���� \\1 ��������",
	'content_is_too_short' => '��������ݲ�������2���ַ�',
	'comments_do_not_exist' => 'ָ�������۲�����',
	'do_not_accept_comments' => '���ռǲ���������',
	'sharing_does_not_exist' => '���۵ķ�������',
	'non_normal_operation' => '����������',
	'the_vote_only_allows_friends_to_comment' => '��ͶƱֻ�����������',

	//source/cp_common.php
	'security_exit' => '���Ѿ���ȫ�˳���\\1',

	//source/cp_doing.php
	'should_write_that' => '����Ӧ��дһ�㶫��',
	'docomment_error' => '����ȷָ��Ҫ���۵ļ�¼',

	//source/cp_invite.php
	'mail_can_not_be_empty' => '�ʼ��б���Ϊ��',
	'send_result_1' => '�ʼ��Ѿ��ͳ������ĺ��ѿ�����Ҫ�����Ӻ�����յ��ʼ�',
	'send_result_2' => '<strong>�����ʼ�����ʧ��:</strong><br/>\\1',
	'send_result_3' => 'δ�ҵ���Ӧ�������¼, �ʼ��ط�ʧ��.',
	'there_is_no_record_of_invitation_specified' => '��ָ���������¼������',

	//source/cp_import.php
	'blog_import_no_result' => '"�޷���ȡԭ���ݣ���ȷ������ȷ�����վ��URL���ʺ���Ϣ������������:<br /><textarea name=\"tmp[]\" style=\"width:98%;\" rows=\"4\">\\1</textarea>"',
	'blog_import_no_data' => '��ȡ����ʧ�ܣ���ο�����������:<br />\\1',
	'support_function_has_not_yet_opened fsockopen' => 'վ����δ����fsockopen����֧�֣�������ʹ�ñ�����',
	'integral_inadequate' => "�����ڵĻ��� \\1 ��������ɱ��β���������������Ҫ����: \\2",
	'experience_inadequate' => "�����ڵľ���ֵ\\1 ��������ɱ��β���������������Ҫ����ֵ: \\2",
	'url_is_not_correct' => '�������վURL����ȷ',
	'choose_at_least_one_log' => '������ѡ��һ��Ҫ������ռ�',

	//source/cp_friend.php
	'friends_add' => '���� \\1 ��Ϊ������',
	'you_have_friends' => '�����Ѿ��Ǻ�����',
	'enough_of_the_number_of_friends' => '����ǰ�ĺ�����Ŀ�ﵽϵͳ���ƣ�����ɾ�����ֺ���',
	'enough_of_the_number_of_friends_with_magic' => '����ǰ�ĺ�����Ŀ�ﵽϵͳ���ƣ�<a id="a_magic_friendnum2" href="magic.php?mid=friendnum" onclick="ajaxmenu(event, this.id, 1)">ʹ�ú������ݿ�����</a>',
	'request_has_been_sent' => '���������Ѿ����ͣ���ȴ��Է���֤��',
	'waiting_for_the_other_test' => '���ڵȴ��Է���֤��',
	'please_correct_choice_groups_friend' => '����ȷѡ��������',
	'specified_user_is_not_your_friend' => 'ָ�����û����������ĺ���',

	//source/cp_mtag.php
	'mtag_managemember_no_privilege' => '�����ܶԵ�ǰѡ���ĳ�Ա����Ⱥ��Ȩ�ޱ��������������ѡ��',
	'mtag_max_inputnum' => '�޷����룬������Ŀ "\\1" �е�Ⱥ����Ŀ�Ѵﵽ \\2 ��������Ŀ',
	'you_are_already_a_member' => '���Ѿ��Ǹ�Ⱥ��ĳ�Ա��',
	'join_success' => '����ɹ����������Ǹ�Ⱥ��ĳ�Ա��',
	'the_discussion_topic_does_not_exist' => '�Բ��𣬲������۵Ļ��ⲻ����',
	'content_is_not_less_than_four_characters' => '�Բ������ݲ�������2���ַ�',
	'you_are_not_a_member_of' => '�����Ǹ�Ⱥ��ĳ�Ա',
	'unable_to_manage_self' => '�����ܶ��Լ����в���',
	'mtag_joinperm_1' => '���Ѿ�ѡ������Ⱥ�飬��ȴ�Ⱥ��������ļ�������',
	'mtag_joinperm_2' => '��Ⱥ����Ҫ�յ�Ⱥ���������ܼ���',
	'invite_mtag_ok' => '�ɹ������Ⱥ�飬�����ԣ�<a href="space.php?do=mtag&tagid=\\1" target="_blank">�������ʸ�Ⱥ��</a>',
	'invite_mtag_cancel' => '���Ը�Ⱥ���������',
	'failure_to_withdraw_from_group' => '�˳�˽��Ⱥ��ʧ��,����ָ��һ����Ⱥ��',
	'fill_out_the_grounds_for_the_application' => '����дȺ����������',

	//source/cp_pm.php
	'this_message_could_not_be_deleted' => 'ָ���Ķ���Ϣ���ܱ�ɾ��',
	'message_send_success' => '��Ϣ���ͳɹ�',
	'unable_to_send_air_news' => '���ܷ��Ϳ���Ϣ',
	'message_can_not_send' => '�Բ��𣬷��Ͷ���Ϣʧ��',
	'message_can_not_send1' => '����ʧ�ܣ�����ǰ������24Сʱ��������Ͷ���Ϣ��Ŀ',
	'message_can_not_send2' => '���η��Ͷ���Ϣ̫�죬���Ե�һ���ٷ���',
	'message_can_not_send3' => '�����ܸ��Ǻ����������Ͷ���Ϣ',
	'message_can_not_send4' => 'Ŀǰ��������ʹ�÷��Ͷ���Ϣ����',
	'not_to_their_own_greeted' => '�������Լ����к�',
	'has_been_hailed_overlooked' => '�к��Ѿ�������',

	//source/cp_profile.php
	'realname_too_short' => '���ų�Ա����������4���ַ�',
	'update_on_successful_individuals' => '�������ϸ��³ɹ���',

	//source/cp_poll.php
	'no_authority_to_add_poll' => '��Ŀǰû��Ȩ�����ͶƱ',
	'no_authority_operation_of_the_poll' => '��û��Ȩ�޲�����ͶƱ',
	'add_at_least_two_further_options' => '�����������������ͬ�ĺ�ѡ��',
	'the_total_reward_should_not_overrun' => '���������ܶ�ܳ���\\1',
	'wrong_total_reward' => '�����ܶ��С��ƽ�����Ͷ��',
	'voting_does_not_exist' => 'ͶƱ��Ϣ������',
	'already_voted' => '���Ѿ�Ͷ��Ʊ',
	'option_exceeds_the_maximum_number_of' => '���������,����ܳ���20��ͶƱ��',
	'the_total_reward_should_not_be_empty' => '�����ܶ��Ϊ��',
	'average_reward_should_not_be_empty' => 'ƽ��ÿ�����Ͷ�Ȳ���Ϊ��',
	'average_reward_can_not_exceed' => 'ƽ��ÿ��������߲��ܳ���\\1������',
	'added_option_should_not_be_empty' => '�����ӵĺ�ѡ���Ϊ��',
	'time_expired_error' => '����ʱ�䲻��С�ڵ�ǰʱ��',
	'please_select_items_to_vote' => '������ѡ��һ��ͶƱѡ��',
	'fill_in_at_least_an_additional_value' => '���������һ��׷������ֵ',

	//source/cp_share.php
	'blog_does_not_exist' => 'ָ�����ռǲ�����',
	'logs_can_not_share' => 'ָ�����ռ�����˽���ò��ܹ�������',
	'album_does_not_exist' => 'ָ������᲻����',
	'album_can_not_share' => 'ָ�����������˽���ò��ܹ�������',
	'image_does_not_exist' => 'ָ����ͼƬ������',
	'image_can_not_share' => 'ָ����ͼƬ����˽���ò��ܹ�������',
	'topics_does_not_exist' => 'ָ���Ļ��ⲻ����',
	'mtag_fieldid_does_not_exist' => 'ָ����Ⱥ����಻����',
	'tag_does_not_exist' => 'ָ���ı�ǩ������',
	'url_incorrect_format' => '�������ַ��ʽ����ȷ',
	'description_share_input' => '��������������',
	'poll_does_not_exist' => 'ָ����ͶƱ������',
	'share_not_self' => '�㲻�ܷ����Լ��������Ϣ(��ͼƬ)',
	'share_space_not_self' => '�㲻�ܷ����Լ�����ҳ',
	'share_already' => '���Ѿ������˸���Ʒ',
	'share_message_limit' => '����˵�������50���ַ�',

	//source/cp_space.php
	'domain_length_error' => '���õĶ����������Ȳ���С��\\1���ַ�',
	'credits_exchange_invalid' => '�һ��Ļ��ַ����д����ܽ��жһ����뷵���޸ġ�',
	'credits_transaction_amount_invalid' => '��Ҫת�˻�һ��Ļ����������������뷵���޸ġ�',
	'credits_password_invalid' => '��û�����������������󣬲��ܽ��л��ֲ������뷵�ء�',
	'credits_balance_insufficient' => '�Բ������Ļ������㣬�һ�ʧ�ܣ��뷵�ء�',
	'extcredits_dataerror' => '�һ�ʧ�ܣ��������Ա��ϵ��',
	'domain_be_retained' => '���趨��������ϵͳ��������ѡ����������',
	'not_enabled_this_feature' => 'ϵͳ��û�п���������',
	'space_size_inappropriate' => '����ȷָ��Ҫ�һ����ϴ��ռ��С',
	'space_does_not_exist' => '�Բ�����ָ�����û��ռ䲻���ڡ�',
	'integral_convertible_unopened' => 'ϵͳĿǰû�п������ֶһ�����',
	'two_domain_have_been_occupied' => '���õĶ��������Ѿ�����ʹ����',
	'only_two_names_from_english_composition_and_figures' => '���õĶ���������Ҫ��Ӣ����ĸ��ͷ��ֻ��Ӣ�ĺ����ֹ���',
	'two_domain_length_not_more_than_30_characters' => '���õĶ����������Ȳ��ܳ���30���ַ�',
	'old_password_invalid' => '��û���������������������뷵��������д��',
	'no_change' => 'û�����κ��޸�',
	'protection_of_users' => '�ܱ������û���û��Ȩ���޸�',

	//source/cp_sendmail.php
	'email_input' => '����û���������䣬����<a href="cp.php?ac=profile&op=contact">��ϵ��ʽ</a>��׼ȷ��д��������',
	'email_check_sucess' => '�������䣨\\1����֤���������',
	'email_check_error' => '�������������֤���Ӳ���ȷ���������ڸ�������ҳ�棬���½����µ�������֤���ӡ�',
	'email_check_send' => '��֤����ļ��������Ѿ����͵����ղ���д������,�����ڼ�����֮���յ������ʼ�����ע����ա�',
	'email_error' => '��д�������ʽ����,��������д',

	//source/cp_theme.php
	'theme_does_not_exist' => 'ָ���ķ�񲻴���',
	'css_contains_elements_of_insecurity' => '���ύ�����ݺ��в���ȫԪ��',

	//source/cp_upload.php
	'upload_images_completed' => '�ϴ�ͼƬ�����',

	//source/cp_thread.php
	'to_login' => '����Ҫ�ȵ�¼���ܼ���������',
	'settings_of_your_mtag' => '����Ⱥ����ܷ����⣬����Ҫ������һ�����Ⱥ�顣<br>ͨ��Ⱥ�飬�����Խ�ʶ��������ͬѡ������ѣ�������һ�������⡣<br><br><a href="cp.php?ac=mtag" class="submit">�����ҵ�Ⱥ��</a>',
	'first_select_a_mtag' => '������Ӧ��ѡ��һ��Ⱥ����ܷ����⡣<br><br><a href="cp.php?ac=mtag" class="submit">�����ҵ�Ⱥ��</a>',
	'no_mtag_allow_thread' => '��ǰ������Ⱥ������������㣬�����ܽ��з����������<br><br><a href="cp.php?ac=mtag" class="submit">�����ҵ�Ⱥ��</a>',
	'mtag_close' => 'ѡ���Ⱥ���Ѿ������������ܽ��б�����',

	//source/space_album.php
	'to_view_the_photo_does_not_exist' => '�������ˣ���Ҫ�鿴����᲻����',

	//source/space_blog.php
	'view_to_info_did_not_exist' => '�������ˣ���Ҫ�鿴����Ϣ�����ڻ����Ѿ���ɾ��',

	//source/space_pic.php
	'view_images_do_not_exist' => '��Ҫ�鿴��ͼƬ������',

	//source/mt_thread.php
	'topic_does_not_exist' => 'ָ���Ĺ㲥�粻����',
	'topicforecast_does_not_exist' => 'ָ���Ĺ㲥��Ԥ�治����',
	'topic_threadid_does_not_exist' => 'ָ���Ĺ㲥�绹δ��������̳',
	'topic_quickcomment_author_empty' => '�û���/���������Ϊ��',
	'topic_quickcomment_message_empty' => '�������ݲ���Ϊ��',

	//source/do_inputpwd.php
	'news_does_not_exist' => 'ָ������Ϣ������',
	'proved_to_be_successful' => '��֤�ɹ������ڽ���鿴ҳ��',
	'password_is_not_passed' => '�������վ��¼���벻��ȷ,�뷵������ȷ��',



	//source/do_login.php
	'login_success' => '��¼�ɹ��ˣ����������������¼ǰҳ�� \\1',
	'not_open_registration' => '�ǳ���Ǹ����վĿǰ��ʱ������ע��',
	'not_open_registration_invite' => '�ǳ���Ǹ����վĿǰ��ʱ�������û�ֱ��ע�ᣬ��Ҫ�к����������Ӳ���ע��',

	//source/do_lostpasswd.php
	'getpasswd_account_notmatch' => '�����˻�������û��������Email��ַ������ʹ��ȡ�����빦�ܣ����������������Ա��ϵ��',
	'getpasswd_email_notmatch' => '�����Email��ַ���û�����ƥ�䣬������ȷ�ϡ�',
	'getpasswd_send_succeed' => 'ȡ������ķ����Ѿ�ͨ�� Email ���͵����������У�<br />���� 3 ��֮���޸��������롣',
	'user_does_not_exist' => '���û�������',
	'getpasswd_illegal' => '�����õ� ID �����ڻ��Ѿ����ڣ��޷�ȡ�����롣',
	'profile_passwd_illegal' => '����ջ�����Ƿ��ַ����뷵��������д��',
	'getpasswd_succeed' => '�����������������ã���ʹ���������¼��',
	'getpasswd_account_invalid' => '�Բ��𣬴�ʼ�ˡ��ܱ����û�����վ������Ȩ�޵��û�����ʹ��ȡ�����빦�ܣ��뷵�ء�',
	'reset_passwd_account_invalid' => '�Բ��𣬴�ʼ�ˡ��ܱ����û�����վ������Ȩ�޵��û�����ʹ���������ù��ܣ��뷵�ء�',

	//source/do_register.php
	'registered' => 'ע��ɹ��ˣ�������˿ռ�',
	'system_error' => 'ϵͳ����δ�ҵ�UCenter Client�ļ�',
	'password_inconsistency' => '������������벻һ��',
	'profile_passwd_illegal' => '����ջ�����Ƿ��ַ�����������д��',
	'user_name_is_not_legitimate' => '�û������Ϸ�',
	'include_not_registered_words' => '�û�������������ע��Ĵ���',
	'user_name_already_exists' => '�û����Ѿ�����',
	'email_format_is_wrong' => '��д�� Email ��ʽ����',
	'email_not_registered' => '��д�� Email ������ע��',
	'email_has_been_registered' => '��д�� Email �Ѿ���ע��',
	'regip_has_been_registered' => 'ͬһ��IP�� \\1 Сʱ��ֻ��ע��һ���˺�',
	'register_error' => 'ע��ʧ��',

	//tag.php
	'tag_does_not_exist' => 'ָ���ı�ǩ������',

	//cp_poke.php
	'poke_success' => '�Ѿ����ͣ�\\1�´η���ʱ���յ�֪ͨ',
	'mtag_minnum_erro' => '��Ⱥ���Ա������ \\1 ���������ܽ��б�����',

	//source/function_common.php
	'information_contains_the_shielding_text' => '�Բ��𣬷�������Ϣ�а���վ�����ε�����',
	'site_temporarily_closed' => 'վ����ʱ�ر�',
	'ip_is_not_allowed_to_visit' => '���ܷ��ʣ�����ǰ��IP����վ��������ʵķ�Χ�ڡ�',
	'no_data_pages' => 'ָ����ҳ���Ѿ�û��������',
	'length_is_not_within_the_scope_of' => '��ҳ����������ķ�Χ��',

	//source/function_block.php
	'page_number_is_beyond' => 'ҳ���Ƿ񳬳���Χ',
	//source/function_cp.php
	'incorrect_code' => '�������֤�벻����������ȷ��',

	//source/function_space.php
	'the_space_has_been_closed' => '��Ҫ���ʵĿռ��ѱ�ɾ����������������ϵ����Ա',

	//source/network_album.php
	'search_short_interval' => '�����������̫�̣���ȴ� \\1 ��������� (<a href="\\2">��������</a>)',
	'set_the_correct_search_content' => '�Բ�����������ȷ�Ĳ�������',

	//source/space_share.php
	'share_does_not_exist' => 'Ҫ�鿴�ķ�������',

	//source/space_tag.php
	'tag_locked' => '��ǩ�Ѿ�������',

	'invite_error' => '�޷���ȡ���������룬��ȷ�����Ƿ����㹻�Ļ��������б�����',
	'invite_code_error' => '�Բ��������ʵ��������Ӳ���ȷ����ȷ�ϡ�',
	'invite_code_fuid' => '�Բ��������ʵ����������Ѿ�������ʹ���ˡ�',

	//source/do_invite.php
	'should_not_invite_your_own' => '�Բ���������ͨ�������Լ������������������Լ���',
	'close_invite' => '�Բ���ϵͳ�Ѿ��ر��˺������빦��',

	'field_required' => '���������еı�����Ŀ��\\1�� ����Ϊ�գ���ȷ��',
	'friend_self_error' => '�Բ��������ܼ��Լ�Ϊ����',
	'change_friend_groupname_error' => 'ָ���ĺ����û��鲻�ܱ�����',

	'mtag_not_allow_to_do' => '�����Ǹû�������Ⱥ��ĳ�Ա��û��Ȩ�޽��б�����',

	//cp_task
	'task_unavailable' => '��Ҫ������н����񲻴��ڻ��߻�û�п�ʼ���޷���������',
	'task_maxnum' => '��Ҫ������н������Ѿ��������������������ˣ��������Զ�ʧЧ',
	'update_your_mood' => '���ȸ���һ�������ڵ�����״̬��',

	'gift_unavailable' => '�����Ʒ�����Ѿ�ȡ���ˡ�',
	'gift_maxnum' => '�����Ʒ�Ѿ���������������,�Ժ����ɡ�����',

	'showcredit_error' => '��д��������Ҫ����0������С�����Ļ���������ȷ��',
	'showcredit_fuid_error' => '��ָ�����û���������ĺ��ѣ���ȷ��',
	'showcredit_do_success' => '���Ѿ��ɹ������ϰ���֣��Ͽ�鿴�Լ�������������',
	'showcredit_friend_do_success' => '���Ѿ��ɹ����ͺ����ϰ���֣����ѻ��յ�֪ͨ��',

	'submit_invalid' => '����������·����ȷ�����֤���������޷��ύ���볢��ʹ�ñ�׼��web��������в�����',
	'no_privilege_my_status' => '�Բ��𣬵�ǰվ���Ѿ��ر����û���Ӧ�÷���',
	'no_privilege_myapp' => '�Բ��𣬸�Ӧ�ò����ڻ��ѹرգ�������<a href="cp.php?ac=userapp&my_suffix=%2Fapp%2Flist">ѡ������Ӧ��</a>',

	'report_error' => '�Բ�������ȷָ��Ҫ�ٱ��Ķ���',
	'report_success' => '��л���ľٱ������ǻᾡ�촦��',
	'manage_no_perm' => '��ֻ�ܶ��Լ���������Ϣ���й���<a href="javascript:;" onclick="hideMenu();">[�ر�]</a>',
	'repeat_report' => '�Բ����벻Ҫ�ظ��ٱ�',
	'the_normal_information' => 'Ҫ�ٱ��Ķ��󱻹���Ա��Ϊû��Υ�棬����Ҫ�ٴξٱ���',
	'report_does_not_exist' => '��Ͷ�߲����ڻ��ѱ�ɾ��',
	'report_process_state_error' => '��Ͷ��״̬������',
	'report_process_state_check_error' => '����Ȩ������Ͷ��״̬',
	'friend_ignore_next' => '�ɹ������û� \\1 �ĺ������룬����������һ��������(<a href="cp.php?ac=friend&op=request">ֹͣ</a>)',
	'friend_addconfirm_next' => '���Ѿ��� \\1 ��Ϊ�˺��ѣ�����������һ������������(<a href="cp.php?ac=friend&op=request">ֹͣ</a>)',

	//source/cp_event.php
	'event_title_empty'=>'��ļ���Ʋ���Ϊ��',
	'event_typeid_empty'=>'����ѡ����ļ�����',
	'event_classid_empty'=>'����ѡ����ļ��Ա����',
	'event_location_empty'=>'����ѡ���ص�',
	'event_city_empty'=>'����ѡ����ļ�����',
	'event_detail_empty'=>'������д��ļ�����',
	'event_bad_time_range'=>'��ļ�����ʱ�䲻�ܳ���60��',
	'event_bad_endtime'=>'��ļ�����ʱ�䲻�����ڿ�ʼʱ��',
	'event_bad_deadline'=>'��ļ�������ֹʱ�䲻��������ļ�����ʱ��',
	'event_bad_starttime'=>'��ļ���ʼʱ�䲻����������',
	'event_already_full'=>'����ļ�������������',
	'event_will_full' => '������������ļ�������������',
	'no_privilege_add_event'=>'��û��Ȩ�޷�������ļ',
	'no_privilege_edit_event'=>'��û��Ȩ�ޱ༭�����ļ�����Ϣ',
	'no_privilege_manage_event_members' =>'��û��Ȩ�޹��������ļ��ĳ�Ա',
	'no_privilege_manage_event_comment' => '��û��Ȩ�޹��������ļ�������',
	'no_privilege_manage_event_pic' => '��û��Ȩ�޹��������ļ������',
	'no_privilege_do_eventinvite' =>'��û��Ȩ�޷�����ļ�����',
	'event_does_not_exist'=>'��ļ������ڻ��ѱ�ɾ��',
	'event_create_failed'=>'������ļ�ʧ�ܣ���������������Ϣ',
	'event_need_verify'=>'��ļ������ɹ����ȴ�����Ա���',
	'upload_photo_failed'=>'�ϴ���ļ�����ʧ��',
	'choose_right_eventmember'=>'��ѡ����ʵ���ļ���Ա���в���',
	'choose_event_pic'=>'��ѡ����ļ���Ƭ',
	'only_creator_can_set_admin'=>'ֻ�д����߿�������������֯��',
	'event_not_set_verify'=>'��ļ�����Ҫ���',
	'event_join_limit'=>'����ļ�ֻ��ͨ��������ܼ���',
	'cannot_quit_event'=>'�������˳���ļ�����Ϊ����û�м�����ļ��������������ļ��ķ�����',
	'event_not_public'=>'����һ���ǹ�����ļ���ֻ��ͨ��������ܲ鿴',
	'no_privilege_do_event_invite' => '����ļ������û��������',
	'event_under_verify' => '����ļ����������',
	'cityevent_under_condition' => 'Ҫ���ͬ����ļ�����Ҫ���������ľ�ס��',
	'event_is_over' => '����ļ��Ѿ�����',
	'event_meet_deadline'=>'��ļ��Ѿ���ֹ����',
	'bad_userevent_status'=>'��ѡ����ȷ����ļ���Ա״̬',
	'event_has_followed'=>'���Ѿ���ע�˴���ļ�',
	'event_has_joint'=>'���Ѿ������˴���ļ�',
	'event_is_closed'=>'��ļ��Ѿ��ر�',
	'event_only_allows_members_to_comment'=>'����ļֻ������ļ���Ա��������',
	'event_only_allows_admins_to_upload'=>'����ļֻ����֯�߿����ϴ���Ƭ',
	'event_only_allows_members_to_upload'=>'ֻ���Ѽ����Ա�����ϴ���ļ��Ƭ',
	'eventinvite_does_not_exist'=>'��û�и���ļ����ļ�����',
	'event_can_not_be_opened' => '����ļ����ڲ��ܱ�����',
	'event_can_not_be_closed' => '����ļ����ڲ��ܱ��ر�',
	'event_only_allows_member_thread' => 'ֻ���Ѽ����Ա���ܷ����ظ���ļ����',
	'event_mtag_not_match' => 'ָ��Ⱥ��û�й���������ļ�',
	'event_memberstatus_limit' => '����ļΪ˽����ļ���ֻ���Ѽ����Ա���ܷ���',
	'choose_event_thread' => '��ѡ������һ����ļ�������в���',

	//source/cp_magic.php
	'magicuse_success' => '����ʹ�óɹ���',
	'unknown_magic' => 'ָ���ĵ��߲����ڻ��ѱ���ֹʹ��',
	'choose_a_magic' => '��ѡ��һ������',
	'magic_is_closed' => '�˵����ѱ�����',
	'magic_groupid_not_allowed' => '�����ڵ��û���û��Ȩ��ʹ�õ���',
	'input_right_buynum' => '����ȷ����Ҫ���������',
	'credit_is_not_enough' => '���Ļ��ֲ�������˵���',
	'not_enough_storage' => '���߿�������㣬�´β���ʱ���� \\1',
	'magicbuy_success' => '���߹���ɹ������ѻ��� \\1',
	'magicbuy_success_with_experence' => '���߹���ɹ������ѻ��� \\1, ���Ӿ��� \\2',
	'bad_friend_username_given' => '����ĺ�������Ч',
	'has_no_more_present_magic' => '����û�е���ת�����֤��<a id="a_buy_license" href="cp.php?ac=magic&op=buy&mid=license" onclick="ajaxmenu(event, this.id, 1)">����ȥ����</a>',
	'has_no_more_magic' => '����û�е��� \\1��<a id="\\2" href="\\3" onclick="ajaxmenu(event, this.id, 1)">���̹���</a>',
	'magic_can_not_be_presented' => '�˵��߲��ܱ�����',
	'magicpresent_success' => '�ѳɹ��� \\1 �����˵���',
	'magic_store_is_closed' => '�����̵��Ѿ��ر�',
	'magic_not_used_under_right_stage' => '�˵��߲����ڵ�ǰ����ʹ��',
	'magic_groupid_limit' => '����ǰ���ڵ��û��鲻�ܹ���õ���',
	'magic_usecount_limit' => '�ܵ���ʹ���������ƣ������ڻ�����ʹ�ô˵��ߡ�<br>���� \\1 ֮��ʹ��',
	'magicuse_note_have_no_friend' => '��û���κκ���',
	'magicuse_author_limit' => '�˵���ֻ�ܶ��Լ���������Ϣʹ��',
	'magicuse_object_count_limit' => '�˵��߶�ͬһ��Ϣʹ�ô����Ѵﵽ���ޣ�\\1 �Σ�',
	'magicuse_object_once_limit' => '�Ѿ��Ը���Ϣʹ�ù��˵��ߣ������ظ�ʹ��',
	'magicuse_bad_credit_given' => '������Ļ�������Ч',
	'magicuse_not_enough_credit' => '������Ļ�������������ǰӵ�еĻ���',
	'magicuse_bad_chunk_given' => '������ĵ��ݻ�������Ч',
	'magic_gift_already_given_out' => '����Ѿ���������',
	'magic_got_gift' => '���Ѿ���ȡ���˺�������� \\1 ������',
	'magic_had_got_gift' => '���Ѿ���ȡ���˴κ����',
	'magic_has_no_gift' => '��ǰ�ռ�û�����ú��',
	'magicuse_object_not_exist' => '���ߵ����ö��󲻴���',
	'magicuse_bad_object' => 'û����ȷѡ�����Ҫ���õĶ���',
	'magicuse_condition_limit' => '���ߵķ�����������',
	'magicuse_bad_dateline' => '�����ʱ����Ч',
	'magicuse_not_click_yet' => '����û�жԸ���Ϣ��̬��',
	'not_enough_coupon' => '����ȯ��Ŀ����',
	'magicuse_has_no_valid_friend' => '����ʹ��ʧ�ܣ�û���κκϷ��ĺ���',
	'magic_not_hidden_yet' => '�����ڲ�������״̬',
	'magic_not_for_sale' => '�˵��߲���ͨ��������',
	'not_set_gift' => '����ǰû�����ú��',
	'not_superstar_yet' => '�������ǳ�������',
	'no_flicker_yet' => '����û�жԴ���Ϣʹ�òʺ���',
	'no_color_yet' => '����û�жԴ���Ϣʹ�ò�ɫ��',
	'no_frame_yet' => '����û�жԴ���Ϣʹ�����',
	'no_bgimage_yet' => '����û�жԴ���Ϣʹ����ֽ',
	'bad_buynum' => '������Ĺ�����Ŀ����',

	'feed_no_found' => 'ָ��Ҫ�鿴�Ķ�̬������',
	'not_open_updatestat' => 'վ��û�п�������ͳ�ƹ���',
	
	'repaste_does_not_exist'=>'�ü�¼�����ڻ��ѱ�ɾ��',
	'repaste_classid_empty'=>'ת�����Ͳ���Ϊ��',
	'repaste_subject_empty'=>'ת�����ⲻ��Ϊ��',
	'repaste_message_empty'=>'ת�����ݲ���Ϊ��',
	
	'topic_recommand_does_not_exist'=>'�ü�¼�����ڻ��ѱ�ɾ��',
	'topic_recommand_topic_empty'=>'�㲥��ID����Ϊ��',
	'topic_recommand_startdate_empty'=>'�㲥���Ƽ���ʼʱ�䲻��Ϊ��',

	'cvweibo_does_not_exist'=>'�ü�¼�����ڻ��ѱ�ɾ��',
	'cvweibo_name_empty'=>'CV������Ϊ��',
	'cvweibo_weibo_empty'=>'CV΢��������Ϊ��',
	'cvweibo_url_empty'=>'΢����ַ����Ϊ��',
	'cvweibo_namecheck_ok'=>'��CV������ʹ��',
	'cvweibo_namecheck_failure'=>'ϵͳ�Ѵ��ڸ�CV��',


	'topic_album_does_not_exist'=>'�ü�¼�����ڻ��ѱ�ɾ��',
	'topic_album_topic_empty'=>'�㲥��ID����Ϊ��',
	'topic_album_startdate_empty'=>'�㲥���Ƽ���ʼʱ�䲻��Ϊ��',

	'topic_subject_error' => '���ⳤ�Ȳ�Ҫ����4���ַ�',
	'topic_no_found' => 'ָ��Ҫ�鿴�Ĺ㲥�粻����',
	'topic_does_not_exist'=>'�㲥�粻���ڻ��ѱ�ɾ��',
	'topic_under_verify' => '�˹㲥�����������',
	'topic_over_verify' => '�˹㲥���ѱ����',
	'topic_list_none' => 'Ŀǰ��û�п��Բ���Ĺ㲥��',
	'ajax_param' => '\\1,\\2,\\3,\\4,\\5,\\6,\\7,\\8,\\9',

	'topic_uid_empty'=>'������ID����Ϊ��',
	'topic_username_empty'=>'��������������Ϊ��',
	'topic_subject_empty'=>'��������Ϊ��',
	'topic_message_empty'=>'��Ʒ��鲻��Ϊ��',
	'topic_pic_empty'=>'���ղ���Ϊ��',
	'topic_product_empty'=>'��Ʒ����Ϊ��',
	'topic_product_exists'=>'ָ������Ʒ�ļ��Ѵ���',
	'topic_product_not_exists'=>'��Ʒ�ļ�������',
	'topic_productclassid_empty'=>'��Ʒ���Ͳ���Ϊ��',
	'topic_club_empty'=>'�����ŶӲ���Ϊ��',
	'topic_director_empty'=>'���ݲ���Ϊ��',
	'topic_writer_empty'=>'��粻��Ϊ��',
	'topic_cast_empty'=>'CAST����Ϊ��',
	'topic_producer_empty'=>'������������Ϊ��',
	'topic_dateline_empty'=>'����ʱ�䲻��Ϊ��',
	'topic_auditstate_empty'=>'���ͨ������Ϊ��',
	'topic_auditdate_empty'=>'���ʱ�䲻��Ϊ��',
	'topic_auditmessage_empty'=>'�����ע����Ϊ��',
	'topic_thread_not_exists'=>'�㲥��������Ӳ�����',
	'topic_post_not_exists'=>'�㲥���������������',
	'topic_pic_unmatched'=>'�����޷���Ӧ\\1,\\2',


	'topic_album_subject_empty'=>'ר��������Ϊ��',
	'topic_album_message_empty'=>'��Ʒ��鲻��Ϊ��',
	'topic_album_pic_empty'=>'���ղ���Ϊ��',
	'topic_album_productclassid_empty'=>'��Ʒ���Ͳ���Ϊ��',
	'topic_album_club_empty'=>'�����ŶӲ���Ϊ��',
	'topic_album_director_empty'=>'���ݲ���Ϊ��',
	'topic_album_writer_empty'=>'��粻��Ϊ��',
	'topic_album_cast_empty'=>'CAST����Ϊ��',
	'topic_album_producer_empty'=>'������������Ϊ��',
	'topic_album_dateline_empty'=>'���ʱ�䲻��Ϊ��',
	
	'topicattachment_does_not_exist'=>'�ù㲥����Դ�����ڻ��ѱ�ɾ��',
	'topicattachment_uid_empty'=>'������ID����Ϊ��',
	'topicattachment_username_empty'=>'��������������Ϊ��',
	'topicattachment_subject_empty'=>'��Դ���Ʋ���Ϊ��',
	'topicattachment_message_empty'=>'��Դ��������Ϊ��',
	'topicattachment_attachment_empty'=>'��Դ�ļ�����Ϊ��',
	'topicattachment_productclassid_empty'=>'��Դ���Ͳ���Ϊ��',
	
	'cover_uid_empty'=>'������ID����Ϊ��',
	'cover_username_empty'=>'��������������Ϊ��',
	'cover_subject_empty'=>'������Ʒ������Ϊ��',
	'cover_product_empty'=>'������Ʒ����Ϊ��',
	'cover_message_empty'=>'��Ʒ�����ܲ���Ϊ��',
	'cover_productclassid_empty'=>'��Ʒ���Ͳ���Ϊ��',
	'cover_club_empty'=>'�����ŶӲ���Ϊ��',
	'cover_does_not_exist'=>'�÷�����Ʒ�����ڻ��ѱ�ɾ��',


	'video_uid_empty'=>'������ID����Ϊ��',
	'video_username_empty'=>'��������������Ϊ��',
	'video_subject_empty'=>'��Ƶ��Ʒ������Ϊ��',
	'video_product_empty'=>'��Ƶ��Ʒ����Ϊ��',
	'video_message_empty'=>'��Ʒ�����ܲ���Ϊ��',
	'video_productclassid_empty'=>'��Ʒ���Ͳ���Ϊ��',
	'video_club_empty'=>'�����ŶӲ���Ϊ��',
	'video_does_not_exist'=>'����Ƶ��Ʒ�����ڻ��ѱ�ɾ��',

	'event_subject_empty'=>'��ļ���Ʋ���Ϊ��',

	'tone_does_not_exist'=>'�����߲����ڻ��ѱ�ɾ��',
	'tone_uid_empty'=>'������ID����Ϊ��',
	'tone_username_empty'=>'��������������Ϊ��',
	'tone_label_empty'=>'��ǩ����Ϊ��',
	'tone_description_empty'=>'��Ʒ��鲻��Ϊ��',
	'tone_file_empty'=>'������Ʒ����Ϊ��',
	'tone_classid_empty'=>'�������Ͳ���Ϊ��',
	'tone_reach_max_size'=>'Ŀǰ��վֻ�����û�����ϴ�10�����ߣ���չ�ֳ����Լ���õ���Ʒ�ɡ�',
	'tone_file_exists'=>'ָ���������ļ��Ѵ���',
	'tone_file_empty'=>'�����ļ�����Ϊ��',
	'tone_file_not_exists'=>'�����ļ�������',
	
	'resume_does_not_exist'=>'�ü�����Ϣ�����ڻ��ѱ�ɾ��',
	'resume_producttype_empty'=>'��Ʒ���಻��Ϊ��',
	'resume_uid_empty'=>'������ID����Ϊ��',
	'resume_jobid_empty'=>'�����ߵ���ְ����Ϊ��',
	'resume_productname_empty'=>'��Ʒ������Ϊ��',
	'resume_club_empty'=>'�������Ų���Ϊ��',
	'resume_introduce_empty'=>'���ҽ��ܲ���Ϊ��',


	'mtag_name_exist'=>'��Ⱥ�������ѱ�ʹ��',
	'mtag_name_empty'=>'Ⱥ�����Ʋ���Ϊ��',
	'mtag_fieldid_empty'=>'Ⱥ�����Ͳ���Ϊ��',
	'mtag_announcement_empty'=>'Ⱥ�鹫�治��Ϊ��',
	'mtag_dateline_empty'=>'����ʱ�䲻��Ϊ��',
	'mtag_pic_empty'=>'����������Ϊ��',
	'mtag_fieldid_unidentitied'=>'Ⱥ�������޷�ʶ��',
	'mtag_not_exist'=>'��Ⱥ�鲻����',
	'mtag_state_not_auditpass'=>'��Ⱥ��δͨ�����',
	'mtag_member_not_exist'=>'��Ⱥ���Ա������',
	'mtag_id_empty'=>'Ⱥ��ID����Ϊ��',
	'mtag_member_realname_empty'=>'��Ա������Ϊ��',
	'mtag_memeber_user_does_not_exist' => '�ó�Ա��δע��',
	'mtag_member_classid_empty'=>'Ⱥ���Աְ�����Ͳ���Ϊ��',
	'mtag_member_gradeid_empty'=>'Ⱥ���ԱȨ�����Ͳ���Ϊ��',
	'mtag_fans_gradeid_empty'=>'��˿Ȩ�������޷�ʶ��',
	'mtag_member_quit_grade_error'=>'Ⱥ��/��Ⱥ�������Լ��˳�Ⱥ��',
	'mtag_member_gradeid_error'=>'Ⱥ���ԱȨ�����ʹ���',
	'mtag_member_creatorid_error'=>'Ⱥ��������ע���Ա',
	'mtag_member_iscreator_error'=>'Ⱥ����Ա��Ϣ�����޸�',
	'mtag_product_not_exist'=>'����Ʒ������',
	'mtag_product_type_empty'=>'����Ʒ���಻��Ϊ��',
	'mtag_product_name_empty'=>'����Ʒ���Ʋ���Ϊ��',
	'mtag_task_not_exist'=>'�ó�Ա���񲻴���',
	'mtag_task_id_empty'=>'�ó�Ա�����Ų���Ϊ��',
	'mtag_task_classid_empty'=>'�ó�Ա�������Ͳ���Ϊ��',
	'mtag_task_subject_empty'=>'�ó�Ա�������Ʋ���Ϊ��',
	'mtag_task_name_empty'=>'�ó�Ա�������Ʋ���Ϊ��',
	'mtag_task_importance_empty'=>'�ó�Ա������Ҫ������Ϊ��',
	'mtag_task_description_empty'=>'�ó�Ա����˵������Ϊ��',
	'mtag_task_nextstep_empty'=>'��ѡ���²�����',
	'mtag_task_starttime_empty'=>'������ʼʱ�䲻��Ϊ��',
	'mtag_task_endtime_empty'=>'���������ʱ�䲻��Ϊ��',
	'mtag_task_starttime_should_before_endtime'=>'��ʼʱ�䲻�����ڽ���ʱ��',
	'mtag_injectcredit_lessexperience'=>'��ľ���ȼ���δ�ﵽҪ��<a href="cp.php?ac=credit&op=usergroup" target="_blank">�ϱ�������</a>��,����Ŭ�������ɡ�',
	'mtag_injectcredit_creditinvalid'=>'��ľ������������0',
	'mtag_injectcredit_creditrunlow'=>'��ľ�����������ĸ����ʲ�',

	'advertisement_not_exist'=>'��վ��������Ʒ������',
	'mtag_credit_not_enough'=>'��Ⱥ����ʽ���',
	'advertisement_credit_should_larger'=>'��ֻ�����Ӹ�վ��������Ʒ��Ͷ���ʽ�',
	'advertisement_credit_empty'=>'��վ��������Ʒ��Ͷ���ʽ���������',
	'advertisement_weight_empty'=>'��վ��������Ʒ��չ�ֻ������������',
	'advertisement_credit_empty'=>'��վ��������Ʒ��Ͷ���ʽ���������',
	'advertisement_location_empty'=>'��ѡ���վ��������Ʒ��չ��λ��',
	'advertisement_description_empty'=>'��վ��������Ʒ������˵������Ϊ��',
	'advertisement_subject_empty'=>'վ��������Ʒ������Ϊ��',
	'advertisement_fromdate_empty'=>'վ��������Ʒ��ʼʱ�䲻��Ϊ��',
	'advertisement_todate_empty'=>'վ��������Ʒ����ʱ�䲻��Ϊ��',
	'advertisement_fromdatetodate'=>'վ��������Ʒ��ʼʱ�䲻�����ڽ���ʱ��',

	'advertisement_item_not_exist'=>'��վ��������Ʒ��ָ��ҳǩ������',
	'advertisement_id_empty'=>'��վ��������Ʒ��Ų���Ϊ��',
	'advertisement_item_tab_classid_empty'=>'��վ��������Ʒҳǩ�����Ͳ���Ϊ��',
	'advertisement_item_tab_name_empty'=>'��վ��������Ʒҳǩ����ʾ���Ʋ���Ϊ��',
	'advertisement_item_message_empty'=>'��վ��������Ʒҳǩ���Զ�����ҳ���ݲ���Ϊ��',
	'advertisement_item_pic_empty'=>'��վ��������Ʒҳǩ����ҳ��������Ϊ��',
	'advertisement_item_video_empty'=>'��վ��������Ʒҳǩ����Ƶ���Ӳ���Ϊ��',
	'advertisement_item_relatedtopicid_empty'=>'��վ��������Ʒҳǩ�Ĺ㲥����Ʒ��������Ϊ��',
	'advertisement_item_relatedvideoid_empty'=>'��վ��������Ʒҳǩ����Ƶ��Ʒ��������Ϊ��',
	'advertisement_item_relatedmtagid_empty'=>'��վ��������Ʒҳǩ��Ⱥ����Ʒ��������Ϊ��',
	'advertisement_item_relatedtopicalbumid_empty'=>'��վ��������Ʒҳǩ�Ĺ㲥��ר����������Ϊ��',
	'advertisement_itemlist_empty'=>'��վ��������Ʒҳǩ��Ϊ��',
	'advertisement_item_tab_index_error'=>'��վ��������Ʒҳǩ��ʾλ���趨����ȷ',

	'mtag_thread_not_exist'=>'�û��ⲻ����',
	'username_empty'=>'�û�������Ϊ��',
	'mtag_thread_subject_empty'=>'�û�����ⲻ��Ϊ��',
	'mtag_thread_label_empty'=>'����������һ���ؼ��ֱ�ǩ',
	'mtag_thread_threadclassid_empty'=>'�û������Ͳ���Ϊ��',
	'mtag_thread_title_empty'=>'�û�����ⲻ��Ϊ��',
	'mtag_thread_subject_not_too_little' => '���ⲻ������2���ַ�',
	'posting_does_not_exist' => 'ָ���Ļ���ظ�������',
	'posting_be_deleted' => 'ָ���Ļ���ظ��ѱ�����',
	'posting_relatedpost_does_not_exist' => '���õĻ���ظ�������',
	'posting_relatedpost_be_deleted' => '���õĻ���ظ��ѱ�����',
	'posting_fakename_empty' => '����ظ����������Ϊ��',
	'choosing_to_operate_the_thread' => '��ѡ��Ҫ����Ļ���',

	'apply_submit_success' => '�����ύ�ɹ�����ȴ���ˡ�',
	'space_has_been_locked' => '�ռ��ѱ������޷����ʣ�������������ϵ����Ա',

	'postnote_not_exist'=>'����ʿ������',
	'postnote_id_empty'=>'����ʿ��Ų���Ϊ��',
	'postnote_uid_empty'=>'��ʿ�������߲���Ϊ��',
	'postnote_fromuid_empty'=>'��ʿ�����߲���Ϊ��',
	'postnote_importance_empty'=>'����ʿ��Ҫ������Ϊ��',
	'postnote_subject_empty'=>'����ʿ���Ʋ���Ϊ��',
	'postnote_description_empty'=>'����ʿ˵������Ϊ��',
	'postnote_notedate_empty'=>'����ʿ�������ڲ���Ϊ��',
	
	'announcement_does_not_exist'=>'��ȫվ���治����',
	'announcement_message_empty'=>'ȫվ���治��Ϊ��',
	'announcement_startdate_empty'=>'��ʼʱ�䲻��Ϊ��',

	'radio_does_not_exist' => 'ָ���ĵ�̨��Ŀ������',
	'radio_threadid_does_not_exist' => 'ָ���ĵ�̨��Ŀ��δ��������̳',
	'radio_subject_empty'=>'�õ�̨��Ŀ���Ʋ���Ϊ��',
	'radio_file_empty'=>'�õ�̨��Ŀ��Ƶ����Ϊ��',
	'radio_starttime_empty'=>'�õ�̨��Ŀ��ʼʱ�䲻��Ϊ��',
	'radio_endtime_empty'=>'�õ�̨��Ŀ����ʱ�䲻��Ϊ��',


	'site_gift_already_given_out' => '����Ѿ���������',
	'site_got_gift' => '���Ѿ���ȡ���˺��',
	'site_had_got_gift' => '���Ѿ���ȡ���˴κ����',

	'site_gift_unavailable' => '�����������Ѿ�ȡ���ˡ�',
	'site_gift_maxnum' => '�������Ѿ���������������,�Ժ����ɡ�����',

	
);

?>