<?php
// ------------------------------------------------------------------------- //
//                      IMGTag - XOOPS photo album                           //
//                        <http://www.kickassamd.com/>                       //
// ------------------------------------------------------------------------- //
//                      IMGTag D3                                            //
//                        <http://xoops.oceanblue-site.com/>                 //
// ------------------------------------------------------------------------- //

include("admin_header.php");

include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
include_once(XOOPS_ROOT_PATH."/class/xoopscomments.php");
include_once(XOOPS_ROOT_PATH."/class/xoopslists.php");

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';

// check $xoopsModule
if(! is_object($xoopsModule)) redirect_header("$mod_url/" , 1 , _NOPERM);
echo "<h3 style='text-align:left;'>".sprintf(_AM_D3IMGTAG_H3_FMT_MODULECHECKER,$xoopsModule->name())."</h3>\n";

d3imgtag_opentable();

// Initialize
$netpbm_pipes = array("jpegtopnm" , "giftopnm" , "pngtopnm" , 
	 "pnmtojpeg" , "pnmtopng" , "ppmquant" , "ppmtogif" ,
	 "pnmscale" , "pnmflip");

// PATH_SEPARATOR
if(! defined('PATH_SEPARATOR')) {
	if(DIRECTORY_SEPARATOR == '/') define('PATH_SEPARATOR' , ':');
	else define('PATH_SEPARATOR' , ';');
}

// Check the path to binaries of imaging packages
if( trim( $d3imgtag_imagickpath ) != '' && substr( $d3imgtag_imagickpath , -1 ) != DIRECTORY_SEPARATOR ) {
	$d3imgtag_imagickpath .= DIRECTORY_SEPARATOR ;
}
if( trim( $d3imgtag_netpbmpath ) != '' && substr( $d3imgtag_netpbmpath , -1 ) != DIRECTORY_SEPARATOR ) {
	$d3imgtag_netpbmpath .= DIRECTORY_SEPARATOR ;
}



//
// ENVIRONTMENT CHECK
//
echo "<h4>"._AM_D3IMGTAG_H4_ENVIRONMENT."</h4>\n";

echo _AM_D3IMGTAG_MB_PHPDIRECTIVE." 'safe_mode' ("._AM_D3IMGTAG_MB_BOTHOK."): &nbsp; ";
$safe_mode_flag = ini_get("safe_mode");
if(! $safe_mode_flag) echo "<font color='#00FF00'><b>off</b></font><br />\n";
else echo "<font color='#00FF00'><b>on</b></font><br />\n";

echo _AM_D3IMGTAG_MB_PHPDIRECTIVE." 'file_uploads' ("._AM_D3IMGTAG_MB_NEEDON."): &nbsp; ";
$rs = ini_get("file_uploads");
if(! $rs) echo "<font color='#FF0000'><b>off</b></font><br />\n";
else echo "<font color='#00FF00'><b>on</b></font><br />\n";

echo _AM_D3IMGTAG_MB_PHPDIRECTIVE." 'register_globals' ("._AM_D3IMGTAG_MB_BOTHOK."): &nbsp; ";
$rs = ini_get("register_globals");
if(! $rs) echo "<font color='#00FF00'><b>off</b></font><br />\n";
else echo "<font color='#00FF00'><b>on</b></font><br />\n";

echo _AM_D3IMGTAG_MB_PHPDIRECTIVE." 'upload_max_filesize': &nbsp; ";
$rs = ini_get("upload_max_filesize");
echo "<font color='#00FF00'><b>$rs byte</b></font><br />\n";

echo _AM_D3IMGTAG_MB_PHPDIRECTIVE." 'post_max_size': &nbsp; ";
$rs = ini_get("post_max_size");
echo "<font color='#00FF00'><b>$rs byte</b></font><br />\n";

echo _AM_D3IMGTAG_MB_PHPDIRECTIVE." 'open_basedir': &nbsp; ";
$rs = ini_get("open_basedir");
if(! $rs) echo "<font color='#00FF00'><b>nothing</b></font><br />\n";
else echo "<font color='#00FF00'><b>$rs</b></font><br />\n";

