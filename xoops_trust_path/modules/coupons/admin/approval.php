<?php

//------------------------------------------------------------------------------------
//DELETE
if( isset($_POST['delete']) && $_POST['delete']==1 && isset($_POST['deleteid']) )
{
  if ( ! $xoopsGTicket->check( true , 'coupons_admin_approval' ) ) {
    redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
  }
  $lid = intval($_POST['deleteid']) ;
  $coupons->delete( $lid ) ;
  redirect_header( $mydirurl."/admin/index.php?page=approval" , 1 , _MD_COUPON_DELETED );
}


//------------------------------------------------------------------------------------
//APPROVE
if( isset($_POST['approval']) && $_POST['approval']==1 && isset($_POST['approvalid']) )
{
  if ( ! $xoopsGTicket->check( true , 'coupons_admin_approval' ) ) {
    redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
  }
  $lid = intval($_POST['approvalid']) ;
  $coupons->statusChange( $lid ) ;

  redirect_header($mydirurl."/admin/index.php?page=approval",1,_MD_APPROVED);
}

//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

$coupons->setWhere(' l.status<=0 AND ') ;
$coupon_data = $coupons->getCoupons() ;
$totalapprovals = $coupons->getCount();
//-------------------------------------------------------------------------
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$tpl =& new XoopsTpl() ;

if( $totalapprovals > 0 ) $tpl->assign('coupons',$coupon_data) ;

$tpl->assign( array(
  'mod_name'       => htmlspecialchars($xoopsModule->getVar('name'),ENT_QUOTES) ,
  'menu_name'      => constant($constprefMI.'_ADMENU3') ,
  'myurl'          => $mydirurl ,
  'totalapprovals' => $totalapprovals ,
  'gticket'        => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'coupons_admin_approval' ) ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_approval.html' ) ;
xoops_cp_footer();
//-------------------------------------------------------------------------
exit();
?>
