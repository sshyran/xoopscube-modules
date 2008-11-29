<?php

require_once 'ad_funcs.php';

$selfurl = XOOPS_URL."/modules/$mydirname/admin/index.php?act=edit";
$backurl = XOOPS_URL."/modules/$mydirname/admin/index.php?act=makemenu";


$subid = isset($_GET['subid']) ? intval($_GET['subid']) : 0;


//GROUP
$member_handler =& xoops_gethandler('member');
$glist = $member_handler->getGroupList();



// UPDATE /////////////////////////////////////
if( isset($_POST['update']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$title = isset($_POST['title']) ? $myts->stripSlashesGPC(trim($_POST['title'])) : "";
	$url = isset($_POST['url']) ? $myts->stripSlashesGPC(trim($_POST['url'])) : "";
	if( $title != "" && $url != "" ){
		$url = checkURL( $url );
		$sql = "UPDATE  $table_menu SET `title`='".addslashes($title)."', `url`='".addslashes($url)."' WHERE `subid`=$subid";
		$xoopsDB->query($sql) or die( "DB Error: update" ) ;
		//Group Access
		$grp = $_POST['grp'];
		foreach( $glist as $k=>$v ){
			$visible = isset($grp[$k]) ? 1 : 0 ;
			$sql = "SELECT count(*) FROM $table_access WHERE `subid`=$subid AND `groupid`=$k" ;
			list($cnt) = $xoopsDB->fetchRow($xoopsDB->query($sql));
			if( $cnt > 0 ){
				$sql = "UPDATE  $table_access SET `visible`=$visible WHERE `subid`=$subid AND `groupid`=$k" ;
				$xoopsDB->query($sql) or die( "DB Error: update " ) ;
			}else{
				$sql = "INSERT INTO  $table_access  (`subid`, `groupid`, `visible` ) VALUES ( $subid, $k, $visible )";
				$xoopsDB->query($sql) or die( "DB Error: insert " ) ;
			}
		}
		redirect_header( $backurl ,1,_MA_TREEMENU_UPDATE_COMPLETE);
		exit();
	}else{
		redirect_header( $selfurl."&amp;subid=$subid" ,1, _MA_TREEMENU_NO_TITLE );
		exit();
	}
}

//GROUP
$sql = "SELECT * FROM $table_access WHERE `subid`=$subid";
$result = $xoopsDB->query($sql);
while( $row = $xoopsDB->fetchArray($result) ){
	$aVal[$row['groupid']]['visible'] = $row['visible'];
}
$inputText = '';
foreach( $glist as $k=>$v ){
	$chk = (@$aVal[$k]['visible']==1) ? "checked='checked'" : "" ;
	$inputText .= "<input type='checkbox' name='grp[$k]' value='1' $chk>$v&nbsp" ;
}


// DB //////////////////////////////////////////////////////
$sql = "SELECT * FROM $table_menu WHERE `subid`=$subid LIMIT 1";
$result = $xoopsDB->query($sql);
$vals = $xoopsDB->fetchArray($result);
$url = $vals['url'] ;
if( !strpos($vals['url'],"//") ){
	$url = XOOPS_URL . $vals['url'] ;
}


// FORM ////////////////////////////////////////////////////
xoops_cp_header();
include 'mymenu.php';

echo "
<form action='' method='POST'>
<h4>"._MA_TREEMENU_EDIT_TITLE."</h4>
<table cellspacing='1' class='outer'>
  <tr>
    <td class='head'>ID</td>
    <td class='even'>". $subid ."</td>
  </tr>
  <tr>
    <td class='head'>". _MA_TREEMENU_MENU_TITLE ."</td>
    <td class='odd'>
      <input type='text' name='title' size='60' value='".htmlspecialchars($vals['title'],ENT_QUOTES)."'>
    </td>
  </tr>
  <tr>
    <td class='head'>". _MA_TREEMENU_MENU_URL ."</td>
    <td class='even'>
      <input type='text' name='url' size='60' value='".htmlspecialchars( tmCodeDecode($url) ,ENT_QUOTES)."'>
    </td>
  </tr>
  <tr>
    <td class='head'>". _MA_TREEMENU_MENU_ACCESS ."</td>
    <td class='odd'>
      $inputText
    </td>
  </tr>
  <tr>
    <td class='head'>&nbsp;</td>
    <td class='even'>
      <input type='submit' name='update' value='". _MA_TREEMENU_UPDATE ."'>
      <input type='button' value='". _BACK ."' onClick='history.back()'>
    </td>
  </tr>
</table>".
$GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ )
."</form>\n";
xoops_cp_footer();
exit();

?>