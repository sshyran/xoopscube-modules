<?php
include("admin_header.php");
include_once('mygrouppermform.php');

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;

// language files
if(defined( 'XOOPS_CUBE_LEGACY' )){
	// Cube Legacy without altsys
	include_once( XOOPS_ROOT_PATH."/modules/legacy/language/".$xoopsConfig['language']."/admin.php" ) ;
} else {
	// conventinal X2
	include_once( XOOPS_ROOT_PATH."/modules/system/language/".$xoopsConfig['language']."/admin.php" ) ;
}


function list_groups()
{
	global $xoopsModule ;

	$global_perms_array = array(
		D3IMGTAG_GPERM_INSERTABLE => _D3IMGTAG_GPERM_G_INSERTABLE ,
		D3IMGTAG_GPERM_SUPERINSERT | D3IMGTAG_GPERM_INSERTABLE => _D3IMGTAG_GPERM_G_SUPERINSERT ,
//		D3IMGTAG_GPERM_EDITABLE => _D3IMGTAG_GPERM_G_EDITABLE ,
		D3IMGTAG_GPERM_SUPEREDIT | D3IMGTAG_GPERM_EDITABLE => _D3IMGTAG_GPERM_G_SUPEREDIT ,
//		D3IMGTAG_GPERM_DELETABLE => _D3IMGTAG_GPERM_G_DELETABLE ,
		D3IMGTAG_GPERM_SUPERDELETE | D3IMGTAG_GPERM_DELETABLE => _D3IMGTAG_GPERM_G_SUPERDELETE ,
		D3IMGTAG_GPERM_RATEVIEW => _D3IMGTAG_GPERM_G_RATEVIEW ,
		D3IMGTAG_GPERM_RATEVOTE | D3IMGTAG_GPERM_RATEVIEW => _D3IMGTAG_GPERM_G_RATEVOTE ,
		D3IMGTAG_GPERM_TELLAFRIEND => _D3IMGTAG_GPERM_G_TELLAFRIEND ,
	) ;

	$form = new MyXoopsGroupPermForm( '' , $xoopsModule->mid() , 'd3imgtag_global' , _AM_D3IMGTAG_ALBM_GROUPPERM_GLOBALDESC ) ;
	foreach( $global_perms_array as $perm_id => $perm_name ) {
		$form->addItem( $perm_id , $perm_name ) ;
	}

	echo $form->render() ;
}



if( ! empty( $_POST['submit'] ) ) {
	include( "mygroupperm.php" ) ;
	redirect_header("index.php?page=groupperm_global" , 1 , _AM_D3IMGTAG_ALBM_GPERMUPDATED );
}

xoops_cp_header() ;
include dirname(__FILE__).'/mymenu.php' ;
echo "" ;
echo "<h3 style='text-align:left;'>".$xoopsModule->name()."</h3>\n" ;
echo "<h4 style='text-align:left;'>"._AM_D3IMGTAG_ALBM_GROUPPERM_GLOBAL."</h4>\n" ;
list_groups() ;
xoops_cp_footer() ;

?>