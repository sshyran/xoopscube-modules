<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'pico' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {






// Appended by Xoops Language Checker -GIJOE- in 2007-09-22 03:55:47
define($constpref.'_ADMENU_EXTRAS','Extra');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-18 10:36:05
define($constpref.'_HTMLPR_EXCEPT','Groups can avoid purification by HTMLPurifier');
define($constpref.'_HTMLPR_EXCEPTDSC','Post from users who are not belonged these groups will be forced to purified as sanitized HTML by HTMLPurifier in Protector>=3.14. This purification cannot work with PHP4');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-12 17:00:59
define($constpref.'_BNAME_MYWAITINGS','My waiting posts');

// Appended by Xoops Language Checker -GIJOE- in 2007-06-15 05:03:02
define($constpref.'_BNAME_SUBCATEGORIES','Subcategories');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENT','new content');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTCAP','Notify if a new content is registered. (approved contents only)');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTSBJ','[{X_SITENAME}] {X_MODULE} : New content');

// Appended by Xoops Language Checker -GIJOE- in 2007-05-29 16:39:07
define($constpref.'_COM_VIEW','View of Comment-integration');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","pico");

// A brief description of this module
define($constpref."_DESC","a module for staic contents");

// admin menus
define( $constpref.'_ADMENU_CONTENTSADMIN' , '���¹���' ) ;
define( $constpref.'_ADMENU_CATEGORYACCESS' , '������' ) ;
define( $constpref.'_ADMENU_IMPORT' , '����/ͬ��' ) ;
define( $constpref.'_ADMENU_MYLANGADMIN' , '���Թ���' ) ;
define( $constpref.'_ADMENU_MYTPLSADMIN' , 'ģ�����' ) ;
define( $constpref.'_ADMENU_MYBLOCKSADMIN' , '����/Ȩ�޹���' ) ;
define( $constpref.'_ADMENU_MYPREFERENCES' , '��������' ) ;

// configurations
define($constpref.'_USE_WRAPSMODE','����Ƕ��ģʽ');
define($constpref.'_USE_REWRITE','����mod_rewriteģʽ');
define($constpref.'_USE_REWRITEDSC','���������Ļ�������������ô���뽫XOOPS_ROOT_PATH/modules/(dirname)/.htaccess.rewrite_wraps (with wraps) �� .htaccess.rewrite_normal (without wraps) ����Ϊ .htaccess');
define($constpref.'_WRAPSAUTOREGIST','�����Զ��Ĵ�Ƕ�����ݿ���ļ���HTML��Ϊ����');
define($constpref.'_TOP_MESSAGE','ģ����ҳ����');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_MENUINMODULETOP','�ڴ�ģ�����ҳ��ʾ�˵� (����)');
define($constpref.'_LISTASINDEX',"�������ҳ��ʾ��������");
define($constpref.'_LISTASINDEXDSC','���ǡ���ʾ�������ҳ��ʾ�����б��������ʾ��ʾΪ���µ�����');
define($constpref.'_SHOW_BREADCRUMBS','��ʾλ�õ���');
define($constpref.'_SHOW_PAGENAVI','��ʾ���µ�ǰ������');
define($constpref.'_SHOW_PRINTICON','��ʾ����ӡ��ͼ��');
define($constpref.'_SHOW_TELLAFRIEND','��ʾ��ת�����ѡ�ͼ��');
define($constpref.'_SEARCHBYUID','��¼����������');
define($constpref.'_SEARCHBYUIDDSC','���½������������ߵ��û������С��������Ϊ��̬����ʹ�ô�ģ�飬��رմ��');
define($constpref.'_USE_TAFMODULE','ʹ�á�Tellafriend��ģ��');
define($constpref.'_FILTERS','Ĭ�Ϲ������趨');
define($constpref.'_FILTERSDSC','��������������������� (|) �ָ�');
define($constpref.'_FILTERSDEFAULT','htmlspecialchars|xcode|smiley|nl2br');
define($constpref.'_FILTERSF','ǿ�ƵĹ�����');
define($constpref.'_FILTERSFDSC','����������������Զ��� (,) �ָ�����������LASTָ�������������׶�ͨ���ģ������Ĺ����������׽׶�ͨ���ġ�');
define($constpref.'_FILTERSP','��ֹ�Ĺ�����');
define($constpref.'_FILTERSPDSC','����������������Զ��� (,) �ָ���');
define($constpref.'_SUBMENU_SC','�ڲ˵�����ʾ����');
define($constpref.'_SUBMENU_SCDSC','Ĭ��Ϊ����ʾ������ơ���������ô�������С��˵��������±���Ҳ����ʾ��');
define($constpref.'_SITEMAP_SC','��ʾ��������վ��ͼģ��');
define($constpref.'_USE_VOTE','����ͶƱ����');
define($constpref.'_GUESTVOTE_IVL','�����ڷÿ͵�ͶƱ');
define($constpref.'_GUESTVOTE_IVLDSC','��Ϊ0����ֹ�ÿ�ͶƱ����������ָ����������ͬIP��ַ���ٴ�ͶƱ���ʱ�� (��)��');
define($constpref.'_HTMLHEADER','ͨ��HTMLͷ��');
define($constpref.'_CSS_URI','ģ��CSS�ļ���URI');
define($constpref.'_CSS_URIDSC','�����趨��Ի����·����Ĭ��ֵ��{mod_url}/index.css');
define($constpref.'_IMAGES_DIR','ͼ���ļ�Ŀ¼');
define($constpref.'_IMAGES_DIRDSC','���·��Ӧ����Ϊģ��Ŀ¼�С�Ĭ��ֵ��images');
define($constpref.'_BODY_EDITOR','���ı༭��');
define($constpref.'_HISTORY_P_C','�洢�����ݿ���޶��汾��');
define($constpref.'_MLT_HISTORY','���޶�������С��Чʱ�� (��)');
define($constpref.'_BRCACHE','ͼ���ļ��Ļ�����Чʱ�� (������Ƕ��ģʽ)');
define($constpref.'_BRCACHEDSC','�ڴ�ʱ����HTML������ļ�����WEB��������� (0Ϊ��ֹ)');
define($constpref.'_COM_DIRNAME','����-���ɣ�d3forumĿ¼��');
define($constpref.'_COM_FORUM_ID','����-���ɣ�forum ID');

// blocks
define($constpref.'_BNAME_MENU','�˵�');
define($constpref.'_BNAME_CONTENT','����');
define($constpref.'_BNAME_LIST','�б�');

// Notify Categories
define($constpref.'_NOTCAT_GLOBAL', 'ȫ��');
define($constpref.'_NOTCAT_GLOBALDSC', '���ڴ�ģ���֪ͨ');

// Each Notifications
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENT', '�ȴ�');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTCAP', '�������·����������ȴ����ʱ֪ͨ (��֪ͨ��������Ա�����Ա)');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTSBJ', '[{X_SITENAME}] {X_MODULE}���ȴ�');

}


?>
