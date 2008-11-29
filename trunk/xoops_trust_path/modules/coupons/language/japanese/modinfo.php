<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'coupons' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) 
{
  define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref .'_NAME','クーポン');
	define( $constpref .'_DESC','クーポンを登録・表示するモジュール');

	//block name
	define( $constpref .'_BNAME1','クーポンブロック');

	//admin menu
	define( $constpref .'_ADMENU1','カテゴリ管理');
	define( $constpref .'_ADMENU2','投稿権限管理');
	define( $constpref .'_ADMENU3','承認');
	define( $constpref .'_ADMENU_MYLANGADMIN' , '言語定数管理' );
	define( $constpref .'_ADMENU_MYTPLSADMIN' , 'テンプレート管理' );
	define( $constpref .'_ADMENU_MYBLOCKSADMIN' , 'ブロック・アクセス権限' );
	define( $constpref .'_ADMENU_MYPREFERENCES' , 'Altsys一般設定' );

	//config items
	define( $constpref .'_DATE_TYPE','日付の表記方法');
	define( $constpref .'_DATE_TYPE_DSC', '');
	define( $constpref .'_ADDFIELD','項目追加機能を利用する');
	define( $constpref .'_ADDFIELDDSC', '');
	define( $constpref .'_PERPAGE','１ページ毎に表示するクーポンの件数');
	define( $constpref .'_PERPAGEDSC', '一覧表示で１ページあたりに表示する最大件数を指定してください。');
	define( $constpref .'_QRCODE','QR コードのサイズ（px）');
	define( $constpref .'_QRCODEDSC', 'Google Chart API を利用して QR コードを生成します。この欄を空欄にすると QR コードライブラリ（'.XOOPS_URL.'/common/qrcode/）で生成を試みます');
	define( $constpref .'_CATICON_PATH','カテゴリイメージのパス');
	define( $constpref .'_CATICON_PATHDESC',"このパス内の画像がカテゴリ管理でカテゴリを作成時に選択できます<br />初期値は modules/$mydirname/images/categories です。");
	define( $constpref.'_COM_DIRNAME' , 'コメント統合する d3forum の dirname' );
	define( $constpref.'_COM_FORUM_ID' , 'コメント統合するフォーラムの番号' );

	//notifications
	define( $constpref .'_GLOBAL_NOTIFY', 'モジュール全体');
	define( $constpref .'_GLOBAL_NOTIFYDSC', 'クーポンモジュール全体における通知オプション');

	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFY', '新規クーポン掲載');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYCAP', '新規クーポンが掲載された場合に通知する');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYDSC', '新規クーポンが掲載された場合に通知する');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 新規クーポンが掲載されました');

	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFY', '削除のリクエスト');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYCAP', '削除のリクエストがあった場合に通知する');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYDSC', '削除のリクエストがあった場合に通知する');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 削除のリクエストがありました');

}
?>