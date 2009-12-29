<?php
require_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';

/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mydirurl/" , 1 , _NOPERM ) ;
echo "<div class='adminnavi' style='text-align:left;'>".$xoopsModule->getVar('name')." &raquo;&raquo; ".constant($constprefMI.'_ADMENU2')."</div>\n" ;
echo "<div class='resultMsg'>"._MD_A_COUPONS_GP_NOTE."</div>";

$module_id = $xoopsModule->getVar('mid');
$form = new XoopsGroupPermForm( '' , $module_id, 'coupons_perm' , '' , 'admin/index.php?page=postperm' );
$form->addItem( 1, _MD_A_COUPONS_GP_PERM_TO_POST );
$form->addItem( 2, _MD_A_COUPONS_GP_PERM_TO_P_APPROVE );
$form->addItem( 3, _MD_A_COUPONS_GP_PERM_TO_EDIT );
$form->addItem( 4, _MD_A_COUPONS_GP_PERM_TO_E_APPROVE );
$form->addItem( 5, _MD_A_COUPONS_GP_PERM_TO_DELETE );
$form->addItem( 6, _MD_A_COUPONS_GP_PERM_TO_D_APPROVE );

echo $form->render();

xoops_cp_footer();
/* ------------------------------------------------------------------ */
?>