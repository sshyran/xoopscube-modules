<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'pico' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","pico");

// A brief description of this module
define($constpref."_DESC","��Ū����ƥ�ĺ����⥸�塼��");

// admin menus
define( $constpref.'_ADMENU_CONTENTSADMIN' , '����ƥ�İ�����' ) ;
define( $constpref.'_ADMENU_CATEGORYACCESS' , '���ƥ��꡼������������' ) ;
define( $constpref.'_ADMENU_IMPORT' , '����ݡ���/Ʊ��' ) ;
define( $constpref.'_ADMENU_EXTRAS' , '��ĥ��ǽ' ) ;
define( $constpref.'_ADMENU_MYLANGADMIN' , '�����������' ) ;
define( $constpref.'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' ) ;
define( $constpref.'_ADMENU_MYBLOCKSADMIN' , '�֥�å�����/�⥸�塼�륢����������' ) ;
define( $constpref.'_ADMENU_MYPREFERENCES' , '��������' ) ;

// configurations
define($constpref.'_USE_WRAPSMODE','wraps�⡼�ɤ�ͭ���ˤ���');
define($constpref.'_USE_REWRITE','mod_rewrite�⡼�ɤ�ͭ���ˤ���');
define($constpref.'_USE_REWRITEDSC','�����ͭ���ˤ����硢XOOPS_ROOT_PATH/modules/(dirname)/ ���ˤ���.htaccess.rewrite_wraps��wraps�⡼��ͭ�����ˤޤ���.htaccess.rewrite_normal��wraps�⡼��̵�����ˤ�.htaccess�˥�͡��ह��ɬ�פ�����ޤ������ε�ǽ�ϡ�XOOPS���Ѥ��Ƥ��륵���Ф�Apache��mod_rewrite�򥵥ݡ��Ȥ��Ƥ��ơ�.htaccess�Ǥλ��꤬��ǽ�Ǥʤ�������ѤǤ��ޤ���');
define($constpref.'_WRAPSAUTOREGIST','HTML��åץե�����μ�ưDB��Ͽ');
define($constpref.'_TOP_MESSAGE','�⥸�塼��ȥåפΥ�å�����');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_MENUINMODULETOP','�⥸�塼��ȥåפǤϼ�ư������˥塼��ɽ������');
define($constpref.'_LISTASINDEX','���ƥ��꡼�ȥåפǥꥹ�Ȥ�ɽ������');
define($constpref.'_LISTASINDEXDSC','�֤Ϥ��פξ�硢���ƥ��꡼�ȥåפǤϥ��֥��ƥ��꡼��ľ���Υ���ƥ�Ĥ��ꥹ�ȼ���ɽ������ޤ����֤������פξ�硢���Υ��ƥ��꡼��ǺǤ�ɽ��ͥ���٤ι⤤����ƥ�Ĥ�ɽ������ޤ���');
define($constpref.'_SHOW_BREADCRUMBS','�ѥ󤯤���ɽ������');
define($constpref.'_SHOW_PAGENAVI','�ڡ����ʥӥ���������ɽ������');
define($constpref.'_SHOW_PRINTICON','�������̤ؤΥ�󥯤�ɽ������');
define($constpref.'_SHOW_TELLAFRIEND','ͧã�˾Ҳ𤹤��󥯤�ɽ������');
define($constpref.'_SEARCHBYUID','�����ǡ���ƼԡפȤ�����ǰ��ͭ���ˤ���');
define($constpref.'_SEARCHBYUIDDSC','ON�ˤ���ȡ�������桼���ץ�ե�������̤ʤɤǡ�����ơװ�����ɽ������ޤ���������Ū����ƥ�Ĥξ���OFF�ˤ��뤳�Ȥ򴫤�ޤ���');
define($constpref.'_USE_TAFMODULE','tellafriend�⥸�塼������Ѥ���');
define($constpref.'_FILTERS','�ǥե���ȥե��륿�����å�');
define($constpref.'_FILTERSDSC','����ƥ�ĺ������˺ǽ餫������å�����Ƥ���ե��륿��̾��|�Ƕ��ڤä����Ϥ��ޤ��������˽񤫤줿�����̤�Ŭ�Ѥ���ޤ���');
define($constpref.'_FILTERSDEFAULT','htmlspecialchars|xcode|smiley|nl2br');
define($constpref.'_FILTERSF','�����ե��륿��');
define($constpref.'_FILTERSFDSC','ɬ���̲᤹��ե��륿��̾��,�Ƕ��ڤä����Ϥ��ޤ����ե��륿��̾�θ���:LAST��Ĥ������Ϥ��Υե��륿����Ǹ���̲ᤷ�ޤ������꤬�ʤ���С��ǽ���̲ᤷ�ޤ���');
define($constpref.'_FILTERSP','�ػߥե��륿�����å�');
define($constpref.'_FILTERSPDSC','���ѤǤ��ʤ��ե��륿��̾��,�Ƕ��ڤä����Ϥ��ޤ�');
define($constpref.'_SUBMENU_SC','���֥�˥塼�˥���ƥ�Ĥ�ɽ������');
define($constpref.'_SUBMENU_SCDSC','ɽ�����ʤ����ϥ��ƥ��꡼�Τߤ�ɽ������ޤ���ɽ��������ϡ���˥塼ɽ�����ꤵ�줿����ƥ�Ĥ⥫�ƥ��꡼��Ʊ���ɽ������ޤ�');
define($constpref.'_SITEMAP_SC','sitemap�˥���ƥ�Ĥ�Ʊ��ɽ������');
define($constpref.'_USE_VOTE','��ɼ��ǽ�����Ѥ���');
define($constpref.'_GUESTVOTE_IVL','��������ɼ�λ�������');
define($constpref.'_GUESTVOTE_IVLDSC','Ʊ���IP����ϡ����λ��֡��ÿ��������ɼ���뤳�Ȥ��Ǥ��ޤ���');
define($constpref.'_HTMLHEADER','����ƥ�Ķ���HTML�إå�');
define($constpref.'_CSS_URI','�⥸�塼����CSS��URI');
define($constpref.'_CSS_URIDSC','���Υ⥸�塼�����Ѥ�CSS�ե������URI�����Хѥ��ޤ������Хѥ��ǻ��ꤷ�ޤ����ǥե���Ȥ�{mod_url}/index.php?page=main_css�Ǥ���');
define($constpref.'_IMAGES_DIR','���᡼���ե�����ǥ��쥯�ȥ�');
define($constpref.'_IMAGES_DIRDSC','���Υ⥸�塼���ѤΥ��᡼������Ǽ���줿�ǥ��쥯�ȥ��⥸�塼��ǥ��쥯�ȥ꤫������Хѥ��ǻ��ꤷ�ޤ����ǥե���Ȥ�images�Ǥ���');
define($constpref.'_BODY_EDITOR','��ʸ�Խ����ǥ���');
define($constpref.'_HTMLPR_EXCEPT','HTMLPurifier�ˤ�붯���񤭴����򤷤ʤ����롼��');
define($constpref.'_HTMLPR_EXCEPTDSC','�����˻��ꤵ��ơ֤��ʤ��ץ��롼�פˤ��HTML��Ƥϡ�Protector3.14�ʾ����°���Ƥ���HTMLPurifier�ˤ�äƶ���Ū��������̵�Ǥ�HTML�˽񤭴������ޤ�����������HTMLPurifier���Ρ�PHP�С������5�ʾ�Ǥʤ��ȵ�ǽ���ޤ���');
define($constpref.'_HISTORY_P_C','����ǽ������ޤ���¸���뤫');
define($constpref.'_MLT_HISTORY','����ΰ�����Ȥ�����¸����Ǿ�����(sec)');
define($constpref.'_BRCACHE','�����ե�����Υ֥饦������å��� (wraps�⡼�ɻ��Τ�)');
define($constpref.'_BRCACHEDSC' , 'HTML�ʳ��Υե������֥饦���˥���å��夹����֤��äǻ����0��̵������');
define($constpref.'_COM_DIRNAME','���������礹��d3forum��dirname');
define($constpref.'_COM_FORUM_ID','���������礹��ե��������ֹ�');
define($constpref.'_COM_VIEW','�����������ɽ����ˡ');

