<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

function dbkmarken_search($keyword, $andor, $limit, $offset, $userid)
{
	global $xoopsDB;
	$ret = array();

	// get this module's config
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname('dbkmarken');
	$config_handler =& xoops_gethandler('config');
	$configs = $config_handler->getConfigList( $module->mid() ) ;

	/*---------------------------------------------------------------
	 Bookmark
	 --------------------------------------------------------------*/
	// where by uid
	if( ! empty( $uid ) ) {
		if( empty( $configs['search_by_uid'] ) ) {
			return array() ;
		}
		$whr_uid = 'uid='.intval($uid) ;
	} else {
		$whr_uid = '1' ;
	}

	$sqlB = "SELECT bm_id, bm_title, uid, memo, reg_unixtime FROM ".$xoopsDB->prefix("dbkmarken_bm")." WHERE ". ($whr_uid);

	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	$count = count($keyword);
	if ( $count > 0 && is_array($keyword) ) {
		$sqlB .= " AND ((bm_title LIKE '%$keyword[0]%' OR memo LIKE '%$keyword[0]%')";
		for ( $i = 1; $i < $count; $i++ ) {
			$sqlB .= " $andor ";
			$sqlB .= "(bm_title LIKE '%$keyword[$i]%' OR memo LIKE '%$keyword[$i]%')";
		}
		$sqlB .= ") ";
	}
	$sqlB .= " ORDER BY bm_id DESC";
	$resultB = $xoopsDB->query($sqlB,$limit,$offset);

	/*---------------------------------------------------------------
	 Tag
	 --------------------------------------------------------------*/
	$sqlT = "SELECT bm_id, tag_name, uid, reg_unixtime FROM ".$xoopsDB->prefix("dbkmarken_tag")." WHERE ". ($whr_uid);
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	$count = count($keyword);
	if ( $count > 0 && is_array($keyword) ) {
		$sqlT .= " AND ((tag_name LIKE '%$keyword[0]%')";
		for ( $j = 1; $j < $count; $j++ ) {
			$sqlT .= " $andor ";
			$sqlT .= "(tag_name LIKE '%$keyword[$j]%')";
		}
		$sqlT .= ") ";
	}
	$sqlT .= " ORDER BY bm_id DESC";
	$resultT = $xoopsDB->query($sqlT,$limit,$offset);


	$i = 0;
 	while ( $myrowB = $xoopsDB->fetchArray($resultB) ) {
		$ret[$i]['image'] = "images/icon_s.gif";
		$ret[$i]['link'] = "index.php?action=BmView&bm_id=".$myrowB['bm_id'];
		$ret[$i]['title'] = $myrowB['bm_title'];
		$ret[$i]['time'] = $myrowB['reg_unixtime'];
		if($myrowB['uid']){
			$ret[$i]['uid'] = $myrowB['uid'];
		}
		$i++;
	}
 	while ( $myrowT = $xoopsDB->fetchArray($resultT) ) {
		$ret[$i]['image'] = "images/icon_s.gif";
		$ret[$i]['link'] = "index.php?action=BmView&bm_id=".$myrowT['bm_id'];
		$ret[$i]['title'] = $myrowT['tag_name'];
		$ret[$i]['time'] = $myrowT['reg_unixtime'];
		if($myrowT['uid']){
			$ret[$i]['uid'] = $myrowT['uid'];
		}
		$i++;
	}
	return $ret;
}
?>
