<?php

if( ! class_exists( 'D3diaryFunc' ) ) {

class D3diaryFunc {

	var $d3dConf ;
	var $mPerm ;
	var $gPerm ;
	var $myts ;
	var $mydirname ;
	var $mid ;
	var $mod_config ;
	var $dcfg ;
	var $uid ;
	var $req_uid ;
	var $arr_weeks ;
	var $arr_monthes ;
	var $arr_dclass ;
	var $arr_wclass ;

function D3diaryFunc( & $d3dConf ){

	$this->d3dConf = & $d3dConf;
}

function ini_set()
{	//must be set $this->mydirname, $req_uid before call it

	// copying parent's parameters
	$this->mydirname = $this->d3dConf->mydirname;
	$this->mid = $this->d3dConf->mid;

	$this->uid = $this->d3dConf->uid;
	$this->mod_config = $this->d3dConf->mod_config;
	$this->dcfg = $this->d3dConf->dcfg;
	$this->req_uid = $this->d3dConf->req_uid;
	
	$this->mPerm = & $this->d3dConf->mPerm;
	$this->gPerm = & $this->d3dConf->gPerm;
	
	$this->myts =& MyTextSanitizer::getInstance();

	list( $this->arr_weeks, $this->arr_monthes, $this->arr_dclass, $this->arr_wclass ) = $this->initBoxArr();

}

function execute( $request )
{
	// abstract (must override it)
}

function & getpost_param($pname)
{
	if(isset($_GET[$pname]))$pdat=$_GET[$pname];
	elseif(isset($_POST[$pname]))$pdat=$_POST[$pname];
	else $pdat="";
	
	return $pdat;
}

function myformatTimestamp($time, $format, $timeoffset=""){
    global $xoopsUser;
    $usertimestamp = xoops_getUserTimestamp($time, $timeoffset);
	return date($format, $usertimestamp);
}

function convert_encoding_utf8($text) {
	if (XOOPS_USE_MULTIBYTES == 1) {
		if(!empty($this->d3dConf->enc_from)){
			return mb_convert_encoding($text, 'UTF-8', $this->d3dConf->enc_from);
		} else {
			return mb_convert_encoding($text, 'UTF-8');
		}
	}
	return utf8_encode($text);
}

function get_xoopsuname($uid){

	$db = & $this->d3dConf->db;
	
	$sql = "SELECT uname, name 
			FROM ".$db->prefix('users')." WHERE uid='".intval($uid)."'";
	$result = $db->query($sql);
	
	$arr_rtn = array();
	while ( $dbdat = $db->fetchArray($result)){
		$arr_rtn = $dbdat;
	}
	return $arr_rtn;
}

function get_user_avatar($uids)
{	// $uid for single uid requiest, $uids for multi uids request

	$db = & $this->d3dConf->db;
    
	$url_avatar = "";
	
	$whr_uids = " WHERE uid IN (".implode(',',$uids).")";
	
	$sql = "SELECT uid, user_avatar FROM ".$db->prefix('users').$whr_uids;
	$result = $db->query($sql);

	if(!empty($result)){
		$user_avatar = "";
		while ( $dbdat = $db->fetchArray($result)){
			$user_avatar = htmlspecialchars($dbdat['user_avatar'], ENT_QUOTES);
			$uid = intval($dbdat['uid']);
			if($user_avatar=="blank.gif" && file_exists(XOOPS_ROOT_PATH."/modules/user/images/no_avatar.gif")) {
				$url_avatar[$uid] = XOOPS_URL . "/modules/user/images/no_avatar.gif";
			} else {
				$url_avatar[$uid] = XOOPS_UPLOAD_URL . "/" . $user_avatar;
       			}
		}
       	}
       	return $url_avatar;
}

function get_openarea_cat($uid,$cid)
{
	$db = & $this->d3dConf->db;
	
	if($cid==0){ return 0; }
	
	$sql = "SELECT openarea FROM ".$db->prefix($this->mydirname."_category")." 
		WHERE uid = '$uid' AND cid = '$cid'";
	if ( !$result = $db->query($sql) ) { return 0; }
	if ( !$row = $db->fetchArray($result) ) { return 0; }
	return intval($row['openarea']);
}

function get_count_diary($uid)
{
	$db = & $this->d3dConf->db;
	
	$sql = "SELECT cnt FROM ".$db->prefix($this->mydirname."_cnt")." 
		WHERE uid = '$uid' AND ymd='1111-11-11'";
	if ( !$result = $db->query($sql) ) { return 0; }
	if ( !$row = $db->fetchArray($result) ) { return 0; }
	return $row['cnt'];
}

// ���L�p�J�E���^
function countup_diary($uid, $bid=0)
{
	$db = & $this->d3dConf->db;
	
	// cout up entry counter
	$bid = (int)$bid;
	if ($bid>0 && $this->uid != $this->req_uid) {
		$res = $db->query("SELECT view 
			FROM ".$db->prefix($this->mydirname."_diary")." WHERE bid='".$bid."'");
		$db->queryF("UPDATE ".$db->prefix($this->mydirname."_diary")." 
			SET view = (view + 1) WHERE bid = '".$bid."'");
	}

	$interval=5*60; // 5��1�J�E���g
	
	$NowTime = time() + 9 * 60 * 60;
	$NowYMD = date('Y-m-d', $NowTime);

	$RemoteAddr = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	$RemoteHost = (isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : '');
	if ($RemoteHost == '') { $RemoteHost = $RemoteAddr; }
	$slashedRH = addslashes($RemoteHost);

	//	Delete Old Access Data
	$db->queryF("DELETE FROM ".$db->prefix($this->mydirname."_cnt_ip")." WHERE acctime < '".($NowTime - $interval)."'");
	
	// �������玞���X�V�̂�
	$sql = "SELECT accip FROM ".$db->prefix($this->mydirname."_cnt_ip")." 
		WHERE accip = '$slashedRH' AND uid='$uid'";
	if ($db->getRowsNum($db->query($sql)) != 0) {
		$sql = "UPDATE ".$db->prefix($this->mydirname."_cnt_ip")." 
			SET acctime = $NowTime WHERE accip = '$slashedRH' AND uid='$uid'";
		$res = $db->queryF($sql);
		return;
	}
	//	Access Data
	$db->queryF("INSERT INTO ".$db->prefix($this->mydirname."_cnt_ip")." 
		(accip, acctime, uid) 
		VALUES ('$slashedRH', '$NowTime', '$uid')");
	// cout up personal counter
	$res = $db->query("SELECT cnt 
		FROM ".$db->prefix($this->mydirname."_cnt")." 
		WHERE uid='".$uid."' AND ymd='1111-11-11'");
	if ($db->getRowsNum($res) == 0) {
		$db->queryF("INSERT INTO ".$db->prefix($this->mydirname."_cnt")." 
			(cnt, uid, ymd) VALUES ('1', '".$uid."', '1111-11-11')");
	} else {
		$db->queryF("UPDATE ".$db->prefix($this->mydirname."_cnt")." 
			SET cnt = (cnt + 1) WHERE uid = '".$uid."' AND ymd='1111-11-11'");
	}

}

# �J�e�S���[���X�g
function get_categories($req_uid, $uid){

	$db = & $this->d3dConf->db;
	
	$editperm=0;
	$whr_openarea = "(openarea <>100 OR uid = $uid) AND";
	if($this->mPerm->isadmin){
		$editperm=1;
		$whr_openarea = "";
	}
	if($req_uid==$uid){$owner=1;}

	if($req_uid==0){	// for diarylist
		$on_uid = "ON ( c.uid='0' AND d.cid=c.cid) " ;
		$whr_uid1 = " c.uid='0' " ;
		$whr_uid2 = " c.uid='0' " ;
	} else {		// for personal index
		$on_uid = "ON ((d.uid=c.uid  OR c.uid='0') AND d.cid=c.cid) " ;
		$whr_uid1 = " d.uid='".intval($req_uid)."' " ;
		$whr_uid2 = " (c.uid='".intval($req_uid)."' OR c.uid='0') " ;
	}

	if($this->mPerm->isadmin){
		$whr_openarea = " 1 ";
	} else {
		// openarea permissions 
		$_params4op['use_gp'] = $this->gPerm->use_gp;
		$_params4op['use_pp'] = $this->gPerm->use_pp;
		$whr_openarea = $this->mPerm->get_open_query( "right_cat1", $_params4op );
		//var_dump($whr_openarea);
	}

	$now = date("Y-m-d H:i:s");
	if ($this->mPerm->isadmin!=true and $this->mPerm->isauthor!=true) {
		$whr_nofuture = " AND d.create_time<'".$now."' ";
	} else { $whr_nofuture = ""; }

	$sql = "SELECT c.cid, count(*) as d_count 
			FROM ".$db->prefix($this->mydirname.'_diary')." d 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c ".$on_uid." 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			WHERE ".$whr_uid1." AND ".$whr_openarea.$whr_nofuture." 
			GROUP BY d.cid ORDER BY c.corder ASC";

	$arr_entry = array(); $arr_catopt = array();
	$result = $db->query($sql);
	while ( $dbdat = $db->fetchArray($result) ) {
		$arr_entry[intval($dbdat['cid'])] =  $dbdat['d_count'];
	}

	if($this->mPerm->isadmin){
		$whr_openarea = " 1 ";
	} else {
		// openarea permissions for cat
		$whr_openarea = $this->mPerm->get_open_query( "right_cat2", $_params4op );
		//var_dump($whr_openarea);
	}

	$sql = "SELECT * 
			FROM ".$db->prefix($this->mydirname.'_category')." c 
	          	WHERE ".$whr_uid2." AND ".$whr_openarea." ORDER BY c.corder ASC";
	//var_dump($sql);
	$result = $db->query($sql);
	while ( $dbdat = $db->fetchArray($result) ) {
		if (isset($arr_entry[intval($dbdat['cid'])])) {	$catopt['num']=$arr_entry[intval($dbdat['cid'])]; }
		else { $catopt['num']=0; }
		$catopt['cid']  = intval($dbdat['cid']);
		$catopt['cname']  = $dbdat['cname'] ? $this->myts->makeTboxData4Show($dbdat['cname']) : constant("_MD_NOCNAME");
		$catopt['subcat']  = intval($dbdat['subcat']);
		$catopt['blogtype']  = intval($dbdat['blogtype']);
		$arr_catopt[] = $catopt;
		//$xoopsTpl->append("catopt", $catopt);
	}
		if (isset($arr_entry[0])) {
			$catopt['num']=$arr_entry[0];
			$catopt['cid']   = 0;
			$catopt['cname']   = constant("_MD_NOCNAME");
			$catopt['subcat']  = 0;
			$arr_catopt[] = $catopt;
			//$xoopsTpl->append("catopt", $catopt);
		}
	return $arr_catopt;
}

function get_calender( $req_uid, $year, $month, $uid, $base_url="", $block=false )
{

	$db = & $this->d3dConf->db;

	$dcnt="";
	
	$start=$year."-".$month."-1 00:00:00";
	if($month==12){
		$end=($year+1)."-01-01 00:00:00";
	}else{
		$end=$year."-".($month+1)."-01 00:00:00";
	}

	$editperm=0;

	if($req_uid==0){	// for diarylist
		$whr_uid = " 1 " ;
	} else {		// for personal index
		$whr_uid = " d.uid='".intval($req_uid)."'" ;
	}
	$on_uid = "ON ((d.uid=c.uid  OR c.uid='0') AND d.cid=c.cid) " ;

	if( $req_uid > 0 ) {
		$base_url = XOOPS_URL."/modules/".$this->mydirname."/index.php?page=index";
	} else {
		$base_url = XOOPS_URL."/modules/".$this->mydirname."/index.php?page=diarylist";
	}
		

	if($this->mPerm->isadmin){
		$editperm=1;
		$whr_openarea = " 1 ";
	} else {
		// openarea permissions 
		$_params4op['use_gp'] = $this->gPerm->use_gp;
		$_params4op['use_pp'] = $this->gPerm->use_pp;
		$whr_openarea = $this->mPerm->get_open_query( "right_cal", $_params4op );
		//var_dump($whr_openarea);
	}

	$sql = "SELECT d.uid, d.bid, d.cid, d.create_time, d.openarea, 
			c.cid, c.openarea AS openareacat 
			FROM ".$db->prefix($this->mydirname.'_diary')." d 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c ".$on_uid." 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			WHERE ".$whr_uid." AND ".$whr_openarea." 
			AND create_time>='".$start."' AND create_time<'".$end."'";
	//echo"<br/>"; var_dump($sql);echo"<br/>"; echo"<br/>"; 
	
	$result = $db->query($sql);
	while ( $dbdat = $db->fetchArray($result)){
		$ctime = preg_split("/[-: ]/",$dbdat['create_time']);
		$tmp=$this->myformatTimestamp(mktime($ctime[3],$ctime[4],$ctime[5],$ctime[1],$ctime[2],$ctime[0]), "d");
		$dcnt[intval($tmp)]=(empty($dcnt[intval($tmp)])) ? 1 : $dcnt[intval($tmp)]+1;
	}

	$last_day=intval(date("j" ,(mktime(0,0,0,($month+1),1,$year)-1)));
	$first_w =intval(date("w" ,mktime(0,0,0,$month,1,$year)));
	$before_month_y=date("Y" ,(mktime(0,0,0,$month,1,$year)-1));
	$before_month_m=date("m" ,(mktime(0,0,0,$month,1,$year)-1));
	$next_month_y=date("Y" ,mktime(0,0,0,($month+1),1,$year));
	$next_month_m=date("m" ,mktime(0,0,0,($month+1),1,$year));

	if($editperm==1){
		$whr_openarea = " 1 ";
	} else {
		$whr_openarea = $this->mPerm->get_open_query( "right_cal_other", $_params4op );
	}
	$sql = "SELECT d.uid, d.cid, d.create_time, 
			c.cid, c.openarea AS openareacat 
			FROM ".$db->prefix($this->mydirname.'_newentry')." d 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c ".$on_uid." 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			WHERE d.blogtype>'0' AND ".$whr_uid." AND ".$whr_openarea." 
			AND create_time>='".$start."' AND create_time<'".$end."'";
	//echo"<br/>"; var_dump($sql);echo"<br/>"; echo"<br/>";
	
	$result = $db->query($sql);
	while ( $dbdat = $db->fetchArray($result)){
		$ctime = preg_split("/[-: ]/",$dbdat['create_time']);
		$tmp=$this->myformatTimestamp(mktime($ctime[3],$ctime[4],$ctime[5],$ctime[1],$ctime[2],$ctime[0]), "d");
		$dcnt[intval($tmp)]=(empty($dcnt[intval($tmp)])) ? 1 : $dcnt[intval($tmp)]+1;
	}
	//var_dump($sql);
	//var_dump($dbdat);
	if ( $block==true ) {
		$constpref = "_MB_" . strtoupper( $this->mydirname ) ;
		$week_arr = explode( ',', constant($constpref."_CALWEEK") );
		$const_before_month = constant($constpref."_BEFORE_MONTH");
		$const_next_month = constant($constpref."_NEXT_MONTH");
	} else {
		$week_arr = explode( ',', constant("_MD_CALWEEK") );
		$const_before_month = constant("_MD_BEFORE_MONTH");
		$const_next_month = constant("_MD_NEXT_MONTH");
	}

	$html="<tr><td colspan=7>";
	$html.="<a style='float:left;' href='".$base_url."&amp;req_uid=".$req_uid."&amp;mode=month&amp;year=".$before_month_y."&amp;month=".$before_month_m."'>&laquo;".$const_before_month."</a>";
	$html.="<a style='float:right;' href='".$base_url."&amp;req_uid=".$req_uid."&amp;mode=month&amp;year=".$next_month_y."&amp;month=".$next_month_m."'>".$const_next_month."&raquo;</a><div class='clear'></div></td></tr>";
	$html.="<tr class='d3d_week'><td><font color='red'>".$week_arr[0]."</font></td>";
	$html.="<td>".$week_arr[1]."</td>";
	$html.="<td>".$week_arr[2]."</td>";
	$html.="<td>".$week_arr[3]."</td>";
	$html.="<td>".$week_arr[4]."</td>";
	$html.="<td>".$week_arr[5]."</td>";
	$html.="<td><font color='blue'>".$week_arr[6]."</font></td></tr><tr>";
	for($i=0;$i<$first_w;$i++){
		$html.="<td></td>";
	}
	for($j=1;$j<=$last_day;$j++){
		if($i==7){
			$i=0;
			$html.="</tr><tr>";
		}
		if(!empty($dcnt[$j]) and intval($dcnt[$j])>0){
			$html.="<td><a href='".$base_url."&amp;req_uid=".$req_uid."&amp;mode=date&amp;year=".$year."&amp;month=".$month."&amp;day=".$j."' style='text-decoration:underline;'>".$j."</a></td>";
		}else{
			$html.="<td>".$j."</td>";
		}
		$i++;
	}
	while($i<7){
		$html.="<td></td>";
		$i++;
	}
	$html.="</tr>";

  	return array( $html, $this->arr_monthes[intval($month)-1] );
}

function get_friends($my_friends){
	global $offset;

	$db = & $this->d3dConf->db;

	$max_size = 10;
	$offset = isset($this->getpost_param['offset'])? intval($this->getpost_param['offset']) : 0;
	
	$arr_friends = array();

	$whr_order = " max_create_time DESC";
	if (!empty($my_friends)) {
		$whr_uids =  " WHERE d.uid IN (".implode(',',$my_friends).")";
	} else {
		$whr_uids =  " WHERE d.uid IN (0)";
	}

	$sql = "SELECT d.uid, count(d.uid) AS count, 
			MAX(d.create_time) AS max_create_time, u.name, u.uname 
			from ".$db->prefix($this->mydirname."_diary")." d 
			LEFT JOIN ".$db->prefix("users")." u 
			ON d.uid=u.uid".$whr_uids." 
			GROUP BY d.uid, u.name, u.uname 
			ORDER BY".$whr_order ;

        $count = $db->getRowsNum( $db->query($sql) );
        $result = $db->query($sql, $max_size, $offset);
	while( $row = $db->fetchArray( $result ) ) {
		$arr_friends[]=$row;
	}
	
	if($count>$max_size){
            if( !empty($_SERVER['QUERY_STRING'])) {
                if( ereg("^offset=[0-9]+$", $_SERVER['QUERY_STRING']) ) {
                    $url = "";
                } else {
                    $url = preg_replace("/^(.*)\&offset=[0-9]+$/", "$1", $_SERVER['QUERY_STRING']);
                }
            } else {
                $url = "";
            }
	    include_once dirname( dirname(__FILE__) ).'/class/d3diaryPagenavi.class.php';
            $nav = new d3diaryPageNav($count, $max_size, $offset, "offset", $url);
            $yd_friendsnavi = $nav->renderNav();
        } else {
            $yd_friendsnavi = "";
        }

  	return array( $arr_friends, $yd_friendsnavi);
}

# �o�^�����X�g
function get_monlist( $req_uid, $uid, $max_size =12 ){

	global $openarea;

	$db = & $this->d3dConf->db;

	$_offset_ = $this->getpost_param('mofst');
	$offset = isset($_offset_) ?(int)$_offset_ : 0;
	
	$_mode = $this->getpost_param('mode');
	if ( $_mode == "moth" || $_mode == "date" ) {
		$_year = (int)$this->getpost_param('year');
		$_month = (int)$this->getpost_param('month');
	}

	if($req_uid==0){	// for diarylist
		$whr_uid = " 1 " ;
	} else {		// for personal index
		$whr_uid = " d.uid='".intval($req_uid)."'" ;
	}

	$now = date("Y-m-d H:i:s");
	if ($this->mPerm->isadmin!=true and $this->mPerm->isauthor!=true) {
		$whr_nofuture = " AND d.create_time<'".$now."' ";
	} else { $whr_nofuture = ""; }

	$editperm=0;
	if($this->mPerm->isadmin){
		$editperm=1;
		$whr_openarea = " 1 ";
	} else {
		// openarea permissions 
		$_params4op['use_gp'] = $this->gPerm->use_gp;
		$_params4op['use_pp'] = $this->gPerm->use_pp;
		$whr_openarea = $this->mPerm->get_open_query( "right_mlist", $_params4op );
		//var_dump($whr_openarea);
	}

	$sql = "SELECT LEFT(d.create_time, 7) as thismonth, count(*) as entries, 
			d.uid, d.cid, d.openarea, c.uid, c.cid, c.openarea 
			FROM ".$db->prefix($this->mydirname.'_diary')." d 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c 
			ON ((d.uid=c.uid  OR c.uid='0') AND d.cid=c.cid) 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			WHERE ".$whr_uid." AND ".$whr_openarea.$whr_nofuture." 
			GROUP BY thismonth ORDER BY thismonth DESC";

        $count = $db->getRowsNum( $db->query($sql) );
        $result = $db->query($sql, $max_size, $offset);

	$str_montharray = array(); $yd_monlist = array();
	$i=0;
	while ( $dbdat = $db->fetchArray($result) ) {
		if (!empty($dbdat['thismonth'])){
			$str_montharray[$i] = $dbdat['thismonth'];
			list($yd_monlist[$i]['year'],$yd_monlist[$i]['month']) = preg_split("/[-]/", $dbdat['thismonth']);
			$yd_monlist[$i]['count'] = intval($dbdat['entries']);
			$i++;
	    	}
	}
		if (!empty($str_montharray)){
			$maxmonth = max($str_montharray);
			$minmonth = min($str_montharray);
		}

	if($count>$max_size){
            if( !empty($_SERVER['QUERY_STRING'])) {
                if( ereg("^mofst=[0-9]+", $_SERVER['QUERY_STRING']) ) {
                    $url = "";
                } else {
                    $url = preg_replace("/^(.*)\&mofst=[0-9]+/", "$1", $_SERVER['QUERY_STRING']);
                }
            } else {
                $url = "";
            }
	    include_once dirname(__FILE__).'/d3diaryPagenavi.class.php';
            $nav = new d3diaryPageNav($count, $max_size, $offset, "mofst", $url);
            $yd_monthnavi = $nav->renderNav();
        } else {
            $yd_monthnavi = "";
        }
	return array( $yd_monlist, $yd_monthnavi );
}

// �ŐV���L���X�g
function get_blist($req_uid, $uid, $maxnum=7, $dosort=true, $params=array() ){
	$mytstamp = array();
	return $this->get_blist_tstamp($req_uid, $uid, $maxnum, $dosort, $mytstamp, $params);
	
}

// �ŐV���L���X�g
function get_blist_tstamp($req_uid, $uid, $maxnum=7, $dosort=true, & $mytstamp, $params=array() ){
	global $openarea ;

	$db = & $this->d3dConf->db;
	$noavatar_exists = file_exists(XOOPS_ROOT_PATH."/modules/user/images/no_avatar.gif");


	$on_uid = "ON ((d.uid=c.uid  OR c.uid='0') AND d.cid=c.cid) " ;

	$editperm=0;
	if($this->mPerm->isadmin){
		$editperm=1;
		$whr_openarea = "";
	} else {
		// openarea permissions 
		$_params4op['use_gp'] = $this->gPerm->use_gp;
		$_params4op['use_pp'] = $this->gPerm->use_pp;
		$whr_openarea = $this->mPerm->get_open_query( "right_blist", $_params4op );
		//var_dump($whr_openarea);

		$whr_openarea = " AND ".$whr_openarea;
	}

	if(intval($req_uid)>0){
		$whr_uids="d.uid='".intval($req_uid)."'";
	} else {
		$whr_uids=" 1 ";
	}
		$now = date("Y-m-d H:i:s");
		if ($this->mPerm->isadmin!=true and $this->mPerm->isauthor!=true) {
			$whr_nofuture = " AND d.create_time<'".$now."' ";
		} else {
			$whr_nofuture = "";
		}

	$whr_timerange = "" ;
	$whr_cat = "" ;
	$whr_tag = "" ;
	$table_tag = "" ;

	if (!empty($params)){
		if(!empty($params['range_start'])){
			$timerange_start = $params['range_start'] ;
			$timerange_end   = $params['range_end'] ;
			$whr_timerange   = " AND d.create_time>'".$timerange_start."' AND d.create_time<'".$timerange_end."' " ;
		}
		if(!empty($params['categories'])){
			$whr_cat = " AND (" ;
		      	foreach($params['categories'] as $cat) {
				$whr_cat .= "c.cname LIKE '".$cat."' OR ";
			}
            		$whr_cat = rtrim( $whr_cat, "OR " ). ")" ;
		}
		if(!empty($params['tags'])){
			$table_tag = "LEFT JOIN ".$db->prefix($this->mydirname.'_tag')." t ON d.bid=t.bid " ;
			$whr_tag = " AND (" ;
		      	foreach($params['tags'] as $tag) {
				$whr_tag .= "t.tag_name LIKE '".$tag."' OR ";
			}
            		$whr_tag = rtrim( $whr_tag, "OR " ). ")" ;
		}
	}

	// entries
	$sql = "SELECT d.uid AS uid, d.bid AS bid, d.title, d.cid, d.diary, d.create_time, d.openarea AS openarea_entry, d.dohtml, 
			u.uname, u.name, u.user_avatar, c.openarea AS openarea_cat, c.cname, cfg.openarea 
			FROM ".$db->prefix($this->mydirname.'_diary')." d 
			INNER JOIN ".$db->prefix('users')." u USING(uid) 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c ".$on_uid." 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			".$table_tag."
			WHERE ".$whr_uids.$whr_openarea.$whr_nofuture.$whr_timerange.$whr_cat.$whr_tag." 
			ORDER BY create_time DESC LIMIT 0,".$maxnum;
	          	
		//var_dump($sql);

	$result = $db->query($sql);

	$yd_d_list = array(); $yd_list = array(); $new_bids = array();

	while ( $dbdat = $db->fetchArray($result) ) {
	    $i = (int)$dbdat['bid'];
	    $new_bids[] = $i;
		$yd_list['bid']   = $i;
		$yd_list['cid']   = intval($dbdat['cid']);
		$yd_list['uid']   = intval($dbdat['uid']);
		$yd_list['title'] = $this->myts->makeTboxData4Show($dbdat['title']);
		$yd_list['uname'] = $dbdat['uname'];
		$yd_list['name']  = !empty($dbdat['name']) ? $dbdat['name'] : $dbdat['uname'];
		$yd_list['create_time']   = $dbdat['create_time'];
		$yd_list['diary'] = $dbdat['diary'];
		$yd_list['cname']   = !empty($dbdat['cname']) ? $this->myts->makeTboxData4Show($dbdat['cname']) : "" ;
		$yd_list['openarea'] = 0;
		$yd_list['dohtml'] = intval($dbdat['dohtml']);
		$yd_list['view'] = !empty($dbdat['view']) ? intval($dbdat['view']) : 0 ;
		$yd_list['url']   = XOOPS_URL.'/modules/'.$this->mydirname.'/index.php?page=detail&bid='.$i;
		
		$yd_list['openarea'] = intval($dbdat['openarea']);
		if (intval($dbdat['openarea_entry'])>0) { $yd_list['openarea'] = $dbdat['openarea_entry'];}
		elseif (intval($dbdat['openarea_cat'])>0) {
			$yd_list['openarea'] = intval($dbdat['openarea_cat']);
		}

		$ctime = preg_split("/[-: ]/", $dbdat['create_time']);
		$tstamp = mktime($ctime[3],$ctime[4],$ctime[5],$ctime[1],$ctime[2],$ctime[0]);
		$yd_list['tstamp']   = $tstamp;
		$yd_list['year']   = $this->myformatTimestamp($tstamp, "Y");
		$yd_list['month']   = $this->myformatTimestamp($tstamp, "m");
		$yd_list['day']   = $this->myformatTimestamp($tstamp, "d");
		$yd_list['time']   = $this->myformatTimestamp($tstamp, "H:i");
		$yd_list['other']  = 0;
			$_user_avatar = htmlspecialchars($dbdat['user_avatar'], ENT_QUOTES);
			if($_user_avatar=="blank.gif" && $noavatar_exists) {
				$yd_list['avatarurl'] = XOOPS_URL . "/modules/user/images/no_avatar.gif";
			} else {
				$yd_list['avatarurl'] = XOOPS_UPLOAD_URL . "/" . $_user_avatar;
       			}
		$yd_d_list[$i] = $yd_list;
		$mytstamp[$i] = $tstamp;

		$first_date =  $yd_list['create_time'];
	}
	
    if (empty($params['tags'])) {
	// newentries (other)
	if (!empty($first_date)) {
		$whr_nofuture = " AND d.create_time>'" . $first_date . "' " . $whr_nofuture ;
	}
	
	if($this->mPerm->isadmin){
		$whr_openarea = "";
	} else {
		// openarea permissions 
		$_params4op['use_gp'] = $this->gPerm->use_gp;
		$_params4op['use_pp'] = $this->gPerm->use_pp;
		$whr_openarea = $this->mPerm->get_open_query( "right_blist_other", $_params4op );
		$whr_openarea = " AND ".$whr_openarea;
	}

	$sql = "SELECT d.uid AS uid, d.cid, d.title, d.create_time, d.url, d.diary, 
			u.uname, u.name, u.user_avatar, c.cname, c.openarea AS openarea_cat, cfg.openarea AS openarea 
			FROM ".$db->prefix($this->mydirname.'_newentry')." d 
			INNER JOIN ".$db->prefix('users')." u USING(uid) 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c ".$on_uid." 
			WHERE d.blogtype>'0' AND ".$whr_uids.$whr_openarea.$whr_nofuture.$whr_cat.$whr_timerange." 
			ORDER BY create_time DESC LIMIT 0,".$maxnum;
		//var_dump($sql);
	$result = $db->query($sql);
	
	$i = -1000; $yd_list = array();
	while ( $dbdat = $db->fetchArray($result) ) {
		$yd_list['bid']   = $i ;
		$yd_list['cid']   = intval($dbdat['cid']);
		$yd_list['uid']   = intval($dbdat['uid']);
		$yd_list['title']   = $this->myts->makeTboxData4Show($dbdat['title']);
		$yd_list['uname'] = $dbdat['uname'];
		$yd_list['name']  = (!empty($dbdat['name'])) ? $dbdat['name'] : $dbdat['uname'];
		$yd_list['create_time']   = $dbdat['create_time'];
		$yd_list['diary'] = strip_tags($dbdat['diary']);
		$yd_list['cname']   = !empty($dbdat['cname']) ? $this->myts->makeTboxData4Show($dbdat['cname']) : "" ;
		$yd_list['openarea'] = $dbdat['openarea'] ? (int)$dbdat['openarea'] : 0 ;
		$yd_list['dohtml'] = 0 ;
		$yd_list['view'] = 0 ;
		$yd_list['url']   = $dbdat['url'];
		
		if (intval($dbdat['openarea_cat'])>0) { $yd_list['openarea'] = $dbdat['openarea_cat'];}

		$ctime = preg_split("/[-: ]/", $dbdat['create_time']);
		$tstamp = mktime($ctime[3],$ctime[4],$ctime[5],$ctime[1],$ctime[2],$ctime[0]);
		$yd_list['tstamp']   = $tstamp;
		$yd_list['year']   = $this->myformatTimestamp($tstamp, "Y");
		$yd_list['month']   = $this->myformatTimestamp($tstamp, "m");
		$yd_list['day']   = $this->myformatTimestamp($tstamp, "d");
		$yd_list['time']   = $this->myformatTimestamp($tstamp, "H:i");
		$yd_list['other']  = 1;
			$_user_avatar = htmlspecialchars($dbdat['user_avatar'], ENT_QUOTES);
			if($_user_avatar=="blank.gif" && $noavatar_exists) {
				$yd_list['avatarurl'] = XOOPS_URL . "/modules/user/images/no_avatar.gif";
			} else {
				$yd_list['avatarurl'] = XOOPS_UPLOAD_URL . "/" . $_user_avatar;
       			}
		$yd_d_list[$i] = $yd_list;
		$mytstamp[$i] = $tstamp;
	//echo"<br />"; var_dump(strval($i)); var_dump($yd_d_list[strval($i)]); echo"<br />"; echo"<br />"; 
	    $i++;
	}
    } //end if (empty($params['tags']))
	//var_dump($mytstamp);
	if ($dosort===true && !empty($mytstamp) && !empty($yd_d_list)) {
		array_multisort($mytstamp, SORT_DESC, $yd_d_list );
	}
	
	$this->d3dConf->set_new_bids ( $new_bids );
	//return array( $yd_d_list, $new_bids );
	//echo"<br />";	var_dump($new_bids); echo"<br />";echo"<br />";
	//var_dump($yd_d_list);
	return $yd_d_list;
}

function get_commentlist($req_uid, $uid, $maxnum=30, $only_count=false, $dosort=true){
	global $openarea;

	$db = & $this->d3dConf->db;
	
	$this->d3dConf->get_new_bids ( $new_bids );

	if ( isset( $new_bids ) ) {
		$bids = $new_bids ;
	} else {
		$yd_list =  $this->get_blist ($req_uid,$uid,$maxnum);
		$this->d3dConf->get_new_bids ( $new_bids );
	}
	//echo"<br />";	var_dump($new_bids); echo"<br />";echo"<br />";

	$com_dirname = $this->mod_config['comment_dirname'];
	$com_forum_id = intval($this->mod_config['comment_forum_id']);
	$com_anchor_type = intval($this->mod_config['comment_anchor_type']);

	// if comment integration is set
    	if(!empty($com_dirname) && ($com_forum_id > 0)){
		// forums can be read by current viewer (check by forum_access)
		$got_forums_can_read = $this->get_d3comforums_can_read( $com_dirname ,$uid );
		if ( !in_array( $com_forum_id, $got_forums_can_read ) ) { return ; }
	}
	
	$editperm=0;
	$owner=0;
	if($uid>0 && $req_uid==$uid){$editperm=1;}
	if($this->mPerm->isadmin){$editperm=1;}
	$_yd_com = array();

	$req_uid2=intval($this->getpost_param('req_uid'));
	if(intval($req_uid2)>0) {
		$whr_uids="AND d.uid=".intval($req_uid2);
	} else {$whr_uids="";}

	if($this->d3dConf->mPerm->isadmin){
		$whr_openarea = "";
	} else {
		$_params4op['use_gp'] = $this->gPerm->use_gp;
		$_params4op['use_pp'] = $this->gPerm->use_pp;
		$whr_openarea = " AND ".$this->mPerm->get_open_query( "b_side_com", $_params4op );
	}

    	if($com_dirname && ($com_forum_id > 0)){
    	// d3comment integration
    
		$whr_forum = 'f.forum_id='.$com_forum_id ;
    		if (!empty($bids)) {
			$whr_bid=" t.topic_external_link_id IN (".implode(',',$bids).")";
		} else {
			$whr_bid=" or t.topic_external_link_id IN (0)";
		}
		$q_order = 'p.post_time DESC';
		
		if($only_count) 
		{
			$sql = "SELECT count(p.post_id) AS count, MAX(p.post_id) AS com_id, 
		    	t.topic_external_link_id FROM "
			.$db->prefix($com_dirname."_posts")." p 
			INNER JOIN ".$db->prefix($com_dirname."_topics")." t 
				ON (t.topic_id=p.topic_id AND ! t.topic_invisible AND ".$whr_bid." ) 
			INNER JOIN ".$db->prefix($com_dirname."_forums")." f 
				ON (f.forum_id=t.forum_id AND ".$whr_forum.") 
			LEFT JOIN ".$db->prefix('users')." u ON p.uid=u.uid 
			GROUP by t.topic_external_link_id 
			ORDER BY p.post_time DESC";

			$result = $db->query($sql);
			while ( $dbdat = $db->fetchArray($result) ) {
				$_com_id[$dbdat['topic_external_link_id']]  =  $dbdat['com_id'];
				$_com_count[$dbdat['topic_external_link_id']]  =  $dbdat['count'];
			}
			if(isset($_com_id)){
				$whr_num = "p.post_id IN (" .implode( "," , $_com_id ). ") ";
			} else { $whr_num = ""; }

		    $sql = "SELECT p.post_id, p.subject, p.votes_sum, p.votes_count, p.post_time, 
			p.post_text, p.uid, p.guest_name, p.unique_path, u.uname, u.name,
			f.forum_id, f.forum_title, t.topic_external_link_id 
			FROM ".$db->prefix($com_dirname."_posts")." p 
			INNER JOIN ".$db->prefix($com_dirname."_topics")." t USING(topic_id) 
			INNER JOIN ".$db->prefix($com_dirname."_forums")." f 
				ON (f.forum_id=t.forum_id AND ".$whr_forum.") 
			LEFT JOIN ".$db->prefix('users')." u ON p.uid=u.uid 
			WHERE ".$whr_num." ORDER BY post_time DESC";

		} else {
			
		    $sql = "SELECT p.post_id, p.subject, p.post_time, 
			p.post_text, p.uid, p.guest_name, p.unique_path, 
			t.topic_external_link_id, u.uname, u.name, 
			d.bid, d.cid, c.cname, c.openarea as openareacat 
			FROM ".$db->prefix($com_dirname."_posts")." p 
			INNER JOIN ".$db->prefix($com_dirname."_topics")." t 
				ON (t.topic_id=p.topic_id AND ! t.topic_invisible ) 
			INNER JOIN ".$db->prefix($com_dirname."_forums")." f 
				ON (f.forum_id=t.forum_id AND ".$whr_forum.") 
			INNER JOIN ".$db->prefix($this->mydirname.'_diary')." d 
				ON t.topic_external_link_id=d.bid ".$whr_uids." 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c 
				ON (d.uid=c.uid  OR c.uid=0) AND d.cid=c.cid 
			LEFT JOIN ".$db->prefix('users')." u ON p.uid=u.uid 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			WHERE ! t.topic_invisible ".$whr_openarea." 
			ORDER BY p.post_time DESC LIMIT 0,".$maxnum;

		//var_dump($sql); echo"<br />"; echo"<br />";
		}
		
		$_yd_com = array();
		$result = $db->query($sql);
		while ( $dbdat = $db->fetchArray($result) ) {
			$yd_comment['com_id']  =  $dbdat['post_id'];
			if(isset($_com_id[$dbdat['topic_external_link_id']])) {
				$yd_comment['com_num']  =  $_com_count[$dbdat['topic_external_link_id']];
			}
			if($com_anchor_type==1) { $yd_comment['unique_path'] = $dbdat['post_id']; }
			else { $yd_comment['unique_path'] = ltrim($dbdat['unique_path'], "."); }
			$yd_comment['title'] = $this->myts->makeTboxData4Show(mb_substr($dbdat['subject'],0,20));
			$yd_comment['datetime']  = intval($dbdat['post_time']);
			$yd_comment['year']  = date("Y", $dbdat['post_time']);
			$yd_comment['month'] = date("m", $dbdat['post_time']);
			$yd_comment['day']   = date("d", $dbdat['post_time']);
			$yd_comment['time']  = date("H:i", $dbdat['post_time']);
			if((mktime()-60*60*24*7)<$dbdat['post_time']){ $yd_comment['newcom'] = 1; }
			else{	$yd_comment['newcom'] = 0; }
			
			$yd_comment['bid']  =  $dbdat['topic_external_link_id'];
			if ($dbdat['uid']) {
				$yd_comment['uname'] = htmlSpecialChars($dbdat['uname'], ENT_QUOTES);
				$yd_comment['name'] = (!empty($dbdat['name'])) ? htmlSpecialChars($dbdat['name'], ENT_QUOTES) : "";
				$yd_comment['guest_name'] = "";
			} else {
				$yd_comment['name'] = $yd_comment['uname'] = "";
				$yd_comment['guest_name'] = !empty($dbdat['guest_name']) ? 
					 htmlSpecialChars($dbdat['guest_name'], ENT_QUOTES) : $GLOBALS['xoopsConfig']['anonymous'];
			}
			$_yd_com[$yd_comment['com_id']] = $yd_comment;
			$mytstamp[$yd_comment['com_id']] = intval($dbdat['post_time']);
		}
			if($com_anchor_type==1) { $yd_com_key = "#post_id"; } 
			else { $yd_com_key = "#post_path"; }

    	} else {
    	//xoops comment
    		if (!empty($bids)) {	$whr_bid=" and com_itemid IN (".implode(',',$bids).")"; }
    		else {			$whr_bid=" and com_itemid IN (0)";	}
		if($only_count) 
		{
		    $sql = "SELECT count(com.com_id) AS count, MAX(com.com_id) AS _com_id, com.com_itemid 
			  	FROM ".$db->prefix('xoopscomments')." com 
				LEFT JOIN ".$db->prefix('users')." u ON com.com_uid=u.uid 
	          		WHERE com.com_modid='".$this->mid."' "
	          		.$whr_bid." GROUP by com.com_itemid 
	          		ORDER BY com_created DESC";

			$result = $db->query($sql);
			while ( $dbdat = $db->fetchArray($result) ) {
				$_com_id[$dbdat['com_itemid']]  =  $dbdat['_com_id'];
				$_com_count[$dbdat['com_itemid']]  =  $dbdat['count'];
			}
			//var_dump($_com_id); var_dump($_com_count);
			
			if(isset($_com_id)){
				$whr_num = "com.com_id IN (" .implode( "," , $_com_id ). ") ";
			} else { $whr_num = "0"; }

			$sql = "SELECT com.com_id, com.com_title, com.com_created, 
				com.com_itemid, u.uname, u.name 
				FROM ".$db->prefix('xoopscomments')." com 
				LEFT JOIN ".$db->prefix('users')." u ON com.com_uid=u.uid 
	       		   	WHERE ".$whr_num." 
	       		   	ORDER BY com_created DESC";
			//var_dump($sql);
			
		} else {
		    $sql = "SELECT com.com_id, com.com_title, com.com_created, com.com_itemid, 
		    	u.uname, u.name, d.bid, d.openarea, d.cid, c.cname, c.openarea as openareacat 
			FROM ".$db->prefix('xoopscomments')." com 
			INNER JOIN ".$db->prefix($this->mydirname.'_diary')." d 
				ON com.com_itemid=d.bid ".$whr_uids."
			LEFT JOIN ".$db->prefix('users')." u ON com.com_uid=u.uid 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c 
				ON ((d.uid=c.uid  OR c.uid='0') AND d.cid=c.cid) 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			WHERE com.com_modid='".$this->d3dConf->mid."' ".$whr_openarea." 
			ORDER BY com_created DESC LIMIT 0,".$maxnum;
		//var_dump($sql); echo"<br />"; echo"<br />";

		}
		
		$result = $db->query($sql);
		while ( $dbdat = $db->fetchArray($result) ) {
			$yd_comment['com_id']  =  $dbdat['com_id'];
			if(isset($_com_id[$dbdat['com_itemid']])) {
				$yd_comment['com_num']  =  $_com_count[$dbdat['com_itemid']];
		//var_dump($dbdat['com_itemid']); var_dump($yd_comment['com_num']); 
			}
			$yd_comment['unique_path']  =  $dbdat['com_id'];
			$yd_comment['title'] = $this->myts->makeTboxData4Show(mb_substr($dbdat['com_title'],0,20));
			$yd_comment['datetime']  = intval($dbdat['com_created']);
			$yd_comment['year']  = date("Y", $dbdat['com_created']);
			$yd_comment['month'] = date("m", $dbdat['com_created']);
			$yd_comment['day']   = date("d", $dbdat['com_created']);
			$yd_comment['time']  = date("H:i", $dbdat['com_created']);
			$yd_comment['bid']  =  $dbdat['com_itemid'];
			if (!empty($dbdat['uname'])) {
				$yd_comment['uname'] =  htmlSpecialChars($dbdat['uname'], ENT_QUOTES);
				$yd_comment['name'] = (!empty($dbdat['name'])) ?  htmlSpecialChars($dbdat['name'], ENT_QUOTES) : "";
				$yd_comment['guest_name'] = "";
			} else {
				$yd_comment['uname'] = $yd_comment['name'] = "";
				$yd_comment['guest_name'] = $GLOBALS['xoopsConfig']['anonymous'];
			}
			if((mktime()-60*60*24*7)<$dbdat['com_created']){ $yd_comment['newcom'] = 1;
			}else{ $yd_comment['newcom'] = 0; }

			$_yd_com[$yd_comment['com_id']] = $yd_comment;
			$mytstamp[$yd_comment['com_id']] = intval($dbdat['com_created']);
		}
			$yd_com_key = "#comment";
    	}
    	//var_dump($_yd_com);
	if ($dosort===true && !empty($mytstamp) && !empty($_yd_com)) {
		array_multisort( $mytstamp, SORT_DESC, $_yd_com );
	}
    	return array($_yd_com,$yd_com_key);

}

function get_photolist( $req_uid, $uid, $max_entry, $offset, $params=array() ){

	$db = & $this->d3dConf->db;
	
	$on_uid = "ON ((d.uid=c.uid  OR c.uid='0') AND d.cid=c.cid) " ;

	$max_entry = !empty($max_entry) ? (int)$max_entry : 0 ;

	if($this->mPerm->isadmin){
		$whr_openarea = "";
	} else {
		// openarea permissions 
		$_params4op['use_gp'] = $this->gPerm->use_gp;
		$_params4op['use_pp'] = $this->gPerm->use_pp;
		$whr_openarea = " AND ".$this->mPerm->get_open_query( "b_photolist", $_params4op );
		//var_dump($whr_openarea);
	}

	if(intval($req_uid)>0){
		$whr_uids="d.uid='".intval($req_uid)."'";
	} else {
		$whr_uids=" 1 ";
	}
		$now = date("Y-m-d H:i:s");
		if ($this->mPerm->isadmin!=true and $this->mPerm->isauthor!=true) {
			$whr_nofuture = " AND d.create_time<'".$now."' ";
		} else {
			$whr_nofuture = "";
		}

	$whr_cat = "" ;
	$whr_tag = "" ;
	$table_tag = "" ;

	if (!empty($params)){
		$size = !empty($params['size']) ? (int)$params['size'] : 0 ;

		if(!empty($params['order'])){
			switch ($params['order']) {
			case 'random' :
				$odr = "rand()" ;
				break;
			case 'time' :
			default :
				$odr = "tstamp DESC" ;
			}
		}

		$ofst_key = !empty($params['ofst_key']) ? $params['ofst_key'] : "phofst";

		if(!empty($params['categories'])){
			$whr_cat = " AND (" ;
		      	foreach($params['categories'] as $cat) {
				$whr_cat .= "c.cname LIKE '".$cat."' OR ";
			}
            		$whr_cat = rtrim( $whr_cat, "OR " ). ")" ;
		}
		if(!empty($params['tags'])){
			$table_tag = "LEFT JOIN ".$db->prefix($this->mydirname.'_tag')." t ON d.bid=t.bid " ;
			$whr_tag = " AND (" ;
		      	foreach($params['tags'] as $tag) {
				$whr_tag .= "t.tag_name LIKE '".$tag."' OR ";
			}
            		$whr_tag = rtrim( $whr_tag, "OR " ). ")" ;
		}
	}

	$sql_base = "FROM ".$db->prefix($this->mydirname.'_photo')." p 
			INNER JOIN ".$db->prefix($this->mydirname.'_diary')." d USING(bid) 
			INNER JOIN ".$db->prefix('users')." u ON d.uid=u.uid 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." c ".$on_uid." 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON d.uid=cfg.uid 
			".$table_tag."
			WHERE ".$whr_uids.$whr_openarea.$whr_nofuture.$whr_cat.$whr_tag." 
			ORDER BY ".$odr ;

	// get total photos count
	$sql = "SELECT count(p.pid) as count ".$sql_base ;

	$result = $db->query($sql);
	list ($count) = $db->fetchRow($result);

	if($count>$max_entry){
            if( !empty($_SERVER['QUERY_STRING'])) {
                if( ereg("^".$ofst_key."=[0-9]+$", $_SERVER['QUERY_STRING']) ) {
                    $url = "";
                } else {
                    $url = preg_replace("/^(.*)\&".$ofst_key."=[0-9]+$/", "$1", $_SERVER['QUERY_STRING']);
                }
            } else {
                $url = "";
            }
	    include_once dirname( dirname(__FILE__) ).'/class/d3diaryPagenavi.class.php';
            $nav = new d3diaryPageNav($count, $max_entry, $offset, $ofst_key, $url);
            $photonavi = $nav->renderNav();
        } else {
            $photonavi = "";
        }

	$sql = "SELECT p.pid as pid, p.ptype as ptype, p.tstamp as tstamp, p.info as info, p.bid as bid, p.uid as uid, 
			title, uname, name "
			.$sql_base ;
        $result = $db->query($sql, $max_entry, $offset);
	$rtn_photos = array();
	while ( $dbdat = $db->fetchArray($result) ) {
		$photo['bid'] = $dbdat['bid'];
		$photo['pid'] = $dbdat['pid'];
		$photo['ptype']= $dbdat['ptype'];
		$photo['pname'] = $this->myts->makeTboxData4Show($photo['pid'].$photo['ptype']);
		$photo['thumbnail'] = "t_".$photo['pid'].$photo['ptype'];
		$photo['info'] = $this->stripPb_Tarea( $dbdat['info'] ) ;
		$photo['tstamp'] = $dbdat['tstamp'] ;
		$photo['title'] = $this->myts->makeTboxData4Show($dbdat['title']);
		$photo['uid'] = (int)$dbdat['uid'];
		$photo['uname'] = htmlSpecialChars( $dbdat['uname'], ENT_QUOTES );
		$photo['name'] = htmlSpecialChars( $dbdat['name'], ENT_QUOTES );
		
		$rtn_photos[] = $photo;
	}

  	return array( $rtn_photos, $photonavi);

}

// for index page , diarylist page and  b_diarylst block
// $myts, $d3dConf ,$f_strip_tag arguments are used from block only
function substrTarea( $tex, $html = 0, $max = 30, $f_strip_tag=false, $enc="" )
{
	$_enc = !empty($enc) ? $enc : _CHARSET ;
	
	$pbreak = $this->d3dConf->pbreak;
	$_pos = mb_strpos($tex, $pbreak, 0, $_enc);
	//$_pos = mb_strpos($tex, $pbreak, 0);

	//$pattern = array('/\[\[YT:([0-9a-z_-]+)\]\]/i','/\[\[ND:([\w\-]+)\]\]/i');
	$pattern = array('/\[\[YT:([0-9a-z_\-]+)\]\]/i','/\[\[ND:([0-9a-z_\-]+)\]\]/i');
 	$replacement = array('','');
 	$tex = preg_replace($pattern,$replacement,$tex);
	
    if ($max > 0) {
	if ($html == 1) {
		if( $_pos !== false ) {
			$_temptex = mb_substr($tex,0,$_pos,$_enc)."...";
			//$_temptex = mb_substr($tex,0,$_pos)."...";
			$t_conv = $this->myts->displayTarea($_temptex,1,1,0,0,0);
			if($f_strip_tag==true) {$t_conv = mb_substr(strip_tags($t_conv),0,$max,$_enc) ;}
			//if($f_strip_tag==true) {$t_conv = mb_substr(strip_tags($t_conv),0,$max) ;}
		} else {
			$t_conv = mb_substr(strip_tags($tex),0,$max,$_enc)."...";
			//$t_conv = mb_substr(strip_tags($tex),0,$max)."...";
		}
	} else {
		if( $_pos !== false ) {
			$_temptex = mb_substr($tex,0,$_pos,$_enc)."...";
			//$_temptex = mb_substr($tex,0,$_pos)."...";
			$t_conv = $this->myts->displayTarea($_temptex,0,1,1,1,1);
			if($f_strip_tag==true) {$t_conv = mb_substr(strip_tags($t_conv),0,$max,$_enc) ;}
			//if($f_strip_tag==true) {$t_conv = mb_substr(strip_tags($t_conv),0,$max) ;}
		} else {
			$t_conv = mb_substr( strip_tags($this->myts->displayTarea($tex,0,1,1,1,1)),0,$max,$_enc)."...";
			//$t_conv = mb_substr( strip_tags($this->myts->previewTarea($tex,0,1,1,1,1)),0,$max)."...";
		}
	}
    } else {
		$_temptex = str_replace($pbreak,"",$tex);
	if ($html == 1) {
		$t_conv = $this->myts->displayTarea($_temptex,1,1,0,0,0);
	} else {
		$t_conv = $this->myts->displayTarea($_temptex,0,1,1,1,1);
	}
    }
	return $t_conv;
}

// for main detail page
// $myts, $d3dConf arguments are used from block only
function stripPb_Tarea($tex, $html = 0)
{
	if ($html == 1) {
		$t_conv = $this->myts->displayTarea($tex,1,1,0,0,0);
	} else {
		$t_conv = $this->myts->displayTarea($tex,0,1,1,1,1);
	}

	//$pattern ='/\[\[YT:([\w\-]+)\]\]/i';
	$pattern = array('/\[\[YT:([0-9a-z_-]+)\]\]/i','/\[\[ND:([0-9a-z_-]+)\]\]/i');
	$replacement1 = '<br /><object width="425" height="344">'.
		'<param name="movie" value="http://www.youtube.com/v/$1&hl=ja&fs=1"></param>'.
		'<param name="allowFullScreen" value="true"></param>'.
		'<embed src="http://www.youtube.com/v/$1&hl=ja&fs=1"'.
		'type="application/x-shockwave-flash" allowfullscreen="true" width="425" height="344"></embed>'.
		'</object><br />';
	$replacement2 = '<br /><script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/$1?w=490&h=307"></script><noscript><a href="http://www.nicovideo.jp/watch/$1">Jump to Video</a></noscript><br />';
	$replacement = array( $replacement1, $replacement2 );
 	$t_conv = preg_replace($pattern,$replacement,$t_conv);
 	$_tex = str_replace($this->d3dConf->pbreak,"",$t_conv);

	return $_tex;
}

function get_breadcrumbs( $uid, $mode, $bc_para )
{
	$bc = array() ;
	$path = ( empty( $bc_para['path'] ) ) ? "index.php" : $bc_para['path'] ;
	$bc_para['uname'] = ($this->mod_config['use_name']==1) ? $bc_para['name'] : $bc_para['uname'];
	
	$i=0;
		$add_para[0]="";
		$tmp_url[0] = XOOPS_URL."/modules/".$this->mydirname."/".$bc_para['path'];
		$bc[$i] = array( 'name' => $bc_para['diary_title'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;

	if(!empty($bc_para['mode'])){
	    if(strcmp($bc_para['mode'], "comment")==0){
		$i++;
		$bc_para['mode'] = "";
		$tmp_url[$i]=$tmp_url[0].$add_para[$i-1];
		$bc[$i] = array( 'name' => $bc_para['bc_name'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ; }
	}
	if ($uid>0) {
		$i++;
		$add_para[$i]="?req_uid=".(int)$uid;
		$tmp_url[$i]=$tmp_url[$i-1].$add_para[$i];
		$bc[$i] = array( 'name' => $bc_para['uname'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ; }
	$_t_strpos = strpos($path,'?');
	$_capt = ($i==0 && empty($_t_strpos)) ? "?" : "&";
	if(!empty($bc_para['mode'])){
	    switch ($bc_para['mode']){
	    	case 'category' :
			$i++;
			$add_para[$i]=$_capt."mode=".$bc_para['mode']."&cid=".(int)$bc_para['cid'];
			$tmp_url[$i]=$tmp_url[0].$add_para[$i-1].$add_para[$i];
			$bc[$i] = array( 'name' => $bc_para['cname'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
	    		if(!empty($bc_para['bid'])) {
				$i++;
				$add_para[$i]=$_capt."bid=".(int)$bc_para['bid'];
				$tmp_url[$i]= XOOPS_URL."/modules/".$this->mydirname."/index.php?page=detail".$add_para[$i];
				$bc[$i] = array( 'name' => $bc_para['title'] ,
						'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ; }
			break;
	    	case 'month' :
			$i++;
			$add_para[$i]=$_capt."mode=".$bc_para['mode']."&year=".(int)$bc_para['year'].
					"&month=".(int)$bc_para['month'];
			$tmp_url[$i]=$tmp_url[0].$add_para[$i-1].$add_para[$i];
			$bc[$i] = array( 'name' => (int)$bc_para['year'].'-'.(int)$bc_para['month'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
			break;
	    	case 'date' :
			$i++;
			$add_para[$i]=$_capt."mode=".$bc_para['mode']."&year=".(int)$bc_para['year'].
					"&month=".(int)$bc_para['month']."&day=".(int)$bc_para['day'];
			$tmp_url[$i]=$tmp_url[0].$add_para[$i-1].$add_para[$i];
			$bc[$i] = array( 'name' => (int)$bc_para['year'].'-'.(int)$bc_para['month'].
					'-'.(int)$bc_para['day'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
			break;
	    	case 'usr_config' :
			$i++;
			$add_para[$i]="";
			$tmp_url[$i]=$tmp_url[0].$add_para[$i-1].$add_para[$i];
			$bc[$i] = array( 'name' => $bc_para['bc_name'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
			break;
	    	case 'editcat_config' :
			$i++;
			$add_para[$i]="";
			$tmp_url[$i]=XOOPS_URL."/modules/".$this->mydirname."/index.php?page=editcategory";
			$bc[$i] = array( 'name' => $bc_para['bc_name'] ,
					'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
			$i++;
			$add_para[$i]="";
			$tmp_url[$i]=XOOPS_URL."/modules/".$this->mydirname."/".$bc_para['path'];
			$bc[$i] = array( 'name' => $bc_para['bc_name2'] ,
					'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
			break;
	    	case 'edit' :
			$i++;
			$add_para[$i]="";
			$tmp_url[$i]=XOOPS_URL."/modules/".$this->mydirname."/index.php?page=edit";
			$bc[$i] = array( 'name' => $bc_para['bc_name'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
			break;
	    	default :
			$i++;
			$add_para[$i]="";
			$tmp_url[$i]=XOOPS_URL."/modules/".$this->mydirname."/".$bc_para['path'];
			$bc[$i] = array( 'name' => $bc_para['bc_name'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
		}
	} else {
	    if(!empty($bc_para['bid'])) {
		$i++;
		$add_para[$i]=$_capt."mode=category&cid=".(int)$bc_para['cid'];
		$tmp_url[$i]=$tmp_url[0].$add_para[$i-1].$add_para[$i];
		$bc[$i] = array( 'name' => $bc_para['cname'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ;
		$i++;
		$add_para[$i]=$_capt."bid=".(int)$bc_para['bid'];
		$tmp_url[$i]= XOOPS_URL."/modules/".$this->mydirname."/index.php?page=detail".$add_para[$i];
		$bc[$i] = array( 'name' => $bc_para['title'] ,
				'url' => htmlSpecialChars($tmp_url[$i], ENT_QUOTES) ) ; }
	}
	
	$_t_strpos = strpos($path,'?');
	$_capt = ($i==0 && empty($_t_strpos)) ? "?" : "&";
	if(!empty($bc_para['tag'])) {
		$i++;
		$enc_tag = rawurlencode($bc_para['tag']);
		$tmp_url[$i]=$tmp_url[$i-1].$_capt."tag_name=".$enc_tag;
		$bc[$i] = array( 'name' => $bc_para['tag'] ,
				'url' => htmlSpecialChars($tmp_url[$i]) ) ; }
	$tmp_url[0] = XOOPS_URL."/modules/".$this->mydirname."/index.php?page=diarylist";
	$bc[0]['url'] = htmlSpecialChars($tmp_url[0], ENT_QUOTES);
	$bc[$i]['url'] = "";	// remove final url
	return $bc;

}

function initBoxArr () {

	if ( $this->d3dConf->is_main==true ) {
		$arr_weeks = array( constant("_MD_W_SUN"), constant("_MD_W_MON"), constant("_MD_W_TUE"), 
			constant("_MD_W_WED"), constant("_MD_W_THR"), constant("_MD_W_FRY"), 
			constant("_MD_W_SAT") );

		$arr_monthes = array( constant("_MD_M_JAN"), constant("_MD_M_FEB"), constant("_MD_M_MAR"), 
			constant("_MD_M_APR"), constant("_MD_M_MAY"), constant("_MD_M_JUN"), 
			constant("_MD_M_JUL"), constant("_MD_M_AUG"), constant("_MD_M_SEP"),
			constant("_MD_M_OCT"), constant("_MD_M_NOV"), constant("_MD_M_DEC") );

	} else {
		$constpref = "_MB_" . strtoupper( $this->mydirname ) ;
		$arr_weeks = array( constant($constpref."_W_SUN"), constant($constpref."_W_MON"), constant($constpref."_W_TUE"), 
			constant($constpref."_W_WED"), constant($constpref."_W_THR"), constant($constpref."_W_FRY"), 
			constant($constpref."_W_SAT") );

		$arr_monthes = array( constant($constpref."_M_JAN"), constant($constpref."_M_FEB"), constant($constpref."_M_MAR"), 
			constant($constpref."_M_APR"), constant($constpref."_M_MAY"), constant($constpref."_M_JUN"), 
			constant($constpref."_M_JUL"), constant($constpref."_M_AUG"), constant($constpref."_M_SEP"),
			constant($constpref."_M_OCT"), constant($constpref."_M_NOV"), constant($constpref."_M_DEC") );
	}

	$arr_dclass = array( "day dSun", "day dMon", "day dTue", "day dWed", "day dThr", "day dFri", "day dSat" );
	$arr_wclass = array( "dweek wSun", "dweek wMon", "dweek wTue", "dweek wWed", "dweek wThr", "dweek wFri", "dweek wSat" );
	
	return ( array( $arr_weeks, $arr_monthes, $arr_dclass, $arr_wclass ));

}

function get_taglist($uid=0, $bid=0, &$pop_tags, &$person_tags, &$entry_tags) {

	$db = & $this->d3dConf->db;

	$sql = "SELECT *
			FROM ".$db->prefix($this->mydirname.'_tag')." 
			ORDER BY tag_name ASC";
		$result = $db->query($sql);

		$db_tags = array();
		while ( $dbdat = $db->fetchArray($result) ) {
			$db_tags[] = $this->myts->makeTboxData4Show($dbdat['tag_name']);
		}
		if(!empty($db_tags)) $pop_tags = array_unique($db_tags);

	$sql = "SELECT *
			FROM ".$db->prefix($this->mydirname.'_tag')."
			WHERE uid='".intval($uid)."' ORDER BY tag_name ASC";
		$result = $db->query($sql);

		$db_tags = array();
		while ( $dbdat = $db->fetchArray($result) ) {
			$db_tags[] = $this->myts->makeTboxData4Show($dbdat['tag_name']);
		}
		if(!empty($db_tags)) $person_tags = array_unique($db_tags);

	$sql = "SELECT *
			FROM ".$db->prefix($this->mydirname.'_tag')."
			WHERE bid='".intval($bid)."' GROUP BY tag_name ORDER BY tag_name ASC";
		$result = $db->query($sql);

		$db_tags = array();
		$i=0;
		while ( $dbdat = $db->fetchArray($result) ) {
			$db_tags[$i]['tag'] = $this->myts->makeTboxData4Show($dbdat['tag_name']);
			$db_tags[$i]['tag_urlenc'] = rawurlencode($dbdat['tag_name']);
			$i++;
		}
		if(!empty($db_tags)){
			$entry_tags = $db_tags;
		}
}

function getTagCloud ( $where = null, $min_size = 80, $max_size = 160, $max_entry = null, $offset = null, $params=array() )
{
	$wh = "";
	$ret = "";
	$tags = array();
	$max_qty = 0;
	$min_qty = 0;

	$db = & $this->d3dConf->db;

	$max_entry = !empty($max_entry) ? (int)$max_entry : 0 ;
	$offset = !empty($offset) ?(int)$offset : 0;
	//$odr = !empty($order) ? $order : "tag_name ASC";
	$odr = !empty($params['order']) ? $params['order'] : "tag_name ASC";
	$ofst_key = !empty($params['ofst_key']) ? $params['ofst_key'] : "tofst";

	if($where){
		$wh = " WHERE ". $where;
	}
	
	$sql = "SELECT tag_name AS tag, COUNT(tag_id) AS quantity
	  FROM ". $db->prefix($this->mydirname ."_tag") .$wh. "
	  GROUP BY tag_name
	  ORDER BY ".$odr;

	//$count = $db->getRowsNum( $db->query($sql) );
	$result = $db->query($sql);
	// here we loop through the results and put them into a simple array
	while ($row = $db->fetchRow($result)) {
	    $tags[$row['0']] = $row[1];
	}
	$count  = count($tags);

	if( $max_entry==0 ) {
		$tagnavi = "";
	} else {
		if( $count>$max_entry ){
	            if( !empty($_SERVER['QUERY_STRING'])) {
	                if( ereg("^".$ofst_key."=[0-9]+", $_SERVER['QUERY_STRING']) ) {
	                    $url = "";
	                } else {
	                    $url = preg_replace("/^(.*)\&".$ofst_key."=[0-9]+/", "$1", $_SERVER['QUERY_STRING']);
	                }
	            } else {
	                $url = "";
	            }
		    include_once dirname(__FILE__).'/d3diaryPagenavi.class.php';
	            $nav = new d3diaryPageNav($count, $max_entry, $offset, $ofst_key, $url);
	            $tagnavi = $nav->renderNav();
	        } else {
	            $tagnavi = "";
		}
	}

	// get the largest and smallest array values
	if($tags){
		$max_qty = max(array_values($tags));
		$min_qty = min(array_values($tags));
	}

	// find the range of values
	$spread = $max_qty - $min_qty;
	if (0 == $spread) { // we don't want to divide by zero
	    $spread = 1;
	}

	// determine the font-size increment
	$step = ($max_size - $min_size)/($spread);

	// loop through our tag array
	$arr_keys = array_keys($tags);
	$arr_values = array_values($tags);
	$last_idx = ($count < $max_entry) ? $count : $max_entry ;
	for ( $i=0; $i < $last_idx; $i++ ) {
		$idx = $i+$offset;
		$size = $min_size + (($arr_values[$idx] - $min_qty) * $step);
		$ret[$i]['tag'] = $this->myts->makeTboxData4Show($arr_keys[$idx]);
		$ret[$i]['tag_urlenc'] = rawurlencode($arr_keys[$idx]);
		$ret[$i]['size'] = $size;
	}

	return array( $ret, $tagnavi ) ;
}

// read other blogs
function update_other(){

	$db = & $this->d3dConf->db;

	require_once dirname( dirname(__FILE__) ).'/include/magpierss/rss_fetch.inc';

	// only other blogs
	$query = "SELECT u.uid, cfg.rss, cfg.blogtype, cfg.openarea 
			FROM ".$db->prefix('users')." u 
			LEFT JOIN ".$db->prefix($this->mydirname.'_config')." cfg ON u.uid=cfg.uid 
			WHERE cfg.blogtype>'0'";

	$result = $db->query($query);
	while ( $line = $db->fetchArray($result) ) {
		$uid    = intval($line['uid']);
		$cid    = 0;

		# �܂��폜
		$query = "DELETE FROM ".$db->prefix($this->mydirname.'_newentry')." WHERE uid='".$uid
			."' AND cid='".$cid."'";
		$result2 = $db->queryF($query);
		

		$rss_url=$line['rss'];
		$rss = d3d_mgp_fetch_rss($line['rss']);

		$yd_data="";
		if(empty($rss)){break;}
		foreach ($rss->items as $item) {
	    	$yd_data['title'] = $item['title'];
		if(mb_internal_encoding()!="UTF-8"){
			$yd_data['title']=mb_convert_encoding($yd_data['title'], mb_internal_encoding(), "UTF-8");
		}
	    	$yd_data['link'] = $item['link'];
	    	$yd_data['blogtype'] = $line['blogtype'];
		
			# ���ʂ�else���̕��������ł����͂��Ȃ񂾂��E�E�E
			if(!empty($item['dc']['date'])){
				$tstamp=strtotime($item['dc']['date']);
			}elseif(!empty($item['pubdate'])){
				$tstamp=strtotime($item['pubdate']);
			}elseif(!empty($item['published'])){
				$tstamp=strtotime($item['published']);
			}elseif(!empty($item['issued'])){
				$tstamp=strtotime($item['issued']);
			}elseif(!empty($item['modified'])){
				$tstamp=strtotime($item['modified']);
			}else{
				$tstamp=$item['date_timestamp'];
			}
			$yd_data['ctime'] = date("Y-m-d H:i:s", $tstamp);
	
			if(!empty($item['summary'])){
	    			$yd_data['diary'] = $item['summary'];
			}elseif(!empty($item['description'])){
				$yd_data['diary'] = $item['description'];
			}elseif(!empty($item['content'])){
				$yd_data['diary'] = $item['content'];
			}else{
				$yd_data['diary']="";
			}
			if(mb_internal_encoding()!="UTF-8"){
				$yd_data['diary']=mb_convert_encoding($yd_data['diary'], mb_internal_encoding(), "UTF-8");
			}
	        if (!get_magic_quotes_gpc()) {
				$yd_data['title']=addslashes($yd_data['title']);
				$yd_data['diary']=addslashes($yd_data['diary']);
			}
	
			# entry�ǉ�
			$query = "INSERT INTO ".$db->prefix($this->mydirname.'_newentry')." (uid, cid, title, url, create_time, blogtype, diary)
						VALUES (
						'".$line['uid']."',
						'".$cid."',
						'".$yd_data['title']."',
						'".$yd_data['link']."',
						'".$yd_data['ctime']."',
						'".$yd_data['blogtype']."',
						'".$yd_data['diary']."'
						)";
			$result2 = $db->queryF($query);
	
			# �ŏ��̃G���g�������ŏI���
			break;
		}
	}
	return true;
}

function update_other_cat($uid){

	$db = & $this->d3dConf->db;

	require_once dirname( dirname(__FILE__) ).'/include/magpierss/rss_fetch.inc';

// get categories of this user

	// only other blogs
	$query = "SELECT u.uid, cat.cid, cat.cname, cat.corder, cat.blogtype, cat.blogurl, cat.rss, cat.openarea 
			FROM ".$db->prefix('users')." u 
			LEFT JOIN ".$db->prefix($this->mydirname.'_category')." cat ON u.uid=cat.uid 
			WHERE u.uid='".$uid."' AND cat.blogtype>'0'";

	$result = $db->query($query);
	
	while ( $line = $db->fetchArray($result) ) {
		//$uid    = intval($line['uid']);
		$cid = intval($line['cid']);

		# �܂��폜
		$query = "DELETE FROM ".$db->prefix($this->mydirname.'_newentry')." WHERE uid='".$uid
			."' AND cid='".$cid."'";
		$result2 = $db->queryF($query);
		

		$rss_url=$line['rss'];
		$rss = d3d_mgp_fetch_rss($rss_url);
		//var_dump($rss);	// test
		$yd_data="";
		if(empty($rss)){break;}
		foreach ($rss->items as $item) {
	    		$yd_data['title'] = $item['title'];
		  	if(mb_internal_encoding()!="UTF-8"){
				$yd_data['title']=mb_convert_encoding($yd_data['title'], mb_internal_encoding(), "UTF-8");
			}
	    		$yd_data['link'] = $item['link'];
	    		$yd_data['blogtype'] = $line['blogtype'];
			//var_dump($cid); var_dump($yd_data['title'] ); echo"<br />";

			# ���ʂ�else���̕��������ł����͂��Ȃ񂾂��E�E�E
			if(!empty($item['dc']['date'])){
				$tstamp=strtotime($item['dc']['date']);
			}elseif(!empty($item['pubdate'])){
				$tstamp=strtotime($item['pubdate']);
			}elseif(!empty($item['published'])){
				$tstamp=strtotime($item['published']);
			}elseif(!empty($item['issued'])){
				$tstamp=strtotime($item['issued']);
			}elseif(!empty($item['modified'])){
				$tstamp=strtotime($item['modified']);
			}else{
				$tstamp=$item['date_timestamp'];
			}
			$yd_data['ctime'] = date("Y-m-d H:i:s", $tstamp);
	
			if(!empty($item['summary'])){
	    			$yd_data['diary'] = $item['summary'];
			}elseif(!empty($item['description'])){
				$yd_data['diary'] = $item['description'];
			}elseif(!empty($item['content'])){
				$yd_data['diary'] = $item['content'];
			}else{
				$yd_data['diary']="";
			}
			if(mb_internal_encoding()!="UTF-8"){
				$yd_data['diary']=mb_convert_encoding($yd_data['diary'], mb_internal_encoding(), "UTF-8");
			}
	        	if (!get_magic_quotes_gpc()) {
				$yd_data['title']=addslashes($yd_data['title']);
				$yd_data['diary']=addslashes($yd_data['diary']);
			}
	
			# entry�ǉ�
			$query = "INSERT INTO ".$db->prefix($this->mydirname.'_newentry')." (uid, cid, title, url, 
						create_time, blogtype, diary) 
						VALUES (
						'".$uid."',
						'".$cid."',
						'".$yd_data['title']."',
						'".$yd_data['link']."',
						'".$yd_data['ctime']."',
						'".$yd_data['blogtype']."',
						'".$yd_data['diary']."'
						)";
			$result2 = $db->queryF($query);
	
			# �ŏ��̃G���g�������ŏI���
			break;
		}
	}
	return true;
}

// using protector for php5, throughout for php4 or no-protector
function htmlPurifier( $text )
{
	global $xoopsUser;

	if( substr( PHP_VERSION , 0 , 1 ) != 4 && file_exists( XOOPS_TRUST_PATH.'/modules/protector/library/HTMLPurifier.auto.php' ) ) {
			require_once XOOPS_TRUST_PATH.'/modules/protector/library/HTMLPurifier.auto.php' ;
			$purifier_enable = sizeof( array_intersect( $xoopsUser->getGroups() ,
				 $this->mod_config['htmlpurify_except'] ) ) == 0 ;
		if( $purifier_enable ) {
			$config = HTMLPurifier_Config::createDefault() ;
			$config->set( 'Cache', 'SerializerPath', XOOPS_TRUST_PATH.'/modules/protector/configs' );
			$config->set( 'Core', 'Encoding', _CHARSET ) ;
			$config->set( 'Attr', 'AllowedFrameTargets', array( '_blank' , '_self' , '_top' ) ) ;
			$config->set( 'Attr', 'AllowedRel', array( 'lightbox[]' ) ) ;
			//$config->set( 'Filter', 'YouTube', true );
			//$config->set( 'HTML', 'Object', array( 'YouTube' ) );
			$purifier = new HTMLPurifier( $config ) ;
			return $purifier->purify( $text ) ;
		}
	}
	return $text ;
}

function get_d3comforums_can_read( $com_dirname, $uid=0 )
{
	global $xoopsUser ;

	$db = & $this->d3dConf->db;

	if( is_object( $xoopsUser ) ) {
		//$uid = intval( $xoopsUser->getVar('uid') ) ;
		$groups = $xoopsUser->getGroups() ;
		if( ! empty( $groups ) ) {
			$whr4forum = "fa.`uid`=$uid || fa.`groupid` IN (".implode(",",$groups).")" ;
			$whr4cat = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
		} else {
			$whr4forum = "fa.`uid`=$uid" ;
			$whr4cat = "`uid`=$uid" ;
		}
	} else {
		$whr4forum = "fa.`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
		$whr4cat = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
	}

	// get categories
	$sql = "SELECT distinct cat_id FROM ".$db->prefix($com_dirname."_category_access")." WHERE ($whr4cat)" ;
	$result = $db->query( $sql ) ;
	if( $result ) while( list( $cat_id ) = $db->fetchRow( $result ) ) {
		$cat_ids[] = intval( $cat_id ) ;
	}
	if( empty( $cat_ids ) ) return array(0) ;

	// get forums
	$sql = "SELECT distinct f.forum_id 
	FROM ".$db->prefix($com_dirname."_forums")." f 
	LEFT JOIN ".$db->prefix($com_dirname."_forum_access")." fa 
	ON fa.forum_id=f.forum_id 
	WHERE ($whr4forum) AND f.cat_id IN (".implode(',',$cat_ids).')' ;
	
	$result = $db->query( $sql ) ;
	if( $result ) while( list( $forum_id ) = $db->fetchRow( $result ) ) {
		$forums[] = intval( $forum_id ) ;
	}

	if( empty( $forums ) ) return array(0) ;
	else return $forums ;
}

// get object for comment integration
function &get_d3com_object( $forum_dirname, $external_link_format )
{
	$params['forum_dirname'] = $forum_dirname ;

	@list( $params['external_dirname'] , $params['classname'] , $params['external_trustdirname'] ) 
		= explode( '::' , $external_link_format ) ;

	$obj =& D3commentObj::getInstance ( $params ) ;
	
	return $obj->d3comObj ;
}

} //end class
}

 // a class for Attachfile plugin D3comment Authorization
if( ! class_exists( 'D3commentObj' ) ) {
class D3commentObj {

var $d3comObj = null ;

function D3commentObj($params )
//  $params['forum_dirname'] , $params['external_dirname'] , $params['classname'] , $params['external_trustdirname']
{
	//$this->mPlug = & $parentObj;
	$mytrustdirpath = !empty($params['external_trustdirname']) ? XOOPS_TRUST_PATH.'/modules/'.$params['external_trustdirname'] : XOOPS_TRUST_PATH.'/modules/d3forum' ;

	if( empty( $params['classname'] ) ) {
		include_once $mytrustdirpath.'/class/D3commentAbstract.class.php' ;
		$this->d3comObj = new D3commentAbstract( $forum_dirname , '' ) ;
	}

	// search the class file
	$class_bases = array(
		XOOPS_ROOT_PATH.'/modules/'.$params['external_dirname'].'/class' ,
		XOOPS_TRUST_PATH.'/modules/'.$params['external_trustdirname'].'/class' ,
		XOOPS_TRUST_PATH.'/modules/d3forum/class' ,
	) ;

	foreach( $class_bases as $class_base ) {
		if( file_exists( $class_base.'/'.$params['classname'].'.class.php' ) ) {
			require_once $class_base.'/'.$params['classname'].'.class.php' ;
			break ;
		}
	}

	// check the class
	if( ! $params['classname'] || ! class_exists( $params['classname'] ) ) {
		include_once $mytrustdirpath.'/class/D3commentAbstract.class.php' ;
		$this->d3comObj = new D3commentAbstract( $params['forum_dirname'] , $params['external_dirname'] ) ;
	}

	$this->d3comObj = new $params['classname']( $params['forum_dirname'] , 
			$params['external_dirname'] , $params['external_trustdirname'] ) ;
}

function & getInstance( $params )
{
	$external_dirname = $params['external_dirname'] ;

	static $instance ;
	if( ! isset( $instance[$external_dirname] ) ) {
		$instance[$external_dirname] = new D3commentObj( $params ) ;
	}
	return $instance[$external_dirname] ;
}
} // end class D3commentObj
}

?>