// blocks
define($constpref.'_BNAME_MENU','��˥塼');
define($constpref.'_BNAME_CONTENT','����ƥ������');
define($constpref.'_BNAME_LIST','����ƥ�İ���');
define($constpref.'_BNAME_SUBCATEGORIES','���֥��ƥ��꡼����');
define($constpref.'_BNAME_MYWAITINGS','���Ȥξ�ǧ�Ԥ�');

// Notify Categories
define($constpref.'_NOTCAT_GLOBAL', '�⥸�塼������');
define($constpref.'_NOTCAT_GLOBALDSC', '����pico�⥸�塼�����Τˤ��������Υ��ץ����');

// Each Notifications
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENT', '��ǧ�Ԥ�');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTCAP', '����ƥ�Ĥο�����Ͽ���ѹ��ʤɤǡ���ǧ��ɬ�פ���Ƥ����ä��������Τ��ޤ��ʥ�ǥ졼���ʳ��ˤ����Τ���ޤ����');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTSBJ', '[{X_SITENAME}] {X_MODULE} : ��ǧ�Ԥ�');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENT', '��������ƥ��');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTCAP', '����ƥ�Ĥο�����Ͽ�����ä��������Τ��ޤ���̤��ǧ�Ǥ�������Τ��ޤ����');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTSBJ', '[{X_SITENAME}] {X_MODULE} : ��������ƥ��');

}


?>