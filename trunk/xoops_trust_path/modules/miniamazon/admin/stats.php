<?php

//$mytrustdirname = basename( dirname(dirname( __FILE__ )) ) ;
//$mytrustdirpath = dirname(dirname( __FILE__ )) ;

include 'adminheader.php';
$mod_url = XOOPS_URL . "/modules/$mydirname" ;

include 'funcs.php';
include_once $mytrustdirpath."/include/gtickets.php";

$table_items = $xoopsDB->prefix( $mydirname."_items" ) ;

$myts =& MyTextSanitizer::getInstance();



//DB èàóù
//çÌèú
if( isset($_POST['DELETE']) && $_POST['DELETE']>0 ){
	if ( ! $xoopsGTicket->check() ) {	// Ticket Check
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$lid = intval($_POST['DELETE']);

	$xoopsDB->query( "DELETE FROM $table_items WHERE lid='$lid'" ) or die( "DB error: DELETE item table" ) ;
	redirect_header( "index.php?act=stats" , 1 , _MD_A_MINIAMAZON_ST_DELETEOK ) ;
	exit();
}

//è≥îF
if( isset($_POST['ADMIT']) && $_POST['ADMIT']>0 ){
	if ( ! $xoopsGTicket->check() ) {	// Ticket Check
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$lid = intval($_POST['ADMIT']);

	$xoopsDB->query( "UPDATE $table_items SET stats='1' WHERE lid='$lid'" ) ;
	redirect_header( "index.php?act=stats" , 1 , _MD_A_MINIAMAZON_ST_ADMITOK ) ;
	exit();
}



/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;
echo "<h3 style='text-align:left;'>".sprintf( _MD_A_MINIAMAZON_ADMISSION_MANAGER , $xoopsModule->name() )."</h3>\n" ;



$rs = $xoopsDB->query( "SELECT * FROM $table_items WHERE stats=0" ) ;
$waiting = $xoopsDB->getRowsNum( $rs ) ;	//ñ¢è≥îFêî
echo sprintf( _MD_A_MINIAMAZON_ST_NEEDADMISSION , $waiting ) ."<br />";

if( $waiting > 0 ){
	echo "
	<form name='MainForm' action='' method='post'>
	".$xoopsGTicket->getTicketHtml( __LINE__ )."
	<table class='outer' cellpadding='4' cellspacing='1'>
	  <tr valign='middle'>
	    <th>". _MD_A_MINIAMAZON_ST_ID ."</th>
	    <th>". _MD_A_MINIAMAZON_ST_TITLE ."</th>
	    <th>". _MD_A_MINIAMAZON_ST_REGDATE ."</th>
	    <th>&nbsp;</th>
	    <th>". _MD_A_MINIAMAZON_ST_ADMISSION ."</th>
	    <th>". _MD_A_MINIAMAZON_ST_DELETE ."</th>
	  </tr>" ;

	$oddeven = 'odd' ;
	while( $row = $xoopsDB->fetchArray( $rs ) ) {
		$oddeven = $oddeven == 'odd' ? 'even' : 'odd' ;
		$lid = $row['lid'];
		$title = $myts->htmlSpecialChars($myts->stripSlashesGPC($row['title']));
		$regdate = date( 'Y-n-j H:i' , $row['regdate'] );

		echo "
		  <tr class='$oddeven'>
		    <td>$lid</td>
		    <td>$title</td>
		    <td>$regdate</td>
		    <td><a href='$mod_url/index.php?act=confirm&amp;lid=$lid' target='_blank'>"._MD_A_MINIAMAZON_ST_CONF."</a></td>
		    <td><input type='button' value='"._MD_A_MINIAMAZON_ST_ADMISSION."' style='background:#00C;color:#fff;' onclick='if(confirm(\""._MD_A_MINIAMAZON_ST_ADMITCONF."\")){document.MainForm.ADMIT.value=\"$lid\";  submit();}'></td>
		    <td><input type='button' value='"._MD_A_MINIAMAZON_ST_DELETE."' style='background:#C00;color:#fff;' onclick='if(confirm(\""._MD_A_MINIAMAZON_ST_DELETECONF."\")){document.MainForm.DELETE.value=\"$lid\";  submit();}'></td>
		  </tr>\n" ;
	}
	echo "<input type='hidden' name='ADMIT' value='' /><input type='hidden' name='DELETE' value='' />";
	echo "</table></form>" ;
}

xoops_cp_footer();
/* ------------------------------------------------------------------ */

?>