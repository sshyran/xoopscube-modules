<?php

$mydirname = basename( dirname ( dirname ( dirname( __FILE__ ) ) ) ) ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

define($constpref."_NAME","CINEMARU");

// A brief description of this module
define($constpref."_DESC","���Υ⥸�塼���ư��⥸�塼��Ǥ���");
define($constpref."_MODULE_DESCRIPTION","���Υ⥸�塼���ư��⥸�塼��Ǥ���");

// Names of admin menu items
define($constpref."_ADMENU1", "����");
define($constpref."_ADMENU_GROUPPERM", "���롼�פ�����Ū�ʸ���");

define($constpref."_MOVIE_MAX_SIZE", "ư��κ���ե����륵����");
define($constpref."_MOVIE_MAX_DEFAULT", "10485760");

define($constpref."_SUBMIT", "��Ƥ���");

define($constpref.'_TAG_MAX_SIZE', '�����κ���ʸ����');
define($constpref.'_TAG_MAX_DEFAULT', 50);
define($constpref.'_INPUT_TAG', '����̾�����Ϥ��Ƥ�������');
define($constpref.'_NUM_OF_TAG', '��Ĥ�ư����դ����륿����');
define($constpref.'_NUM_OF_TAG_DEFAULT', 10);
define($constpref.'_TAG_ENCODING', '����̾��ʸ��������');
define($constpref.'_TAG_ENCODING_DEFAULT', 'EUC-JP');
define($constpref.'_NUM_OF_THUMB', '�����̤�ɽ�����륵��ͥ���ο�');
define($constpref.'_NUM_OF_THUMB_DEFAULT', '10');
define($constpref.'_THUMB_BGCOLOR', '����ͥ�����طʿ�');
define($constpref.'_THUMB_BGCOLOR_DESC', '����ͥ�����طʿ�����ꤷ�ޤ���#FF8888 �Τ褦�˻��ꤷ�Ƥ�����������ά������طʿ��ϻ��ꤵ��ޤ���');
define($constpref.'_THUMB_BGCOLOR_DEFAULT', '');

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BLOCK_RANDOM", "������ɽ��");
define($constpref."_BLOCK_THUMB", "����ͥ���ɽ��");

// ���ε�ǽ

define($constpref.'_GLOBAL_NOTIFY', '�⥸�塼������');
define($constpref.'_GLOBAL_NOTIFYDSC', '�⥸�塼�����ΤΥ������塼����Ф������Υ��ץ����');

define ($constpref.'_GLOBAL_NEWPOST_NOTIFY', '��Ͽ');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYCAP', '��Ͽ�����ä��������Τ���');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYDSC', '��Ͽ�����ä��������Τ���');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ��Ͽ������ޤ���');

define ($constpref.'_GLOBAL_UPDATE_NOTIFY', '����');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYCAP', '���������ä��������Τ���');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYDSC', '���������ä��������Τ���');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ����������ޤ���');

define($constpref.'_SHOW_USER_ID', 'ư����Υ����Ȥ˥桼��ID���դ���');
define($constpref.'_SHOW_USER_ID_DESC', 'ư����Υ����Ȥ����˥桼��ID���դ��롣');
define($constpref.'_SHOW_USER_ID_DEFAULT', '0');
define($constpref.'_SHOW_USER_ID_OK', '�դ���');
define($constpref.'_SHOW_USER_ID_NG', '�դ��ʤ�');

// name setting
define($constpref.'_NAME_SETTING', '̾��ɽ������');
define($constpref.'_SET_NAME', '������ID');
define($constpref.'_SET_UNAME', '��̾');
define($constpref.'_SET_NAME_AND_UNAME', '������ID����̾');
define($constpref.'_SET_UNAME_OR_NAME', '��̾����������̾��̤����ξ��ϥ�����ID');

// avatar setting
define($constpref.'_SHOW_AVATAR', 'ư����Υ����Ȥ˥��Х�����Ĥ���');
define($constpref.'_SHOW_AVATAR_DEFAULT', '0');
define($constpref.'_SHOW_AVATAR_OK', '�դ���');
define($constpref.'_SHOW_AVATAR_NG', '�դ��ʤ�');

