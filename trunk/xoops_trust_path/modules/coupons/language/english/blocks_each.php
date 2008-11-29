<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'coupons' ;
$constpref = '_MB_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
  define( $constpref.'_LOADED' , 1 ) ;

  define($constpref.'_LANG_LIMITDATE', 'Expiration date');

}
?>