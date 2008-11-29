<?php
// ------------------------------------------------------------------------- //
//                      IMGTag - XOOPS photo album                           //
//                        <http://www.kickassamd.com/>                       //
// ------------------------------------------------------------------------- //
//                      IMGTag D3                                            //
//                        <http://xoops.oceanblue-site.com/>                 //
// ------------------------------------------------------------------------- //

include("admin_header.php");
include_once("../../../class/xoopsformloader.php");

// get and check $_POST['size']
$start = isset($_POST['start']) ? intval($_POST['start']) : 0 ;
$size = isset($_POST['size']) ? intval($_POST['size']) : 10 ;
if($size <= 0 || $size > 10000) $size = 10 ;

$forceredo = isset($_POST['forceredo']) ? intval($_POST['forceredo']) : false ;
$removerec = isset($_POST['removerec']) ? intval($_POST['removerec']) : false ;
$resize = isset($_POST['resize']) ? intval($_POST['resize']) : false ;

// get flag of safe_mode
$safe_mode_flag = ini_get("safe_mode");

// even if makethumb is off, it is treated as makethumb on
if(! $d3imgtag_makethumb) {
	$d3imgtag_makethumb = 1 ;
	$thumbs_dir = XOOPS_ROOT_PATH . $d3imgtag_thumbspath ;
	$thumbs_url = XOOPS_URL . $d3imgtag_thumbspath ;
}

// check if the directories of thumbs and photos are same.
if($thumbs_dir == $photos_dir) die("The directory for thumbnails is same as for photos.");

// check or make thumbs_dir
if($d3imgtag_makethumb && ! is_dir($thumbs_dir)) {
	if($safe_mode_flag) {
		redirect_header(XOOPS_URL."/modules/$mydirname/admin/",10,"At first create & chmod 777 '$thumbs_dir' by ftp or shell.");
		exit;
	}

	$rs = mkdir($thumbs_dir , 0777);
	if(! $rs) {
		redirect_header(XOOPS_URL."/modules/$mydirname/",10,"$thumbs_dir is not a directory");
		exit;
	} else @chmod($thumbs_dir , 0777);
}

// check or make preview_dir
if($d3imgtag_makepreview && ! is_dir($previews_dir)) {
	if($safe_mode_flag) {
		redirect_header(XOOPS_URL."/modules/$mydirname/admin/",10,"At first create & chmod 777 '$previews_dir' by ftp or shell.");
		exit;
	}

	$rs = mkdir($previews_dir , 0777);
	if(! $rs) {
		redirect_header(XOOPS_URL."/modules/$mydirname/",10,"$previews_dir is not a directory");
		exit;
	} else @chmod($previews_dirr , 0777);
}

