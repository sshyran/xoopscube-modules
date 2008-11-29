<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3quotes' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","D3引用文");

// A brief description of this module
define($constpref."_DESC","ブロックへランダムに引用文を表示する");

// Names of admin menu items
define($constpref."_MENU","引用文の追加/編集");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME","ランダム引用");
define($constpref."_BDESC","ランダムに引用文表示");

// admin menu
define($constpref.'_ADMENU_MYLANGADMIN' , '言語定数管理' ) ;
define($constpref.'_ADMENU_MYTPLSADMIN' , 'テンプレート管理' ) ;
define($constpref.'_ADMENU_MYBLOCKSADMIN' , 'ブロック管理/アクセス権限' ) ;
define($constpref.'_ADMENU_MYPREFERENCES' , '一般設定' ) ;

}

?>