<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'xpwiki' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

// a flag for this language file has already been read or not.
define( $constpref.'_LOADED' , 1 ) ;

// Names of blocks for this module (Not all module has blocks)
define( $constpref."_BNAME_A_PAGE","ページ表示 ({$mydirname})");
define( $constpref."_BDESC_A_PAGE","ページ名を指定してその内容をブロックに表示することができます");
define( $constpref."_BNAME_NOTIFICATION","イベント通知 ({$mydirname})");
define( $constpref."_BDESC_NOTIFICATION","イベント通知オプションを設定します");
define( $constpref."_BNAME_FUSEN","付箋機能 ({$mydirname})");
define( $constpref."_BDESC_FUSEN","付箋プラグインのコントロールメニューを表示します。");
define( $constpref."_BNAME_MENUBAR","MenuBar ({$mydirname})");
define( $constpref."_BDESC_MENUBAR","MenuBar を表示します。");

define( $constpref.'_MODULE_DESCRIPTION' , 'PukiWikiベースのWikiモジュール' ) ;

define( $constpref.'_PLUGIN_CONVERTER' , 'プラグイン変換ツール' ) ;
define( $constpref.'_SKIN_CONVERTER' , 'スキン変換ツール' ) ;
define( $constpref.'_ADMIN_CONF' , '環境設定' ) ;
define( $constpref.'_ADMIN_TOOLS' , '管理用ツール一覧' ) ;

define( $constpref.'_COM_DIRNAME','コメント統合するd3forumのdirname');
define( $constpref.'_COM_FORUM_ID','コメント統合するフォーラムの番号');

// Notify Replaces
define($constpref.'_NOTCAT_REPLASE2MODULENAME', 'モジュール');
define($constpref.'_NOTCAT_REPLASE2FIRSTLEV', '表示中の第1階層');
define($constpref.'_NOTCAT_REPLASE2SECONDLEV', '表示中の第2階層');
//define($constpref.'_NOTCAT_REPLASE2PAGENAME', 'このページ');

// Notify Categories
define($constpref.'_NOTCAT_PAGE', '表示中のページ');
define($constpref.'_NOTCAT_PAGEDSC', '表示中のページに対する通知オプション');
define($constpref.'_NOTCAT_PAGE1', '表示中の第1階層 以下');
define($constpref.'_NOTCAT_PAGE1DSC', '表示中の第1階層 以下のページに対する通知オプション');
define($constpref.'_NOTCAT_PAGE2', '表示中の第2階層 以下');
define($constpref.'_NOTCAT_PAGE2DSC', '表示中の第2階層 以下のページに対する通知オプション');
define($constpref.'_NOTCAT_GLOBAL', 'モジュール全体');
define($constpref.'_NOTCAT_GLOBALDSC', 'モジュール全体における通知オプション');

// Each Notifications
define($constpref.'_NOTIFY_PAGE_UPDATE', 'ページ更新');
define($constpref.'_NOTIFY_PAGE_UPDATECAP', 'このページが更新された場合に通知する');
define($constpref.'_NOTIFY_PAGE1_UPDATECAP', '「表示中の第1階層」以下のページが更新された場合に通知する');
define($constpref.'_NOTIFY_PAGE2_UPDATECAP', '「表示中の第2階層」以下のページが更新された場合に通知する');
define($constpref.'_NOTIFY_PAGE_UPDATESBJ', '[{X_SITENAME}] {X_MODULE}:{PAGE_NAME} ページ更新');
define($constpref.'_NOTIFY_GLOBAL_UPDATECAP', 'モジュール内のいずれかのページが更新された場合に通知する');

}

?>