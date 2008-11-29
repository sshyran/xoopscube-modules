<?php

	if(! defined('XOOPS_ROOT_PATH')) exit();

	global $xoopsConfig , $xoopsDB , $xoopsUser ;

	// trust dirname
	$mytrustdirname = isset($mytrustdirname) ?  $mytrustdirname : basename( dirname( dirname( __FILE__ ) ) ) ;

	// module information
	$mod_url = XOOPS_URL . "/modules/$mydirname";
	$mod_path = XOOPS_ROOT_PATH . "/modules/$mydirname";
	$mod_trust_path = XOOPS_TRUST_PATH . "/modules/$mytrustdirname" ;
	$mod_copyright = "<b>IMGTag D3 v0.24 By <a href='http://xoops.oceanblue-site.com/'>OceanBlue</a></b>";

	// global langauge file
	$language = $xoopsConfig['language'] ;
	if (file_exists("$mod_trust_path/language/$language/d3imgtag_constants.php")) {
		include_once "$mod_trust_path/language/$language/d3imgtag_constants.php";
	} else {
		include_once "$mod_trust_path/language/english/d3imgtag_constants.php";
		$language = "english";
	}

	// read from xoops_config
	// get my mid
	$rs = $xoopsDB->query("SELECT `mid` FROM `".$xoopsDB->prefix('modules')."` WHERE `dirname` = '$mydirname'");
	list($d3imgtag_mid) = $xoopsDB->fetchRow($rs);

	// read configs from xoops_config directly
	$rs = $xoopsDB->query("SELECT `conf_name`, `conf_value` FROM `".$xoopsDB->prefix('config')."` WHERE `conf_modid` = '$d3imgtag_mid'");
	while(list($key, $val) = $xoopsDB->fetchRow($rs)) {
		$d3imgtag_configs[$key] = $val ;
	}

	foreach($d3imgtag_configs as $key => $val) {
		if( strncmp( $key , "d3imgtag_" , 9 ) == 0 ) $$key = $val ;
	}

	// User Informations
	if(empty($xoopsUser)) {
		$my_uid = 0 ;
		$isadmin = false ;
	} else {
		$my_uid = $xoopsUser->uid();
		$isadmin = $xoopsUser->isAdmin($d3imgtag_mid);
	}

	// Value Check
	$d3imgtag_addposts = intval($d3imgtag_addposts);
	if($d3imgtag_addposts < 0) $d3imgtag_addposts = 0 ;

	// Path to Main Photo & Thumbnail ;
	if(ord($d3imgtag_photospath) != 0x2f) $d3imgtag_photospath = "/$d3imgtag_photospath";
	if(ord($d3imgtag_thumbspath) != 0x2f) $d3imgtag_thumbspath = "/$d3imgtag_thumbspath";
	$photos_dir = XOOPS_ROOT_PATH . $d3imgtag_photospath;
	$photos_url = XOOPS_URL . $d3imgtag_photospath;
	if($d3imgtag_makethumb) {
		$thumbs_dir = XOOPS_ROOT_PATH . $d3imgtag_thumbspath ;
		$thumbs_url = XOOPS_URL . $d3imgtag_thumbspath ;
	} else {
		$thumbs_dir = $photos_dir ;
		$thumbs_url = $photos_url ;
	}
	
	if ($d3imgtag_makepreview) {
		$previews_dir = XOOPS_ROOT_PATH. $d3imgtag_previewspath;
		$previews_url = XOOPS_URL. $d3imgtag_previewspath;
	} else {
		$previews_dir = $photos_dir;
		$previews_url = $photos_url;
	}

	// DB table name
	$table_photos = $xoopsDB->prefix("{$mydirname}_photos");
	$table_cat = $xoopsDB->prefix("{$mydirname}_cat");
	$table_text = $xoopsDB->prefix("{$mydirname}_text");
	$table_votedata = $xoopsDB->prefix("{$mydirname}_votedata");
	$table_comments = $xoopsDB->prefix("xoopscomments");

	// Pipe environment check
	if($d3imgtag_imagingpipe || function_exists('imagerotate')) $d3imgtag_canrotate = true ;
	else $d3imgtag_canrotate = false ;
	if($d3imgtag_imagingpipe || $d3imgtag_forcegd2) $d3imgtag_canresize = true ;
	else $d3imgtag_canresize = false ;

	// Normal Extensions of Image
	$d3imgtag_normal_exts = array('jpg' , 'jpeg' , 'gif' , 'png');

	// Allowed extensions & MIME types
	if(empty($d3imgtag_allowedexts)) {
		$array_allowed_exts = $d3imgtag_normal_exts ;
	} else {
		$array_allowed_exts = explode('|' , $d3imgtag_allowedexts);
	}
	if(empty($d3imgtag_allowedmime)) {
		$array_allowed_mimetypes = array();
	} else {
		$array_allowed_mimetypes = explode('|' , $d3imgtag_allowedmime);
	}
?>