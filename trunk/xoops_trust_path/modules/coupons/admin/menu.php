<?php
$constpref = '_MI_' . strtoupper( $mydirname ) ; 

$adminmenu[1]['title'] = constant( $constpref.'_ADMENU1') ;
$adminmenu[1]['link']  = "admin/index.php?page=categories" ;
$adminmenu[2]['title'] = constant( $constpref.'_ADMENU2') ;
$adminmenu[2]['link']  = "admin/index.php?page=postperm";
$adminmenu[3]['title'] = constant( $constpref.'_ADMENU3') ;
$adminmenu[3]['link']  = "admin/index.php?page=approval";

$adminmenu[4]['title'] = constant( $constpref.'_ADMENU_MYLANGADMIN' ) ;
$adminmenu[4]['link']  = 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin' ;
$adminmenu[5]['title'] = constant( $constpref.'_ADMENU_MYTPLSADMIN' ) ;
$adminmenu[5]['link']  = 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin' ;
$adminmenu[6]['title'] = constant( $constpref.'_ADMENU_MYBLOCKSADMIN' ) ;
$adminmenu[6]['link']  = 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin' ;
$adminmenu[7]['title'] = constant( $constpref.'_ADMENU_MYPREFERENCES' ) ;
$adminmenu[7]['link']  = 'admin/index.php' ;


?>