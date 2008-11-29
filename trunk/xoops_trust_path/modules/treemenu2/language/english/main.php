<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'treemenu' ;
$constpref = '_MD_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
    define( $constpref.'_LOADED' , 1 ) ;


	define( $constpref.'_POPUPWIN' , 'pop-up' );


}
?>