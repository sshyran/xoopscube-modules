<?php

$constpref = '_MI_' . strtoupper( $mydirname ) ; 


$adminmenu[0]['title'] = constant( $constpref.'_ADMENU1');	//	�J�e�S���[�ҏW
$adminmenu[0]['link'] = "admin/index.php?act=cat";
$adminmenu[1]['title'] = constant( $constpref.'_ADMENU2');	//	���e����
$adminmenu[1]['link'] = "admin/index.php?act=gperm";
$adminmenu[2]['title'] = constant( $constpref.'_ADMENU3');	//	���F
$adminmenu[2]['link'] = "admin/index.php?act=stats";
$adminmenu[3]['title'] = constant( $constpref.'_ADMENU4');	//	�Ė⍇��
$adminmenu[3]['link'] = "admin/index.php?act=req";


?>