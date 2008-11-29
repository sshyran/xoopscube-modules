<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'miniamazon' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
  define( $constpref.'_LOADED' , 1 ) ;


	define( $constpref.'_NAME' , 'MiniAmazon' );
	
define ($constpref. '_DESC', 'Amazon Simple module');

define ($constpref. '_CONF_ID_TITLE', 'Amazon Associate ID');
Define ($constpref. '_CONF_ID_DESC','');
define ($constpref. '_CONF_PP_TITLE', 'Number of items per page');
define ($constpref. '_CONF_PP_DESC', 'Select the maximum number of items displayed on Category View');
define ($constpref. '_CONF_NS_TITLE', 'How many characters to display in description?');
define ($constpref. '_CONF_NS_DESC', 'If you set this value to 0 then the description will be no longuer limited in Category View.');
define ($constpref. '_COM_ALLOW', 'd3forum Comment-integration');
define ($constpref. '_COM_DIRNAME', 'd3forum dirname for comments integration');
define ($constpref. '_COM_FORUM_ID', 'Comment-integration: forum ID ');

define ($constpref. '_BNAME_NEWITEM', 'New Item');

define ($constpref. '_ADMENU1', 'Categories');
define ($constpref. '_ADMENU2', 'Management');
Define ($constpref. '_ADMENU3', 'Approve');
define ($constpref. '_ADMENU4', 'Amazon Web Service');

if (! defined ( '_MD_A_MYMENU_MYTPLSADMIN')) define ( '_MD_A_MYMENU_MYTPLSADMIN', 'Templates');
if (! defined ( '_MD_A_MYMENU_MYBLOCKSADMIN')) define ( '_MD_A_MYMENU_MYBLOCKSADMIN', 'Permissions');
if (! defined ( '_MD_A_MYMENU_MYLANGADMIN')) define ( '_MD_A_MYMENU_MYLANGADMIN', 'Languages');

}
?>
