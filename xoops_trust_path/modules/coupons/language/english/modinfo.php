<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'coupons' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) 
{
  define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref .'_NAME','Coupons');
	define( $constpref .'_DESC','Module to register and display coupons');

	//block name
	define( $constpref .'_BNAME1','Coupons Block');

	//admin menu
	define( $constpref .'_ADMENU1','Categories');
	define( $constpref .'_ADMENU2','Post Permission');
	define( $constpref .'_ADMENU3','Approval');
	define( $constpref .'_ADMENU_MYLANGADMIN' , 'Languages' );
	define( $constpref .'_ADMENU_MYTPLSADMIN' , 'Templates' );
	define( $constpref .'_ADMENU_MYBLOCKSADMIN' , 'Blocks' );
	define( $constpref .'_ADMENU_MYPREFERENCES' , 'Preferences' );

	//config items
	define( $constpref .'_DATE_TYPE','Method of writing date');
	define( $constpref .'_DATE_TYPE_DSC', '');
	define( $constpref .'_ADDFIELD','The item addition function is used.');
	define( $constpref .'_ADDFIELDDSC', '');
	define( $constpref .'_PERPAGE','How many coupons displayed per page?');
	define( $constpref .'_PERPAGEDSC', 'Please specify the maximum number of coupons listed on each page.');
	define( $constpref .'_QRCODE','Size of QR code (px)');
	define( $constpref .'_QRCODEDSC', 'The QR code is generated using Google Chart API. When this is empty, generation is tried from QR code library ('.XOOPS_URL.'/common/qrcode/)');
	define( $constpref .'_CATICON_PATH','Directory for image files');
	define( $constpref .'_CATICON_PATHDESC',"A relative path of images for categories can be set here. <br />The initial value is : uploads/categories/$mydirname");
	define( $constpref.'_COM_DIRNAME' , 'Dirname of d3forum that does comment integration' );
	define( $constpref.'_COM_FORUM_ID' , 'Forum ID where comment integration is done' );

	//notifications
	define( $constpref .'_GLOBAL_NOTIFY', 'The entire module');
	define( $constpref .'_GLOBAL_NOTIFYDSC', 'Notification option in the entire coupons module');

	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFY', 'New coupon publishing');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYCAP', 'It notifies when a new coupon is published.');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYDSC', 'It notifies when a new coupon is published.');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: A new coupon was published.');

	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFY', 'Request of deletion');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYCAP', 'It notifies when the deletion is requested.');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYDSC', 'It notifies when the deletion is requested.');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: The deletion was requested.');


}
?>
