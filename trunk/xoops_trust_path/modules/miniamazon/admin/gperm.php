<?php
$mod_url = XOOPS_URL . "/modules/$mydirname" ;


include 'adminheader.php';
//include 'funcs.php';

require_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';


/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;
echo "<h3 style='text-align:left;'>".sprintf( _MD_A_MINIAMAZON_GPERM_MANAGER , $xoopsModule->name() )."</h3>\n" ;
echo _MD_A_MINIAMAZON_GP_NOTE ;

$module_id = $xoopsModule->getVar('mid');
$form = new XoopsGroupPermForm( '' , $module_id, 'miniamazon_perm' , '' , 'admin/?act=gperm' );
$form->addItem(1, _MD_A_MINIAMAZON_GP_RIGHT_TO_POST);
$form->addItem(2, _MD_A_MINIAMAZON_GP_RIGHT_TO_P_APPROVE);
$form->addItem(3, _MD_A_MINIAMAZON_GP_RIGHT_TO_EDIT);
$form->addItem(4, _MD_A_MINIAMAZON_GP_RIGHT_TO_E_APPROVE);

echo $form->render();

xoops_cp_footer();
/* ------------------------------------------------------------------ */

?>