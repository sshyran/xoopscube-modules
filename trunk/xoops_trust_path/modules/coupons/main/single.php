<?php
if ( !isset($_GET['lid']) || empty($_GET['lid'])  ) {
	redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
	exit();
}

//GET data
$lid = intval($_GET['lid']) ;
$coupons->countup($lid) ;
$coupons->setWhere('') ;
$coupon_data = $coupons->getCoupon( $lid ) ;



if( empty($coupon_data) ){
  redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
  exit();
}


//---------------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_single.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign('coupon',$coupon_data);

$xoopsTpl->assign( $basic_assign );

$breadplus = assign_get_breadcrumbs_by_tree( $table_cat , 'cid' , 'pid' , 'title' , $coupon_data['cid'] , $mydirurl.'/index.php?cid=%u' );
$breadplus[] = array( 'name'=> $coupon_data['title'] );
$xoopsTpl->assign('xoops_breadcrumbs' , $breadplus );

//comment integration
//$xoopsTpl->assign( 'comment_allow' , intval($xoopsModuleConfig['comment_allow']) ) ;
$xoopsTpl->assign( 'comment_dirname' , htmlspecialchars($xoopsModuleConfig['comment_dirname'],ENT_QUOTES) ) ;
$xoopsTpl->assign( 'comment_forum_id' , intval($xoopsModuleConfig['comment_forum_id']) ) ;

include XOOPS_ROOT_PATH.'/footer.php';
?>
