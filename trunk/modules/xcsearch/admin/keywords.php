<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */

include 'adminheader.php';

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
include_once XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php";

//DB table
$table_cx = $xoopsDB->prefix( "xcsearch_cx" ) ;
$table_rank = $xoopsDB->prefix( "xcsearch_rank" ) ;



//TRUNCATE TABLE
if( isset($_POST['truncate']) && $_POST['truncate']=='delete' ){
	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$sql = "TRUNCATE TABLE $table_rank";
	$xoopsDB->query( $sql ) or die( "DB Error: TRUNCATE TABLE " ) ;
}


$p = ( isset($_GET['p']) ) ? intval($_GET['p']): 1 ;	//page
$ken = 100; //per page
$offset = $ken * ($p-1);

//navigation
$sql = "SELECT COUNT(*) FROM $table_rank";
list( $count ) = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
$pages = ceil( $count / $ken );
$navi = "";
if( $pages > 1 ){
	for( $i = 1 ; $i <= $pages ; $i++ ){
		$color = ( $i == $p ) ? '#F9F' : '' ;
		$navi .= "<a href='keywords.php?p=$i' style='" ;
		if( $color != '' ) $navi .= "background-color:{$color};" ;
		$navi .= "padding:1px 2px;'>$i</a> | " ;
	}
}

/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;

echo "<h3 style='text-align:left;'>". $xoopsModule->name() .'&nbsp;:&nbsp;'. _MI_XCSEARCH_ADMENU2 ."</h3>\n" ;
echo "&raquo; <a href='keywords2.php'>Monthly Report</a><br /><br />";

if( $xoopsModuleConfig['xcsearch_rank'] ){
	echo '['. _MI_XCSEARCH_CONF_RANK_TITLE .'] <span style="color:#0000ff;">ON</span><br />';
} else {
	echo '['. _MI_XCSEARCH_CONF_RANK_TITLE .'] <span style="color:#FF0000;">OFF</span><br />';
}

$earse = '<input type="button" value="'. _AM_XCSEARCH_ALLERASE .'" onclick="if(confirm(\''. _AM_XCSEARCH_ERASECONFIRM .'\')){document.MainF.truncate.value=\'delete\'; submit();}" />';
echo '<form name="MainF" action="" method="post"><input type="hidden" name="truncate" value=""><br /><span style="color:#FF0000;">'. _AM_XCSEARCH_TRUNCATE .'</span>&nbsp;'. $earse . $xoopsGTicket->getTicketHtml( __LINE__ ) .'</form><br />';

echo $navi;
echo "<br /><br />";

echo "
<table class='outer' cellpadding='4' cellspacing='1'>
  <tr align='center' valign='middle'>
    <th>". "KEYWORD" ."</th>
    <th>". "DATE" ."</th>
    <th>". "YEAR" ."</th>
    <th>". "MONTH" ."</th>
    <th>". "COUNT" ."</th>
    <th>". "CX ID" ."</th>
    <th>". "CX TITLE" ."</th>
  </tr>
" ;

$sql = "SELECT r.query, r.day, r.year, r.month, r.count, r.cxid, c.cxtitle FROM $table_rank r LEFT JOIN $table_cx c ON r.cxid=c.cxid ORDER BY r.cxid ASC, r.count DESC, r.day DESC  LIMIT $ken OFFSET $offset";
//echo $sql;
$rs = $xoopsDB->query( $sql );

$total=array();
$oddeven = 'odd' ;
while( $cx = $xoopsDB->fetchArray($rs) ) {
	$oddeven = ($oddeven == 'odd') ? 'even' : 'odd' ;
	$query = htmlSpecialChars( $cx['query'], ENT_QUOTES );
	$day = date('Y-m-d',$cx['day']);
	$year = $cx['year'];
	$month = $cx['month'];
	$count = $cx['count'];
	$cxid = $cx['cxid'];
	$cxtitle = htmlSpecialChars( $cx['cxtitle'], ENT_QUOTES );

	echo "
	  <tr class='$oddeven'>
	    <td>$query</td>
	    <td>$day</td>
	    <td>$year</td>
	    <td>$month</td>
	    <td>$count</td>
	    <td>$cxid</td>
	    <td>$cxtitle</td>
	  </tr>\n" ;
}
echo "</table><br /><br />" ;

echo $navi;

xoops_cp_footer();
/* ------------------------------------------------------------------ */

?>