<?php
if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirname = basename( dirname(dirname(__FILE__)) ) ;
$mydirpath = dirname(dirname(__FILE__)) ;
require $mydirpath.'/mytrustdirname.php' ;

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/onuninstall.php' ;

?>