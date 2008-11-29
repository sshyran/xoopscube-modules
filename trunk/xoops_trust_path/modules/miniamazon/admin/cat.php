<?php
$mod_url = XOOPS_URL . "/modules/$mydirname" ;

include 'adminheader.php';
include 'funcs.php';
include_once $mytrustdirpath."/include/gtickets.php";

//require_once XOOPS_ROOT_PATH . "/include/xoopscodes.php" ;
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
//include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php" ;


$action = isset( $_POST[ 'action' ] ) ? $_POST[ 'action' ] : '' ;
$disp = isset( $_GET[ 'disp' ] ) ? $_GET[ 'disp' ] : '' ;
$cid = isset( $_GET[ 'cid' ] ) ? intval( $_GET[ 'cid' ] ) : 0 ;

$table_cat = $xoopsDB->prefix( $mydirname."_cat" ) ;
$table_items = $xoopsDB->prefix( $mydirname."_items" ) ;

$myts =& MyTextSanitizer::getInstance();
$cattree = new XoopsTree( $table_cat , "cid" , "pid" ) ;


//
// DB part
//
if( $action == "insert" ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// newly insert
	$sql = "INSERT INTO $table_cat SET " ;
	$cols = array( "pid" => "I:N:0" ,"ctitle" => "50:E:1" ,"corder" => "I:N:0" ) ;
	$sql .= mysql_get_sql_set( $cols ) ;
	$xoopsDB->query( $sql ) or die( "DB Error: insert category" ) ;

	// Check if cid == pid
	$cid = $xoopsDB->getInsertId() ;
	if( $cid == intval( $_POST['pid'] ) ) {
		$xoopsDB->query( "UPDATE $table_cat SET pid='0' WHERE cid='$cid'" ) ;
	}

	redirect_header( "index.php?act=cat" , 1 , _MD_A_MINIAMAZON_CAT_INSERTED ) ;
	exit ;

} else if( $action == "update" && ! empty( $_POST['cid'] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	$cid = intval( $_POST['cid'] ) ;
	$pid = intval( $_POST['pid'] ) ;

	// Check if new pid was a child of cid
	if( $pid != 0 ) {
		$children = $cattree->getAllChildId( $cid ) ;
		$children[] = $cid ;
		foreach( $children as $child ) {
			if( $child == $pid ) die( "category looping has occurred" ) ;
		}
	}

	// update
	$sql = "UPDATE $table_cat SET " ;
	$cols = array( "pid" => "I:N:0" ,"ctitle" => "50:E:1" ,"corder" => "I:N:0" ) ;
	$sql .= mysql_get_sql_set( $cols ) . " WHERE cid='$cid'" ;
	$xoopsDB->query( $sql ) or die( "DB Error: update category" ) ;
	redirect_header( "index.php?act=cat" , 1 , _MD_A_MINIAMAZON_CAT_UPDATED ) ;
	exit ;

} else if( ! empty( $_POST['delcat'] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// Delete
	$cid = intval( $_POST['delcat'] ) ;

	//get all categories under the specified category
	$children = $cattree->getAllChildId( $cid ) ;
	$whr = "cid IN (" ;
	foreach( $children as $child ) {
		$whr .= "$child," ;
	}
	$whr .= "$cid)" ;

	delete_items( $whr ) ;

	$xoopsDB->query( "DELETE FROM $table_cat WHERE $whr" ) or die( "DB error: DELETE cat table" ) ;
	redirect_header( 'index.php?act=cat' , 2 , _MD_A_MINIAMAZON_CAT_DELETED ) ;
	exit ;

}



/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;
echo "<h3 style='text-align:left;'>".sprintf( _MD_A_MINIAMAZON_CATEGORIES_MANAGER , $xoopsModule->name() )."</h3>\n" ;

if( $disp == "edit" && $cid > 0 ) {

	// Editing
	$sql = "SELECT cid,pid,ctitle,corder FROM $table_cat WHERE cid='$cid'" ;
	$crs = $xoopsDB->query( $sql ) ;
	$cat_array = $xoopsDB->fetchArray( $crs ) ;
	display_edit_form( $cat_array , _MD_A_MINIAMAZON_CAT_MENU_EDIT , 'update' ) ;

} else if( $disp == "new" ) {

	// New
	$cat_array = array( 'cid' => 0 , 'pid' => $cid , 'ctitle' => '' , 'corder' => 0 ) ;
	display_edit_form( $cat_array , _MD_A_MINIAMAZON_CAT_MENU_NEW , 'insert' ) ;

} else {

	// Listing
	$cat_tree_array = $cattree->getChildTreeArray( 0 , 'corder' ) ;

	// Get ghost categories
	$live_cids = $cattree->getAllChildId(0);
	$whr_cid = "cid NOT IN (" ;
	foreach( $live_cids as $cid ) {
		$whr_cid .= "$cid," ;
	}
	$whr_cid .= "0)" ;
	$rs = $xoopsDB->query( "SELECT * FROM $table_cat WHERE $whr_cid" ) ;
	if( $xoopsDB->fetchArray( $rs ) != false ) {
		$xoopsDB->queryF( "UPDATE $table_cat SET pid='0' WHERE $whr_cid" ) ;
		redirect_header( 'index.php?act=cat' , 0 , 'A Ghost Category found.' ) ;
		exit ;
	}


	// Top links
	echo "<p><a href='?act=cat&amp;disp=new&amp;cid=0'>"._MD_A_MINIAMAZON_CAT_LINK_MAKETOPCAT."&nbsp;<img src='../images/cat_add.gif' width='18' height='15' alt='"._MD_A_MINIAMAZON_CAT_LINK_MAKETOPCAT."' title='"._MD_A_MINIAMAZON_CAT_LINK_MAKETOPCAT."' /></a>\n";

	// TH
	echo "
	<form name='MainForm' action='' method='post'>
	".$xoopsGTicket->getTicketHtml( __LINE__ )."
	<input type='hidden' name='delcat' value='' />
	<table width='75%' class='outer' cellpadding='4' cellspacing='1'>
	  <tr valign='middle'>
	    <th>"._MD_A_MINIAMAZON_CAT_TH_TITLE."</th>
	    <th nowrap>"._MD_A_MINIAMAZON_CAT_TH_ORDER."</th>
	    <th>"._MD_A_MINIAMAZON_CAT_TH_OPERATION."</th>
	  </tr>
	" ;

	// TD
	$oddeven = 'odd' ;
	foreach( $cat_tree_array as $cat_node ) {
		$oddeven = $oddeven == 'odd' ? 'even' : 'odd' ;
		extract( $cat_node ) ;

		$prefix = str_replace( '.' , '&nbsp;--' , substr( $prefix , 1 ) ) ;
		//$cid = $cid ;
		$del_confirm = 'confirm("' . sprintf( _MD_A_MINIAMAZON_CAT_FMT_CATDELCONFIRM , $ctitle ) . '")' ;

		echo "
		  <tr>
		    <td class='$oddeven' width='100%'><a href='$mod_url/index.php?cid=$cid' target='_blank'>$prefix&nbsp;".$myts->htmlSpecialChars($ctitle)."</a></td>	
		    <td class='$oddeven'>". $corder ."</a></td>
		    <td class='$oddeven' align='center' nowrap='nowrap'>
		      &nbsp;
		      <a href='?act=cat&amp;disp=edit&amp;cid=$cid'><img src='../images/cat_edit.gif' width='18' height='15' alt='"._MD_A_MINIAMAZON_CAT_LINK_EDIT."' title='"._MD_A_MINIAMAZON_CAT_LINK_EDIT."' /></a>
		      &nbsp;
		      <a href='?act=cat&amp;disp=new&amp;cid=$cid'><img src='../images/cat_add.gif' width='18' height='15' alt='"._MD_A_MINIAMAZON_CAT_LINK_MAKESUBCAT."' title='"._MD_A_MINIAMAZON_CAT_LINK_MAKESUBCAT."' /></a>
		      &nbsp;
		      <input type='button' value='"._DELETE."' onclick='if($del_confirm){document.MainForm.delcat.value=\"$cid\"; submit();}' />
		    </td>
		  </tr>\n" ;	//[178] act=viewcat&amp;
	}

	// Table footer
	echo "</table></form>" ;
}

xoops_cp_footer();
/* ------------------------------------------------------------------ */

?>