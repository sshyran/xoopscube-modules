<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

include 'adminheader.php';
include 'funcs.php';
include_once XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php";

include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";


$action = isset( $_POST[ 'action' ] ) ? $_POST[ 'action' ] : '' ;
$op = isset( $_GET[ 'op' ] ) ? $_GET[ 'op' ] : '' ;
$cxid = isset( $_GET[ 'cxid' ] ) ? intval( $_GET[ 'cxid' ] ) : '' ;
$dele = isset( $_GET[ 'dele' ] ) ? intval( $_GET[ 'dele' ] ) : '' ;

$table_cx = $xoopsDB->prefix( "xcsearch_cx" ) ;

$myts =& MyTextSanitizer::getInstance();


//
// DB part
//
if( $action == "insert" ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// newly insert
	$sql = "INSERT INTO $table_cx SET " ;
	$cols = array( "cxtitle" => "128:E:1" , "cxvalue" => "40:E:1" , "cxorder" => "I:N:0" ) ;
	$sql .= mysql_get_sql_set( $cols ) ;
	$xoopsDB->query( $sql ) or die( "DB Error: insert " ) ;

	redirect_header( "cx.php" , 1 , _AM_XCSEARCH_INSERTED ) ;
	exit ;

} else if( $action == "update" && !empty($cxid) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// update
	$sql = "UPDATE $table_cx SET " ;
	$cols = array( "cxtitle" => "128:E:1" , "cxvalue" => "40:E:1" , "cxorder" => "I:N:0" ) ;
	$sql .= mysql_get_sql_set( $cols ) . " WHERE cxid='$cxid'" ;
	$xoopsDB->query( $sql ) or die( "DB Error: update " ) ;
	redirect_header( "cx.php" , 1 , _AM_XCSEARCH_UPDATED ) ;
	exit ;

} else if( ! empty( $_POST['delcat'] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// Delete
	$cxid = intval( $_POST['delcat'] ) ;

	$xoopsDB->query( "DELETE FROM $table_cx WHERE cxid=$cxid" ) or die( "DB error: DELETE cat table" ) ;
	redirect_header( 'cx.php' , 2 , _AM_XCSEARCH_DELETED ) ;
	exit ;

}

/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;

echo "<h3 style='text-align:left;'>". $xoopsModule->name() .'&nbsp;:&nbsp;'. _MI_XCSEARCH_ADMENU1 ."</h3>\n" ;

if( $op == 'edit' && $cxid > 0 ) {

	// Editing
	$sql = "SELECT cxid,cxtitle,cxvalue,cxorder FROM $table_cx WHERE cxid='$cxid'" ;
	$rs = $xoopsDB->query( $sql ) ;
	$cx_array = $xoopsDB->fetchArray( $rs ) ;
	display_edit_form( $cx_array , _AM_XCSEARCH_EDIT , 'update' ) ;

} elseif( $op == 'new' ) {

	// New
	$cx_array = array( 'cxid' => 0 , 'cxvalue' => '' , 'cxtitle' => '' , 'cxorder' => 0 ) ;
	display_edit_form( $cx_array , _AM_XCSEARCH_ADD_NEW , 'insert' ) ;

} else {

	// NEW link
	echo "<br /><a href='?op=new&cxid=0'>". _AM_XCSEARCH_ADD_NEW ."</a><br /><br />\n";


	echo "
	<form name='MainForm' action='' method='post'>
	".$xoopsGTicket->getTicketHtml( __LINE__ )."
	<input type='hidden' name='delcat' value='' />
	<table width='75%' class='outer' cellpadding='4' cellspacing='1'>
	  <tr align='center' valign='middle'>
	    <th>ID</th>
	    <th>". _AM_XCSEARCH_CXTITLE ."</th>
	    <th>". _AM_XCSEARCH_CXVALUE ."</th>
	    <th>". _AM_XCSEARCH_CXORDER ."</th>
	    <th>". _EDIT ."</th>
	    <th>". _DELETE ."</th>
	  </tr>
	" ;

	$rs = $xoopsDB->query( "SELECT * FROM $table_cx ORDER BY cxorder ASC , cxid ASC" ) ;

	$oddeven = 'odd' ;
	while( $cx = $xoopsDB->fetchArray($rs) ) {
		$oddeven = ($oddeven == 'odd') ? 'even' : 'odd' ;
		$cxid = $cx['cxid'];
		$cxtitle = $myts->htmlSpecialChars($cx['cxtitle']);
		$cxvalue = $myts->htmlSpecialChars($cx['cxvalue']);
		$del_confirm = 'confirm("' . sprintf( _AM_XCSEARCH_DELCONFIRM , $cxtitle , $cxvalue ) . '")' ;
		echo "
		  <tr class='$oddeven'>
		    <td>$cxid</td>
		    <td>$cxtitle</td>
		    <td>$cxvalue</td>
		    <td>".$cx['cxorder']."</td>
		    <td><a href='?op=edit&cxid=". $cxid ."'>". _EDIT ."</a></td>
		    <td><input type='button' value='"._DELETE."' onclick='if($del_confirm){document.MainForm.delcat.value=\"$cxid\"; submit();}' /></td>
		  </tr>\n" ;
	}
	echo "</table></form><br /><br />" ;

}

xoops_cp_footer();
/* ------------------------------------------------------------------ */

?>