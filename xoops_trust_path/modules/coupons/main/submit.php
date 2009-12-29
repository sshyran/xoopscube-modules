<?php
if( !$postperm ){
  redirect_header(XOOPS_URL."/user.php",2,_NOPERM);
  exit();
}

//add language file (permission)
if( is_object($langman) ){
  $langman->read( 'admin.php' , $mydirname , $mytrustdirname ) ;
}


//----------------------------------------------------------------------
//----------------------------------------------------------------------
if (!empty($_POST['submit'])) {
  //gticket check
  if ( ! $xoopsGTicket->check( true , 'coupons_submit' ) ) {
    redirect_header($mydirurl."/",3,$xoopsGTicket->getErrors());
    exit();
  }
  //spam check JS is necessary.
  if( !is_object($xoopsUser) && !empty($_POST['CP']) ){
    redirect_header($mydirurl."/",3,_MD_NEED_JS);
    exit();
  }

  $coupons->insert();

  // NOtification
  $notification_handler =& xoops_gethandler('notification');
  $tags = array();
  $tags['LINK_NAME'] = htmlspecialchars($coupons->saveData['title'],ENT_QUOTES);
  $tags['LINK_URL'] = $mydirurl .'/index.php?lid='. intval($coupons->saveData['lid']);
  if ( $post_approval == 1 ) {//auto approval
    $notification_handler->triggerEvent('global', 0, 'new_coupon', $tags);
    redirect_header($mydirurl."/",2,_MD_RECEIVED."<br />"._MD_ISAPPROVED."");
  }

  redirect_header($mydirurl."/",2,_MD_RECEIVED);
  exit();
}
//----------------------------------------------------------------------
//----------------------------------------------------------------------




$firstCids = $categories->getFirstChild(0,"corder,cid");
if( empty($firstCids) ){
  redirect_header($mydirurl."/",2,_MD_NO_CATEGORY);
}
$getcid = isset($_GET['cid']) ? intval( $_GET['cid'] ) : 0 ;
$selbox = $categories->makeMySelBox( 'corder,cid' , $getcid , 1 , 'cid' /*,"","cid",0*/);

//----------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_submit.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign('category_selbox',$selbox);
$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign('gticket',$xoopsGTicket->getTicketHtml(__LINE__,1800,'coupons_submit'));

$xoopsTpl->assign( 'xoops_module_header' , '<link rel="stylesheet" type="text/css" href="'.$mydirurl.'/js/calendar.css" media="all"><script type="text/javascript" src="'.$mydirurl.'/js/yahoo-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/dom-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/event-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/calendar-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/script.js"></script>' . $xoopsTpl->get_template_vars("xoops_module_header") );
include XOOPS_ROOT_PATH.'/footer.php';
//----------------------------------------------------------------------
?>