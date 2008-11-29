<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'miniamazon' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
  define( $constpref.'_LOADED' , 1 ) ;


	define( $constpref.'_NAME' , 'miniamazon' );
	define( $constpref.'_DESC' , 'シンプルな Amazon モジュール' );

	define( $constpref.'_CONF_ID_TITLE' , 'AMAZON ASSOCIATE ID' );
	define( $constpref.'_CONF_ID_DESC' , '');
	define( $constpref.'_CONF_PP_TITLE' , 'ページあたりのアイテム数' );
	define( $constpref.'_CONF_PP_DESC' , 'モジュールトップ、カテゴリ表示 で使用');
	define( $constpref.'_CONF_NS_TITLE' , '説明部分の表示文字数' );
	define( $constpref.'_CONF_NS_DESC' , 'モジュールトップ、カテゴリ表示 で使用、0 を指定すると制限がなくなります。');
	define( $constpref.'_COM_ALLOW' , 'コメント統合を利用する' );
	define( $constpref.'_COM_DIRNAME' , 'コメント統合する d3forum の dirname' );
	define( $constpref.'_COM_FORUM_ID' , 'コメント統合するフォーラムの番号' );

	define( $constpref.'_BNAME_NEWITEM' , '新着アイテム' );

	define( $constpref.'_ADMENU1' , 'カテゴリー編集' );
	define( $constpref.'_ADMENU2' , '投稿権限' );
	define( $constpref.'_ADMENU3' , '承認' );
	define( $constpref.'_ADMENU4' , '再問合せ' );

	if( !defined('_MD_A_MYMENU_MYTPLSADMIN') ) define( '_MD_A_MYMENU_MYTPLSADMIN' , 'テンプレート管理' );
	if( !defined('_MD_A_MYMENU_MYBLOCKSADMIN') ) define( '_MD_A_MYMENU_MYBLOCKSADMIN' , 'ブロック・アクセス権限' );
	if( !defined('_MD_A_MYMENU_MYLANGADMIN') ) define( '_MD_A_MYMENU_MYLANGADMIN' , '言語定数管理' );

}
?>
