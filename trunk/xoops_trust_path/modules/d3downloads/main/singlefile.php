<?php

include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = $mydirname.'_main_singlefile.html' ;

$db =& Database::getInstance() ;
global $xoopsUser ;

include_once dirname(dirname(__FILE__)).'/class/mytree.php' ;
include_once dirname(dirname(__FILE__)).'/class/mydownload.php' ;
include_once dirname(dirname(__FILE__)).'/class/user_access.php' ;
require_once dirname(dirname(__FILE__)).'/include/common_functions.php' ;

$user_access = new user_access( $mydirname ) ;

// �{���E���e�\�ȃJ�e�S���擾�̏���
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
$whr_cat4read = "d.".$whr_cat ;
$whr_cat4post = "cid IN (".implode(",", $user_access->can_post() ).")" ;

if( is_object( $xoopsUser ) ) {
	$xoops_isuser = true ;
	$xoops_userid = $xoopsUser->getVar('uid') ;
	$xoops_uname = $xoopsUser->getVar('uname') ;
	$xoops_isadmin = $xoopsUserIsAdmin ;
} else {
	$xoops_isuser = false ;
	$xoops_userid = 0 ;
	$xoops_uname = '' ;
	$xoops_isadmin = false ;
}

// �J�e�S���ԍ����擾
$cid = isset( $_GET['cid'] ) ? intval( $_GET['cid'] ) : 0 ;
$lid = isset( $_GET['lid'] ) ? intval( $_GET['lid'] ) : 0 ;

// �Y������_�E�����[�h��񂪂Ȃ��ꍇ�̓��_�C���N�g
$mydownload = new MyDownload( $mydirname, $whr_cat4read, $lid );
if( ! $mydownload->return_lid() ) {
	redirect_header(  XOOPS_URL.'/modules/'.$mydirname.'/',3, _MD_D3DOWNLOADS_NOMATCH ) ;
	exit() ;
}

// mydownloads �Ƃ̌݊�����}�邽�߁A�J�e�S���ԍ����w�肵�Ȃ��Ă��A�N�Z�X�ł���悤�ɂ��܂�
if( empty( $cid ) ) $cid = $mydownload->return_cid();

// �{���ł��Ȃ��J�e�S���̏ꍇ�̓��_�C���N�g
$canread = $user_access->user_access_for_cat( $cid, $whr_cat );
if( empty( $canread ) ) {
	redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/',3, _MD_D3DOWNLOADS_NOREADLINKPERM );
	exit();
}

// �p�������������A�T�C��
$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
if( ! empty( $xoopsModuleConfig['show_breadcrumbs'] ) ){
	$pathstring = d3download_pathstring( $mytree, $cid, $whr_cat );
	$xoopsTpl->assign('category_path', $pathstring);
}

// �{���\�ȃ����N�݂̂̓o�^�������擾���A�T�C��
$total = $mydownload->Total_Num( $whr_cat, $cid );
$total_num = sprintf( _MD_D3DOWNLOADS_CATEGORY_NUM , $total );
$xoopsTpl->assign( 'download_total_num' , $total_num ) ;

// �o�^�f�[�^���擾
$download4assign = $mydownload->get_downdata_for_singleview( $whr_cat4read, $lid, $cid, 1 );

$mod_url = XOOPS_URL.'/modules/'.$mydirname ;

// �{���\�ȃJ�e�S���̃��X�g�� SELECT�{�b�N�X�p�Ɏ擾
$category4assin = array();
$category4assin = d3download_makecache_for_selbox( $mydirname, $mytree, $whr_cat, 0, 1 );

$lang_directcatsel = _MD_D3DOWNLOADS_SEL_CATEGORY;
$d3comment_dirname = $xoopsModuleConfig['comment_dirname']  ? $xoopsModuleConfig['comment_dirname']  : "";
$d3comment_forum_id = $xoopsModuleConfig['comment_forum_id']  ? $xoopsModuleConfig['comment_forum_id']  : "";
$comment_view = $xoopsModuleConfig['comment_view']  ? $xoopsModuleConfig['comment_view']  : "";

// �X�N���[���V���b�g�摜���g�p���邩�ǂ���
$canuseshots = ! empty( $xoopsModuleConfig['useshots'] ) ? 1 : 0 ;
$xoops_module_header = d3download_dbmoduleheader( $mydirname );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));

$title4assign = $mydownload->return_title('Show') ;
$breadcrumbs[0] = d3download_breadcrumbs( $mydirname ) ;
$bc_arr =  $mytree->getNicePathArrayFromId( $cid, "title", $whr_cat, "index.php?" );
foreach( $bc_arr as $bc ) {
	$breadcrumbs[] = array(
		'name' => $bc['name'] ,
		'url' => $bc['url'] ,
	) ;
}
$breadcrumbs[] = array( 'name' => $title4assign ) ;

// assign
$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => $mod_url ,
	'mytrustdirpath' => 'd3downloads' ,
	'file' => $download4assign ,
	'category' => $category4assin ,
	'lang_directcatsel' => $lang_directcatsel ,
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'xoops_isadmin' => $xoops_isadmin ,
	'xoops_config' => $xoopsConfig ,
	'mod_config' => $xoopsModuleConfig ,
	'd3comment_dirname' => $d3comment_dirname ,
	'd3comment_forum_id' => $d3comment_forum_id ,
	'comment_view' => $comment_view ,
	'canuseshots' => $canuseshots ,
	'xoops_pagetitle' => $title4assign ,
	'xoops_breadcrumbs' => $breadcrumbs ,
) ) ;
// display
include XOOPS_ROOT_PATH.'/footer.php';

?>