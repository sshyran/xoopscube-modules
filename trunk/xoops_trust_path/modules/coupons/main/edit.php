<?php
$lid = (isset($_POST['lid']) && !empty($_POST['lid'])) ? intval($_POST['lid']) : 0 ;
$lid = ( $lid==0 && isset($_GET['lid']) && !empty($_GET['lid']) ) ? intval($_GET['lid']) : $lid ;
if ( $lid==0 ){
  redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
  exit();
}

//GET coupon
$coupons->setWhere('') ;
$coupon_data = $coupons->getCoupon( $lid , 'edit' ) ;

//data_exists
if( empty($coupon_data) ){
  redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
  exit();
}

//permission check
if( !$editperm || !($isadmin || $coupon_data['uid']==$uid) ){
  redirect_header($mydirurl."/",2,_NOPERM);
  exit();
}

//add language file (for permission lang)
if( is_object($langman) ){
  $langman->read( 'admin.php' , $mydirname , $mytrustdirname ) ;
}



//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------
if (!empty($_POST['edit'])) {
  //gticket check
  if ( ! $xoopsGTicket->check( true , 'coupon_mod' ) ) {
    redirect_header($mydirurl."/",3,$xoopsGTicket->getErrors());
    exit();
  }
  //spam check , JS is necessary.
  if( !is_object($xoopsUser) && !empty($_POST['CP']) ){
    redirect_header($mydirurl."/",3,_MD_NEED_JS);
    exit();
  }

  $coupons->update( $lid , $coupon_data['status'] ) ;

	// Notify of new link (anywhere) and new link in category.
    //$tags = array();
    //$tags['MODIFYREPORTS_URL'] = $mydirurl .'/admin/index.php?page=modlink&amp;lid=$lid';
    //$notification_handler =& xoops_gethandler('notification');
    //$notification_handler->triggerEvent('global', 0, 'link_modify', $tags);
    //unset($coupons->saveData) ;
  if( !$edit_approval ){
    redirect_header($mydirurl."/",2,_MD_MODIFY_OK_NOTAPP);
  }else{
    redirect_header($mydirurl."/",2,_MD_MODIFY_OK);//
  }
  exit();
}

//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//DELETE
if( $delperm && !empty($_POST['dellink']) ){
  //gticket check
  if ( ! $xoopsGTicket->check( true , 'coupon_mod' ) ) {
    redirect_header($mydirurl."/",3,$xoopsGTicket->getErrors());
    exit();
  }
  if ( !isset($_POST['lid']) || empty($_POST['lid']) ){
    redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
    exit();
  }
  $lid = intval($_POST['lid']) ;
  if( !$del_approval ){
    $coupons->deleteReq( $lid );
    
    $tags = array();
    $tags['MODDELETE_URL'] = $mydirurl .'/admin/index.php?page=edit&amp;lid=$lid';
    $notification_handler =& xoops_gethandler('notification');
    $notification_handler->triggerEvent('global', 0, 'coupon_delete', $tags);
    redirect_header( $mydirurl."/" , 2 , _MD_COUPON_DEL_REQ );
  }else{
    $coupons->delete( $lid );
    redirect_header( $mydirurl."/" , 2 , _MD_COUPON_DELETED );
  }
  exit();
}



//----------------------------------------------------------------------




//date
$dateselector = makeDateSelector( $coupon_data['regidate_STP'] ) ;

//----------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_edit.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign('coupon',$coupon_data);
$xoopsTpl->assign('dateselector', $dateselector );

$selbox = $categories->makeMySelBox('corder,cid', $coupon_data['cid'] ,true,'cid');
$xoopsTpl->assign('category_selbox',$selbox);

$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign('gticket',$xoopsGTicket->getTicketHtml(__LINE__,1800,'coupon_mod'));

$xoopsTpl->assign( 'xoops_module_header' , '<link rel="stylesheet" type="text/css" href="'.$mydirurl.'/js/calendar.css" media="all"><script type="text/javascript" src="'.$mydirurl.'/js/yahoo-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/dom-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/event-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/calendar-min.js"></script><script type="text/javascript" src="'.$mydirurl.'/js/script.js"></script>' . $xoopsTpl->get_template_vars("xoops_module_header") );

include XOOPS_ROOT_PATH.'/footer.php';
//----------------------------------------------------------------------
exit();
?>