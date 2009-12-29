<?php
$lid = isset($_GET['lid']) ? intval($_GET['lid']) : 0 ;


$mobileitems = $categories->checkItems($mydirname,'print') ;

$coupons->countup($lid);
$coupons->setWhere('') ;
$couponData = $coupons->getCoupon( $lid );

//$allcid = $categories->getAllcatKeyCid( "corder,cid" );
$category = $categories->getCategory( $couponData['cid'] );

$file = '' ;
if( $mobileitems[$couponData['cid']]['title'] ){
  $file = XOOPS_ROOT_PATH."/modules/$mydirname/images/p/title_". $couponData['cid'] .".". $mobileitems[$couponData['cid']]['title'] ;
}elseif( file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/images/p/title_d.jpg") ){
  $file = XOOPS_ROOT_PATH."/modules/$mydirname/images/p/title_d.jpg" ;
}
if( !empty($file) ){
  $size = getimagesize($file) ;
}


//--------------------------------------------------------------------------
header( 'Content-Type:text/html; charset=' . _CHARSET ) ;
include XOOPS_ROOT_PATH."/header.php";

if( isset($size) ){
  $xoopsTpl->assign( 'width' , intval($size[0])."px" );
  $xoopsTpl->assign( 'height' , intval($size[1])."px" );
  $xoopsTpl->assign( 'topposition' , $size[1]/2 - 30 );
}else{
  $xoopsTpl->assign( 'width' , "100%" );
  $xoopsTpl->assign( 'height' , "300px" );
  $xoopsTpl->assign( 'topposition' , "80px" );
}
$xoopsTpl->assign( 'coupon' , $couponData );
$xoopsTpl->assign( 'category' , htmlspecialchars($category['title'],ENT_QUOTES) );
$xoopsTpl->assign( 'module_name' , htmlspecialchars($xoopsModule->getVar('name'),ENT_QUOTES) );
$xoopsTpl->assign( 'mobileitems' , $mobileitems );
$xoopsTpl->assign( $basic_assign );

$xoopsTpl->display('db:'.$mydirname."_print.html");
?>