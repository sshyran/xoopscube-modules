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

//ERASE DATA
if( isset($_POST['erase']) && $_POST['erase']=='erase' ){
	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$cxid = isset($_POST['cxid']) ? intval($_POST['cxid']) : 0 ;
	$yearmonth = isset($_POST['yearmonth']) ? intval($_POST['yearmonth']) : 0 ;
	$year = intval( $yearmonth / 100 ) ;
	$mon = intval( $yearmonth - $year*100 ) ;
	//var_dump($cxid);
	//var_dump($year);
	//var_dump($mon);
    $sql = "DELETE FROM $table_rank WHERE cxid=$cxid AND year=$year AND month=$mon" ;
    $xoopsDB->query($sql) or die( "DB Error: DELETE keywordranking by cxid, year and month" );
}


/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;

echo "<h3 style='text-align:left;'>". $xoopsModule->name() .'&nbsp;:&nbsp;'. _MI_XCSEARCH_ADMENU2 ."</h3>\n" ;
echo "&raquo; <a href='keywords.php'>Daily Report</a><br /><br />";

if( $xoopsModuleConfig['xcsearch_rank'] ){
	echo '['. _MI_XCSEARCH_CONF_RANK_TITLE .'] <span style="color:#0000ff;">ON</span><br />';
} else {
	echo '['. _MI_XCSEARCH_CONF_RANK_TITLE .'] <span style="color:#FF0000;">OFF</span><br />';
}

$earse = '<input type="button" value="'. _AM_XCSEARCH_ALLERASE .'" onclick="if(confirm(\''. _AM_XCSEARCH_ERASECONFIRM .'\')){document.MainF.truncate.value=\'delete\'; submit();}" />';
echo '<form name="MainF" action="" method="post"><input type="hidden" name="truncate" value=""><br /><span style="color:#FF0000;">'. _AM_XCSEARCH_TRUNCATE .'</span>&nbsp;'. $earse . $xoopsGTicket->getTicketHtml( __LINE__ ) .'</form><br />';



$sql = "SELECT r.query, r.day, r.year, r.month, r.count, r.cxid, c.cxtitle FROM $table_rank r LEFT JOIN $table_cx c ON r.cxid=c.cxid ORDER BY r.cxid ASC, r.count DESC, r.day DESC";



$rs = $xoopsDB->query( $sql );

$total= $cxcx = array();
while( $cx = $xoopsDB->fetchArray($rs) ) {
	$cxid = $cx['cxid'];
    $ym = $cx['year']*100+$cx['month'];
    $total[$cxid][$ym][$cx['query']] = ( isset($total[$cxid][$ym][$cx['query']]) ) ? $total[$cxid][$ym][$cx['query']]+$cx['count'] : $cx['count'];
    $cxcx[$cxid] = $cx['cxtitle'] ;
}



foreach( $total as $key_cxid => $months ){
  echo "<div style='background-color:#666;color:#fff;font-size:150%;padding:3px;'>";
  echo empty($cxcx[$key_cxid]) ? '&nbsp;' : htmlspecialchars($cxcx[$key_cxid],ENT_QUOTES) ;
  echo "</div>" ;
  echo "<div style='padding-left:20px;'>";

  krsort($months);
  foreach( $months as $key_ym => $keywords ){
    echo "<div style='background-color:#999;color:#fff;font-size:130%;padding:3px;'>".intval($key_ym) ."</div>";
    echo "<div style='padding-left:20px;'>";

    //erase form
    echo "<form name='Form_{$key_cxid}_{$key_ym}' action='".XOOPS_URL."/modules/$mydirname/admin/keywords2.php' method='post'>";
    echo "<input type='hidden' name='cxid' value='". intval($key_cxid) ."'>";
    echo "<input type='hidden' name='yearmonth' value='". intval($key_ym) ."'>";
    echo "<input type='hidden' name='erase' value=''>";
    echo $xoopsGTicket->getTicketHtml( __LINE__ );
    echo "<input type='button' value='". _AM_XCSEARCH_ERASE ."' onclick='if(confirm(\"". htmlspecialchars($cxcx[$key_cxid],ENT_QUOTES)."[".intval($key_cxid)."] - ".intval($key_ym)."\\n". _AM_XCSEARCH_ERASECONFIRM2 ."\")){document.Form_{$key_cxid}_{$key_ym}.erase.value=\"erase\"; submit();}' />";
    echo "</form>";

    echo "<table class='outer' cellpadding='3' cellspacing='1' style='margin-bottom:6px;'><tr><th>KEYWORD</th><th>COUNT</th></tr>" ;
    $oddeven = 'odd' ;
    arsort($keywords);
    foreach( $keywords as $key_kw => $count ){
      $oddeven = ($oddeven == 'odd') ? 'even' : 'odd' ;
      echo "<tr class='$oddeven'><td>". htmlspecialchars($key_kw,ENT_QUOTES) ."</td>";
      echo "<td>". intval($count) ."</td></tr>";
    }
    echo "</table>" ;
    
    echo "</div>";
  }

  echo "</div>";
}

xoops_cp_footer();
/* ------------------------------------------------------------------ */

?>