echo _AM_D3IMGTAG_MB_PHPDIRECTIVE." 'upload_tmp_dir': &nbsp; ";
$tmp_dirs = explode(PATH_SEPARATOR , ini_get("upload_tmp_dir"));
foreach($tmp_dirs as $dir) {
	if($dir != "" && (! is_writable($dir) || ! is_readable($dir))) {
		echo "<font color='#FF0000'><b>Error: upload_tmp_dir ($dir) is not writable nor readable .</b></font><br />\n";
		$error_upload_tmp_dir = true ;
	}
}
if(empty($error_upload_tmp_dir)) echo "<font color='#00FF00'><b>ok ".ini_get("upload_tmp_dir")."</b></font><br />\n";


//
// TABLE CHECK
//
echo "<h4>"._AM_D3IMGTAG_H4_TABLE."</h4>\n";

echo _AM_D3IMGTAG_MB_PHOTOSTABLE.": $table_photos &nbsp; ";
$rs = $xoopsDB->query("SELECT COUNT(lid) FROM $table_photos");
if(! $rs) echo "<font color='#FF0000'><b>Error</b></font><br />\n";
else echo "<font color='#00FF00'><b>ok</b></font><br />\n";
list($num_photo) = $xoopsDB->fetchRow($rs);
echo _AM_D3IMGTAG_MB_NUMBEROFPHOTOS.": $num_photo<br /><br />\n";

echo _AM_D3IMGTAG_MB_DESCRIPTIONTABLE.": $table_text &nbsp; ";
$rs = $xoopsDB->query("SELECT COUNT(lid) FROM $table_text");
if(! $rs) echo "<font color='#FF0000'><b>Error</b></font><br />\n";
else echo "<font color='#00FF00'><b>ok</b></font><br />\n";
list($num_text) = $xoopsDB->fetchRow($rs);
echo _AM_D3IMGTAG_MB_NUMBEROFDESCRIPTIONS.": $num_text<br /><br />\n";

echo _AM_D3IMGTAG_MB_CATEGORIESTABLE.": $table_cat &nbsp; ";
$rs = $xoopsDB->query("SELECT COUNT(cid) FROM $table_cat");
if(! $rs) echo "<font color='#FF0000'><b>Error</b></font><br />\n";
else echo "<font color='#00FF00'><b>ok</b></font><br />\n";
list($num_cat) = $xoopsDB->fetchRow($rs);
echo _AM_D3IMGTAG_MB_NUMBEROFCATEGORIES.": $num_cat<br /><br />\n";

echo _AM_D3IMGTAG_MB_VOTEDATATABLE.": $table_votedata &nbsp; ";
$rs = $xoopsDB->query("SELECT COUNT(lid) FROM $table_votedata");
if(! $rs) echo "<font color='#FF0000'><b>Error</b></font><br />\n";
else echo "<font color='#00FF00'><b>ok</b></font><br />\n";
list($num_votedata) = $xoopsDB->fetchRow($rs);
echo _AM_D3IMGTAG_MB_NUMBEROFVOTEDATA.": $num_votedata<br /><br />\n";

echo _AM_D3IMGTAG_MB_COMMENTSTABLE.": $table_comments &nbsp; ";
$rs = $xoopsDB->query("SELECT COUNT(com_id) FROM $table_comments WHERE com_modid=$d3imgtag_mid");
if(! $rs) echo "<font color='#FF0000'><b>Error</b></font><br />\n";
else echo "<font color='#00FF00'><b>ok</b></font><br />\n";
list($num_comments) = $xoopsDB->fetchRow($rs);
echo _AM_D3IMGTAG_MB_NUMBEROFCOMMENTS.": $num_comments<br /><br />\n";


//
// CONFIG CHECK
//
echo "<h4>"._AM_D3IMGTAG_H4_CONFIG."</h4>\n";

