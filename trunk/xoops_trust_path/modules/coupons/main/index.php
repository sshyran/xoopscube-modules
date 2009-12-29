<?php
$linkuid = ( isset($_GET['uid']) && !empty($_GET['uid']) ) ? intval(($_GET['uid'])) : 0 ;


//--------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname."_index.html";
include XOOPS_ROOT_PATH."/header.php";

$cats = $categories->makeCategoryBlock($mydirname) ;
$xoopsTpl->assign( 'categories' , $cats ) ;

$numrows = $coupons->getCount(0,$linkuid);

if( $numrows > 0 ){ 
  //navi
  $show = isset($_GET['show']) ? intval($_GET['show']) : $xoopsModuleConfig['perpage'] ;
  $p = empty( $_GET['p'] ) ? 0 : intval( $_GET['p'] ) ;
  if( $p >= $numrows ) $p = 0 ;
  if( $numrows > $show ) {
	include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' ) ;
	$extra_arg  = "show={$show}" ;//&amp;orderby={$orderbyout}
	$extra_arg .= ( $linkuid > 0 ) ? "uid=$linkuid" : "" ;
	$nav = new XoopsPageNav( $numrows , $show , $p , 'p' , $extra_arg ) ;//NE+, "num=$num"
	$nav_html = $nav->renderNav( 10 ) ;
	$last = $p + $show ;
	if( $last > $numrows ) $last = $numrows ;
	$navinfo = sprintf( _MD_COUPONS_NAVINFO , $p + 1 , $last , $numrows ) ;
	$xoopsTpl->assign( 'navdisp' , true ) ;
	$xoopsTpl->assign( 'nav' , $nav_html ) ;
	$xoopsTpl->assign( 'navinfo' , $navinfo ) ;
  } else {
	$xoopsTpl->assign( 'navdisp' , false ) ;
  }

  $allcid = $categories->getAllcatKeyCid( "corder,cid" );
  //$allkeycid = array_keys($allcid);
  if( isset($allcid) ) $xoopsTpl->assign('allcat', $allcid );

  $couponData = $coupons->getCoupons( 0 , $linkuid , $show , $p );
  $xoopsTpl->assign( 'coupons' , $couponData );
} //END of if( $numrows > 0 )


$xoopsTpl->assign( $basic_assign );
if( $linkuid > 0 ){
  $member_handler =& xoops_gethandler('member') ;
  $linkuidOBJ =& $member_handler->getUser($linkuid) ;
  $linkuidname = $linkuidOBJ->uname() ;
  $bread[] = array( 'name'=> htmlspecialchars(sprintf(_MD_SUBMITTER_SITE,$linkuidname),ENT_QUOTES) );
  $xoopsTpl->assign('xoops_breadcrumbs' , $bread );
  $xoopsTpl->assign('linkuid_number', sprintf(_MD_LINKUID_NUM,$linkuidname,$numrows));
  $xoopsTpl->assign('linkuid', $linkuid );
  $xoopsTpl->assign('linkuidname', htmlspecialchars($linkuidname,ENT_QUOTES) );
}else{
  $xoopsTpl->assign('lang_thereare', sprintf(_MD_THEREARE,$numrows));
}

//comment integration
//$xoopsTpl->assign( 'comment_allow' , intval($xoopsModuleConfig['comment_allow']) ) ;
$xoopsTpl->assign( 'comment_dirname' , htmlspecialchars($xoopsModuleConfig['comment_dirname'],ENT_QUOTES) ) ;
$xoopsTpl->assign( 'comment_forum_id' , intval($xoopsModuleConfig['comment_forum_id']) ) ;

include XOOPS_ROOT_PATH.'/footer.php';
?>