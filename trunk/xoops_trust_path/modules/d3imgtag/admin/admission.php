<?php
// ------------------------------------------------------------------------- //
//                      IMGTag - XOOPS photo album                           //
//                        <http://www.kickassamd.com/>                       //
// ------------------------------------------------------------------------- //
//                      IMGTag D3                                            //
//                        <http://xoops.oceanblue-site.com/>                 //
// ------------------------------------------------------------------------- //

include("admin_header.php");
include_once(XOOPS_ROOT_PATH.'/class/xoopstree.php');
include_once(XOOPS_ROOT_PATH.'/class/pagenav.php');
include_once(dirname(dirname(__FILE__)).'/class/d3imgtag.textsanitizer.php');


// initialization of Xoops vars
$cattree = new XoopsTree($table_cat , "cid" , "pid");
$myts =& d3imgtagTextSanitizer::getInstance();


// GET vars
$pos = empty($_GET[ 'pos' ]) ? 0 : intval($_GET[ 'pos' ]);
$num = empty($_GET[ 'num' ]) ? 20 : intval($_GET[ 'num' ]);
$txt = empty($_GET[ 'txt' ]) ? '' : $myts->stripSlashesGPC(trim($_GET[ 'txt' ]));


if(! empty($_POST['action']) && $_POST['action'] == 'admit' && isset($_POST['ids']) && is_array($_POST['ids'])) {

	// Do admission
	$whr = "";
	foreach($_POST[ 'ids' ] as $id) {
		$id = intval($id);
		$whr .= "lid=$id OR ";
	}
	$xoopsDB->query("UPDATE $table_photos SET status=1 WHERE $whr 0");

	// Trigger Notification
	$notification_handler =& xoops_gethandler('notification');
	$rs = $xoopsDB->query("SELECT l.lid,l.img,l.cid,l.submitter,l.title,c.title FROM $table_photos l LEFT JOIN $table_cat c ON l.cid=c.cid WHERE $whr 0");
	while(list($lid , $img, $cid , $submitter , $title , $cat_title) = $xoopsDB->fetchRow($rs)) {
		// Global Notification
		$notification_handler->triggerEvent('global' , 0 , 'new_photo' , array('PHOTO_TITLE' => $title , 'PHOTO_URI' => "$mod_url/index.php?page=photo&lid=$lid&cid=$cid"));

		// Category Notification
		$notification_handler->triggerEvent('category' , $cid , 'new_photo' , array('PHOTO_TITLE' => $title , 'CATEGORY_TITLE' => $cat_title , 'PHOTO_URI' => "$mod_url/index.php?page=photo&lid=$lid&cid=$cid"));
	}

	redirect_header('index.php?page=admission' , 2 , _MD_D3IMGTAG_AM_ADMITTING);
	exit;

} else if(! empty($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['ids']) && is_array($_POST['ids'])) {

	// remove records

	// Double check for anti-CSRF
	if(! xoops_refcheck()) die("XOOPS_URL is not included in your REFERER");

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	foreach($_POST['ids'] as $lid) {
		d3imgtag_delete_photos("lid=".intval($lid));
	}
	redirect_header("index.php?page=admission" , 2 , _MD_D3IMGTAG_DELETINGPHOTO);
	exit;
}


// extracting by free word
$whr = "l.status<=0 ";
if($txt != "") {
	$keywords = explode(" " , $txt);
	foreach($keywords as $keyword) {
		$whr .= "AND (CONCAT(l.title , l.ext , c.title) LIKE '%" . addslashes($keyword) . "%') ";
	}
}

// query for listing
$rs = $xoopsDB->query("SELECT count(l.lid) FROM $table_photos l LEFT JOIN $table_cat c ON l.cid=c.cid WHERE $whr");
list($numrows) = $xoopsDB->fetchRow($rs);
$prs = $xoopsDB->query("SELECT l.lid, l.img, l.cid, l.title, l.submitter, l.ext, t.description FROM $table_photos l LEFT JOIN $table_cat c ON l.cid=c.cid LEFT JOIN $table_text t ON l.lid=t.lid WHERE $whr ORDER BY l.lid DESC LIMIT $pos,$num");

// Page Navigation
$nav = new XoopsPageNav($numrows , $num , $pos , 'pos' , "num=$num&txt=" . urlencode($txt));
$nav_html = $nav->renderNav(10);


