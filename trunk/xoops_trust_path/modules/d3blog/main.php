<?php
/**
 * @version $Id: main.php 281 2008-02-23 09:49:31Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

$mytrustdirpath = dirname( __FILE__ ) ;

$page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_GET['page'] );

// Let's initiate module base
require $mytrustdirpath.'/include/prepend.inc.php';

require_once $mytrustdirpath.'/include/header.inc.php';

// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'main.php' , $mydirname , $mytrustdirname ) ;

// fork to each pages
if( file_exists( "$mytrustdirpath/main/$page.php" ) ) {
    include "$mytrustdirpath/main/$page.php" ;
} else {
    include "$mytrustdirpath/main/index.php" ;
}


?>