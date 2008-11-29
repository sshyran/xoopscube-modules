<?php

$xoopsOption['nocommon'] = true ;
require_once '../../mainfile.php' ;

if( ! defined( 'XOOPS_TRUST_PATH' ) || XOOPS_TRUST_PATH == '' ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
require $mydirpath.'/mytrustdirname.php' ;

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/images/module_icon.php' ;


?>