// pipe
echo _AM_D3IMGTAG_MB_PIPEFORIMAGES.": \n";
if( $d3imgtag_imagingpipe == PIPEID_IMAGICK ) {
	echo "ImageMagick<br />\n Path: $d3imgtag_imagickpath<br />\n" ;
	exec( "{$d3imgtag_imagickpath}convert --help" , $ret_array ) ;
	if( count( $ret_array ) < 1 ) echo "<font color='#FF0000'><b>Error: {$d3imgtag_imagickpath}convert can't be executed</b></font><br />\n" ;
	else echo " &nbsp; {$ret_array[0]} &nbsp; <font color='#00FF00'><b>ok</b></font><br />" ;
} else if( $d3imgtag_imagingpipe == PIPEID_NETPBM ) {
	echo "NetPBM<br />\n Path: $d3imgtag_netpbmpath<br />\n" ;
	foreach( $netpbm_pipes as $pipe ) {
		$ret_array = array() ;
		exec( "{$d3imgtag_netpbmpath}$pipe --version 2>&1" , $ret_array ) ;
		if( count( $ret_array ) < 1 ) echo "<font color='#FF0000'><b>Error: {$d3imgtag_netpbmpath}pnmscale can't be executed</b></font><br />\n" ;
		else echo " &nbsp; {$ret_array[0]} &nbsp; <font color='#00FF00'><b>ok</b></font><br />" ;
	}
} else {
	echo "GD<br />\n" ;
	if( function_exists( 'gd_info' ) ) {
		$gd_info = gd_info() ;
		echo " &nbsp; GD Version: {$gd_info['GD Version']}<br />\n" ;
	}
	echo " &nbsp; <a href='index.php?page=checkgd2' target='_blank'>"._AM_D3IMGTAG_LNK_CHECKGD2."</a><br />\n &nbsp; "._AM_D3IMGTAG_MB_CHECKGD2."<br />\n" ;
}
echo "<br />\n" ;

echo _AM_D3IMGTAG_MB_CHECKTTF."<br>";
if (function_exists('imagettftext')) {
	echo _AM_D3IMGTAG_MB_CHECKTTFSUCCESS."<br>";
} else {
	echo _AM_D3IMGTAG_MB_CHECKTTFFAILED."<br>";
}
echo "<br />";

// directory
echo _AM_D3IMGTAG_MB_DIRECTORYFORPHOTOS.": ".XOOPS_ROOT_PATH."$d3imgtag_photospath &nbsp; ";
if(substr($d3imgtag_photospath , -1) == '/') {
	echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_LASTCHAR."</b></font><br />\n";
} else if(ord($d3imgtag_photospath) != 0x2f) {
	echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_FIRSTCHAR."</b></font><br />\n";
} else if(! is_dir($photos_dir)) {
	if($safe_mode_flag) {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_PERMISSION."</b></font><br />\n";
	} else {
		$rs = mkdir($photos_dir , 0777);
		if(! $rs) echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_NOTDIRECTORY."</b></font><br />\n";
		else echo "<font color='#00FF00'><b>ok</b></font> &nbsp; <br />\n";
	}
} else if(! is_writable($photos_dir) || ! is_readable($photos_dir)) {
	echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_READORWRITE."</b></font><br />\n";
} else {
	echo "<font color='#00FF00'><b>ok</b></font> &nbsp; <br />\n";
}
echo "<br />\n";

// thumbs
if($d3imgtag_makethumb) {
	echo _AM_D3IMGTAG_MB_DIRECTORYFORTHUMBS.": ".XOOPS_ROOT_PATH."$d3imgtag_thumbspath &nbsp; ";
	if(substr($d3imgtag_thumbspath , -1) == '/') {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_LASTCHAR."</b></font><br />\n";
	} else if(ord($d3imgtag_thumbspath) != 0x2f) {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_FIRSTCHAR."</b></font><br />\n";
	} else if(! is_dir($thumbs_dir)) {
		if($safe_mode_flag) {
			echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_PERMISSION."</b></font><br />\n";
		} else {
			$rs = mkdir($thumbs_dir , 0777);
			if(! $rs) echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_NOTDIRECTORY."</b></font><br />\n";
			else echo "<font color='#00FF00'><b>ok</b></font> &nbsp; <br />\n";
		}
	} else if($d3imgtag_thumbspath == $d3imgtag_photospath) {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_SAMEDIR."</b></font><br />\n";
	} else if(! is_writable($thumbs_dir) || ! is_readable($thumbs_dir)) {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_READORWRITE."</b></font><br />\n";
	} else {
		echo "<font color='#00FF00'><b>ok</b></font> &nbsp; <br />\n";
	}
	echo "<br />\n";
}

