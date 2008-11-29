<?php
// ------------------------------------------------------------------------- //
//                      IMGTag - XOOPS photo album                           //
//                        <http://www.kickassamd.com/>                       //
// ------------------------------------------------------------------------- //
//                      IMGTag D3                                            //
//                        <http://xoops.oceanblue-site.com/>                 //
// ------------------------------------------------------------------------- //

include("header.php");
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
include_once(XOOPS_ROOT_PATH . "/class/xoopstree.php");
$cattree = new XoopsTree($table_cat , "cid" , "pid");

$xoopsOption['template_main'] = "{$mydirname}_main.html";

include(XOOPS_ROOT_PATH . "/header.php");

include(dirname(dirname(__FILE__)).'/include/assign_globals.php');
$xoopsTpl->assign($d3imgtag_assign_globals);

$xoopsTpl->assign('subcategories' , d3imgtag_get_sub_categories(0 , $cattree));
$xoopsTpl->assign('category_options' , d3imgtag_get_cat_options());

$prs = $xoopsDB->query("SELECT COUNT(lid) FROM $table_photos WHERE status>0");
list($photo_num_total) = $xoopsDB->fetchRow($prs);

$xoopsTpl->assign('photo_global_sum' , sprintf(_MD_D3IMGTAG_THEREARE , $photo_num_total));
if($global_perms & D3IMGTAG_GPERM_INSERTABLE) $xoopsTpl->assign('lang_add_photo' , _MD_D3IMGTAG_ADDPHOTO);

// Navigation
$num = empty($_GET['num']) ? $d3imgtag_newphotos : intval($_GET['num']);
if($num < 1) $num = $d3imgtag_newphotos ;
$pos = empty($_GET['pos']) ? 0 : intval($_GET['pos']);
if($pos >= $photo_num_total) $pos = 0 ;
if($photo_num_total > $num) {
	include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');
	$nav = new XoopsPageNav($photo_num_total , $num , $pos , 'pos' , "num=$num");
	$nav_html = $nav->renderNav(10);
	$last = $pos + $num ;
	if($last > $photo_num_total) $last = $photo_num_total ;
	$photonavinfo = sprintf(_MD_D3IMGTAG_AM_PHOTONAVINFO , $pos + 1 , $last , $photo_num_total);
	$xoopsTpl->assign('photonavdisp' , true);
	$xoopsTpl->assign('photonav' , $nav_html);
	$xoopsTpl->assign('photonavinfo' , $photonavinfo);
} else {
	$xoopsTpl->assign('photonavdisp' , false);
}

// Assign Latest Photos
$prs = $xoopsDB->query("SELECT l.lid, l.img, l.cid, l.title, l.ext, l.size, l.share, l.res_x, l.res_y, l.status, l.date, l.hits, l.rating, l.votes, l.comments, l.submitter, t.description,c.title AS cat_title FROM $table_photos l LEFT JOIN $table_text t ON l.lid=t.lid LEFT JOIN $table_cat c ON l.cid=c.cid WHERE l.status>0 ORDER BY date DESC" , $num , $pos);
if( ! $prs ) {
	$prs = $xoopsDB->query( "SELECT l.lid, i.img, l.cid, l.title, l.ext, l.size, l.share, l.res_x, l.res_y, l.status, l.date, l.hits, l.rating, l.votes, l.comments, l.submitter, t.description,c.title AS cat_title FROM $table_photos l INNER JOIN $table_text t ON l.lid=t.lid LEFT JOIN $table_cat c ON l.cid=c.cid WHERE l.status>0 ORDER BY date DESC" , $num , $pos ) ;
}

while($fetched_result_array = $xoopsDB->fetchArray($prs)) {
	$xoopsTpl->append_by_ref('photos' , d3imgtag_get_array_for_photo_assign($fetched_result_array , true));
}

$imagesCount = explode("|", $d3imgtag_perpage);
$xoopsTpl->assign("viewPhotoCount", $imagesCount);

include(XOOPS_ROOT_PATH . "/footer.php");

?>