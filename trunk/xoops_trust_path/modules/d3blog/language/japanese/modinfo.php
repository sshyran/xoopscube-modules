<?php
/**
 * @version $Id: modinfo.php 622 2009-09-06 17:23:01Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3blog' ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// <--- BASIC PROPERTY --->
define ( $constpref.'_BASIC_MODULE_NAME','D3�֥�' );
define ( $constpref.'_BASIC_MODULE_NAME_DSC','D3��Xoops�֥������ƥ�' );

// <--- SUBMENU PROPERTY --->
define ( $constpref.'_SUBMENU_POST','��Ƥ���' );
define ( $constpref.'_SUBMENU_MY_BLOG','�ޥ��֥�' );
define ( $constpref.'_SUBMENU_ARCHIVES','����������' );

// <--- ADMENU PROPERTY --->
define ( $constpref.'_ADMENU_CATEGORY_MANAGER','���ƥ������' );
define ( $constpref.'_ADMENU_PERMISSION_MANAGER','�ѥߥå�������' );
define ( $constpref.'_ADMENU_APPROVAL_MANAGER','��ǧ����' );
define ( $constpref.'_ADMENU_IMPORT_MANAGER','����ݡ���' );
define ( $constpref.'_ADMENU_CSS_MANAGER','CSS�ޥͥ��㡼' );
define ( $constpref.'_ADMENU_MYLANGADMIN','�����������' ) ;
define ( $constpref.'_ADMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���' ) ;
define ( $constpref.'_ADMENU_MYBLOCKSADMIN','�֥�å�����/�⥸�塼�륢����������' ) ;
define ( $constpref.'_ADMENU_MYPREFERENCES','��������' ) ;

// <--- BLOCKS PROPERTY --->
define ( $constpref.'_CALENDAR', '�֥� ��������');
define ( $constpref.'_CALENDAR_DESC', '�����������');
define ( $constpref.'_CATEGORY_LIST', '���ƥ������');
define ( $constpref.'_CATEGORY_LIST_DESC', '����Ĥ����ƥ������');
define ( $constpref.'_ARCHIVE_LIST', '����������');
define ( $constpref.'_ARCHIVE_LIST_DESC', '���������֤θ���');
define ( $constpref.'_LATEST_ENTRIES','�ǿ��Υ���ȥ�');
define ( $constpref.'_LATEST_ENTRIES_DESC','�ǿ�����ȥ�ΰ���');
define ( $constpref.'_LATEST_TRACKBACKS','�ǿ��Υȥ�å��Хå�');
define ( $constpref.'_LATEST_TRACKBACKS_DESC','�Ƕ���������ȥ�å��Хå�����');
define ( $constpref.'_LATEST_COMMENTS','�ǿ��Υ�����');
define ( $constpref.'_LATEST_COMMENTS_DESC','�֥��Υ���ȥ�˺Ƕ��դ���줿������');
define ( $constpref.'_BLOGGERS_LIST', '�֥�������');
define ( $constpref.'_BLOGGERS_LIST_DESC', '�֥����ΰ���');

// <--- CFG PROPERTY --->
define ( $constpref.'_WYSIWYG','���ѥ��ǥ���' );
define ( $constpref.'_WYSIWYG_DSC','FCKeditor��Quicktag��html���¤Τ���桼�����Τ߻��Ѳ�' );
define ( $constpref.'_NO_WYSIWYG','xoops�ǥե����' );
define ( $constpref.'_WYSIWYG_FCK','FCK���ǥ���' );
define ( $constpref.'_WYSIWYG_QUICKTAG','QUICK����' );
define ( $constpref.'_PERM_BY','����ȥ�ñ�̤Ǳ������¤����ꤹ��' );
define ( $constpref.'_PERM_BY_DSC','�ƥ���ȥ������ơ��Խ����˱�����ǽ�ʥ��롼�פ�����Ǥ��ޤ���<br />���������ѥߥå��������Ǳ����ԲĤȤ������롼�פϤ��ä��������Ǥ��ޤ���' );
define ( $constpref.'_PERMED','���Ĥ��륰�롼�פΥǥե����' );
define ( $constpref.'_PERMED_DSC','����ȥ�ñ�̤α������¤����ꤷ�����Υ��롼�׽���ͤǤ���<br /><span style="font-weight:bold">���롼�פ��ɲä������ϡ���˥⥸�塼�륢�åץǡ��Ȥ���ɬ�פ�����ޤ���</span>' );
define ( $constpref.'_EXCERPTOK','�����ȥ롦������ʬ�ϱ�����ǽ' );
define ( $constpref.'_EXCERPTOK_DSC','����ȥ�ñ�̤Ǳ������¤Τʤ����롼�פǤ⡢�����ȥ롦������ʬ�ϱ�����ǽ�ˤʤ�ޤ���' );
define ( $constpref.'_NUMPERPAGE','�ڡ���������ɽ��������' );
define ( $constpref.'_NUMPERPAGE_DSC','�ǿ������ڡ����˰��٤�ɽ�����뵭����' );
define ( $constpref.'_MAX_FEED','RDF�ե����ɵ�����' );
define ( $constpref.'_MAX_FEED_DSC','�ե������׵᤬���ä��Ȥ��ֿ����뵭�����θ��١�' );
define ( $constpref.'_RSSICON','RSS�ե����ɥ��������ɽ������' );
define ( $constpref.'_RSSICON_DSC','ɽ�����ϥƥ�ץ졼���Խ��Ǽ�ͳ�˷��Ƥ���������' );
define ( $constpref.'_AVATAR','�Ƶ����˥��Х���ɽ������' );
define ( $constpref.'_AVATAR_DSC','ɽ����ˡ�ϥƥ�ץ졼���Խ��Ǥ���ͳ�ˡ�' );
define ( $constpref.'_LOGOPATH','�⥸�塼����ե�����Υѥ�' );
define ( $constpref.'_LOGOPATH_DSC','rss�������ڡ����ѡ����Хѥ��ǻ��ꤷ�Ƥ���������' );
define ( $constpref.'_INCREMENT','�֥���Ƥ�桼������ƿ��˲ä���' );
define ( $constpref.'_INCREMENT_DSC','' );
define ( $constpref.'_CAT_ICON','���ƥ��ꥢ��������֤��ǥ��쥯�ȥ�Υѥ�' );
define ( $constpref.'_CAT_ICON_DSC','���Хѥ��ǻ��ꤷ�Ƥ������������������ftp�ġ���ǥ��åפ��ޤ���' );
define ( $constpref.'_URL_CHOICE','����ping�����С�����ƻ����ꤹ��' );
define ( $constpref.'_URL_CHOICE_DSC','��ƻ��˹���ping�����С������򤬲�ǽ�ˤʤ�ޤ���' );
define ( $constpref.'_MAX_URLS','����ping�����С����θ���' );
define ( $constpref.'_MAX_URLS_DSC','�����ǽ�ˤ������Τ����¤��ޤ���' );
define ( $constpref.'_UPDATEPING','����ping�����С�' );
define ( $constpref.'_UPDATEPING_DSC','����ping�����С�����ꤷ�ޤ������ԤǶ��ڤ�ޤ���' );
define ( $constpref.'_UPDATEPING_SERVERS',"http://ping.bloggers.jp/rpc/\nhttp://ping.myblog.jp/\nhttp://blog.goo.ne.jp/XMLRPC" );
define ( $constpref.'_TBAPPROVAL','�ȥ�å��Хå����դϾ�ǧ��ɬ�פȤ���' );
define ( $constpref.'_TBAPPROVAL_DSC','' );
define ( $constpref.'_TBTICKET','�����åȼ��ȥ�å��Хå�URL��Ȥ�' );
define ( $constpref.'_TBTICKET_DSC','Javascript���Ȥ��ʤ��桼�����ˤ�̵���Ǥ��Τ���դ��Ƥ�����������¸���֤ϥǥե���Ȥ�1����' );
define ( $constpref.'_NOT_ADMIN','�ȥ�å��Хå������ä������Τ���' );
define ( $constpref.'_NOT_ADMIN_DSC','��ǧ������ĥ桼�����������Τ��ޤ���' );
define ( $constpref.'_SPAMCHECK','�ȥ�å��Хå���SPAM�����å�' );
define ( $constpref.'_SPAMCHECK_DSC','�����å����ȹ礻�����򤷤Ƥ���������' );
define ( $constpref.'_NOSPAMCHECK','SPAM�����å��򤷤ʤ�' );
define ( $constpref.'_REFERENCE','�֥��ڡ����θ���' );
define ( $constpref.'_WORLDLIST','�ػ��Ѹ�����å�' );
define ( $constpref.'_BANNEDWORD','�ػ��Ѹ�' );
define ( $constpref.'_BANNEDWORD_DSC','�֥�̾�������ȥ롢���������å����ޤ���1�ԤˤĤ�1��Ǥ���' );
define ( $constpref.'_BANNEDWORDS', "drugs\nhydrocodone\npharma\nsex\nsmoking\nviagra" );
define ( $constpref.'_REGEX','����ɽ�������å�' );
define ( $constpref.'_REGEXCHECK','����ɽ��' );
define ( $constpref.'_REGEXCHECK_DSC','�֥�̾�������ȥ롢����url������å����ƥޥå����������ݤ��ޤ���1�ԤˤĤ�1���åȤǤ���' );
define ( $constpref.'_DNSBL','DNSBL�����å�' );
define ( $constpref.'_DNSBLSRV','DNSBL�����С�' );
define ( $constpref.'_DNSBLSRV_DSC','���ȸ������Υ����С��Υ֥�å��ꥹ��DB����Ͽ����Ƥ��뤫�ɤ���������å����ޤ���1�ԤˤĤ�1�����С��Ǥ���' );
define ( $constpref.'_DNSBL_SERVERS', "niku.2ch.net\nlist.dsbl.org\nbl.spamcop.net\nsbl-xbl.spamhaus.org\nall.rbl.jp\nopm.blitzed.org\nbsb.empty.us\nbsb.spamlookup.net");
define ( $constpref.'_SURBL','SURBL�����å�' );
define ( $constpref.'_SURBLSRV','SURBL�����С�' );
define ( $constpref.'_SURBLSRV_DSC','�֥�̾�������ȥ롢����ʸ���url�����Υ����С��Υ֥�å��ꥹ��DB����Ͽ����Ƥ��뤫�ɤ���������å����ޤ���1�ԤˤĤ�1�����С��Ǥ���' );
define ( $constpref.'_SURBL_SERVERS',"url.rbl.jp\nmulti.surbl.org" );
define ( $constpref.'_LANGCHECK','���ܸ�����å�' );
define ( $constpref.'_PATTERN','���ܸ��ͭ��ʸ���ѥ�����' );
define ( $constpref.'_PATTERN_DSC','���������ʡ����ʤ�������������ɽ����' );
define ( $constpref.'_REGEX_PATTERN','[��-��]+|[��-��]+|[��-����]+' );
define ( $constpref.'_LETTERS','ɬ�פ�ʸ����' );
define ( $constpref.'_LETTERS_DSC','���ܸ�����å�on�ˤ�����硢�����ȥ롢�֥�̾������ʸ�������ʸ������פ�����򲼲����SPAM��Ƚ�ꤷ�ޤ���' );
define ( $constpref.'_DYNAMICCSS','�����ʥߥå��������륷���Ȥλ���' );
define ( $constpref.'_DYNAMICCSS_DSC','����DB����ľ���ɤ߹���Τ�on�ˤ����CSS�Խ����������Ǥ���<br />�̾����off�ˤ���CSS�ޥͥ��㡼��text������CSS��񤭽Ф��֥饦������å����ͭ�����Ѥ��ޤ���' );
define ( $constpref.'_ORIGINAL_COM','d3blog���ꥸ�ʥ�Υ����ȥ����ƥ�����' );
define ( $constpref.'_ORIGINAL_COM_DSC','���ꥸ�ʥ륳���ȤǤ��ֿ���֥���ƼԤΤߤ˸���Ǥ��ޤ���<br />���ξ��ϲ������ܤΡ֤Ϥ��פ����򤷤Ƥ���������' );
define ( $constpref.'_REJECTREPLY','�������ֿ��ϥ֥���ƼԤΤ�' );
define ( $constpref.'_REJECTREPLY_DSC','���ꥸ�ʥ륳���Ȥ���Ѥ����硢�ֿ�����ƼԤΤߤ˸���Ǥ��ޤ���<br />����2���ܤΥ��ץ����Ϥ�����Υ����ȥ����ƥ�Ǥ�ͭ���Ǥ���' );
define ( $constpref.'_FIGUREHANDLER','FigureHandler.js�λ���' );
define ( $constpref.'_FIGUREHANDLER_DSC','d3blog�Ǥϲ�������ɽ�ʤɤ򥭥�ץ����ȤȤ�˥ޡ������åפ���xcode��[fig]�������ɲä��Ƥ���ޤ���<br />����ˡ�����js��Ȥ��Ȳ����������˱����ƥ��饹��ư�������뤳�Ȥ���ǽ�ˤʤ�ޤ���<br />������������js�ϼ¸�Ū�ʼ���ȤߤʤΤǡ��ơ������䥹�����륷���Ȥ��μ����ʤ�����off�ˤ��Ƥ����Ƥ���������' );
define ( $constpref.'_COM_AGENT','����������' );
define ( $constpref.'_COM_AGENT_DSC','d3forum�Υ��������絡ǽ����Ѥ�����ϳ����⥸�塼��Υǥ��쥯�ȥ�̾����ꤷ�ޤ���' );
//define ( $constpref.'_NO_COM_AGENT','��������������Ѥ��ʤ�' );
define ( $constpref.'_COM_AGENTID','�����Ȥ�forum_id' );
define ( $constpref.'_COM_AGENTID_DSC','��������������򤷤���硢forum_id��ɬ�����ꤷ�Ƥ���������' );

// <--- NOTIFY PROPERTY --->
define ( $constpref.'_NOTIFY_GLOBAL','�֥�����' );
define ( $constpref.'_NOTIFY_GLOBAL_DSC','�֥��⥸�塼�����Τˤ��������Υ��ץ����' );
define ( $constpref.'_NOTIFY_ENTRY','ɽ����Υ���ȥ�' );
define ( $constpref.'_NOTIFY_ENTRY_DSC','ɽ����Υ���ȥ�ˤ��������Υ��ץ����' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED','��ǧ��ɬ�פʥ���ȥ���Ƥ����ä��Ȥ�' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_CAP','�֥��˾�ǧ��ɬ�פʿ�����Ƥ����ä������Τ���' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_DSC','�֥��˾�ǧ��ɬ�פʿ�����Ƥ����ä��Ȥ�' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYPOSTED_SBJ','[{X_SITENAME}] {X_MODULE}: ��ǧ��ɬ�פʥ���ȥ꤬��Ƥ���ޤ���' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED','�֥��˿����Ǻܤ����ä��Ȥ�' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_DSC','�֥��˿����Ǻܤ����ä������Τ���' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_CAP','�֥��˿����Ǻܤ����ä������Τ���' );
define ( $constpref.'_NOTIFY_GLOBAL_ENTRYAPPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: �֥��˿�������ȥ꤬�Ǻܤ���ޤ���' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED','��ǧ��ɬ�פʥȥ�å��Хå�����������Ȥ�' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_CAP','��ǧ��ɬ�פʥȥ�å��Хå���������������Τ���' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_DSC','��ǧ��ɬ�פʥȥ�å��Хå�����������Ȥ�' );
define ( $constpref.'_NOTIFY_GLOBAL_TBRECEIVED_SBJ','[{X_SITENAME}] {X_MODULE}: ��ǧ��ɬ�פʥȥ�å��Хå���������ޤ���' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED','�ȥ�å��Хå�����������Ȥ�' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_CAP','�֥��˥ȥ�å��Хå������ä������Τ���' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_DSC','�֥��˥ȥ�å��Хå������ä��Ȥ�' );
define ( $constpref.'_NOTIFY_GLOBAL_TBAPPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: �ȥ�å��Хå���������ޤ���' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED','�֥�����ȥ꤬��ǧ���줿�Ȥ�' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_CAP','�֥�����ȥ꤬��ǧ���줿�����Τ���' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_DSC','�֥�����ȥ꤬��ǧ���줿�Ȥ�' );
define ( $constpref.'_NOTIFY_ENTRY_APPROVED_SBJ','[{X_SITENAME}] {X_MODULE}: �֥�����ȥ꤬��ǧ����ޤ���' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK','�ȥ�å��Хå�����������Ȥ�' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_DSC','ɽ����Υ���ȥ�˥ȥ�å��Хå�����������Ȥ����Τ���' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_CAP','ɽ����Υ���ȥ�˥ȥ�å��Хå�����������Ȥ����Τ���' );
define ( $constpref.'_NOTIFY_ENTRY_TRACKBACK_SBJ','[{X_SITENAME}] {X_MODULE}: �ȥ�å��Хå���������ޤ���' );

}
?>
