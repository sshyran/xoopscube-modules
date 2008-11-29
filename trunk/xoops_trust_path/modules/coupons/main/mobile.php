<?php
$lid = isset($_GET['lid']) ? intval($_GET['lid']) : 0 ;


$mobileitems = $categories->checkItems($mydirname,'mobile') ;

require_once XOOPS_ROOT_PATH.'/class/template.php';
$xoopsTpl = new XoopsTpl();


//--------------------------------------------------------------------------
$coupons->countup($lid);
$coupons->setWhere('') ;
$couponData = $coupons->getCoupon( $lid );
$couponData = sjisEncode( $couponData ) ;

$xoopsTpl->assign( 'coupon' , $couponData );


$category = $categories->getCategory( $couponData['cid'] );
$xoopsTpl->assign( 'category' , htmlspecialchars($category['title'],ENT_QUOTES) );


$xmobile = false ;
if( file_exists(XOOPS_ROOT_PATH."/modules/xmobile/plugins/$mydirname.php") ){
  $module_hanlder =& xoops_gethandler( 'module' ) ;
  $module =& $module_hanlder->getByDirname('xmobile') ;
  if( is_object( $module ) && $module->getVar('isactive') ) $xmobile = true ;
}


$xoopsTpl->assign( 'coupon_msg' , convert_encoding_sjis(_MD_COUPON_MSG) );
$xoopsTpl->assign( 'limittime' , convert_encoding_sjis(_MD_LIMITTIME) );
$xoopsTpl->assign( 'xoops_sitename' , convert_encoding_sjis(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)) );
$xoopsTpl->assign( 'module_name' , convert_encoding_sjis(htmlspecialchars($xoopsModule->getVar('name'))) );
$xoopsTpl->assign( 'mobileitems' , $mobileitems );
$xoopsTpl->assign( 'xmobile', $xmobile );

$xoopsTpl->assign( $basic_assign );

if (function_exists('mb_http_output')) mb_http_output('pass') ;
header ('Content-Type:text/html; charset=Shift_JIS');

$xoopsTpl->display('db:'.$mydirname."_mobile.html");
?>