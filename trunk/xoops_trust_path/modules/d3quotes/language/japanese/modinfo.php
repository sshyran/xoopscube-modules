<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3quotes' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","D3����ʸ");

// A brief description of this module
define($constpref."_DESC","�֥�å��إ�����˰���ʸ��ɽ������");

// Names of admin menu items
define($constpref."_MENU","����ʸ���ɲ�/�Խ�");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME","���������");
define($constpref."_BDESC","������˰���ʸɽ��");

// admin menu
define($constpref.'_ADMENU_MYLANGADMIN' , '�����������' ) ;
define($constpref.'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' ) ;
define($constpref.'_ADMENU_MYBLOCKSADMIN' , '�֥�å�����/������������' ) ;
define($constpref.'_ADMENU_MYPREFERENCES' , '��������' ) ;

}

?>