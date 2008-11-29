<?php
//Please put this file to the site root.

$mydirname = 'treemenu2' ;	//set directory name


require './mainfile.php' ;

$mydirpath = dirname( __FILE__ ) . '/modules/' . $mydirname ;
$mydirurl = XOOPS_URL.'/modules/'.$mydirname;
require $mydirpath.'/mytrustdirname.php' ;

$_GET['act'] = 'google';
require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/index.php' ;

?>