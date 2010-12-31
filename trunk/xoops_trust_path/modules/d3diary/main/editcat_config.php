<?php

//--------------------------------------------------------------------
// Config
//--------------------------------------------------------------------

include_once dirname( dirname(__FILE__) ).'/class/category.class.php';
include_once dirname( dirname(__FILE__) ).'/class/d3diaryConf.class.php';

$category =& Category::getInstance();

	global $xoopsUser ;
	if (is_object( @$xoopsUser )){
		$uid = intval($xoopsUser->getVar('uid'));
	} else {
		$uid = 0 ;
	}

	if($uid<=0) {
		redirect_header(XOOPS_URL.'/user.php',2,_MD_IVUID_ERR);
		exit();
	}

	$req_uid = $uid;

$d3dConf = & D3diaryConf::getInstance($mydirname, $req_uid, "editcat_config");
$myts =& $d3dConf->myts;

//--------------------------------------------------------------------
// GET Initial Valuses
//--------------------------------------------------------------------

$myname = "editcat_config.php";

$uname = $d3dConf->uname;
$name = $d3dConf->name;

// define Template
$xoopsOption['template_main']= $mydirname.'_editcat_config.html';

include XOOPS_ROOT_PATH."/header.php";
// this page uses smarty template
// this must be set before including main header.php

$_tempGperm = $d3dConf->gPerm->getUidsByName( array_keys($d3dConf->gPerm->gperm_config) );
// check edit permission by group
if(!empty($_tempGperm['allow_edit'])){
	if(!in_array($uid, $_tempGperm['allow_edit'])) {
		redirect_header(XOOPS_URL.'/user.php',2,_MD_NOPERM_EDIT);
		exit();
	}
} else {
	redirect_header(XOOPS_URL.'/user.php',2,_MD_NOPERM_EDIT);
	exit();
}

// dort /rename / add / delete�� --> non nategory ��
$common_cat=$d3dConf->func->getpost_param('common_cat') ? intval($d3dConf->func->getpost_param('common_cat')) : 0 ;

// uid overrides for common category
if ($common_cat==1){
	$category->uid=0;
} else {
	$category->uid=$uid;
}

$cid = $category->cid=intval($d3dConf->func->getpost_param('cid'));

// edit
if(!empty($_POST['submit1']) and $category->cid>0){
	$category->readdb($mydirname);
	$category->blogtype=intval($d3dConf->func->getpost_param('blogtype'));
	$category->blogurl=$d3dConf->func->getpost_param('blogurl');
	$category->rss=$d3dConf->func->getpost_param('rss');
	$category->openarea=intval($d3dConf->func->getpost_param('openarea'));
	$category->dohtml=intval($d3dConf->func->getpost_param('dohtml'));
	$chk_vgids= $d3dConf->func->getpost_param('vgids');
	$category->vgids = $chk_vgids ? "|".implode("|", array_map("intval" ,$chk_vgids))."|" : "";
	$chk_vpids= $d3dConf->func->getpost_param('vpids');
	$category->vpids = $chk_vpids ? "|".implode("|", array_map("intval" ,explode("," , $chk_vpids)))."|" : "";
	
	$category->updatedb($mydirname);
	redirect_header("index.php?page=editcategory",2,_MD_CATEGORY_UPDATED);

// input form
}else{
	$category->readdb($mydirname);

	$yd_category['cid']   = $category->cid;
	$yd_category['cname']   = htmlspecialchars($category->cname, ENT_QUOTES);
	$yd_category['corder']   = $category->corder;
	$yd_category['blogtype']   = $category->blogtype;
	$yd_category['blogurl']   = $category->blogurl;
	$yd_category['rss']   = $category->rss;
	$yd_category['openarea']   = $category->openarea;
	$yd_category['dohtml']   = $category->dohtml;

	$_selcted = explode( "|", trim( $category->vgids ,"|" ) );

	//var_dump($d3dConf->gPerm->group_list);
	$yd_category['group_list'] = array();
	$_oc = (int)$d3dConf->mod_config['use_open_cat'];
	if( $_oc == 10 || $_oc == 20 ) {
		$_selcted = explode( "|", trim( $category->vgids ,"|" ) );
		foreach ( $d3dConf->gPerm->group_list as $_gid => $_name) {
		    if($_gid >= 4 && (in_array($_gid, $d3dConf->mPerm->mygids) || $d3dConf->mPerm->isadmin)){
			$group_list[$_gid]['gname'] = $_name;
			$group_list[$_gid]['gsel'] = (in_array( $_gid, $_selcted )) ? 1 : 0;
		    }
		}
		$yd_category['group_list'] = $group_list;
	}
	if( $_oc == 20 ) {
		$p_selcted = array_map("intval", explode( "|", trim( $category->vpids ,"|" )) );
		$pperm_list = implode( "," , $p_selcted ) ;
		$yd_category['pperm_list'] = $pperm_list;
		$unames = array(); $names = array();

		foreach ($p_selcted as $vpid) {
			if( $vpid >1 ) {
				$rtn = $d3dConf->func->get_xoopsuname($vpid);
				$uname = $rtn['uname'];
				$name = (!empty($rtn['name'])) ? $rtn['name'] : "" ;
				$unames[] = htmlspecialchars( $uname.'['.$vpid.'] ', ENT_QUOTES );
				$names[] = htmlspecialchars( $name.'['.$vpid.'] ', ENT_QUOTES );
			}
		}
		if( $d3dConf->mod_config['use_name'] == 1 ) {
			$yd_category['pperm_names'] = $names;
		} else {
			$yd_category['pperm_names'] = $unames;
		}
	}
}

	// assign module header for tags
	$d3diary_header = '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=main_css" />'."\r\n";
	if(!empty($_tempGperm['allow_ppermission'])){
		if(in_array($uid,$_tempGperm['allow_ppermission'])){
			$d3diary_header .= '<script type="text/javascript" src="'.XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=loader&src=prototype,suggest,log.js"></script>'."\r\n";
		}
	}