define($constpref.'_SHOW_NAME_CLIST', '�����Ȱ�������Ͽ�Ԥ�̾����Ф�');
define($constpref.'_SHOW_NAME_CLIST_DEFAULT', '1');
define($constpref.'_SHOW_NAME_CLIST_OK', '�Ф�');
define($constpref.'_SHOW_NAME_CLIST_NG', '�Ф��ʤ�');

define($constpref.'_GUEST_USER_NAME', '�����ȥ桼����̾��');
define($constpref.'_GUEST_USER_NAME_DEFAULT', 'GUEST');

define($constpref.'_SHOW_NAME_MOVIE', '�������̤���Ͽ�Ԥ�̾����Ф�');
define($constpref.'_SHOW_NAME_MOVIE_DEFAULT', '1');
define($constpref.'_SHOW_NAME_MOVIE_OK', '�Ф�');
define($constpref.'_SHOW_NAME_MOVIE_NG', '�Ф��ʤ�');

define($constpref.'_SHOW_REPORT_LINK', '�������̤˰�ȿ����󥯤�Ф�');
define($constpref.'_SHOW_REPORT_LINK_DEFAULT', '1');
define($constpref.'_SHOW_REPORT_LINK_OK', '�Ф�');
define($constpref.'_SHOW_REPORT_LINK_NG', '�Ф��ʤ�');

define($constpref.'_SP_RANDOM_OK', '������ˤ���');
define($constpref.'_SP_RANDOM_NG', '������ˤ��ʤ�');

define($constpref.'_SP_COMMAND1', '���ڥ���륳�ޥ��1');
define($constpref.'_SP_COMMAND1_DEFAULT', 'star');
define($constpref.'_SP_COMMAND1_URL', '���ڥ���륳�ޥ��1 URL');
define($constpref.'_SP_COMMAND1_URL_DEFAULT', 'star1.swf');
define($constpref.'_SP_COMMAND1_RAND', '���ڥ���륳�ޥ��1 Y���������ˤ���');
define($constpref.'_SP_COMMAND1_RANDOM_DEFAULT', '1');

define($constpref.'_SP_COMMAND2', '���ڥ���륳�ޥ��2');
define($constpref.'_SP_COMMAND2_DEFAULT', 'star2');
define($constpref.'_SP_COMMAND2_URL', '���ڥ���륳�ޥ��2 URL');
define($constpref.'_SP_COMMAND2_URL_DEFAULT', 'star2.swf');
define($constpref.'_SP_COMMAND2_RAND', '���ڥ���륳�ޥ��2 Y���������ˤ���');
define($constpref.'_SP_COMMAND2_RANDOM_DEFAULT', '1');

define($constpref.'_SP_COMMAND3', '���ڥ���륳�ޥ��3');
define($constpref.'_SP_COMMAND3_DEFAULT', 'star3');
define($constpref.'_SP_COMMAND3_URL', '���ڥ���륳�ޥ��3URL');
define($constpref.'_SP_COMMAND3_URL_DEFAULT', 'star3.swf');
define($constpref.'_SP_COMMAND3_RAND', '���ڥ���륳�ޥ��3 Y���������ˤ���');
define($constpref.'_SP_COMMAND3_RANDOM_DEFAULT', '1');

define($constpref.'_RICHTEXT', '��å��ƥ���������');
define($constpref.'_USE_RICHTEXT', 'ͽ�����Ƥ˥�å��ƥ����Ȥ�Ȥ�');
define($constpref.'_USE_PLAINTEXT', 'ͽ�����Ƥ˥ץ쥤��ƥ����Ȥ�Ȥ�');

define($constpref.'_BLOG_PASTE', '�֥�Ž���դ���ǽ');
define($constpref.'_BLOG_PASTE_OK', 'ͭ���ˤ���');
define($constpref.'_BLOG_PASTE_NG', '̵���ˤ���');

define($constpref.'_TOP_MOVIE', '�⥸�塼��ȥåײ��̤�ɽ����������');
define($constpref.'_TOP_MOVIE_DESC', '�⥸�塼��ȥåײ��̤�ư��/MP3�Υǥե���Ȥ�ɽ���������롣���������桼�������򤷤���祯�å����˵�Ͽ���졢���󤫤�Ϥ����餬ͥ�褵��롣');
define($constpref.'_TOP_MOVIE_LIST', '�ꥹ��ɽ��');
define($constpref.'_TOP_MOVIE_THUMB', '����ͥ���ɽ��');
