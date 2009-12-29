<?php
/**
 * @version $Id: trackback_send.php 281 2008-02-23 09:49:31Z hodaka $
 */

$xoopsOption['nocommon'] = true;
include_once "../../mainfile.php";

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/trackback_send.php' ;

?>