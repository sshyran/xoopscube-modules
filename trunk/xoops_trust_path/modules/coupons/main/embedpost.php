<?php
if( !$postperm ) return ;

//add language file (permission)
if( is_object($langman) ){
  $langman->read( 'admin.php' , $mydirname , $mytrustdirname ) ;
}

//----------------------------------------------------------------------
if (!empty($_POST['submit'])) {
  $redirect = isset($_POST['filequery']) ? $myts->stripSlashesGPC($_POST['filequery']) : '' ;
  $embed_dir = isset($_POST['embed_dir']) ? $myts->stripSlashesGPC($_POST['embed_dir']) : '' ;
  $redirect = "modules/$embed_dir/".$redirect ;
  $redirect = htmlspecialchars(coupons_urlCheckReplace($redirect),ENT_QUOTES) ;

  //gticket check
  if ( ! $xoopsGTicket->check( true , 'coupons_embed_submit' ) ) {
    redirect_header( XOOPS_URL."/".$redirect ,3,$xoopsGTicket->getErrors());
    exit();
  }
  //spam check JS is necessary.
  if( !is_object($xoopsUser) && !empty($_POST['CP']) ){
    redirect_header( XOOPS_URL."/".$redirect ,3,_MD_NEED_JS);
    exit();
  }

  $coupons->insert();

  // Notification
  $notification_handler =& xoops_gethandler('notification');
  $tags = array();
  $tags['LINK_NAME'] = htmlspecialchars($coupons->saveData['title'],ENT_QUOTES);
  $tags['LINK_URL'] = $mydirurl .'/index.php?lid='. intval($coupons->saveData['lid']);
  if ( $post_approval == 1 ) {//auto approval
    $notification_handler->triggerEvent('global', 0, 'new_coupon', $tags);
    redirect_header( XOOPS_URL."/".$redirect ,2,_MD_RECEIVED."<br />"._MD_ISAPPROVED."");
    exit();
  }
  redirect_header( XOOPS_URL."/".$redirect ,2,_MD_RECEIVED);
  exit();
}
//----------------------------------------------------------------------

?>