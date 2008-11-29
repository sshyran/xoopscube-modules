<?php

require '../../mainfile.php' ;
if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH in mainfile.php' ) ;

$mydirname = basename( dirname( __FILE__ ) ) ;
$mydirpath = dirname( __FILE__ ) ;
$mydirurl = XOOPS_URL.'/modules/'.$mydirname;

require $mydirpath.'/mytrustdirname.php' ;


require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/index.php' ;



?>