// beggining of Output
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';

// check $xoopsModule
if(! is_object($xoopsModule)) redirect_header(XOOPS_URL.'/user.php' , 1 , _NOPERM);
echo "<h3 style='text-align:left;'>".sprintf(_AM_D3IMGTAG_H3_FMT_ADMISSION,$xoopsModule->name())."</h3>\n";

echo "
<p><font color='blue'>".(isset($_GET['mes'])?$_GET['mes']:"")."</font></p>
<table width='95%' border='0' cellpadding='4' cellspacing='0'><tr><td>
<form action='' method='GET' style='margin-bottom:0px;text-align:right'>
  <input type='hidden' name='num' value='$num'>
  <input type='text' name='txt' value='".htmlspecialchars($txt,ENT_QUOTES)."'>
  <input type='submit' value='"._MD_D3IMGTAG_AM_BUTTON_EXTRACT."' /> &nbsp; 
  $nav_html &nbsp; 
</form>
<form name='MainForm' action='' method='POST' style='margin-top:0px;'>
".$xoopsGTicket->getTicketHtml( __LINE__ )."
<input type='hidden' name='action' value='' />
<table width='95%' class='outer' cellpadding='4' cellspacing='1'>
  <tr valign='middle'>
    <th width='5'><input type='checkbox' name='dummy' onclick=\"with(document.MainForm){for(i=0;i<length;i++){if(elements[i].type=='checkbox'){elements[i].checked=this.checked;}}}\" /></th>
    <th></th>
    <th>"._AM_D3IMGTAG_TH_SUBMITTER."</th>
    <th>"._AM_D3IMGTAG_TH_TITLE."</th>
    <th>"._AM_D3IMGTAG_TH_DESCRIPTION."</th>
    <th>"._AM_D3IMGTAG_TH_CATEGORIES."</th>
  </tr>
";

// Listing
$oddeven = 'odd' ;
while(list($lid , $img, $cid , $title , $submitter , $ext , $description) = $xoopsDB->fetchRow($prs)) {
	$oddeven = ($oddeven == 'odd' ? 'even' : 'odd');
	$title = $myts->makeTboxData4Show($title);
	$description = $myts->displayTarea($description , 0 , 1 , 1 , 0 , 1 , 1);
	$cat = $cattree->getNicePathFromId($cid , "title", "../index.php?page=viewcat&");
	$editbutton = "<a href='".XOOPS_URL."/modules/$mydirname/index.php?page=editphoto&lid=$lid' target='_blank'><img src='".XOOPS_URL."/modules/$mydirname/images/img_edit.png' border='0' alt='"._MD_D3IMGTAG_EDITTHISPHOTO."' title='"._MD_D3IMGTAG_EDITTHISPHOTO."' /></a>  ";

	echo "
  <tr>
    <td class='$oddeven'><input type='checkbox' name='ids[]' value='$lid' /></td>
    <td class='$oddeven'>$editbutton</td>
    <td class='$oddeven'>".$xoopsUser->getUnameFromId($submitter)."</td>
    <td class='$oddeven'><a href='$photos_url/{$lid}.{$ext}' target='_blank'>$title</a></td>
    <td class='$oddeven' width='100%'>$description</td>
    <td class='$oddeven'>$cat</td>
  </tr>\n";
}

echo "
  <tr>
    <!-- <td colspan='4' align='left'>"._MD_D3IMGTAG_AM_LABEL_ADMIT."<input type='submit' name='admit' value='"._MD_D3IMGTAG_AM_BUTTON_ADMIT."' /></td> -->
    <td colspan='8' align='left'>"._MD_D3IMGTAG_AM_LABEL_ADMIT."<input type='button' value='"._MD_D3IMGTAG_AM_BUTTON_ADMIT."' onclick='document.MainForm.action.value=\"admit\"; submit();' /></td>
  </tr>
  <tr>
    <td colspan='8' align='left'>"._MD_D3IMGTAG_AM_LABEL_REMOVE."<input type='button' value='"._MD_D3IMGTAG_AM_BUTTON_REMOVE."' onclick='if(confirm(\""._MD_D3IMGTAG_AM_JS_REMOVECONFIRM."\")){document.MainForm.action.value=\"delete\"; submit();}' /></td>
  </tr>
</table>
</form>
</td></tr></table>
";

xoops_cp_footer();
?>