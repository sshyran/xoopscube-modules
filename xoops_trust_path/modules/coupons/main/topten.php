<?php
$limit = ( isset($_GET['hits']) && !empty($_GET['hits']) ) ? intval($_GET['hits']) : 50 ;
$cid = ( isset($_GET['cid']) && !empty($_GET['cid']) ) ? intval($_GET['cid']) : 0 ;


$limit = ( $limit > 100 ) ? 50 : ceil($limit/10)*10 ;

$coupons->setOrder( " ORDER BY l.hits DESC " ) ;
$coupon_data = $coupons->getCoupons( $cid , 0 , $limit ) ;

//-------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_topten.html';
include XOOPS_ROOT_PATH."/header.php";

$category = $categories->getCategory( $cid );
$ctitle = ( $category ) ? htmlspecialchars($category['title'],ENT_QUOTES) : '' ;
$xoopsTpl->assign( 'category' , $ctitle );

$xoopsTpl->assign('coupons',$coupon_data);
$xoopsTpl->assign('limit' ,$limit);
$xoopsTpl->assign( $basic_assign );
include XOOPS_ROOT_PATH.'/footer.php';
?>