// preview
if($d3imgtag_makepreview) {
	echo _AM_D3IMGTAG_MB_DIRECTORYFORPREVIEWS.": ".XOOPS_ROOT_PATH."$d3imgtag_previewspath &nbsp; ";
	if(substr($d3imgtag_thumbspath , -1) == '/') {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_LASTCHAR."</b></font><br />\n";
	} else if(ord($d3imgtag_previewspath) != 0x2f) {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_FIRSTCHAR."</b></font><br />\n";
	} else if(! is_dir($previews_dir)) {
		if($safe_mode_flag) {
			echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_PERMISSION."</b></font><br />\n";
		} else {
			$rs = mkdir($previews_dir , 0777);
			if(! $rs) echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_NOTDIRECTORY."</b></font><br />\n";
			else echo "<font color='#00FF00'><b>ok</b></font> &nbsp; <br />\n";
		}
	} else if($d3imgtag_previewspath == $d3imgtag_photospath) {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_SAMEDIR."</b></font><br />\n";
	} else if(! is_writable($previews_dir) || ! is_readable($previews_dir)) {
		echo "<font color='#FF0000'><b>"._AM_D3IMGTAG_ERR_READORWRITE."</b></font><br />\n";
	} else {
		echo "<font color='#00FF00'><b>ok</b></font> &nbsp; <br />\n";
	}
	echo "<br />\n";
}


//
// CONSISTEMCY CHECK
//
echo "<h4>"._AM_D3IMGTAG_H4_PHOTOLINK."</h4>\n";

$dead_photos = 0 ;
$dead_thumbs = 0 ;
echo _AM_D3IMGTAG_MB_NOWCHECKING ;
$rs = $xoopsDB->query("SELECT lid,img,ext FROM $table_photos");
// check loop
while(list($lid, $img, $ext) = $xoopsDB->fetchRow($rs)) {
	echo ". ";
	if(! is_readable("$photos_dir/$img.$ext")) {
		printf("<br />"._AM_D3IMGTAG_FMT_PHOTONOTREADABLE."\n" , "$photos_dir/$img.$ext");
		$dead_photos ++ ;
	}
	if($d3imgtag_makethumb && in_array(strtolower($ext) , $d3imgtag_normal_exts) && ! is_readable("$thumbs_dir/$img.$ext")) {
		printf("<br />"._AM_D3IMGTAG_FMT_THUMBNOTREADABLE."\n" , "$thumbs_dir/$img.$ext");
		$dead_thumbs ++ ;
	}
}
// show result
if($dead_photos == 0) {
	if(! $d3imgtag_makethumb || $dead_thumbs == 0) {
		echo "<font color='#00FF00'><b>ok</b></font> &nbsp; <br />\n";
	} else {
		printf("<br /><font color='#FF0000'><b>"._AM_D3IMGTAG_FMT_NUMBEROFDEADTHUMBS."</b></font><br />\n" , $dead_thumbs);
		echo "
			<form action='index.php?page=redothumbs' method='post'>
				<input type='submit' value='"._AM_D3IMGTAG_LINK_REDOTHUMBS."' />
			</form>\n";
	}
} else {
	printf("<br /><font color='#FF0000'><b>"._AM_D3IMGTAG_FMT_NUMBEROFDEADPHOTOS."</b></font><br />\n" , $dead_photos);
	echo "
		<form action='index.php?page=redothumbs' method='post'>
			<input type='hidden' name='removerec' value='1' />
			<input type='submit' value='"._AM_D3IMGTAG_LINK_TABLEMAINTENANCE."' />
		</form>\n";
}

echo "<h4>"._AM_D3IMGTAG_H4_SIZECHECK."</h4>\n";
$res = $xoopsDB->query("SELECT SUM(size) as totalSize FROM $table_photos");

while ($total = $xoopsDB->fetchArray($res)) {
	$totalSize = $total['totalSize'];
}
echo convert_from_bytes($totalSize);

// Clear tempolary files
$removed_tmp_num = d3imgtag_clear_tmp_files($photos_dir);
if($removed_tmp_num > 0) printf("<br />"._AM_D3IMGTAG_FMT_NUMBEROFREMOVEDTMPS."<br />\n" , $removed_tmp_num);

d3imgtag_closetable();
xoops_cp_footer();

?>