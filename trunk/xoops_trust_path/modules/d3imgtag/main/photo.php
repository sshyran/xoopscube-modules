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
include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
$cattree = new XoopsTree($table_cat , "cid" , "pid");

// GET variables
$lid = empty($_GET['lid']) ? 0 : intval($_GET['lid']);
$cid = empty($_GET['cid']) ? 0 : intval($_GET['cid']);

$xoopsOption['template_main'] = "{$mydirname}_photo.html";

include(XOOPS_ROOT_PATH . "/header.php");

if($global_perms & D3IMGTAG_GPERM_INSERTABLE) $xoopsTpl->assign('lang_add_photo' , _MD_D3IMGTAG_ADDPHOTO);
$xoopsTpl->assign('lang_album_main' , _MD_D3IMGTAG_MAIN);
include(dirname(dirname(__FILE__)).'/include/assign_globals.php');
$xoopsTpl->assign($d3imgtag_assign_globals);

// update hit count
$xoopsDB->queryF("UPDATE `$table_photos` SET `hits` = `hits` + 1 WHERE `lid` = '$lid' AND `status` > 0");

$prs = $xoopsDB->query("SELECT l.lid, l.img, l.cid, l.title, l.ext, l.size, l.share, l.res_x, l.res_y, l.status, l.date, l.hits, l.rating, l.votes, l.comments, l.submitter, t.description, c.title AS cat_title FROM $table_photos as l, $table_text as t, $table_cat as c WHERE l.lid = $lid AND l.lid=t.lid AND (l.status > 0)");
$p = $xoopsDB->fetchArray($prs);
if($p == false) {
	redirect_header($mod_url.'/' , 3 , _MD_D3IMGTAG_NOMATCH);
	exit;
}
$photo = d3imgtag_get_array_for_photo_assign($p);

// <title></title>
$xoopsTpl->assign( 'xoops_pagetitle' , $photo['title'] ) ;

// Middle size calculation
$photo['width_height'] = '' ;
list( $max_w , $max_h ) = explode( 'x' , $d3imgtag_middlepixel ) ;
if( ! empty( $max_w ) && ! empty( $p['res_x'] ) ) {
	if( empty( $max_h ) ) $max_h = $max_w ;
	if( $max_h / $max_w > $p['res_y'] / $p['res_x'] ) {
		if( $p['res_x'] > $max_w ) $photo['width_height'] = "width='$max_w'" ;
	} else {
		if( $p['res_y'] > $max_h ) $photo['width_height'] = "height='$max_h'" ;
	}
}

$xoopsTpl->assign_by_ref('photo' , $photo);

// Category Information
$cid = empty($p['cid']) ? $cid : $p['cid'] ;
$xoopsTpl->assign('category_id' , $cid);
$cids = $cattree->getAllChildId($cid);
$sub_title = preg_replace("/\'\>/" , "'><img src='$mod_url/images/folder.png' alt='' align='absmiddle'/>" , $cattree->getNicePathFromId($cid , 'title' , "index.php?page=viewcat&num=" . intval($d3imgtag_perpage) ));
$sub_title = preg_replace("/^(.+)folder16/" , '$1folder_open' , $sub_title);
$xoopsTpl->assign('album_sub_title' , $sub_title);

// Orders
include(dirname(dirname(__FILE__)).'/include/photo_orders.php');
if(isset($_GET['orderby']) && isset($d3imgtag_orders[ $_GET['orderby'] ])) $orderby = $_GET['orderby'] ;
else if(isset($d3imgtag_orders[ $d3imgtag_defaultorder ])) $orderby = $d3imgtag_defaultorder ;
else $orderby = 'lidA' ;

// create category navigation
$fullcountresult = $xoopsDB->query("SELECT lid FROM $table_photos WHERE cid=$cid AND status>0 ORDER BY {$d3imgtag_orders[$orderby][0]}");
$ids = array();
while(list($id) = $xoopsDB->fetchRow($fullcountresult)) {
	$ids[] = $id ;
}

$photo_nav = "";
$numrows = count($ids);
$pos = array_search($lid , $ids);
if($numrows > 1) {
	// prev mark
	if($ids[0] != $lid) {
		$photo_nav .= "<a href='index.php?page=photo&lid=".$ids[0]."'><img src='$mod_url/images/control_faststart.png' align='absmiddle' alt='Just Back To First Image.'></a>&nbsp;&nbsp;";
		$photo_nav .= "<a href='index.php?page=photo&lid=".$ids[$pos-1]."'><img src='$mod_url/images/control_back.png' align='absmiddle' alt='Previous Image'></a>&nbsp;&nbsp;";
	    
	}

	$nwin = 7 ;
	if($numrows > $nwin) { // window
		if($pos > $nwin / 2) {
			if($pos > round($numrows - ($nwin / 2) - 1)) {
				$start = $numrows - $nwin + 1 ;
			} else {
				$start = round($pos - ($nwin / 2)) + 1 ;
			}
		} else {
			$start = 1 ;
		}
	} else {
		$start = 1 ;
	}
	
	for($i = $start; $i < $numrows + 1 && $i < $start + $nwin ; $i++) {
		if($ids[$i-1] == $lid) {
			$photo_nav .= "$i&nbsp;&nbsp;";
		} else {
			$photo_nav .= "<a href='index.php?page=photo&lid=".$ids[$i-1]."'>$i</a>&nbsp;&nbsp;";
		}
	}

	// next mark
	if($ids[$numrows-1] != $lid) {
		$photo_nav .= "<a href='index.php?page=photo&lid=".$ids[$pos+1]."'><img src='$mod_url/images/control_next.png' align='absmiddle' alt='Next Image'></a>&nbsp;&nbsp;";
		$photo_nav .= "<a href='index.php?page=photo&lid=".$ids[$numrows-1]."'><img src='$mod_url/images/control_fastend.png' align='absmiddle' alt='Jump To Last Image'></a>";
	}
}

$xoopsTpl->assign('photo_nav' , $photo_nav);

// comments

include XOOPS_ROOT_PATH.'/include/comment_view.php';

include(XOOPS_ROOT_PATH . "/footer.php");

?>