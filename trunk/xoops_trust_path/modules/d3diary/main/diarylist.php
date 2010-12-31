<?php

//--------------------------------------------------------------------
// Config
//--------------------------------------------------------------------
include_once dirname( dirname(__FILE__) ).'/class/category.class.php';
include_once dirname( dirname(__FILE__) ).'/class/photo.class.php';
include_once dirname( dirname(__FILE__) ).'/class/tag.class.php';
include_once dirname( dirname(__FILE__) ).'/class/d3diaryConf.class.php';

$category =& Category::getInstance();
$photo =& Photo::getInstance();
$tag =& Tag::getInstance();
$d3dConf =& D3diaryConf::getInstance($mydirname, 0, "diarylist");
$myts =& $d3dConf->myts;

//--------------------------------------------------------------------
// GET Initial Valuses
//--------------------------------------------------------------------

$myname = "diarylist.php";

$uid = $d3dConf->uid;

$xoopsOption['template_main']= $mydirname.'_diarylist.html';
include XOOPS_ROOT_PATH."/header.php";
// this page uses smarty template
// this must be set before including main header.php

// assign module header for css
$d3diary_header = '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.
	'/modules/'.$mydirname.'/index.php?page=main_css" />'."\r\n";
$d3diary_header .= '<link rel="alternate" type="application/rss+xml" title="RDF" href="'.XOOPS_URL.
	'/modules/'.$mydirname.'/rdf.php" />'."\r\n";
//$xoopsTpl->assign( 'xoops_module_header' ,$xoopsTpl->get_template_vars( 'xoops_module_header' ).$d3diary_header );

$d3dConf->func->update_other();

