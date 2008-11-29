<?php

// for older files
function d3imgtag_header()
{
	global $mod_url , $mydirname ;

	$logo_url = $mod_url."/images/logo".rand(1, 4).".png";
	
	$tpl = new XoopsTpl();
	$tpl->assign(array('mod_url' => $mod_url, 'logo_url' => $logo_url));
	$tpl->display("db:{$mydirname}_header.html");
}


// for older files
function d3imgtag_footer()
{
	global $mod_copyright , $mydirname ;

	$tpl = new XoopsTpl();
	$tpl->assign(array('mod_copyright' => $mod_copyright));
	$tpl->display("db:{$mydirname}_footer.html");
}


// returns appropriate name from uid
function d3imgtag_get_name_from_uid($uid)
{
	global $d3imgtag_nameoruname ;

	if($uid > 0) {
		$member_handler =& xoops_gethandler('member');
		$poster =& $member_handler->getUser($uid);

		if(is_object($poster)) {
			if($d3imgtag_nameoruname == 'uname' || trim( $poster->name() ) == '' ) {
				$name = htmlspecialchars( $poster->uname() , ENT_QUOTES ) ;
			} else {
				$name = htmlspecialchars( $poster->name() , ENT_QUOTES ) ;
			}
		} else {
			$name = _MD_D3IMGTAG_CAPTION_GUESTNAME ;
		}

	} else {
		$name = _MD_D3IMGTAG_CAPTION_GUESTNAME ;
	}

	return $name ;
}


// Get photo's array to assign into template (heavy version)
function d3imgtag_get_array_for_photo_assign($fetched_result_array , $summary = false)
{
	global $my_uid , $isadmin , $global_perms ;
	global $photos_url , $thumbs_url , $thumbs_dir , $mod_url , $mod_path ;
	global $d3imgtag_makethumb , $d3imgtag_thumbsize , $d3imgtag_popular , $d3imgtag_newdays , $d3imgtag_normal_exts, $d3imgtag_imagedateformat ;

	include_once(dirname(dirname(__FILE__)).'/class/d3imgtag.textsanitizer.php');

	$myts =& d3imgtagTextSanitizer::getInstance();

	extract($fetched_result_array);

	if(in_array(strtolower($ext) , $d3imgtag_normal_exts)) {
		$imgsrc_thumb = "$thumbs_url/$lid.$ext";
		$imgsrc_photo = "$photos_url/$lid.$ext";
		$ahref_photo = "$photos_url/$lid.$ext";
		$is_normal_image = true ;

		// Width of thumb
		$width_spec = "width='$d3imgtag_thumbsize'";
		if($d3imgtag_makethumb) {
			list($width , $height , $type) = getimagesize("$thumbs_dir/$img.$ext");
			// if thumb images was made, 'width' and 'height' will not set.
			if($width <= $d3imgtag_thumbsize) $width_spec = '' ;
		}
	} else {
		$imgsrc_thumb = "$thumbs_url/$lid.gif";
		$imgsrc_photo = "$thumbs_url/$lid.gif";
		$ahref_photo = "$photos_url/$lid.$ext";
		$is_normal_image = false ;
		$width_spec = '' ;
	}

	// Voting stats
	if($rating > 0) {
		if($votes == 1) {
			$votestring = _MD_D3IMGTAG_ONEVOTE ;
		} else {
			$votestring = sprintf(_MD_D3IMGTAG_NUMVOTES , $votes);
		}
		$info_votes = number_format($rating , 2)." ($votestring)";
	} else {
		$info_votes = '0.00 ('.sprintf(_MD_D3IMGTAG_NUMVOTES , 0) . ')' ;
	}

	// Submitter's name
	$submitter_name = d3imgtag_get_name_from_uid($submitter);

	// Category's title
	$cat_title = empty($cat_title) ? '' : $cat_title ;

	// Summarize description
	if($summary) $description = $myts->extractSummary($description);
	
	return array(
		'lid' => $lid ,
		'img' => $img,
		'cid' => $cid ,
		'ext' => $ext ,
		'size' => convert_from_bytes($size),
		'res_x' => $res_x ,
		'res_y' => $res_y ,
		'share' => $share,
		'window_x' => $res_x + 16 ,
		'window_y' => $res_y + 16 ,
		'title' => $myts->makeTboxData4Show($title) ,
		'datetime' => date($d3imgtag_imagedateformat, $date),
		'description' => $myts->displayTarea($description , 0 , 1 , 1 , 1 , 1 , 1) ,
		'imgsrc_thumb' => $imgsrc_thumb ,
		'imgsrc_photo' => $imgsrc_photo ,
		'ahref_photo' => $ahref_photo ,
		'width_spec' => $width_spec ,
		'can_edit' => (($global_perms & D3IMGTAG_GPERM_EDITABLE) && ($my_uid == $submitter || $isadmin)) ,
		'submitter' => $submitter ,
		'submitter_name' => $submitter_name ,
		'hits' => $hits ,
		'rating' => $rating ,
		'rank' => floor($rating - 0.001) ,
		'votes' => $votes ,
		'info_votes' => $info_votes ,
		'comments' => $comments ,
		'is_normal_image' => $is_normal_image ,
		'is_newphoto' => ($date > time() - 86400 * $d3imgtag_newdays && $status == 1) , 
		'is_updatedphoto' => ($date > time() - 86400 * $d3imgtag_newdays && $status == 2) , 
		'is_popularphoto' => ($hits >= $d3imgtag_popular) ,
		'info_morephotos' => sprintf(_MD_D3IMGTAG_MOREPHOTOS , $submitter_name) ,
		'cat_title' => $myts->makeTboxData4Show($cat_title)
	);
}


