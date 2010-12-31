<?php

//--------------------------------------------------------------------
// Config
//--------------------------------------------------------------------

include_once dirname( dirname(__FILE__) ).'/class/diaryconfig.class.php';
include_once dirname( dirname(__FILE__) ).'/class/d3diaryConf.class.php';

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

$d3dConf = & D3diaryConf::getInstance($mydirname, $req_uid, "usr_config");
$dcfg =& $d3dConf->dcfg;
$myts =& $d3dConf->myts;

//--------------------------------------------------------------------
// GET Initial Valuses
//--------------------------------------------------------------------

$uname = $d3dConf->uname;
$name = $d3dConf->name;
// get permission unames for each groupPermission
$_tempGperm = $d3dConf->gPerm->getUidsByName( array('allow_edit') );
// check edit permission by group
if(!empty($_tempGperm['allow_edit'])){
	if(!in_array($uid, $_tempGperm['allow_edit'])) {
		redirect_header(XOOPS_URL.'/user.php',2,_MD_NOPERM_EDIT);
		exit();
	}	unset($_tempGperm);
} else {
	redirect_header(XOOPS_URL.'/user.php',2,_MD_NOPERM_EDIT);
	exit();
}

// define Template
$xoopsOption['template_main']= $mydirname.'_usr_config.html';

include XOOPS_ROOT_PATH."/header.php";
// this page uses smarty template
// this must be set before including main header.php

// change config
if(!empty($_POST['submit1'])){

	$dcfg->uid = $uid;

	$dcfg->blogurl=$d3dConf->func->getpost_param('blogurl');
	$dcfg->blogtype=$d3dConf->func->getpost_param('blogtype');
	$dcfg->rss=$d3dConf->func->getpost_param('rss');
	$dcfg->openarea=intval($d3dConf->func->getpost_param('openarea'));

	if($dcfg->blogtype>0 and empty($dcfg->blogurl)){
		redirect_header('index.php?page=usr_config',3,_MD_FAIL_UPDATED._MD_NODIARYURL);
		exit();
	}

	// 最後にスラッシュを追加
	if(!preg_match("/^.*\/$/i",$dcfg->blogurl)){
		$dcfg->blogurl.="/";
	}
	
	if($dcfg->blogtype==0){
		// このブログ
		$dcfg->rss="";
		$dcfg->blogurl="";
		d3diary_update_newentry($mydirname, $uid);
	}elseif($dcfg->blogtype==1){ 
		// 楽天広場
		$dcfg->rss=$dcfg->blogurl."rss";
		preg_match("/^http:\/\/plaza.rakuten.co.jp(.*)$/i", $dcfg->rss, $matches);
		$dcfg->rss = "http://api.plaza.rakuten.ne.jp".$matches[1];

	}elseif($dcfg->blogtype==2){ 
		// はてなダイアリ
		$dcfg->rss=$dcfg->blogurl."rss";

	}elseif($dcfg->blogtype==3 or $dcfg->blogtype==4){ 
		// ドリコムブログ・ヤプログ
		$dcfg->rss=$dcfg->blogurl."index1_0.rdf";

	}elseif($dcfg->blogtype==5 or $dcfg->blogtype==10 or 
			$dcfg->blogtype==12 or $dcfg->blogtype==16 or $dcfg->blogtype==18){ 
		// チャンネル北国tv Seesaa goo BLOG ブログ・ジー（269g） So-net blog
		$dcfg->rss=$dcfg->blogurl."index.rdf";

	}elseif($dcfg->blogtype==6){
		// livedoor Blog
		$dcfg->rss=$dcfg->blogurl."atom.xml";

	}elseif($dcfg->blogtype==17){
		// ココログ
		$dcfg->rss=$dcfg->blogurl."blog/atom.xml";

	}elseif($dcfg->blogtype==7){
		// Doblog
		preg_match("/^http:\/\/www.doblog.com\/weblog\/myblog\/(\d+)/i",$dcfg->blogurl,$matches);
		$dcfg->rss="http://rss.doblog.com/rss/myrss.do?method=mypagerss&userid=".intval($matches[1])."&type=RSS_1_0";

	}elseif($dcfg->blogtype==8 or $dcfg->blogtype==11){
		// Exciteブログ Movable Type系 
		$dcfg->rss=$dcfg->blogurl."index.xml";

	}elseif($dcfg->blogtype==9){
		// JUGEM
		$dcfg->rss=$dcfg->blogurl."?mode=rss";

	}elseif($dcfg->blogtype==13 or $dcfg->blogtype==19){
		// AOLダイアリー Yahoo!ブログ
		$dcfg->rss=$dcfg->blogurl."rss.xml";

	}elseif($dcfg->blogtype==14){
		// アメーバブログ
		$dcfg->rss=$dcfg->blogurl."rss.html";

	}elseif($dcfg->blogtype==15){
		// fc2ブログ
		$dcfg->rss=$dcfg->blogurl."?xml";

	}else{
		// その他
		if($dcfg->blogtype!=100 or empty($dcfg->rss)){
			redirect_header('index.php?page=usr_config',3,_MD_FAIL_UPDATED._MD_NORSSURL);
			exit();
		}
	}
	
	// RSSフィードの読み込みチェック（省略）

	$dcfg->deletedb($mydirname);
	$dcfg->insertdb($mydirname);

	redirect_header('index.php?page=usr_config',3,_MD_CONF_UPDATED);

// show config
} else {

	//--------------------------------------------------------------------
	// Read Config
	//--------------------------------------------------------------------
	$sql = "SELECT *
			  FROM ".$xoopsDB->prefix($mydirname.'_config').
			  " WHERE uid='".$uid."'";

	$result = $xoopsDB->query($sql);

	if ( $dbdat = $xoopsDB->fetchArray($result) ) {
		$yd_cfg['blogtype'] = $dbdat['blogtype'];
		$yd_cfg['openarea'] = $dbdat['openarea'];
		if($dbdat['blogtype']>0){
			$yd_cfg['blogurl'] = $dbdat['blogurl'];
			if($dbdat['blogtype']==100){
				$yd_cfg['rss'] = $dbdat['rss'];
			}
		}
	}else{
		$yd_cfg['blogtype'] = 0;
		$yd_cfg['openarea'] = 0;
	}
}

