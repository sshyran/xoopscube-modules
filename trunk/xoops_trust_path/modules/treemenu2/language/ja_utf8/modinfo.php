<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'treemenu' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
    define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref."_MODULE_NAME" , "ツリーメニュー2" );
	define( $constpref."_MODULE_DSC" , "ツリーメニューをブロック表示＆サイトマップモジュール" );

	define( $constpref."_BLOCK_NAME" , "ツリーメニュー" );
	define( $constpref."_BLOCK_DSC" , "メニューブロック" );
	define( $constpref."_BLOCK2_NAME" , "サイトマップ" );
	define( $constpref."_BLOCK2_DSC" , "メニューをサイトマップでブロック表示" );

	define( $constpref."_VIEWTYPE_TITLE" , "「ツリーメニュー」ブロックでの表示形式" );
	define( $constpref."_VIEWTYPE_DSC" , "全て表示 ： 登録されているもの全て表示<br />
				カレントディレクトリの一つ下まで表示 ： 選択階層の上位階層すべてと下位１層を表示<br />
				カレントディレクトリ内全表示 ： 選択位置の同一ブロックをすべて表示<br />
				プルダウン用 ： 第２階層までの全てと、表示されている全ての下位２層までを表示<br />
			");
	define( $constpref."_VIEWTYPE_OPT1" , "全て表示" );
	define( $constpref."_VIEWTYPE_OPT2" , "カレントディレクトリの一つ下まで表示" );
	define( $constpref."_VIEWTYPE_OPT3" , "カレントディレクトリ内全表示" );
	define( $constpref."_VIEWTYPE_OPT4" , "プルダウン用" );
	define( $constpref."_TARGETBLANK_TIT" , "ターゲットブランク" );
	define( $constpref."_TARGETBLANK_DSC" , '外部リンクの場合 A タグに target="_blank" を付加する' );
	define( $constpref."_COLUMNS_TITLE" , "サイトマップ表示時の列数" );
	define( $constpref."_COLUMNS_DSC" , XOOPS_URL."/modules/$mydirname/ へのアクセスした時に表示されるサイトマップ" );

	// ADMIN MENU
	define( $constpref."_ADMINMENU1" , "メニュー管理" );
	define( $constpref."_ADMINMENU2" , "メニュー表示権限" );

	define( $constpref.'_ADMENU_MYLANGADMIN' , '言語定数管理' );
	define( $constpref.'_ADMENU_MYTPLSADMIN' , 'テンプレート管理' );
	define( $constpref.'_ADMENU_MYBLOCKSADMIN' , 'ブロック・アクセス権限' );
	define( $constpref.'_ADMENU_MYPREFERENCES' , 'Altsys一般設定' );


}
?>