// breadcrumbs
	$bc_para['diary_title'] = $xoopsTpl->get_template_vars('xoops_modulename');
	$bc_para['path'] = "index.php?page=editcat_config";
	$bc_para['uname'] = $uname;
	$bc_para['name'] = (!empty($name)) ? $name : $uname ;
	$bc_para['mode'] = "editcat_config";
	$bc_para['bc_name'] = constant('_MD_CATEGORY_EDIT');
	$bc_para['bc_name2'] = htmlspecialchars( $category->cname, ENT_QUOTES ) ;
	
	$breadcrumbs = $d3dConf->func->get_breadcrumbs( $uid, $bc_para['mode'], $bc_para );
	//var_dump($breadcrumbs);


$xoopsTpl->assign(array(
		"yd_uid" => $uid,
		"yd_uname" => $uname,
		"yd_name" => $name,
		"yd_isadmin" => $d3dConf->mPerm->isadmin,
		"yd_use_friend" => intval($d3dConf->mod_config['use_friend']),
		"yd_use_open_cat" => intval($d3dConf->mod_config['use_open_cat']),
		"yd_cfg" => $yd_category,
		"yd_openarea" => intval($d3dConf->dcfg->openarea),
		"common_cat" => $common_cat,
		"mydirname" => $mydirname,
		"mod_config" => $d3dConf->mod_config,
		"charset" => _CHARSET,
		"xoops_breadcrumbs" => $breadcrumbs,
		"xoops_module_header" => 
			$xoopsTpl->get_template_vars( 'xoops_module_header' ).$d3diary_header,
		"allow_edit" => in_array($uid, $_tempGperm['allow_edit']),
		"allow_html" => in_array($uid, $_tempGperm['allow_html']),
		"allow_regdate" => in_array($uid,$_tempGperm['allow_regdate'])
		));
		
	if(!empty($_tempGperm['allow_gpermission']))
		{ $xoopsTpl->assign( 'allow_gpermission' , in_array($uid,$_tempGperm['allow_gpermission'])); }
	if(!empty($_tempGperm['allow_ppermission']))
		{ $xoopsTpl->assign( 'allow_ppermission' , in_array($uid,$_tempGperm['allow_ppermission'])); }
	

include_once XOOPS_ROOT_PATH.'/footer.php';

?>
