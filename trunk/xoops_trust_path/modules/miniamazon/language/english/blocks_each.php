<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'miniamazon' ;
$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'__LOADED' ) ) {
	define( $constpref.'__LOADED' , 1 ) ;


	define( $constpref.'_LANG_NO_CATEGORY' , 'No Category');

}

?>