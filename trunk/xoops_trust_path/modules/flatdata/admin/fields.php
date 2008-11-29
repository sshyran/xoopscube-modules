<?php

/* ------------------------------------------------------------------ */
//INSERT , UPDATE
if( isset($_POST['edit']) ){
  if ( ! $xoopsGTicket->check( true , 'flatdata_admin_fields' ) ) {
    redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
  }
  $msg = "<span style='color:red;'>"._MD_A_FLATDATA_FLD_DB_ERR."</span>" ;
  if( !empty($_POST['fname']) ){
    if( isset($_POST['fid']) && $_POST['fid']>0 ){
      if( $fields->update(intval($_POST['fid'])) ) $msg = _MD_A_FLATDATA_FLD_INSERTED ;
    }else{
      if( $fields->insert() ) $msg = _MD_A_FLATDATA_FLD_INSERTED ;
    }
  }
  redirect_header( "$mydirurl/admin/index.php?page=fields" , 2 , $msg ) ;
}

/* ------------------------------------------------------------------ */
//DELETE
if( @$_POST['delf']==1 && @$_POST['fid']>0 ){
  if ( ! $xoopsGTicket->check( true , 'flatdata_admin_fields' ) ) {
    redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
  }
  $msg = "<span style='color:red;'>". _MD_A_FLATDATA_FLD_DELETED_ERR ."</span>" ;
  if( $fields->delete(intval($_POST['fid'])) ){
    $msg = _MD_A_FLATDATA_FLD_DELETED ;
  }
  redirect_header( "$mydirurl/admin/index.php?page=fields" , 2 , $msg ) ;
}
/* ------------------------------------------------------------------ */





//edit fid
$edit = false ;
if( isset($_GET['fid']) ){
  $edit = $fields->getField( intval($_GET['fid']) );
}

$allfields = $fields->getAllFields();
/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include dirname(__FILE__).'/mymenu.php' ;

$tpl =& new XoopsTpl() ;
if( !empty($allfields) ){
	$tpl->assign( 'fields' , $allfields );
}
if( $edit ) {
  $tpl->assign( 'editfield' , $edit ) ;
}
$tpl->assign( array(
  'mod_name'    => $xoopsModule->getVar('name') ,
  'menu_name'   => constant($constprefMI.'_ADMENU1') ,
  'myurl'       => $mydirurl ,
  'gticket'     => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'flatdata_admin_fields' ) ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_fields.html' ) ;
xoops_cp_footer();
/* ------------------------------------------------------------------ */
?>