// breadcrumbs
	$bc_para['diary_title'] = $xoopsTpl->get_template_vars('xoops_modulename');
	$bc_para['path'] = "index.php";
	$bc_para['uname'] = $uname;
	$bc_para['name'] = (!empty($name)) ? $name : $uname ;
	$bc_para['mode'] = "usr_config";
	$bc_para['bc_name'] = constant('_MD_CONF_LINK');
	
	$breadcrumbs = $d3dConf->func->get_breadcrumbs( $uid, $bc_para['mode'], $bc_para );
	//var_dump($breadcrumbs);

$xoopsTpl->assign(array(
		"yd_uid" => $uid,
		"yd_uname" => $uname,
		"yd_name" => $name,
		"yd_cfg" => $yd_cfg,
		"yd_use_friend" => $d3dConf->mod_config['use_friend'],
		"mydirname" => $mydirname,
		"mod_config" => $d3dConf->mod_config,
		"xoops_breadcrumbs" => $breadcrumbs
		));


// newentry更新
function d3diary_update_newentry($mydirname, $uid)
{
	global $xoopsDB;
	
	$sql = "DELETE FROM ".$xoopsDB->prefix($mydirname.'_newentry')." WHERE uid='".$uid."' AND cid='0'";
	$result = $xoopsDB->queryF($sql);
	
	$sql = "SELECT *
			  FROM ".$xoopsDB->prefix($mydirname.'_diary')."
	          WHERE uid='".intval($uid)."' ORDER BY create_time DESC";

	$result = $xoopsDB->query($sql);
	if ( $dbdat = $xoopsDB->fetchArray($result) ) {
	
        if (!get_magic_quotes_gpc()) {
			$tmptitle=addslashes($dbdat['title']);
		}else{
			$tmptitle=$dbdat['title'];
		}
		
		$sql = "INSERT INTO ".$xoopsDB->prefix($mydirname.'_newentry')."
				(uid, cid, title, url, create_time, blogtype)
				VALUES (
				'".$dbdat['uid']."',
				'0',
				'".$tmptitle."',
				'".XOOPS_URL."/modules/".$mydirname."/index.php?page=detail&bid=".$dbdat['bid']."',
				'".$dbdat['create_time']."',
				'0'
				)";
		$result = $xoopsDB->queryF($sql);
	}

}

include_once XOOPS_ROOT_PATH.'/footer.php';

?>
