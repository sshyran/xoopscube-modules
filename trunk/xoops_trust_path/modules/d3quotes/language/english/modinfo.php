<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3quotes' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","RandomQuotes D3");

// A brief description of this module
define($constpref."_DESC","Insert a block with random quotes.");

// Names of admin menu items
define($constpref."_MENU","Add/Edit Quotes");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME","The Quote");
define($constpref."_BDESC","Shows a random quote");

// admin menu
define($constpref.'_ADMENU_MYLANGADMIN','Languages');
define($constpref.'_ADMENU_MYTPLSADMIN','Templates');
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocks/Permissions');
define($constpref.'_ADMENU_MYPREFERENCES','Preferences');

}

?>