<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3downloads' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","D3�б���������ɥ⥸�塼��");

// A brief description of this module
define($constpref."_DESC","�桼������ͳ�˥�������ɾ������Ͽ��ɾ����Ԥ��륻��������������ޤ���");

// admin menus
define($constpref.'_ADMENU_FILEMANAGER','��������ɾ������') ;
define($constpref.'_ADMENU_APPROVALMANAGER','��������ɾ���ǧ') ;
define($constpref.'_ADMENU_CATEGORYMANAGER','���ƥ������') ;
define($constpref.'_ADMENU_IMPORT','����ݡ���/���åץǡ���') ;
define($constpref.'_ADMENU_CONFIG_CHECK','���åץ��ɴĶ������å�') ;
define($constpref.'_ADMENU_MYLANGADMIN','�����������') ;
define($constpref.'_ADMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','�֥�å�����/������������') ;
define($constpref.'_ADMENU_MYPREFERENCES','��������') ;

// blocks
define($constpref.'_BNAME_RECENT','������������') ;
define($constpref.'_BNAME_TOPRANK','��͵����������') ;
define($constpref.'_BNAME_DOWNLOAD','��������ɾ�������') ;
define($constpref.'_BNAME_LIST','��������ɾ������') ;

// Sub menu titles
define($constpref.'_SMNAME1','�͵����������');
define($constpref.'_SMNAME2','��ɾ�����������');

// Title of config items
define($constpref.'_POPULAR','�ֿ͵���������ɡפˤʤ뤿��Υ�������ɿ�');
define($constpref.'_NEWDLS','�ȥåץڡ����Ρֿ����������ɡפ�ɽ��������');
define($constpref.'_NEWMARK','�ֿ���ס֥��åץǡ��ȡץ��������ɽ����������');
define($constpref.'_PERPAGE','���ڡ������ɽ�������������ɾ���η��');
define($constpref.'_BREADCRUMBS','�ѥ󤯤���ɽ������');
define($constpref.'_USESHOTS','�����꡼�󥷥�åȲ�����ɽ������');
define($constpref.'_USEALBUM','myAlbum-P ����Ͽ���������򥹥��꡼�󥷥�åȲ����Ȥ������Ѥ���');
define($constpref.'_USEALBUMDSC','�֥����꡼�󥷥�åȲ�����ɽ������פ�ͭ�������ꤷ�Ƥ�����ˡ�myAlbum-P �⥸�塼�����Ͽ���������򥹥��꡼�󥷥�åȲ����Ȥ������Ѥ��뤳�Ȥ��Ǥ��ޤ���');
define($constpref.'_ALBUMSELECT','Ϣ�Ȥ������Ѥ��� myAlbum-P �� dirname');
define($constpref.'_ALBUMSELECTDSC','Ϣ�Ȥ������Ѥ��� myAlbum-P �⥸�塼��� dirname �����Ϥ��Ƥ�������(������ myalbum)��');
define($constpref.'_SHOTSSELECT','����ͥ���Web�����ӥ������Ѥ��ƥ����꡼�󥷥�åȲ�����ɽ������');
define($constpref.'_SHOTSSELECTDSC','�֥����꡼�󥷥�åȲ�����ɽ������פ�ͭ�������ꤷ�������꡼�󥷥�åȲ����λ��꤬�ʤ����ˡ�����ͥ���Web�����ӥ������Ѥ������ز�����ɽ�����ޤ���');
define($constpref.'_SHOTWIDTH','�����꡼�󥷥�åȤβ�����');
define($constpref.'_CHECKURL','Ʊ����������Ͽ������å�����');
define($constpref.'_CHECKHOST','�����쥯�ȥ�󥯤ζػ�(leeching)');
define($constpref.'_REFERERS','�����Υ����Ȥϥե�����ؤΥ����쥯�ȥ�󥯤���ǽ<br />�ƥ����Ȥ� | ��ʬ��');
define($constpref.'_PER_HISTORY','����Ȥ��ƻĤ������');
define($constpref.'_EXTENSION','���åץ��ɤ���Ĥ����ĥ��');
define($constpref.'_EXTENSIONDSC','���åץ��ɤ���Ĥ����ĥ�Ҥ� | �Ƕ��ڤä����Ϥ��Ƥ������������٤ƾ�ʸ���ǻ��ꤷ���ԥꥪ�ɤ���������ʤ��ǲ��������ʤ���php��phtml �ʤɤγ�ĥ�Ҥϻ��ꤷ�Ƥ�̵�뤵��ޤ���');
define($constpref.'_MAXFILESIZE','���åץ��ɻ��κ���ե����륵����(KB)');
define($constpref.'_MULTIDOT','���åץ��ɻ��� multiple dot file �Υ����å��򤹤�');
define($constpref.'_MULTIDOTDSC','multiple dot file(�ɥå�(.)�� 2�İʾ夢��̾���Υե�����)�Υ��åץ��ɤ���Ĥ��뤫�ɤ��������ꤷ�ޤ���multiple dot file �ϳ�ĥ�ҵ�¤�β�ǽ�������뤿�ᡢɸ��Ǥϥ��åץ��ɽ���������λ���ޤ���');
define($constpref.'_CHECKHEAD','���åץ��ɻ��˥ե�����Υإå�������å�����');
define($constpref.'_CHECKHEADDSC','ɸ��Ǥϥե����륢�åץ��ɻ��˥ե��������Ƭ��ʬ������å����������ʥ��åץ��ɤ�Ƚ�Ǥ������˶�����λ���ޤ����Ǥ���¤����Τʥ����å��򤷤褦�Ȥ��Ƥ��ޤ�������ǧ���⤢�����ޤ�����ǧ���ʤɤ�������ˤϡ֤������פ����ꤷ�Ƥ���������');
define($constpref.'_EDITOR','��ʸ�Խ����ǥ���');
define($constpref.'_EDITORDSC','fckeditor �ϡ�HTML����Ĥ������ƥ���ǤΤ�ͭ���ˤʤꡢHTML ����Ĥ��ʤ����ƥ���Ǥ�̵���� xoopsdhtml �Ȥʤ�ޤ���');
define($constpref.'_PURIFIER','HTML ���Ļ��˴��ʥ���������');
define($constpref.'_PURIFIERDSC','ɸ��Ǥ� HTML ���Ļ��� XSS �ˤĤʤ���褦�ʴ��ʥ��������ޤ�����ƼԤ�����Ǥ���桼�����˸��ꤵ����������ơ��֤Ϥ��פ�������Ǥ���');
define($constpref.'_PLATFORM','���Ѳ�ǽ�� OS/���ե���');
define($constpref.'_PLATFORMDSC','���Ѳ�ǽ�� OS/���ե����� | �Ƕ��ڤä����Ϥ��Ƥ������������������ꤷ�����ܤ���ƥե�����Υ��쥯�ȥܥå���������Ǥ���褦�ˤʤ�ޤ���');
define($constpref.'_TELLAFRINED','Tell A Friend�⥸�塼������Ѥ���');
define($constpref.'_PER_RSS','RSS��ɽ�����');
define($constpref.'_COM_DIRNAME','���������礹��d3forum��dirname');
define($constpref.'_COM_FORUM_ID','���������礹��ե��������ֹ�');
define($constpref.'_COM_VIEW','�����������ɽ����ˡ');