// menu
if($d3dConf->mod_config['menu_layout']==1){
	$yd_layout = "left";
}elseif($d3dConf->mod_config['menu_layout']==2){
	$yd_layout = "";
}else{
	$yd_layout = "right";
}

	// get friends' array at first
	$d3dConf->set_mod_config(0,"diarylist");	// needs $dcfg
	$openarea = array();
	$noavatar_exists = file_exists(XOOPS_ROOT_PATH."/modules/user/images/no_avatar.gif");
	
	// *********** SQL for
	// get personal config openarea and friends' uids
	$sql = "SELECT DISTINCT d.uid, cfg.openarea 
			FROM ".$xoopsDB->prefix($mydirname.'_diary')
			." d LEFT JOIN ".$xoopsDB->prefix($mydirname.'_config')
			." cfg ON d.uid=cfg.uid ";
	
	$result = $xoopsDB->query($sql);
	
	while($dbdat = $xoopsDB->fetchArray($result)){
		$u = (int)$dbdat['uid'];
		$openarea[$u] = (int) $dbdat['openarea'];
	}

	$editperm=0;
	
	if($d3dConf->mPerm->isadmin){
		$editperm=1;
		$whr_openarea = " 1 ";
	} else {
		$_params4op['use_gp'] = $d3dConf->gPerm->use_gp;
		$_params4op['use_pp'] = $d3dConf->gPerm->use_pp;
		$whr_openarea = $d3dConf->mPerm->get_open_query( "dlist1", $_params4op );
	}

	// added requested tag_name
	$b_tag=rawurldecode($d3dConf->func->getpost_param('tag_name'));
	if (!empty($b_tag) && $d3dConf->mod_config['use_tag']>1) {
		$sql_tag= "LEFT JOIN ".$xoopsDB->prefix($mydirname.'_tag')." t ON d.bid=t.bid ";
	        if (!get_magic_quotes_gpc()) {
			$whr_tag= " AND t.tag_name='".addslashes($b_tag)."'";
		} else {
			$whr_tag= " AND t.tag_name='".$b_tag."'";
		}
		$url_tag= "&amp;tag_name=".$b_tag;
	} else {
		$sql_tag= ""; $whr_tag= " "; $url_tag= "";
	}

	// added common category query
	$common_cid=intval($d3dConf->func->getpost_param('cid'));
	if( 10000 < $common_cid ){
		$category->uid = 0;
		$category->cid = $common_cid;
		$category->getchildren($mydirname);
		$yd_param['cname'] = $category->cname;
		$url_tag.="&amp;cid=".$common_cid;
	}

	$whr_time = ""; $whr_cat = ""; $whr_uids = "";

	$yd_param['mode']=$d3dConf->func->getpost_param('mode');
	$yd_param['year']=intval($d3dConf->func->getpost_param('year'));
	$yd_param['month']=intval($d3dConf->func->getpost_param('month'));
	$yd_param['day']=intval($d3dConf->func->getpost_param('day'));

	if(!empty($yd_param['year'])) {
		$yd_param['prev_year'] = $yd_param['year'] -1;
		$yd_param['next_year'] = $yd_param['year'] +1;
	}

	if(strcmp($yd_param['mode'], "category")==0){
		if($category->children){
			$whr_cat.=" AND d.cid IN (".implode(",",$category->children).") ";
		} else {
			$whr_cat.=" AND d.cid='".$yd_param['cid']."' ";
		}
	}elseif(strcmp($yd_param['mode'], "friends")==0){
    		if (!empty($d3dConf->mPerm->req_friends)) {
			$whr_uids=" AND d.uid IN (".implode(',',$d3dConf->mPerm->req_friends).")";
		}
	}elseif(strcmp($yd_param['mode'], "date")==0){
		$whr_time.=" AND d.create_time>='".$yd_param['year']."-".$yd_param['month']
			."-".$yd_param['day']." 00:00:00"."' ";
		$whr_time.=" AND d.create_time<='".$yd_param['year']."-".$yd_param['month']
			."-".$yd_param['day']." 23:59:59"."' ";
	}elseif(strcmp($yd_param['mode'], "month")==0){
		if($yd_param['month']==12){
			$next_year=$yd_param['year']+1;
			$next_month=1;
		}else{
			$next_year=$yd_param['year'];
			$next_month=$yd_param['month']+1;
		}
		$whr_time.=" AND d. create_time>='".$yd_param['year']."-".$yd_param['month']."-01 00:00:00"."' ";
		$whr_time.=" AND d. create_time<'".$next_year."-".$next_month."-01 00:00:00"."' ";
	}


	$now = date("Y-m-d H:i:s");
	if ($d3dConf->mPerm->isadmin!=true and $d3dConf->mPerm->isauthor!=true) {
		$whr_nofuture = " AND d.create_time<'".$now."' ";
	} else { $whr_nofuture = ""; }

	// arrays for BoxDate
	list( $arr_weeks, $arr_monthes, $arr_dclass, $arr_wclass ) = $d3dConf->func->initBoxArr();

	// *********** SQL base
	$sql_base = "FROM ".$xoopsDB->prefix($mydirname.'_diary')." d 
			INNER JOIN ".$xoopsDB->prefix('users')." u USING(uid) 
			LEFT JOIN ".$xoopsDB->prefix($mydirname.'_category')." c ON ((c.uid=d.uid or c.uid='0') and d.cid=c.cid) 
			LEFT JOIN ".$xoopsDB->prefix($mydirname.'_config')." cfg ON d.uid=cfg.uid ".$sql_tag." 
			WHERE ".$whr_openarea.$whr_cat.$whr_time.$whr_uids.$whr_tag.$whr_nofuture." AND 
			(cfg.blogtype='0' OR cfg.blogtype IS NULL) ORDER BY d.create_time DESC";

	// *********** SQL for
	// get count of total entries or
	$sql = "SELECT count(d.bid) as count ".$sql_base ;
	$result = $xoopsDB->query($sql);
	list ($num_rows) = $xoopsDB->fetchRow($result);

	// page control
	$max_entry = intval($d3dConf->mod_config['block_diarynum']);
	$offset = $d3dConf->func->getpost_param('pofst');
	$offset = (isset($offset) && ($offset>0)) ? intval($offset) : 0;
	if ( $offset <= 0 ) {
		$offset2 = 0 ;
		$max_entry2 = $max_entry ;
		$startnum = $offset2 + 1 ;
		$endnum = $max_entry ;
	} else {
		$offset2 = $offset-1 ;
		$max_entry2 = $max_entry + 1 ;
		$startnum = $offset + 1 ;
		$endnum = $offset + $max_entry ;
	}

	if(empty($num_rows)){$startnum = 0;	$endnum = 0;}
	if ($endnum > $num_rows) { $endnum = $num_rows;	}
	
	// query limit
	$whr_offset = " LIMIT ".$offset2.",".$max_entry2 ;

	// using d3diaryPageNav
	if($num_rows>$max_entry){
            if( !empty($_SERVER['QUERY_STRING'])) {
                if( ereg("^pofst=[0-9]+", $_SERVER['QUERY_STRING']) ) {
                    $url = "";
                } else {
                    $url = preg_replace("/^(.*)\&pofst=[0-9]+/", "$1", $_SERVER['QUERY_STRING']);
                }
            } else {
                $url = "";
            }
	    include_once dirname( dirname(__FILE__) ).'/class/d3diaryPagenavi.class.php';
            $nav = new d3diaryPageNav($num_rows, $max_entry, $offset, "pofst", $url);
            $yd_pagenavi = $nav->getNav();
        } else {
            $yd_pagenavi = "";
        }

	// *********** SQL for
	// get entries on selected offset
	$sql = "SELECT d.diary, d.create_time, d.cid, d.title, d.bid, d.openarea AS openarea, d.dohtml, 
			d.view, d.vgids AS vgids, d.vpids AS vpids, u.uid, u.uname, u.name, u.user_avatar, 
			c.cid, c.cname, c.openarea AS openarea_cat, c.vgids AS vgids_cat, c.vpids AS vpids_cat "
		.$sql_base.$whr_offset ;
	$result = $xoopsDB->query($sql);

	// flag for using d3comment
	if(!empty($d3dConf->mod_config['comment_dirname']) 
		&& intval($d3dConf->mod_config['comment_forum_id'])>0){
		$yd_param['use_d3comment']=true;
	}else{
		$yd_param['use_d3comment']=false;
	}

	$entry = array(); $got_bids = array(); $mytstamp=array(); $is1st=1;
	while($dbdat = $xoopsDB->fetchArray($result)){
	//var_dump($dbdat);
	    if($offset>0 and $is1st==1){
	    	$last_date = $dbdat['create_time'];
	    } else {
		$i = intval($dbdat['bid']);
		$entry[$i]['bid']=$dbdat['bid'];

		$ctime = preg_split("/[-: ]/",$dbdat['create_time']);
		$entry[$i]['tstamp'] = $tstamp = mktime($ctime[3],$ctime[4],$ctime[5],$ctime[1],$ctime[2],$ctime[0]);
		$week = intval($d3dConf->func->myformatTimestamp($tstamp, "w"));

		$entry[$i]['create_time']=$dbdat['create_time'];
		$entry[$i]['year']   = intval($d3dConf->func->myformatTimestamp($tstamp, "Y"));
		$entry[$i]['month']   = intval($d3dConf->func->myformatTimestamp($tstamp, "m"));
		$entry[$i]['day']   = intval($d3dConf->func->myformatTimestamp($tstamp, "d"));
		$entry[$i]['time']   = $d3dConf->func->myformatTimestamp($tstamp, "H:i");
		$entry[$i]['week'] = $arr_weeks [$week];
		$entry[$i]['b_month'] = $arr_monthes [$entry[$i]['month'] -1];
		$entry[$i]['dclass'] = $arr_dclass [$week];
		$entry[$i]['wclass'] = $arr_wclass [$week];

		$entry[$i]['title'] =empty( $dbdat['title'] ) ? constant('_MD_DIARY_NOTITLE') 
				: $myts->makeTboxData4Show($dbdat['title']);
		$entry[$i]['url']=XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=detail&bid='.$dbdat['bid'];
		$entry[$i]['uid']=$dbdat['uid'];
		$_user_avatar = htmlspecialchars($dbdat['user_avatar'], ENT_QUOTES);
			if($_user_avatar=="blank.gif" && $noavatar_exists) {
				$entry[$i]['avatarurl'] = XOOPS_URL . "/modules/user/images/no_avatar.gif";
			} else {
				$entry[$i]['avatarurl'] = XOOPS_UPLOAD_URL . "/" . $_user_avatar;
       			}
		
		$entry[$i]['uname']=$myts->htmlSpecialChars($dbdat['uname']);
		$entry[$i]['name']= !empty($dbdat['name']) ? 
				htmlSpecialChars($dbdat['name'], ENT_QUOTES) : $entry[$i]['uname'];
		$entry[$i]['view'] = $dbdat['view'];
		$entry[$i]['cid'] = isset($dbdat['cid']) ? intval($dbdat['cid']) : 0 ;
		$entry[$i]['cname'] = isset($dbdat['cname']) ? htmlSpecialChars($dbdat['cname'], ENT_QUOTES) : constant('_MD_NOCNAME') ;

		// openarea overrides
		$_tmp_op = isset($openarea[$dbdat['uid']]) ? intval($openarea[$dbdat['uid']]) : 0 ;
		$openarea_cat = intval($dbdat['openarea_cat']);

		list( $_got_op , $_slctd_op , $_tmp_gperms, $_tmp_pperms ) 
			= $d3dConf->mPerm->override_openarea( $_tmp_op, intval($dbdat['openarea']), $openarea_cat, 
				$dbdat['vgids'], $dbdat['vpids'], $dbdat['vgids_cat'], $dbdat['vpids_cat'] );
		$entry[$i]['openarea'] = $_got_op;
			// var_dump($_tmp_gperms); var_dump($_tmp_pperms);

		$entry[$i]['can_disp'] = true;
		// timestamp for sort
		$mytstamp[$i] = $tstamp;

		$got_bids[] = $i;
		if(!isset($last_date)){ $last_date = $dbdat['create_time']; }
		$first_date =  $dbdat['create_time'];

		$entry[$i]['dohtml'] = intval($dbdat['dohtml']);
		$entry[$i]['diary'] = $d3dConf->func->substrTarea($dbdat['diary'], $entry[$i]['dohtml'], 
			intval($d3dConf->mod_config['preview_charmax']));
		$entry[$i]['other']=0;
	    } //end (is1st)
	    $is1st=0;
	}
	if($num_rows < $max_entry or $startnum <= 1) { $last_date = $now; }
	if($startnum + $max_entry > $num_rows) { 
		$whr_date = " and d.create_time<'".$last_date."' "; 
	} else {
		$whr_date = "and d.create_time>'".$first_date."' and d.create_time<'".$last_date."' ";
	}
	
	// *********** SQL for
	// other enrties
	
	if (empty($b_tag) || $d3dConf->mod_config['use_tag']==0) {
		$sql = "SELECT  d.diary, d.create_time, d.title, d.url, u.uname, u.name, u.uid, u.user_avatar, 
			c.cid, c.cname, c.openarea AS openarea_cat 
			FROM ".$xoopsDB->prefix($mydirname.'_newentry')." d 
			INNER JOIN ".$xoopsDB->prefix('users')." u USING(uid) 
			LEFT JOIN ".$xoopsDB->prefix($mydirname.'_category')." c 
			ON ((c.uid=d.uid or c.uid='0') and d.cid=c.cid) 
			WHERE d.blogtype>'0' ".$whr_cat.$whr_time.$whr_uids.$whr_date." 
			ORDER BY d.create_time DESC";
		$result = $xoopsDB->query($sql);

	    $i=-1000;
	    while($dbdat = $xoopsDB->fetchArray($result)){
		$tmp = preg_split("/[-: ]/",$dbdat['create_time']);
		
		$entry[$i]['tstamp'] = $tstamp = mktime($tmp[3],$tmp[4],$tmp[5],$tmp[1],$tmp[2],$tmp[0]);
		$week = intval($d3dConf->func->myformatTimestamp($tstamp, "w"));

		$entry[$i]['create_time']=$dbdat['create_time'];
		$entry[$i]['year']   = intval($d3dConf->func->myformatTimestamp($tstamp, "Y"));
		$entry[$i]['month']   = intval($d3dConf->func->myformatTimestamp($tstamp, "m"));
		$entry[$i]['day']   = intval($d3dConf->func->myformatTimestamp($tstamp, "d"));
		$entry[$i]['time']   = $d3dConf->func->myformatTimestamp($tstamp, "H:i");
		$entry[$i]['week'] = $arr_weeks [$week];
		$entry[$i]['b_month'] = $arr_monthes [$entry[$i]['month'] -1];
		$entry[$i]['dclass'] = $arr_dclass [$week];
		$entry[$i]['wclass'] = $arr_wclass [$week];
		
		$entry[$i]['title']=empty( $dbdat['title'] ) ? constant($constpref.'_NOTITLE') 
			: $myts->makeTboxData4Show($dbdat['title']);
		$entry[$i]['url']=$dbdat['url'];
		$entry[$i]['uid']=intval($dbdat['uid']);
		$_user_avatar = htmlspecialchars($dbdat['user_avatar'], ENT_QUOTES);
			if($_user_avatar=="blank.gif" && $noavatar_exists) {
				$entry[$i]['avatarurl'] = XOOPS_URL . "/modules/user/images/no_avatar.gif";
			} else {
				$entry[$i]['avatarurl'] = XOOPS_UPLOAD_URL . "/" . $_user_avatar;
       			}
		$entry[$i]['uname']= htmlSpecialChars($dbdat['uname'], ENT_QUOTES);
		$entry[$i]['name']= !empty($dbdat['name']) ? 
				htmlSpecialChars($dbdat['name'], ENT_QUOTES) : $entry[$i]['uname'];
		$entry[$i]['cid'] = isset($dbdat['cid']) ? intval($dbdat['cid']) : 0 ;
		$entry[$i]['cname'] = isset($dbdat['cname']) ? $dbdat['cname'] : constant('_MD_NOCNAME') ;

//		$entry[$i]['diary'] = $d3dConf->func->substrTarea($dbdat['diary'], 0, 
//					intval($d3dConf->mod_config['preview_charmax']));
		$entry[$i]['diary'] = mb_substr(strip_tags($dbdat['diary']),0,(int)$d3dConf->mod_config['preview_charmax'], _CHARSET)."...";
					
		// openarea overrides
		$_tmp_op = isset($openarea[$dbdat['uid']]) ? intval($openarea[$dbdat['uid']]) : 0 ;
		$entry[$i]['openarea']=$_tmp_op;
		$openarea_cat = intval($dbdat['openarea_cat']);
		if ($openarea_cat>0) { $entry[$i]['openarea'] = $openarea_cat; }

		$entry[$i]['can_disp'] = true;
		
		$entry[$i]['other']=1;
		$entry[$i]['dohtml']=0;
		$mytstamp[$i] = $tstamp;
		$i++;
	    }
	} // end if
	// random phptos
	$photo->bids = $got_bids;
	$photo->readrand_mul($mydirname);
	foreach ( $photo->photos as $i => $_photo ) {
			$entry[$i]['photo'] = $_photo['pid'].$_photo['ptype'];
	}
	unset($photo->photos);
	
	if ( $d3dConf->mod_config['use_tag']>0 ) {
		// tags
		$tag->bids = $got_bids;
		$tag->readdb_mul($mydirname);
		foreach ( $tag->tags as $i => $_tag ) {
			$entry[$i]['tag'] = $_tag;
			$entry[$i]['tag_num'] = count($_tag);
		}
		unset($tag->tags);
	}

	$d3dConf->set_new_bids ( $got_bids );
	// comment counts, newest comments
	//list($yd_comment,$yd_com_key) = $d3dConf->func->get_commentlist(0,$uid,$got_bids,100,true);
	list($yd_comment,$yd_com_key) = $d3dConf->func->get_commentlist(0,$uid,100,true);
	foreach( $yd_comment as $_com){
		$i = $_com['bid'];
		$entry[$i]['com_num'] = $_com['com_num'];
		$entry[$i]['unique_path'] = $_com['unique_path'];
		$entry[$i]['com_uname'] = $_com['uname'];
		$entry[$i]['com_name'] = $_com['name'];
		$entry[$i]['com_guest_name'] = $_com['guest_name'];
		$entry[$i]['com_title'] = $_com['title'];
		$entry[$i]['com_datetime'] = $_com['datetime'];
		$entry[$i]['newcom'] = $_com['newcom'];
	}

	// sort by timestamp
	if (!empty($mytstamp) && !empty($entry)) {
		array_multisort($mytstamp, SORT_DESC, $entry );
	}

	//TagCloud
	$where = "";
	list( $tagCloud, $dummy_navi ) = $d3dConf->func->getTagCloud($where, 80, 200);

