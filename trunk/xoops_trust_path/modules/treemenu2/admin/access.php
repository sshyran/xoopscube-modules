<?php

$selfurl = XOOPS_URL."/modules/$mydirname/admin/index.php?act=access";


//GROUP
$member_handler =& xoops_gethandler('member');
$groups = $member_handler->getGroups();
$gcount = count($groups);


// UPDATE
//-----------------------------------------------------------------------
if( isset($_POST['update']) ) {
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$menu = $_POST['menu'];
	$sql = "SELECT * FROM $table_menu ORDER BY sortnum ASC";
	$result = $xoopsDB->query($sql);
	while( $row = $xoopsDB->fetchArray($result) ){
		$subid = $row['subid'];
		for ( $i=0; $i < $gcount; $i++ ) {
			$gid = $groups[$i]->getVar('groupid') ;
			$visible = ( isset($menu[$subid][$gid]) ) ? 1 : 0 ;
			
			$sql = "SELECT count(*) FROM $table_access WHERE `subid`=$subid AND `groupid`=$gid" ;
			list($cnt) = $xoopsDB->fetchRow($xoopsDB->query($sql));
			if( $cnt == 1 ){
				$sql = "UPDATE  $table_access SET `visible`=$visible WHERE `subid`=$subid AND `groupid`=$gid" ;
				$xoopsDB->query($sql);
			}else{
				$sql = "INSERT INTO  $table_access  (`subid`, `groupid`, `visible` ) VALUES ( $subid, $gid, $visible )";
				$xoopsDB->query($sql) or die( "DB Error: insert " ) ;
			}
		}
	}
	redirect_header( $selfurl , 1 , _MA_TREEMENU_UPDATE_COMPLETE );
	exit();
}



// データ取得 ////////////////////////////////////////
$sql = "SELECT m.subid,m.title,m.hiera,a.groupid,a.visible FROM $table_menu AS m LEFT OUTER JOIN $table_access AS a ON m.subid=a.subid ORDER BY m.sortnum ASC, a.groupid ASC";
$result = $xoopsDB->query($sql);




// view form ///////////////////////////////////////////////
xoops_cp_header();
include 'mymenu.php';
echo '<h3>'. $xoopsModule->getVar('name') .'</h3>' ;

echo "<h4>"._MA_TREEMENU_GROUP_ACCESS."</h4>
	<form action='' name='MainForm1' method='POST'>
	<table cellspacing='1' class='outer'><tr>
	<th>ID</th><th>"._MA_TREEMENU_MENU_TITLE."</th>";
for ( $i=0; $i < $gcount; $i++ ) {	//GROUP NAME
	$gid = $groups[$i]->getVar('groupid');
	echo "<th><input type='checkbox' name='dummy' onclick='with(document.MainForm1){for(i=0;i<length;i++){if(elements[i].name.match(/^menu\[\d*\]\[$gid\]?/)){elements[i].checked=this.checked;}}}' />". $groups[$i]->getVar('name') ."</th>";
}
echo "</tr>";

$menu = array() ;
while( $row = $xoopsDB->fetchArray($result) ){
	$menu[$row['subid']][$row['groupid']] = $row['visible'] ;
	$menu[$row['subid']]['title'] = $row['title'] ;
}

$class = 'odd' ;
foreach( $menu as $k => $v ){
	echo "
		<tr class='$class'>
			<td>$k</td>
			<td>". htmlspecialchars($v['title'],ENT_QUOTES) ."</td>";
	for ( $i=0; $i < $gcount; $i++ ) {
		$gid = $groups[$i]->getVar('groupid');
		$visible = !empty($v[$gid]) ? "CHECKED='CHECKED'" : '' ;
		echo "<td><input type='checkbox' name='menu[$k][$gid]' value='1' $visible /></td>";
	}
	echo "</tr>" ;
}


echo "<tr class='foot'><td>&nbsp;</td><td>&nbsp;</td><td colspan='$gcount'><input type='submit' name='update' value='". _MA_TREEMENU_UPDATE ."' /></td></tr>
	</table>".
	$GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ )
	."</form>";

xoops_cp_footer();
exit();

?>