<?php
# medialinks admin language resources
# $Id: admin.php,v 1.3.2.1 2008-01-17 11:45:40 nobu Exp $

define("_AM_CONTENTS_ADMIN", "����ƥ�Ĥδ���");
define("_AM_CONTENTS_DEL", "����ƥ�Ĥ������ޤ�");
define("_AM_CONTENTS_NEW", "����ƥ�Ĥο�������");
define("_AM_ATTACH_COUNT", "���/ź��ʸ���");
define("_AM_COMMENT_COUNT", "�����Ȥο�");
define("_AM_PAGE", "�ڡ���");
define("_AM_TITLE", "�����ȥ�");
define("_AM_CTIME", "��������");
define("_AM_MTIME", "��������");
define("_AM_POSTER", "������");
define("_AM_OPERATION", "���");
define("_AM_SORT_ORDER", "ɽ����");
define("_AM_OP_CONF", "�Ǻܾ�ǧ����");
define("_AM_OP_HIDE", "��ɽ���ˤ���");
define("_AM_OP_DEL", "�������");

define("_AM_STATUS", "�Ǻܾ���");
define("_AM_STAT_W_WAIT", "��ǧ��");
define("_AM_STAT_N_NORMAL", "�Ǻ���");
define("_AM_STAT_X_UNUSED", "��Ǻ�");

define("_AM_KEYWORDS_ADMIN", "������ɤδ���");
define("_AM_KEYWORDS_EDIT", "��������Խ�");
define("_AM_KEYWORDS_NEW", "�����������");
define("_AM_KEYWORDS_NAME", "̾��");
define("_AM_KEYWORDS_PARENT", "��̥������");
define("_AM_KEYWORDS_RELAY", "Ϣ�ȥ��� <span class='fontSmall'>(�����ƥ���Τߤ�ͭ��)</span>");
define("_AM_KEYWORDS_DESC", "������");
define("_AM_KEYWORDS_REMOVE", "������ɤκ��");
define("_AM_KEYWORDS_NODETYPE", "�����λȤ�ʬ��");
define("_AM_KEYWORDS_COUNT", "������ɤλ��ѿ�");
define("_AM_KEYWORDS_PRINT", "������ɡ�%s�פ� %u �Ĥλ��Ѥ���Ƥ��ޤ�");

define("_AM_SORT_WEIGHT", "ɽ���� <span class='fontSmall'>(0=��ɽ��)</span>");
define("_AM_KEY_NONE", "�ʤ�");
define("_AM_NODE_BOTH", "���ƥ���ܥ������");
define("_AM_NODE_CATEGORY", "���ƥ���Τ�");
define("_AM_NODE_KEY", "������ɤΤ�");

define("_AM_FIELDS_EDIT", "�ե�������Խ�");
define("_AM_FIELDS_NEW", "�����ե������");
define("_AM_FIELDS_NAME", "̾��");
define("_AM_FIELDS_LABEL", "̾��");
define("_AM_FIELDS_TYPE", "�ǡ�����");
define("_AM_FIELDS_DEF", "������");
define("_AM_FIELDS_SIZE", "ʸ����Ĺ");
define("_AM_FIELDS_OPERATION", "���");
define("_AM_FIELDS_DELETE", "�ե�����ɤκ��");
define("_AM_FIELDS_COUNT", "�ե�����ɤ����ѿ�");
define("_AM_FIELDS_COUNT_NOTICE", "%u��Υǡ�����¸�ߤ��ޤ�");
define("_AM_TYPE_STRING", "ʸ����");
define("_AM_TYPE_INTEGER", "����");
define("_AM_TYPE_DATE", "����");
define("_AM_TYPE_TIMESTAMP", "����");
define("_AM_TYPE_UID", "�桼��ID");
define("_AM_TYPE_TEXT", "�ƥ�����");
define("_AM_TYPE_KEYWORD", "�������");
define("_AM_TYPE_LINK", "���");

global $nodetypes_select, $status_sel;

$nodetypes_select =
    array(0=>_AM_NODE_BOTH,
	  1=>_AM_NODE_CATEGORY,
	  2=>_AM_NODE_KEY);

$status_sel=
    array('W'=>_AM_STAT_W_WAIT,
	  'N'=>_AM_STAT_N_NORMAL,
	  'X'=>_AM_STAT_X_UNUSED);

define("_AM_DBUPDATED", "�������ޤ���");
define("_AM_DBUPDATE_FAIL", "�����˼��Ԥ��ޤ���");

// summary.php
define("_AM_SUMMARY_TITLE", "����������");
define("_AM_SUMMARY_TYPE", "ɽ��������");
define("_AM_LTYPE_MEDIA", "��ǥ���");
define("_AM_LTYPE_DOCUMENT", "ź�եե�����");
define("_AM_LINKNAME", "ʸ��̾");
define("_AM_HITS", "���ȿ�");
define("_AM_COUNT", "���");
define("_AM_EXPORT_CHARSET", "UTF-8");
define("_AM_EXPORT_FILE", "CSV�ե��������");
?>