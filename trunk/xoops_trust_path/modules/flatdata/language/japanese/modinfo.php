<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'flatdata' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) 
{
  define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref .'_NAME','フラットデータ');
	define( $constpref .'_DESC','簡易データベースモジュール');

	//block name
	define( $constpref .'_BNAME1','FLATDATA BLOCK');
	define( $constpref .'_BNAME2','FLATDATA カテゴリ');

	//admin menu
	define( $constpref .'_ADMENU1','項目管理');
	define( $constpref .'_ADMENU2','グループ権限');
	define( $constpref .'_ADMENU_MYLANGADMIN' , '言語定数管理' );
	define( $constpref .'_ADMENU_MYTPLSADMIN' , 'テンプレート管理' );
	define( $constpref .'_ADMENU_MYBLOCKSADMIN' , 'ブロック・アクセス権限' );
	define( $constpref .'_ADMENU_MYPREFERENCES' , 'Altsys一般設定' );

	//config items
	define( $constpref .'_NUM_OF_LIST','ページあたりに表示するデータの数');
	define( $constpref .'_NUM_OF_LIST_D', '');
	define( $constpref .'_EMBED_DISPPERM','アカウント情報でのエンベッド時の“閲覧権限”を管理者と該当ユーザのみとする');
	define( $constpref .'_EMBED_DISPPERM_D', 'これが「はい」の場合、モジュール側はモジュール管理者のみの閲覧となります。');
	define( $constpref .'_USE_BBCODE','BBコード、顔アイコン、改行などを変換したデータをアサインする');
	define( $constpref .'_USE_BBCODE_D', 'テンプレートでは {$fd.data_bb[1]} のように利用する');
	define( $constpref .'_CAT_GROUP','XCat で設定したカテゴリーグループのID（gr_id）');
	define( $constpref .'_CAT_GROUP_D', 'カテゴリを利用する場合設定してください。<a href="http://xoops.trpg-labo.com/" target="_blank">XCat モジュール（氷川 XOOPS 研究室）</a>');

}
?>