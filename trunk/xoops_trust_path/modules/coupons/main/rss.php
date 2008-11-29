<?php
$item_num = 20 ;//Number of link in RSS

$cid = ( isset($_GET['cid']) && !empty($_GET['cid']) ) ? intval($_GET['cid']) : 0 ;



$allcid = $categories->getAllcatKeyCid( "corder,cid" );
$allkeycid = array_keys($allcid);

//channel
$config_handler =& xoops_gethandler('config');
$meta =& $config_handler->getConfigsByCat(XOOPS_CONF_METAFOOTER);
$channel_desc = htmlspecialchars($meta['meta_description'],ENT_QUOTES);
$channel_webmaster = htmlspecialchars($meta['meta_author'],ENT_QUOTES);
$channel_editor = str_replace( '@', ' atmark ' ,$xoopsConfig['adminmail'] );

//data
$coupon_data = $coupons->getCoupons( $cid , 0 , $item_num ) ;




//--------------------------------------------------------
if (function_exists('mb_http_output')) mb_http_output('pass') ;
header ('Content-Type:text/xml; charset=utf-8');
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
//$tpl->xoops_setCaching(2);
//$tpl->xoops_setCacheTime(300);



for( $i=0; $i<count($coupon_data); $i++ ){
  $coupon_data[$i]['title'] = xoops_utf8_encode($coupon_data[$i]['title']) ;
  $coupon_data[$i]['description'] = xoops_utf8_encode(strip_tags($coupon_data[$i]['description'])) ;
  //$coupon_data[$i]['author'] = xoops_utf8_encode(getUnameFromUid( $coupon_data[$i]['uid'] )) ;
  $coupon_data[$i]['author'] = xoops_utf8_encode( $coupon_data[$i]['uname'] ) ;
  $coupon_data[$i]['category'] = xoops_utf8_encode(htmlspecialchars($allcid[$coupon_data[$i]['cid']],ENT_QUOTES)) ;
}
$tpl->assign('coupons',$coupon_data);


$tpl->assign( array(
    'channel_title'       => xoops_utf8_encode(htmlspecialchars($xoopsConfig['sitename']." - ".$xoopsModule->getVar('name'),ENT_QUOTES)) ,
    'channel_link'        => $mydirurl."/" ,
    'channel_lastbuild'   => date('r',time()) ,
    'channel_generator'   => "coupons version ".htmlspecialchars($coupons_version,ENT_QUOTES). " - http://never-ever.info/" ,
    'channel_description' => xoops_utf8_encode($channel_desc) ,
    'channel_category'    => "coupons" ,
    'channel_editor'      => xoops_utf8_encode($channel_editor) ,
    'channel_webmaster'   => xoops_utf8_encode($channel_webmaster) ,
    'channel_language'    => _LANGCODE ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_rss.html' ) ;
exit ;
?>
