<?php

$mydirname = basename( dirname ( dirname (  __FILE__ ) ) ) ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

$adminmenu[0]['title'] = constant($constpref . '_ADMENU_GROUPPERM');
$adminmenu[0]['link'] = "admin/groupperm.php";



$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYTPLSADMIN,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin');
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYBLOCKSADMIN,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin');
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYPREFERENCES,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences');