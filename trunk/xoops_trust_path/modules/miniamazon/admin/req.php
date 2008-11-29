<?php
$mod_url = XOOPS_URL . "/modules/$mydirname" ;

include 'adminheader.php';
include 'funcs.php';
include_once $mytrustdirpath."/include/gtickets.php";
include_once $mytrustdirpath."/class/amazon.php";
include_once $mytrustdirpath."/include/xml.php";

$myts =& MyTextSanitizer::getInstance();

$table_items = $xoopsDB->prefix( $mydirname."_items" ) ;

$num = 20;	//1“x‚ÉÄ–â‡‚¹‚·‚é”

//‘SŒ”
$rs = $xoopsDB->query( "SELECT * FROM $table_items WHERE stats>0" ) ;
$item_num_total = $xoopsDB->getRowsNum( $rs ) ;



$num_page = ceil( $item_num_total / $num );

$page = ( empty($_POST['page']) ) ? 0 : intval($_POST['page']) ;

//Ä–â‡‚¹ˆ—
$amazon = new miniAmazon( $xoopsModuleConfig['associate_id'] );
$sql='';
if( isset($_POST['XOOPS_G_TICKET']) ){
	if ( ! $xoopsGTicket->check() ) {	// Ticket Check
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	if( $page > 0 ){
		$pos = ( $page - 1 ) * $num ;
		$sql = "SELECT lid, ASIN, title, Creator, Manufacturer, ProductGroup, MediumImage , DetailPageURL, IsAdult FROM $table_items WHERE stats>0";
		$result = $xoopsDB->query( $sql , $num , $pos ) ;
	}elseif( isset($_POST['noimgall']) ){
		$sql = "SELECT lid, ASIN, title, Creator, Manufacturer, ProductGroup, MediumImage , DetailPageURL, IsAdult FROM $table_items WHERE MediumImage=''";
		$result = $xoopsDB->query( $sql ) ;
	}elseif( isset($_POST['reqimgno']) ){
		$sql = "SELECT lid, ASIN, title, Creator, Manufacturer, ProductGroup, MediumImage , DetailPageURL, IsAdult FROM $table_items WHERE lid=". intval($_POST['reqimgno']);
		$result = $xoopsDB->query( $sql ) ;
	}
}
if( isset($result) ){
	$req_num = $xoopsDB->getRowsNum( $result ) ;
	$update_num = 0;

	while( $row = $xoopsDB->fetchArray( $result ) ){
		list( $error, $title, $creator, $manufacturer, $img_m, $pgroup, $dpURL, $isadult ) = $amazon->query($row['ASIN']);
		if( $error ) continue;
		$setSQL = array();
		if( $row['title'] != $title ) $setSQL[] = "title='". addslashes($title) ."'";
		if( $row['Creator'] != $creator ) $setSQL[] = "Creator='". addslashes($creator) ."'";
		if( $row['Manufacturer'] != $manufacturer ) $setSQL[] = "Manufacturer='". addslashes($manufacturer) ."'";
		if( $row['ProductGroup'] != $pgroup ) $setSQL[] = "ProductGroup='". addslashes($pgroup) ."'";
		if( $row['MediumImage'] != $img_m ) $setSQL[] = "MediumImage='". addslashes($img_m) ."'";
		if( $row['DetailPageURL'] != $dpURL ) $setSQL[] = "DetailPageURL='". addslashes($dpURL) ."'";
		if( intval($row['IsAdult']) !== intval($isadult) ) $setSQL[] = "IsAdult='". intval($isadult) ."'";
		if( count($setSQL) > 0 ){
			$setdatas = "";
			foreach( $setSQL as $setdata ){
				$setdatas .= $setdata .",";
			}
			$setdatas = substr_replace( $setdatas , "" , -1 , 1 );
			$upsql = "UPDATE $table_items SET $setdatas WHERE lid=".$row['lid'];
			$xoopsDB->query($upsql);
			$update_num++;
		}
		sleep(1);
	}
	$redirect_msg = sprintf( _MD_A_MINIAMAZON_RQ_UPDATE, $req_num , $update_num );
	redirect_header( $mod_url.'/admin/?act=req' , 3 , $redirect_msg );
}

//NO IMAGES
$rs = $xoopsDB->query( "SELECT * FROM $table_items WHERE MediumImage=''" ) ;
$noimg_num = $xoopsDB->getRowsNum( $rs ) ;
$noimgtext = '';
if( $noimg_num > 0 ){
	$noimgtext  = "<form action='' method='post'>\n" ;
	$noimgtext .= "<input type='submit' name='noimgall' value='". _MD_A_MINIAMAZON_RQ_ALL ."'>\n";
	$noimgtext .= "<table class='outer' cellpadding='4' cellspacing='1'>\n";
	$noimgtext .= "<tr><th>". _MD_A_MINIAMAZON_ST_ID ."</th><th>". _MD_A_MINIAMAZON_ST_TITLE ."</th><th>". _MD_A_MINIAMAZON_RQ_ONE ."</th></tr>\n";
	$oddeven = 'odd' ;
	while( $row = $xoopsDB->fetchArray( $rs ) ){
		$noimgtext .= "<tr class='". $oddeven ."'>" ;
		$noimgtext .= "<td>". $row['lid'] ."</td>";
		$noimgtext .= "<td><a href='$mod_url/?lid=". $row['lid'] ."' target='_blank'>". $row['title'] ."</a></td>";
		$noimgtext .= "<td><input type='submit' name='reqimgno' value='". $row['lid'] ."'></td>";
		$noimgtext .= "</tr>\n" ;
		$oddeven = ($oddeven=='odd') ? 'even' : 'odd' ;
	}
	$noimgtext .= $xoopsGTicket->getTicketHtml( __LINE__ );
	$noimgtext .= "\n</form></table>\n" ;
}

/* ------------------------------------------------------------------ */
xoops_cp_header() ;
include 'mymenu.php';

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( "$mod_url/" , 1 , _NOPERM ) ;
echo "<h3 style='text-align:left;'>".sprintf( _MD_A_MINIAMAZON_REQUERY_MANAGER , $xoopsModule->name() )."</h3>\n" ;

echo sprintf( _MD_A_MINIAMAZON_RQ_ALLTOTAL , $item_num_total );
echo "<br /><br />";

if( $item_num_total > 0 ){
	echo _MD_A_MINIAMAZON_RQ_REQUERY;
	if( !empty($noimgtext) ){
		echo "<hr style='border:0; border-top:1px dashed #999;height:1px; background:#fff;' />";
		echo "<h4>". _MD_A_MINIAMAZON_RQ_NOIMG ."</h4>\n" ;
		echo $noimgtext ;
	}
	echo "<hr style='border:0; border-top:1px dashed #999;height:1px; background:#fff;' />";
	echo "<h4>". _MD_A_MINIAMAZON_RQ_SPLIT ."</h4>\n" ;
	if( $num_page > 1 ){
		echo sprintf( _MD_A_MINIAMAZON_RQ_REQUERY3 , $item_num_total,$num,$num_page,$num );
	} else {
		echo sprintf( _MD_A_MINIAMAZON_RQ_REQUERY2 , $item_num_total,$item_num_total );
	}
		echo "<br /><br />\n";
		echo "<form action='' method='post'>\n";
		echo $xoopsGTicket->getTicketHtml( __LINE__ );
	for( $i=1; $i<=$num_page; $i++ ){
		echo "<input type='submit' name='page' value='$i'>\n";
		echo "&nbsp;";
	}
		echo "</form>";

	echo "<br /><br />";
}

xoops_cp_footer();
/* ------------------------------------------------------------------ */

?>