// Get photo's array to assign into template (light version)
function d3imgtag_get_array_for_photo_assign_light($fetched_result_array , $summary = false)
{
	global $my_uid , $isadmin , $global_perms ;
	global $photos_url , $thumbs_url , $thumbs_dir ;
	global $d3imgtag_makethumb , $d3imgtag_thumbsize , $d3imgtag_normal_exts ;

	$myts =& MyTextSanitizer::getInstance();

	extract($fetched_result_array);

	if(in_array(strtolower($ext) , $d3imgtag_normal_exts)) {
		$imgsrc_thumb = "$thumbs_url/$lid.$ext";
		$imgsrc_photo = "$photos_url/$lid.$ext";
		$is_normal_image = true ;
		// Width of thumb
		$width_spec = "width='$d3imgtag_thumbsize'";
		if($d3imgtag_makethumb && $ext != 'gif') {
			// if thumb images was made, 'width' and 'height' will not set.
			$width_spec = '' ;
		}
	} else {
		$imgsrc_thumb = "$thumbs_url/$lid.gif";
		$imgsrc_photo = "$thumbs_url/$lid.gif";
		$is_normal_image = false ;
		$width_spec = "";
	}

	return array(
		'lid' => $lid ,
		'img' => $img,
		'cid' => $cid ,
		'ext' => $ext ,
		'res_x' => $res_x ,
		'res_y' => $res_y ,
		'window_x' => $res_x + 16 ,
		'window_y' => $res_y + 16 ,
		'title' => $myts->makeTboxData4Show($title) ,
		'imgsrc_thumb' => $imgsrc_thumb ,
		'imgsrc_photo' => $imgsrc_photo ,
		'width_spec' => $width_spec ,
		'can_edit' => (($global_perms & D3IMGTAG_GPERM_EDITABLE) && ($my_uid == $submitter || $isadmin)) ,
		'hits' => $hits ,
		'rating' => $rating ,
		'rank' => floor($rating - 0.001) ,
		'votes' => $votes ,
		'comments' => $comments ,
		'is_normal_image' => $is_normal_image
	);
}


// get list of sub categories in header space
function d3imgtag_get_sub_categories($parent_id , $cattree)
{
	global $xoopsDB , $table_cat ;

	$myts =& MyTextSanitizer::getInstance();

	$ret = array();

	$crs = $xoopsDB->query("SELECT cid, title, imgurl FROM $table_cat WHERE pid=$parent_id ORDER BY title") or die("Error: Get Category.");

	while(list($cid , $title , $imgurl) = $xoopsDB->fetchRow($crs)) {

		// Show first child of this category
		$subcat = array();
		$arr = $cattree->getFirstChild($cid , "title");
		foreach($arr as $child) {
			$subcat[] = array(
				'cid' => $child['cid'] ,
				'title' => $myts->makeTboxData4Show($child['title']) ,
				'photo_small_sum' => d3imgtag_get_photo_small_sum_from_cat($child['cid'] , "status>0") ,
				'number_of_subcat' => sizeof($cattree->getFirstChildId($child['cid']))
			);
		}

		// Category's banner default
		if($imgurl == "http://") $imgurl = '' ;

		// Total sum of photos
		$cids = $cattree->getAllChildId($cid);
		array_push($cids , $cid);
		$photo_total_sum = d3imgtag_get_photo_total_sum_from_cats($cids , "status>0");

		$ret[] = array(
			'cid' => $cid ,
			'imgurl' => $myts->makeTboxData4Edit($imgurl) ,
			'photo_small_sum' => d3imgtag_get_photo_small_sum_from_cat($cid , "status>0") ,
			'photo_total_sum' => $photo_total_sum ,
			'title' => $myts->makeTboxData4Show($title) ,
			'subcategories' => $subcat
		);
	}

	return $ret ;
}


// get attributes of <img> for preview image
function d3imgtag_get_img_attribs_for_preview($preview_name)
{
	global $photos_url , $mod_url , $mod_path , $d3imgtag_normal_exts , $d3imgtag_thumbsize ;

	$ext = substr(strrchr($preview_name , '.') , 1);

	if(in_array(strtolower($ext) , $d3imgtag_normal_exts)) {
		return array("$photos_url/$preview_name" , "width='$d3imgtag_thumbsize'" , "$photos_url/$preview_name");

	} else {
		if(file_exists("$mod_path/icons/$ext.gif")) {
			return array("$mod_url/icons/mp3.gif" , '' , "$photos_url/$preview_name");
		} else {
			return array("$mod_url/icons/default.gif" , '' , "$photos_url/$preview_name");
		}
	}
}

?>