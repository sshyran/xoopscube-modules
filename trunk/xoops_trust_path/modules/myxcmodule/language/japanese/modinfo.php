<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'myxcmodule' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

// a flag for this language file has already been read or not.
define($constpref.'_LOADED' , 1 ) ;

define($constpref.'_MODULE_DESCRIPTION' , '�ڡ�����å����ѥ⥸�塼��' ) ;

define($constpref.'_BNAME1','�ƥ��ȥ֥�å�');
define($constpref.'_BDESC1','');
    
// admin menu
define($constpref.'_UPDATE_SEARCH_INDEX' , '�����ѥ���ǥå����ι���' ) ;
define($constpref.'_ADMENU_MYLANGADMIN' , '�����������' ) ;
define($constpref.'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' ) ;
define($constpref.'_ADMENU_MYBLOCKSADMIN' , '������������' ) ;
define($constpref.'_ADMENU_MYPREFERENCES' , '��������' ) ;

// configs
define($constpref.'_INDEX_FILE' , '�ȥåץڡ���' ) ;
define($constpref.'_INDEX_FILEDSC' , '�⥸�塼��ȥåפ˥����������줿���˥�åפ���ե��������ꤷ�ޤ�' ) ;
define($constpref.'_INDEXAUTOUPD' , '��������ǥå����μ�ư����' ) ;
define($constpref.'_INDEXLASTUPD' , '��������ǥå����κǽ���������' ) ;
define($constpref.'_BRCACHE' , '�����ե�����Υ֥饦������å���' ) ;
define($constpref.'_BRCACHEDSC' , 'HTML�ʳ��Υե������֥饦���˥���å��夹����֤��äǻ����0��̵������' ) ;


}


?>