define($constpref.'_POPULARDSC','�ֿ͵����ץ�������ɽ������뤿��Υ�������ɷ������ꤷ�Ƥ���������');
define($constpref.'_NEWDLSDSC','�ȥåץڡ����Ρֿ����������ɡפ�ɽ���������������ꤷ�Ƥ���������');
define($constpref.'_PERPAGEDSC','��������ɰ���ɽ���ǣ��ڡ����������ɽ���������������ꤷ�Ƥ���������');
define($constpref.'_SHOTWIDTHDSC','�����꡼�󥷥�åȲ����β����κ����ͤ���ꤷ�Ƥ���������');
define($constpref.'_REFERERSDSC','�ե�����ؤΥ����쥯�ȥ�󥯤���Ĥ��볰�������Ȥ���󤷤Ƥ���������');

// Notify Categories
define($constpref.'_NOTCAT_CAT', 'ɽ����Υ��ƥ���');
define($constpref.'_NOTCAT_CATDSC', 'ɽ����Υ��ƥ�����Ф������Υ��ץ����');
define($constpref.'_NOTCAT_GLOBAL', '�⥸�塼������');
define($constpref.'_NOTCAT_GLOBALDSC', '�ե������⥸�塼�����Τˤ��������Υ��ץ����');

// Each Notifications
define($constpref.'_NOTIFY_CAT_NEWPOST', '���ƥ��������');
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP', '���Υ��ƥ������Ƥ����ä��������Τ���');
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} ���ƥ��������');

define($constpref.'_NOTIFY_CAT_NEWPOSTFULL', '���ƥ����������ʸ');
define($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP', '���Υ��ƥ������Ƥ����ä����������ʸ�����Τ��ޤ���');
define($constpref.'_NOTIFY_CATL_NEWPOSTFULLSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} ���ƥ����������ʸ');

define($constpref.'_NOTIFY_CAT_NEWFORUM', '���ƥ����⿷�ե������');
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP', '���Υ��ƥ���ˤ����ƿ��ե�����बΩ�Ƥ�줿�������Τ���');
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ', '[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} ���ƥ����⿷�ե������');

define($constpref.'_NOTIFY_GLOBAL_NEWPOST', '���������');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP', '���Υ⥸�塼�����ΤΤ����줫����Ƥ����ä��������Τ���');
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ', '[{X_SITENAME}] {X_MODULE}: ���');

define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORY', '�⥸�塼������');
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP', '���Υ⥸�塼�����ΤΤ����줫�˿����ƥ��꤬Ω�Ƥ�줿�������Τ���');
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYSBJ', '[{X_SITENAME}] {X_MODULE}: �����ƥ���');

define($constpref.'_NOTIFY_GLOBAL_WAITING', '��ǧ�Ԥ�');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP', '��ǧ���פ�����ơ��Խ����Ԥ�줿�������Τ��ޤ�������������');
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ', '[{X_SITENAME}] {X_MODULE}: ��ǧ�Ԥ�');

define($constpref.'_NOTIFY_GLOBAL_BROKEN', '�ե�������»���');
define($constpref.'_NOTIFY_GLOBAL_BROKENCAP', '�ե�������»��𤬹Ԥ�줿�������Τ��ޤ�������������');
define($constpref.'_NOTIFY_GLOBAL_BROKENSBJ', '[{X_SITENAME}] {X_MODULE}: �ե�������»����𤬤���ޤ���');

define($constpref.'_NOTIFY_GLOBAL_APPROVE', '�ե����뾵ǧ');
define($constpref.'_NOTIFY_GLOBAL_APPROVECAP', '���Υե����뤬��ǧ���줿�������Τ���');
define($constpref.'_NOTIFY_GLOBAL_APPROVECAPSBJ', '[{X_SITENAME}] {X_MODULE}: �ե����뤬��ǧ����ޤ���');

}
?>