// breadcrumbs
	$bc_para['diary_title'] = $xoopsTpl->get_template_vars('xoops_modulename');
	$bc_para['path'] = "index.php?page=diarylist";
	$bc_para['uname'] = ""; $bc_para['name'] = "";
	$bc_para['mode'] = $yd_param['mode'];
	if($common_cid>=10000){
		$bc_para['mode'] = "category";
		$bc_para['cid'] = $common_cid;
		$bc_para['cname'] = $yd_param['cname'] ? $yd_param['cname'] : constant('_MD_NOCNAME');
	}
	if((strcmp($bc_para['mode'], "category")==0)){
		$bc_para['cid'] = $yd_param['cid'];
		$bc_para['cname'] = $yd_param['cname'] ? $yd_param['cname'] : constant('_MD_NOCNAME');
	} elseif(strcmp($bc_para['mode'], "month")==0){ 
		$bc_para['year'] = $yd_param['year'];
		$bc_para['month'] = $yd_param['month'];
	} elseif(strcmp($bc_para['mode'], "date")==0){
		$bc_para['year'] = $yd_param['year'];
		$bc_para['month'] = $yd_param['month'];
		$bc_para['day'] = $yd_param['day'];
	} elseif(strcmp($bc_para['mode'], "friends")==0){
		$bc_para['bc_name'] = constant('_MD_DIARY_FRIENDSVIEW');;
	}
	
	if(!empty($b_tag) && $d3dConf->mod_config['use_tag']>0) {
		$bc_para['tag'] = htmlspecialchars( urldecode($d3dConf->func->getpost_param('tag_name')), ENT_QUOTES);
	}
	$breadcrumbs = $d3dConf->func->get_breadcrumbs( 0, $bc_para['mode'], $bc_para );
	//var_dump($breadcrumbs);

	$xoopsTpl->assign(array(
		//	"yd_editperm" => $editperm,
			"yd_layout" => $yd_layout,
			"yd_data" => $entry,
			"yd_param" => $yd_param,
			"yd_offset" => $offset,
			"yd_com_key"  => $yd_com_key,			
			"yd_pagenavi" => $yd_pagenavi,
			"catopt" => d3diary_assign_common_category ($mydirname),
			"common_cid" => $common_cid,
			"yd_tag" => $b_tag,
			"tagCloud" => $tagCloud,
			"lang_datanum" => constant('_MD_DATANUM1').$num_rows. constant('_MD_DATANUM2').
						$startnum. constant('_MD_DATANUM3').$endnum.
						constant('_MD_DATANUM4'),
			"mydirname" => $mydirname,
		//	"xoops_pagetitle" => $xoops_pagetitle,
			"xoops_breadcrumbs" => $breadcrumbs,
			"xoops_module_header" => 
				$xoopsTpl->get_template_vars( 'xoops_module_header' ).$d3diary_header,
			"mod_config" =>  $d3dConf->mod_config
			));

	$d3dConf->debug_appendtime('diarylist');
	if($d3dConf->mPerm->isadmin==true && $d3dConf->debug_mode==1){$xoopsTpl->assign("debug_time", $d3dConf->debug_gettime());}

