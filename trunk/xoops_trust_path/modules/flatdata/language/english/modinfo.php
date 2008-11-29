<?php
//This was translated on the translation site.

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'flatdata' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) 
{
  define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref .'_NAME','Flatdata');
	define( $constpref .'_DESC','Tiny simple data base module');

	//block name
	define( $constpref .'_BNAME1','FLATDATA BLOCK');
	define( $constpref .'_BNAME2','FLATDATA CATEGORY');

	//admin menu
	define( $constpref .'_ADMENU1','Fileds');
	define( $constpref .'_ADMENU2','Permission');
	define( $constpref .'_ADMENU_MYLANGADMIN' , 'Languages' );
	define( $constpref .'_ADMENU_MYTPLSADMIN' , 'Templates' );
	define( $constpref .'_ADMENU_MYBLOCKSADMIN' , 'Blocks/Permissions' );
	define( $constpref .'_ADMENU_MYPREFERENCES' , 'Altsys Preferences' );

	//config items
	define( $constpref .'_NUM_OF_LIST','Number of data displayed on about page');
	define( $constpref .'_NUM_OF_LIST_D', '');
	define( $constpref .'_EMBED_DISPPERM','Display permission in account information at embed is made only a manager and a pertinent user.');
	define( $constpref .'_EMBED_DISPPERM_D', 'When this is YES, the module side becomes inspection only of the module manager.');
	define( $constpref .'_USE_BBCODE','Assign does data that converts the BBcode, smiley and new line code, etc.');
	define( $constpref .'_USE_BBCODE_D', 'It uses it like {$fd.data_bb[1]} in the template. ');
	define( $constpref .'_CAT_GROUP','Category Group ID(gr_id) that set in XCat');
	define( $constpref .'_CAT_GROUP_D', 'Please set it when you use the category. <a href="http://xoops.trpg-labo.com/" target="_blank">XCat module (Hikawa XOOPS Laboratory)</a>') ; 
}
?>
