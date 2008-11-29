<?php

require_once XOOPS_ROOT_PATH.'/class/xoopslists.php';


//category icon
if(!empty($GLOBALS['xoopsModuleConfig']['categoryicon_path'])) {
  $imagepath = coupons_urlCheckReplace( $GLOBALS['xoopsModuleConfig']['categoryicon_path'] ) ;
  $imagepath = preg_replace( array("|^(.+)/$|") , array("$1") , $imagepath ) ;// remove trailing slash ???
  // for imgurl box
  $images_array = XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH."/".$imagepath );
  foreach($images_array as $img){
    $images[] = htmlspecialchars(coupons_urlCheckReplace($img), ENT_QUOTES);
  }
}



//INSERT , UPDATE
if( isset($_POST['edit']) && !empty($_POST['title']) ){
  if ( ! $xoopsGTicket->check( true , 'coupons_admin_categories' ) ) {
    redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
  }
  if( isset($_POST['cid']) && $_POST['cid']>0 ){
    if( $_POST['cid'] == $_POST['pid'] ){
      $msg = "<span style='color:red;'>"._MD_CID_EQUAL_PID."</span>" ;
    }else{
      if( $categories->update(intval($_POST['cid'])) ){
        $msg = _MD_A_COUPONS_CAT_INSERTED ;
      }else{
        $msg = "<span style='color:red;'>"._MD_A_COUPONS_CAT_INSERT_ERR."</span>" ;
      }
    }
  }else{
    if( $categories->insert() ){
      $msg = _MD_A_COUPONS_CAT_INSERTED ;
    }else{
      $msg = "<span style='color:red;'>"._MD_A_COUPONS_CAT_INSERT_ERR."</span>" ;
    }
  }
  redirect_header( "$mydirurl/admin/index.php?page=categories" , 2 , $msg ) ;
}

//DELETE
if( @$_POST['delcat']==1 && @$_POST['cid']>0 ){
  if ( ! $xoopsGTicket->check( true , 'coupons_admin_categories' ) ) {
    redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
  }
  $delcid = intval($_POST['cid']) ;
  if( $categories->delete( $delcid ) ){
    $msg = _MD_A_COUPONS_CAT_DELETED ;
    $childIds =& $categories->getAllChildId($delcid);
    $childIds[] = $delcid ;
    //delete coupons
    if( $dellidnum = $coupons->deleteByCid($childIds) ){
      $msg .= "<br />( ". _MD_COUPON_DELETED ." : $dellidnum )" ;
    }
  }else{
    $msg = "<span style='color:red;'>". _MD_A_COUPONS_CAT_DELETED_ERR ."</span>" ;
  }
  redirect_header( "$mydirurl/admin/index.php?page=categories" , 2 , $msg ) ;
}



//edit category
$editcat = false ;
if( isset($_GET['cid']) ){
  $editcat = $categories->getCategory( intval($_GET['cid']) );
}

//category tree
$cat_tree_array = $categories->getChildTreeArray( 0 , 'corder,cid' ) ;

//pid selector
/*ob_start();
$selected_id = isset($editcat['pid']) ? $editcat['pid'] : 0 ;
$categories->makeMySelBox('corder,cid',$selected_id,true,'pid',"","pid",0);
$pidSelector = ob_get_contents() ;
ob_end_clean();*/
$selected_id = isset($editcat['pid']) ? $editcat['pid'] : 0 ;
$pidSelector = $categories->makeMySelBox('corder,cid',$selected_id,true,'pid',"","pid",0);

/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include dirname(__FILE__).'/mymenu.php' ;

$tpl =& new XoopsTpl() ;
foreach( $cat_tree_array as $cat_node ) {
  extract( $cat_node ) ;
  $prefix = str_replace( '.' , '&nbsp;--' , substr( $prefix , 1 ) ) ;
  $imgurl = coupons_urlCheckReplace( $imgurl ) ;
  $itemnum = getItemsNum($cid);
  $tpl->append( 'categories' , array(
    'cid'     => $cid , 
    'pid'     => $pid , 
    'corder'  => $corder , 
    'prefix'  => $prefix , 
    'title'   => htmlspecialchars($title, ENT_QUOTES) ,
    'imgurl'  => $imgurl , 
    'itemnum' => $itemnum , 
  ) );
}
if( $editcat ) {
  $tpl->assign( 'editcat' , $editcat ) ;
}
$tpl->assign( array(
  'mod_name'    => $xoopsModule->getVar('name') ,
  'menu_name'   => constant($constprefMI.'_ADMENU1') ,
  'myurl'       => $mydirurl ,
  'pidselector' => $pidSelector ,
  'imgfiles'    => $images ,
  'imgpath'     => htmlspecialchars($imagepath,ENT_QUOTES) ,
  'gticket'     => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'coupons_admin_categories' ) ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_categories.html' ) ;
xoops_cp_footer();
/* ------------------------------------------------------------------ */
?>