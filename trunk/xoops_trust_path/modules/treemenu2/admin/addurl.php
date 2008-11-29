<?php


$selfurl = XOOPS_URL."/modules/$mydirname/admin/index.php?act=addurl";
$backurl = XOOPS_URL."/modules/$mydirname/admin/index.php?act=makemenu";



$subid = isset($_GET['subid']) ? intval($_GET['subid']) : 0;


// Addurl
if( isset($_POST['addurl']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$url = isset($_POST['url']) ? $myts->stripSlashesGPC(trim($_POST['url'])) : "";
	if( $url != "" ){
		/*if( !( strpos($url,'http://')!==0 || strpos($url,'https://')!==0 ) ){
			$url = ( strpos($url,'/')!==0 ) ? XOOPS_URL."/$url" : XOOPS_URL.$url ;
		}*/
		if( strpos($url,'http://')==0 || strpos($url,'https://')==0 ){
			$url = str_replace( XOOPS_URL , '' , $url ) ;
		}
		if( strpos($url,'http')!==0 && strpos($url,'/')!==0 ){
			$url = "/$url" ;
		}
		if( substr_count($url,'/')==2
			|| ( !strpos($url,'?') && strrpos($url,'/')!=(strlen($url)-1) && preg_match('/.*\.[0-9a-zA-Z]{2,4}$/',$url)==0 )
			 ){
				$url .= "/" ;
		}
		$url = addslashes($url);
		$sql = "INSERT INTO  $table_addurl  (`subid`, `url` ) VALUES ( $subid, '$url' )";
		$xoopsDB->query($sql) or die( "DB Error: addurl" ) ;
		redirect_header( $backurl ,1,_MA_TREEMENU_ADD_COMPLETE);
		exit();
	}else{
		redirect_header( $selfurl."&amp;subid=$subid" ,1, _MA_TREEMENU_NO_URL );
		exit();
	}
}

// DELETE URI
if( !empty($_POST['delurl']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$addid = isset($_POST['delurl']) ? intval($_POST['delurl']) : 0 ;
	$sql = "DELETE FROM $table_addurl WHERE addid=$addid";
	$xoopsDB->query($sql) or die( "DB Error: delete uri " ) ;
	redirect_header( $backurl ,1, _MA_TREEMENU_UPDATE_COMPLETE );
	exit();
}


// DB ////////////////////////////////////////
$sql = "SELECT * FROM $table_menu WHERE `subid`=$subid LIMIT 1";
$result = $xoopsDB->query($sql);
$vals = $xoopsDB->fetchArray($result);

$title = htmlspecialchars($vals['title'],ENT_QUOTES);
$url = htmlspecialchars($vals['url'],ENT_QUOTES);

// view form ///////////////////////////////////////////////
xoops_cp_header();
include 'mymenu.php';

echo "
<form action='' method='POST'>
<h4>"._MA_TREEMENU_ADDURL_TITLE."</h4>
<table cellspacing='1' class='outer'>
  <tr>
    <td class='head'>ID</td>
    <td class='even'>". $subid ."<input type='hidden' name='subid' value='$subid'></td>
  </tr>
  <tr>
    <td class='head'>"._MA_TREEMENU_MENU_TITLE."</td>
    <td class='odd'>$title</td>
  </tr>
  <tr>
    <td class='head'>URL</td>
    <td class='even'>$url</td>
  </tr>
  <tr>
    <td class='head'>"._MA_TREEMENU_ADDURI."</td>
    <td class='odd'>
      <input type='text' name='url' size='60' value='". XOOPS_URL ."/'>
    </td>
  </tr>
  <tr>
    <td class='head'>&nbsp;</td>
    <td class='foot'>
      <input type='submit' name='addurl' value='". _ADD ."'>
      <!--input type='button' value='". _BACK ."' onClick='history.back()'-->
    </td>
  </tr>
</table>".
$GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ )
."</form>\n";


//ADDURL
$sql = "SELECT * FROM $table_addurl WHERE `subid`=$subid";
$result = $xoopsDB->query($sql);

$gticket= $GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ );

echo "<h4>". _MA_TREEMENU_ADDEDURI ."</h4><form name='MainForm2' action='' method='POST'>
	<input type='hidden' name='delurl' value='' /><table cellspacing='1' class='outer'>";
while( $row = $xoopsDB->fetchArray($result) ){
	$url = $row['url'] ;
	//if( strpos($url,XOOPS_URL)!==0 ){
	//	$url = XOOPS_URL . $url ;
	//}
	$url = htmlspecialchars($url,ENT_QUOTES);
	$aid = $row['addid'];
	$del_confirm = 'confirm("' . sprintf( _MA_TREEMENU_DELCONFIRM , $url ) . '")' ;

	echo "
	<tr class='even'>
	  <td>$url</td>
	  <td><input type='button' name='delete' value='". _DELETE ."'  onclick='if($del_confirm){document.MainForm2.delurl.value=\"$aid\"; submit();}' ></td>
	</tr>
	";
}
echo "</table>$gticket</form>";

xoops_cp_footer();
exit();

?>