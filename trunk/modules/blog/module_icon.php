<?php
/**
 * @version $Id: module_icon.php 40 2007-07-21 06:21:54Z hodaka $
 */

$xoopsOption['nocommon'] = true ;
require '../../mainfile.php' ;

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/module_icon.php' ;

?>