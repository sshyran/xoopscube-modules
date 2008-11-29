<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'treemenu' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
    define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref."_MODULE_NAME" , "TREE MENU 2" );
	define( $constpref."_MODULE_DSC" , "It is a module that displays the menu in the block. Moreover, it is a sitemap module." );

	define( $constpref."_BLOCK_NAME" , "TREEMENU" );
	define( $constpref."_BLOCK_DSC" , "" );
	define( $constpref."_BLOCK2_NAME" , "SITEMAP" );
	define( $constpref."_BLOCK2_DSC" , "" );

	define( $constpref."_VIEWTYPE_TITLE" , "Display form in tree menu block" );
	define( $constpref."_VIEWTYPE_DSC" , "1.ALL : All registered menus are displayed. <br />
				2.Current menu & lower tier : A menu now at the time of be selected and the menu under the one hierarchy are displayed. <br />
				3.Current menu & Current block : Everything is displayed in the same block of the selected menu. <br />
				4.Second Hierarchy : Two subordinate position layers all that have been selected are displayed all of the second hierarchy. <br />
			");
	define( $constpref."_VIEWTYPE_OPT1" , "1.ALL" );
	define( $constpref."_VIEWTYPE_OPT2" , "2.Current menu & lower tier" );
	define( $constpref."_VIEWTYPE_OPT3" , "3.Current menu & Current block" );
	define( $constpref."_VIEWTYPE_OPT4" , "4.Second Hierarchy" );
	define( $constpref."_TARGETBLANK_TIT" , "Target Blank" );
	define( $constpref."_TARGETBLANK_DSC" , 'target ="_ blank" is added to A tag at an external link. ' );
	define( $constpref."_COLUMNS_TITLE" , "Number of rows when site map is displayed" );
	define( $constpref."_COLUMNS_DSC" , "Site map displayed when it accesses ".XOOPS_URL."/modules/$mydirname/ " );

	// ADMIN MENU
	define( $constpref."_ADMINMENU1" , "Menu Manager" );
	define( $constpref."_ADMINMENU2" , "Permissions of Menu" );

	define( $constpref.'_ADMENU_MYLANGADMIN' , 'Languages' );
	define( $constpref.'_ADMENU_MYTPLSADMIN' , 'Templates' );
	define( $constpref.'_ADMENU_MYBLOCKSADMIN' , 'Blocks/Permissions' );
	define( $constpref.'_ADMENU_MYPREFERENCES' , 'Altsys Preferences' );


}
?>