if(! empty($_POST['submit'])) {
	ob_start();

	$result = $xoopsDB->query("SELECT lid, img, ext , res_x , res_y FROM $table_photos ORDER BY lid LIMIT $start , $size") or die("DB Error");
	$record_counter = 0 ;
	while(list($lid, $img, $ext , $w , $h) = $xoopsDB->fetchRow($result)) {
		$record_counter ++ ;
		echo ($record_counter + $start - 1) . ") ";
		printf(_AM_D3IMGTAG_FMT_CHECKING , "$img.$ext");

		// Check if the main image exists
		if(! is_readable("$photos_dir/$img.$ext")) {
			echo _AM_D3IMGTAG_MB_PHOTONOTEXISTS." &nbsp; ";
			if($removerec) {
				d3imgtag_delete_photos("lid='$lid'");
				echo _AM_D3IMGTAG_MB_RECREMOVED."<br />\n";
			} else {
				echo _AM_D3IMGTAG_MB_SKIPPED."<br />\n";
			}
			continue ;
		}

		// Check if the file is normal image
		if(! in_array(strtolower($ext) , $d3imgtag_normal_exts)) {
			if($forceredo || ! is_readable("$thumbs_dir/$img.gif")) {
				d3imgtag_create_thumb("$photos_dir/$img.$ext" , $img , $ext);
				d3imgtag_create_preview("$photos_dir/$img.$ext" , $img , $ext);
				echo _AM_D3IMGTAG_MB_CREATEDTHUMBS."<br />\n";
			} else {
				echo _AM_D3IMGTAG_MB_SKIPPED."<br />\n";
			}
			continue ;
		}

		// Size of main photo
		list($true_w , $true_h) = getimagesize("$photos_dir/$img.$ext");
		echo "{$true_w}x{$true_h} .. ";

		// Check and resize the main photo if necessary
		if($resize && ($true_w > $d3imgtag_width || $true_h > $d3imgtag_height)) {
			$tmp_path = "$photos_dir/d3imgtag_tmp_photo";
			@unlink($tmp_path);
			rename("$photos_dir/$img.$ext" , $tmp_path);
			d3imgtag_modify_photo($tmp_path , "$photos_dir/$img.$ext");
			@unlink($tmp_path);
			echo _AM_D3IMGTAG_MB_PHOTORESIZED." &nbsp; ";
			list($true_w , $true_h) = getimagesize("$photos_dir/$img.$ext");
		}

		// Check and repair record of the photo if necessary
		if($true_w != $w || $true_h != $h) {
			$xoopsDB->query("UPDATE $table_photos SET res_x=$true_w, res_y=$true_h WHERE lid=$lid") or die("DB error: UPDATE photo table.");
			echo _AM_D3IMGTAG_MB_SIZEREPAIRED." &nbsp; ";
		}

		// Create Thumbs
		if(is_readable("$thumbs_dir/$img.$ext")) {
			list($thumb_w , $thumb_h) = getimagesize("$thumbs_dir/$img.$ext");
			echo "{$thumb_w}x{$thumb_h} ... ";
			if($forceredo) {
				$retcode = d3imgtag_create_thumb("$photos_dir/$img.$ext" , $img , $ext);
			} else {
				$retcode = 3 ;
			}
		} else {
			if($d3imgtag_makethumb) {
				$retcode = d3imgtag_create_thumb("$photos_dir/$img.$ext" , $img , $ext);
			} else {
				$retcode = 3 ;
			}
		}
		
		// Create Previews
		if(is_readable("$previews_dir/$img.$ext")) {
			list($thumb_w , $thumb_h) = getimagesize("$previews_dir/$img.$ext");
			echo "{$thumb_w}x{$thumb_h} ... ";
			if($forceredo) {
				$retcode = d3imgtag_create_preview("$photos_dir/$img.$ext" , $img , $ext);
			} else {
				$retcode = 3 ;
			}
		} else {
			if($d3imgtag_makethumb) {
				$retcode = d3imgtag_create_preview("$photos_dir/$img.$ext" , $img , $ext);
			} else {
				$retcode = 3 ;
			}
		}

		switch($retcode) {
			case 0 : 
				echo _AM_D3IMGTAG_MB_FAILEDREADING."<br />\n";
				break ;
			case 1 : 
				echo _AM_D3IMGTAG_MB_CREATEDTHUMBS."<br />\n";
				break ;
			case 2 : 
				echo _AM_D3IMGTAG_MB_BIGTHUMBS."<br />\n";
				break ;
			case 3 : 
				echo _AM_D3IMGTAG_MB_SKIPPED."<br />\n";
				break ;
		}
	}
	$result_str = ob_get_contents();
	ob_end_clean();

	$start += $size ;
}

// Make form objects
$form = new XoopsThemeForm(_AM_D3IMGTAG_FORM_RECORDMAINTENANCE , "batchupload" , "index.php?page=redothumbs");
$form->setExtra("enctype='multipart/form-data'");

$start_text = new XoopsFormText(_AM_D3IMGTAG_TEXT_RECORDFORSTARTING , "start" , 20 , 20 , $start);
$size_text = new XoopsFormText(_AM_D3IMGTAG_TEXT_NUMBERATATIME."<br /><br /><span style='font-weight:normal'>"._AM_D3IMGTAG_LABEL_DESCNUMBERATATIME."</span>", "size" , 20 , 20 , $size);
$forceredo_radio = new XoopsFormRadioYN(_AM_D3IMGTAG_RADIO_FORCEREDO , 'forceredo' , $forceredo);
$removerec_radio = new XoopsFormRadioYN(_AM_D3IMGTAG_RADIO_REMOVEREC , 'removerec' , $removerec);
$resize_radio = new XoopsFormRadioYN(_AM_D3IMGTAG_RADIO_RESIZE." ({$d3imgtag_width}x{$d3imgtag_height})" , 'resize' , $resize);

if(isset($record_counter) && $record_counter < $size) {
	$submit_button = new XoopsFormLabel("" , _AM_D3IMGTAG_MB_FINISHED." &nbsp; <a href='index.php?page=redothumbs'>"._AM_D3IMGTAG_LINK_RESTART."</a>");
} else {
	$submit_button = new XoopsFormButton("" , "submit" , _AM_D3IMGTAG_SUBMIT_NEXT , "submit");
}


// Render forms
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';

// check $xoopsModule
if(! is_object($xoopsModule)) redirect_header("$mod_url/" , 1 , _NOPERM);
echo "<h3 style='text-align:left;'>".sprintf(_AM_D3IMGTAG_H3_FMT_RECORDMAINTENANCE,$xoopsModule->name())."</h3>\n";

d3imgtag_opentable();
$form->addElement($start_text);
$form->addElement($size_text);
$form->addElement($forceredo_radio);
$form->addElement($removerec_radio);
$form->addElement($resize_radio);
$form->addElement($submit_button);
$form->display();
d3imgtag_closetable();

if(isset($result_str)) {
	echo "<br />\n";
	echo $result_str ;
}

xoops_cp_footer();

?>