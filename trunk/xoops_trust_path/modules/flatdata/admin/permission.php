<?php
require_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';

/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

if( ! is_object( $xoopsModule ) ) redirect_header( "$mydirurl/" , 1 , _NOPERM ) ;
echo "<h3 style='text-align:left;'>".$xoopsModule->getVar('name')." - ".constant($constprefMI.'_ADMENU2')."</h3>\n" ;
echo _MD_A_FLATDATA_GP_NOTE ;

$module_id = $xoopsModule->getVar('mid');
$form = new XoopsGroupPermForm( '' , $module_id, 'flatdata_perm' , '' , 'admin/index.php?page=permission' );
$form->addItem( 1, _MD_A_FLATDATA_GP_PERM_TO_POST );
$form->addItem( 2, _MD_A_FLATDATA_GP_PERM_TO_EDIT );
$form->addItem( 3, _MD_A_FLATDATA_GP_PERM_TO_DELETE );

echo $form->render();

xoops_cp_footer();
/* ------------------------------------------------------------------ */
?>