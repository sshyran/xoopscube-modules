<?php
// $Id: admin.php,v 1.4 2009/11/15 09:51:08 nobu Exp $

define('_AM_FORM_EDIT', '���󥿥��ȥե�������Խ�');
define('_AM_FORM_NEW', '�������󥿥��ȥե�����κ���');
define('_AM_FORM_TITLE', '�ե�����̾');
define('_AM_FORM_MTIME', '��������');
define('_AM_FORM_DESCRIPTION', '����ʸ');
define('_AM_INS_TEMPLATE', '�ƥ�ץ졼�Ȥ��ɲ�');
define('_AM_FORM_ACCEPT_GROUPS', '���ե��롼��');
define('_AM_FORM_ACCEPT_GROUPS_DESC', '���Υե�����Ǽ��դ�Ԥ����롼�פ���ꤷ�ޤ�');
define('_AM_FORM_DEFS', '�ե���������');
define('_AM_FORM_DEFS_DESC', '<a href="help.php#form" target="_blank">����ܺ�</a> <small>��: text checkbox radio textarea select const hidden mail file</small>');
define('_AM_FORM_PRIM_CONTACT', 'ô����');
define('_AM_FORM_PRIM_NONE', 'ô���Ԥʤ�');
define('_AM_FORM_PRIM_DESC', '���Ф���ꤷ����硢ô���Ԥ򤽤Υ��롼�פ������(uid)�ǻ��ꤹ�롣');
define('_AM_FORM_CONTACT_GROUP', 'ô�����롼��');
define('_AM_FORM_CGROUP_NONE', 'ô�����롼�פʤ�');
define('_AM_FORM_STORE', '�ǡ����١�������¸');
define('_AM_FORM_CUSTOM', '����ʸ�ΰ���');
define('_AM_FORM_WEIGHT', 'ɽ����');
define('_AM_FORM_REDIRECT', '�������ɽ���ڡ���');
define('_AM_FORM_OPTIONS', '���ץ�����ѿ�');
define("_AM_FORM_OPTIONS_DESC","�ե���������Ǥ˻��ꤹ��<a href='help.php#attr'>���ץ�����ѿ�</a>�ʤɤ����ꤹ�롣�� <tt>size=60,rows=5,cols=50</tt>");
define('_AM_FORM_ACTIVE', '�ե��������դ���');
define('_AM_DELETE_FORM', '�ե�����������ޤ�');
define('_AM_FORM_LAB', '����̾');
define('_AM_FORM_LABREQ', '����̾�����Ϥ��Ƥ�������');
define('_AM_FORM_REQ','ɬ�ܹ���');
define('_AM_FORM_ADD', '�ɲ�');
define('_AM_FORM_OPTREQ', '������ɬ�פǤ�');
define('_AM_CUSTOM_DESCRIPTION', '0=�̾������ʸ[bb],4=HTML����ʸ[bb],1=�̾�ƥ�ץ졼��,2=���Υƥ�ץ졼��');
define('_AM_CHECK_NOEXIST', '������¸�ߤ��ޤ���');
define('_AM_CHECK_DUPLICATE', '��������ʣ���Ƥ��ޤ�');
define('_AM_DETAIL', '�ܺ�');
define('_AM_OPERATION', '���');
define('_AM_CHANGE','�ѹ�');
define('_AM_SEARCH_USER', '�桼������');

define('_AM_MSG_ADMIN', '��礻����');
define('_AM_MSG_CHANGESTATUS', '���֤ΰ���ѹ�');
define('_AM_SUBMIT', '����');

define('_AM_MSG_COUNT', '���');
define('_AM_MSG_STATUS', '����');
define('_AM_MSG_CHARGE', 'ô����');
define('_AM_MSG_FROM', '�����');
define('_AM_MSG_COMMS', '������');

define('_AM_MSG_WAIT', '�Ԥ�');
define('_AM_MSG_WORK', '���');
define('_AM_MSG_REPLY', '�Ѥ�');
define('_AM_MSG_CLOSE', '��λ');
define('_AM_MSG_DEL', '���');

define('_AM_MSG_CTIME', '��Ͽ����');
define('_AM_MSG_MTIME', '��������');

define('_AM_MSG_UPDATED', '���֤��ѹ����ޤ���');
define('_AM_MSG_UPDATE_FAIL', '�ѹ��˼��Ԥ��ޤ���');

define('_AM_LOGGING','�б�����');

define('_AM_FORM_UPDATED', '�ե������ǡ����١�������¸���ޤ���');
define('_AM_FORM_DELETED', '�ե�����������ޤ���');
define('_AM_FORM_UPDATE_FAIL', '�ե�����ι����˼��Ԥ��ޤ���');
define('_AM_TIME_UNIT', '%dʬ,%d����,%d��,%s ��');
define('_AM_NODATA', '�ǡ���������ޤ���');
define('_AM_SUBMIT_VIEW','��ɽ��');
define('_AM_OPTVARS_SHOW','������ܤ�ɽ������');
define('_AM_OPTVARS_LABEL','notify_with_email=�᡼�륢�ɥ쥹�����Τ�ɽ������
redirect=�ե���������������ܤ���ڡ���
reply_comment=�����᡼����ղä���ʸ
reply_use_comtpl=�ղ�ʸ������᡼��Υƥ�ץ졼�Ȥˤ���
others=����¾���ѿ� (��̾��=�͡פη���)
');

include_once dirname(__FILE__)."/common.php";
?>
