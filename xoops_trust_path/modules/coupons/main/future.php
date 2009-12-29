<?php
if( !$isadmin ){
  redirect_header($mydirurl."/",2,_NOPERM);
  exit();
}

$pos = empty( $_GET['p'] ) ? 0 : intval( $_GET['p'] ) ;
$num = 50 ;	//per page

if( isset($_GET['past']) ){
  $coupons->setWhere(' l.status>0 AND l.endtime<'.time().' AND ') ;
  $coupons->setOrder(' ORDER BY l.endtime DESC ') ;
}else{
  $coupons->setWhere(' l.status>0 AND l.starttime>'.time().' AND ') ;
  $coupons->setOrder(' ORDER BY l.starttime ASC ') ;
}
$coupon_data = $coupons->getCoupons( 0 , 0 , $num , $pos ) ;
$numrows = $coupons->getCount( 0 , 0 , $num , $pos );



//--------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname."_future.html";
include XOOPS_ROOT_PATH."/header.php";

// Navigation
if( $pos >= $numrows ) $pos = 0 ;
if( $numrows > $num ) {
	include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' ) ;
	$nav = new XoopsPageNav( $numrows , $num , $pos , 'p'  ) ;
	$nav_html = $nav->renderNav( 10 ) ;
	$last = $pos + $num ;
	if( $last > $numrows ) $last = $numrows ;
	$navinfo = sprintf( _MD_COUPONS_NAVINFO , $pos + 1 , $last , $numrows ) ;
	$xoopsTpl->assign( 'navdisp' , true ) ;
	$xoopsTpl->assign( 'nav' , $nav_html ) ;
	$xoopsTpl->assign( 'navinfo' , $navinfo ) ;
} else {
	$xoopsTpl->assign( 'navdisp' , false ) ;
}

$xoopsTpl->assign('coupons',$coupon_data);

$xoopsTpl->assign( $basic_assign );
$bread[] = isset($_GET['past']) ? array( 'name'=> _MD_PAST ) : array( 'name'=> _MD_FUTURE );
$xoopsTpl->assign('xoops_breadcrumbs' , $bread );
$xoopsTpl->assign('past' , intval(@$_GET['past']) );

include XOOPS_ROOT_PATH.'/footer.php';
?>