function d3diary_assign_common_category ($mydirname) {
	global $xoopsDB, $d3dConf ;
	// naao changed for common category (uid=0)
	$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname.'_category')."
	          WHERE uid='0' ORDER BY corder";

	$result = $xoopsDB->query($sql);
	$catopt = array();
	$catopts = array();
	while ( $dbdat = $xoopsDB->fetchArray($result) ) {
		$op = (int)$dbdat['openarea'];
		if($dbdat['blogtype'] != 100){
			$catopt['cid']   = (int)$dbdat['cid'];
			$catopt['cname']   = htmlspecialchars($dbdat['cname'], ENT_QUOTES);
			$catopt['corder']   = (int)$dbdat['corder'];
			$catopt['subcat']   = (int)$dbdat['subcat'];
			$catopt['openarea']   = $op;
			$catopt['blogtype']   = (int)$dbdat['blogtype'];
			$catopt['dohtml']   = (int)$dbdat['dohtml'];
		}
		if($op ==10 || $op==20) {
			$_tmp_gperms = isset($dbdat['vgids']) ? 
					array_map("intval", explode('|', trim($dbdat['vgids'],'|'))) : array();
			if (array_intersect($d3dConf->mPerm->mygids, $_tmp_gperms)) {
				$catopts[] = $catopt;
			}
		} else {
			$catopts[] = $catopt;
		}
	}
	return $catopts;
}

include_once XOOPS_ROOT_PATH.'/footer.php';

?>
