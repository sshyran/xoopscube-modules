<?php
# medialinks user side language resources
# $Id: main.php,v 1.4 2006-07-22 05:36:41 nobu Exp $

define("_MD_CONTENT_EDIT", "����ƥ�Ĥ��Խ�");
define("_MD_CONTENT_NEW", "����ƥ�Ĥο�������");

define("_MD_CONTENT_STATUS", "�Ǻܾ���");
define("_MD_VIEW_LIST", "����ɽ��");
define("_MD_VIEW_TOP", "�ȥå�");
define("_MD_VIEW_PAGE", "�ڡ���");
define("_MD_KEY_NONE", "*�ʤ�*");
define("_MD_SEP", " :: ");
define("_MD_KEY_SEP", " - ");
define("_MD_COUNT", "���");
define("_MD_DEL", "���");
define("_MD_URL", "URL");
define("_MD_TITLE", "̾��");
define("_MD_WEIGHT", "��");
define("_MD_NEW", "����");
define("_MD_SAVE", "��¸");
define("_MD_REQUIRE_INPUT", "�����ι��ܤ�ɬ�����Ϥ��Ƥ�������");
define("_MD_PREVIEW", "�ץ�ӥ塼");
define("_MD_DBUPDATED", "�ǡ�������¸���ޤ���");
define("_MD_DBUPDATE_FAIL", "�ǡ�������¸�˼��Ԥ��ޤ���");
define('_MD_CONTENT_STYLE','ɽ������');
define("_MD_CONTENT_DELETE", "���Υ���ƥ�Ĥ������ޤ�");
define("_MD_NOTIFY_SUBJECT", "��������ƥ�Ĥ���Ͽ - {TITLE}");

global $weekname, $monthname, $edit_style, $status_sel;

// Localization Calender Select Widget
define("_MD_CAL_MONTH", "%u��");
define("_MD_CAL_BUTTON", "������");
define("_MD_CAL_MONDAY_FIRST", false);
$weekname = array('Sun'=>'��', 'Mon'=>'��','Tue'=>'��', 'Wed'=>'��',
		  'Thu'=>'��','Fri'=>'��', 'Sat'=>'��');

$monthname = array();
for ($i=1; $i<=12; $i++) {
    $monthname[$i] = sprintf(_MD_CAL_MONTH, $i);
}
$edit_style=array('h'=>'XOOPS �����Τ��Ѵ�',
		  'b'=>'���Ԥ򥿥�&lt;br&gt;���Ѵ�',
		  'n'=>'HTML ������̵���ˤ���');
$status_sel=array('W'=>'��ǧ��',
		  'N'=>'�Ǻ���',
		  'X'=>'��Ǻ�');
?>