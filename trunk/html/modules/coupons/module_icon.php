<?php
$xoopsOption['nocommon'] = true ;
require '../../mainfile.php' ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
require $mydirpath.'/mytrustdirname.php' ;

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/module_icon.php' ;

?>