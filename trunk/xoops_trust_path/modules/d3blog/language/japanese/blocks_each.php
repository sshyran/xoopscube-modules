<?php
/**
 * @version $Id: blocks_each.php 281 2008-02-23 09:49:31Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3blog' ;

$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// calendar
define($constpref.'_LANG_PREVMONTH', '&laquo;');
define($constpref.'_LANG_NEXTMONTH', '&raquo;');
define($constpref.'_LANG_PREVYEAR', '&laquo;');
define($constpref.'_LANG_NEXTYEAR', '&raquo;');
define($constpref.'_LANG_PREVMONTH_TITLE', '���η�');
define($constpref.'_LANG_NEXTMONTH_TITLE', '���η�');
define($constpref.'_LANG_PREVYEAR_TITLE', '����ǯ');
define($constpref.'_LANG_NEXTYEAR_TITLE', '����ǯ');
define($constpref.'_LANG_THIS_MONTH_TITLE', '���η�Υ���������');
define($constpref.'_LANG_SUNDAY', '��');
define($constpref.'_LANG_MONDAY', '��');
define($constpref.'_LANG_TUESDAY', '��');
define($constpref.'_LANG_WEDNESDAY', '��');
define($constpref.'_LANG_THURSDAY', '��');
define($constpref.'_LANG_FRIDAY', '��');
define($constpref.'_LANG_SATURDAY', '��');
// latest entries
define($constpref.'_LANG_CATEGORY', '���ƥ���');
define($constpref.'_LANG_TITLE', '�����ȥ�');
define($constpref.'_LANG_ENTRIES', '�Ƕ�Υ���ȥ�');
define($constpref.'_LANG_ENTRIES_FOR', '%s����Υ���ȥ�');
define($constpref.'_LANG_AUTHOR', '��ɮ��');
define($constpref.'_LANG_COMMENTS', '�����ȿ�');
define($constpref.'_LANG_POSTED', '�����');
define($constpref.'_LANG_COUNTER', '������');
define($constpref.'_LANG_BLOGTOP', '%s�Υȥåפ�');
define($constpref.'_LANG_READMORE', '...³�����ɤ�');
// archives
define($constpref.'_LANG_SORT_ARCHIVE', '�����θ���');
define($constpref.'_LANG_MOREARCHIVES', '���������֤�');
// bloggers list
define($constpref.'_LANG_READ_ENTRIES_OF_BLOGGER', '%s����Υ���ȥ���ɤ�');
// trackback
define($constpref.'_LANG_TRACKBACKS', '�ȥ�å��Хå���'); //eng
define($constpref.'_LANG_TRACKBACKS_FOR', '%s����ؤΥȥ�å��Хå�');
define($constpref.'_LANG_TB_TITLE', '�����ȥ�');
define($constpref.'_LANG_TB_ENTRYTITLE', '�ȥ�å��Хå�����ȥ�');
define($constpref.'_LANG_TB_BLOGNAME', '�֥�̾');
define($constpref.'_LANG_TB_POSTED', '����');
// comments
define($constpref.'_LANG_COM_TITLE', '������');
define($constpref.'_LANG_COM_UNAME', '�桼��');
define($constpref.'_LANG_COM_ENTRYTITLE', '�����ȤΥ���ȥ�');
define($constpref.'_LANG_COM_POSTED', '����');

define($constpref.'_LANG_LINKS_FOR','%s����Υ��');

define($constpref.'_USERS_SORT_READS', '�߷ױ�����');
define($constpref.'_USERS_SORT_UPDATE', '�ǽ�����');

define($constpref.'_SUMMARY_COMMENTS_LIST', '���Υơ��֥�ϥ֥����Ф���ǿ��Υ����Ȥ�����ˤ���ɽ�Ǥ���');
define($constpref.'_SUMMARY_CALENDAR', '���Υơ��֥�����̤���ƥǡ�����̵ͭ�򼨤��֥����������Ǥ����ǯñ�̤�����˰�ư�Ǥ��ޤ���');
define($constpref.'_SUMMARY_LATEST_BLOGS', '���Υơ��֥�Ϻǿ��֥��ΰ�����ɽ�ˤ�����ΤǤ���');
define($constpref.'_SUMMARY_LATEST_CONTENTS', '���Υơ��֥�Ϻǿ��֥��Υ���ƥ�İ�����ɽ�ˤ�����ΤǤ���');
define($constpref.'_SUMMARY_LATEST_TRACKBACKS', '���Υơ��֥�Ϻǿ��ȥ�å��Хå��ΰ�����ɽ�ˤ�����ΤǤ���');
define($constpref.'_SUMMARY_USERS_BLOG', '���Υơ��֥�ϥ桼�����̺ǿ��֥��ΰ�����ɽ�ˤ�����ΤǤ���');

}
?>