<?php
require_once $mytrustdirpath .'/class/gtickets.php' ;
require_once $mytrustdirpath .'/include/functions.php';
require_once $mytrustdirpath .'/include/version.php';

//DB table
$table_coupons    = $xoopsDB->prefix( $mydirname."_coupons" ) ;
$table_cat      = $xoopsDB->prefix( $mydirname."_cat" ) ;
$table_text     = $xoopsDB->prefix( $mydirname."_text" ) ;

$myts = & MyTextSanitizer::getInstance();

//xoopsuser and permission check
if ( is_object($xoopsUser) ) {
	$uid = $xoopsUser->uid() ;
	$uname = $xoopsUser->uname();
	$realname = $xoopsUser->name() ? $xoopsUser->name() : '' ;
	$isadmin = $xoopsUser->isAdmin( $xoopsModule->getVar('mid') ) ;
	$groups = $xoopsUser->getGroups();
}else{
	$uid = 0 ;
	$uname = isset($xoopsConfig) ? htmlspecialchars($xoopsConfig['anonymous'],ENT_QUOTES) : '' ;
	$realname = '' ;
	$isadmin = false ;
	$groups = XOOPS_GROUP_ANONYMOUS;
}

//投稿権限:1 承認不要:2　、編集権限:3 承認不要:4　、削除権限:5 承認不要:6
$mid = $xoopsModule->getVar('mid');
$gperm =& xoops_gethandler('groupperm');
$postperm      = ( $gperm->checkRight('coupons_perm',1,$groups,$mid) || $isadmin ) ? true : false ;
$post_approval = ( $gperm->checkRight('coupons_perm',2,$groups,$mid) || $isadmin ) ? true : false ;
$editperm      = ( ($gperm->checkRight('coupons_perm',3,$groups,$mid) && is_object($xoopsUser)) || $isadmin ) ? true : false ;
$edit_approval = ( ($gperm->checkRight('coupons_perm',4,$groups,$mid) && is_object($xoopsUser)) || $isadmin ) ? true : false ;
$delperm       = ( ($gperm->checkRight('coupons_perm',5,$groups,$mid) && is_object($xoopsUser)) || $isadmin ) ? true : false ;
$del_approval  = ( ($gperm->checkRight('coupons_perm',6,$groups,$mid) && is_object($xoopsUser)) || $isadmin ) ? true : false ;


//ADD FIELD
$addfield = $xoopsModuleConfig['addfield'] ? true : false ;

//category instance
require_once $mytrustdirpath."/class/categories.class.php" ;
$categories = new couponsCategoriesClass( $table_cat ) ;


//coupons instance
require_once $mytrustdirpath."/class/coupons.class.php" ;
$coupons = new Coupons( $mydirname ) ;
$coupons->setPerm( $postperm , $post_approval , $editperm , $edit_approval , $delperm , $del_approval , $uid , $isadmin ) ;
$coupons->setAddField( $addfield ) ;

//qrcode
$qrcode =  file_exists(XOOPS_ROOT_PATH."/common/qrcode/qrcode_image.php") ? true : false ;

//Bread crumbs
$bread[] = array( 'name'=> $xoopsModule->getVar('name') , 'url'=>$mydirurl.'/' );
if( ($page=='viewcat') && isset($_GET['cid']) && $_GET['cid'] > 0 ) {
  $breadplus = assign_get_breadcrumbs_by_tree( $table_cat , 'cid' , 'pid' , 'title' , intval($_GET['cid']) , $mydirurl.'/index.php?cid=%u' );
  $bread = array_merge( $bread , $breadplus );
}else{
  switch( $page ){
    case 'submit' :
      $bcname = _MD_SUBMITCOUPON ;
      break;
    case 'edit' :
      $bcname = _MD_MODIFY ;
      break;
    case 'topten' :
      $bcname = _MD_POPULAR ;
      break;
    default:
      $bcname = '';
      break;
  }
  if( !empty($bcname) ) $bread[] = array( 'name'=> $bcname );
}

//date format
if( $xoopsModuleConfig['datetype']==1 ) $date_format='Y-m-d' ;
if( $xoopsModuleConfig['datetype']==2 ) $date_format='m-d-Y' ;
if( $xoopsModuleConfig['datetype']==3 ) $date_format='d-m-Y' ;

//携帯チェック
$is_mobile = FALSE;
if (class_exists('Wizin_User')) {	//wizmobile
	$mobile_user = & Wizin_User::getSingleton();
	$is_mobile = $mobile_user->bIsMobile;
} else if (defined('HYP_K_TAI_RENDER') && HYP_K_TAI_RENDER) {	//携帯対応レンダラー
	$is_mobile = HYP_K_TAI_RENDER;
}

//basic assign
$basic_assign = array(
  'myurl'             => $mydirurl ,
  'mydirname'         => $mydirname ,
  'postperm'          => $postperm ,
  'post_approval'     => $post_approval ,
  'editperm'          => $editperm ,
  'edit_approval'     => $edit_approval ,
  'delperm'           => $delperm ,
  'del_approval'      => $del_approval ,
  'catimgpath'        => htmlspecialchars(coupons_urlCheckReplace($xoopsModuleConfig['categoryicon_path']) , ENT_QUOTES) ,
  'uid'               => $uid ,
  'uname'             => $uname ,
  'realname'          => $realname ,
  'isadmin'           => $isadmin ,
  'xoops_breadcrumbs' => $bread ,
  'version'           => _COUPONS_VERSION,
  'qrcode'            => $qrcode ,
  'is_mobile'         => $is_mobile,

  'datetype'          => $xoopsModuleConfig['datetype'] ,
  'date_format'       => $date_format ,
  'addfield'          => $addfield ,
  'qrcode_size'       => intval($xoopsModuleConfig['qrcode_size']) ,
);

?>
