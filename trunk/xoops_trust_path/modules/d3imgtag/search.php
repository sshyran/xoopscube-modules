<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

eval( '
function '.$mydirname.'_global_search( $keywords , $andor , $limit , $offset , $userid )
{
	return d3imgtag_global_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}
' ) ;

if( ! function_exists( 'd3imgtag_global_search_base' ) ) {

function d3imgtag_global_search_base( $mydirname , $keywords , $andor , $limit , $offset , $userid )
{
	global $xoopsDB ;

	include XOOPS_TRUST_PATH."/modules/d3imgtag/include/read_configs.php" ;

	// XOOPS Search module
	$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$select4con = $showcontext ? "t.description" : "'' AS description" ;

	$sql = "SELECT l.lid,l.cid,l.title,l.submitter,l.date,$select4con FROM ".$xoopsDB->prefix($mydirname."_photos")." l LEFT JOIN ".$xoopsDB->prefix($mydirname."_text")." t ON t.lid=l.lid LEFT JOIN ".$xoopsDB->prefix("users")." u ON l.submitter=u.uid WHERE status>0" ;

	if( $userid > 0 ) {
		$sql .= " AND l.submitter=".$userid." ";
	}

	$whr = "" ;
	if( is_array( $keywords ) && count( $keywords ) > 0 ) {
		$whr = "AND (" ;
		switch( strtolower( $andor ) ) {
			case "and" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(l.title,' ',t.description,' ',IFNULL(u.uname,'')) LIKE '%$keyword%' AND " ;
				}
				$whr = substr( $whr , 0 , -5 ) ;
				break ;
			case "or" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(l.title,' ',t.description,' ',IFNULL(u.uname,'')) LIKE '%$keyword%' OR " ;
				}
				$whr = substr( $whr , 0 , -4 ) ;
				break ;
			default :
				$whr .= "CONCAT(l.title,'  ',t.description,' ',IFNULL(u.uname,'')) LIKE '%{$keywords[0]}%'" ;
				break ;
		}
		$whr .= ")" ;
	}

	$sql = "$sql $whr ORDER BY l.date DESC";
	$result = $xoopsDB->query( $sql , $limit , $offset ) ;
	$ret = array() ;
	$context = '' ;
	include_once XOOPS_TRUST_PATH."/modules/d3imgtag/class/d3imgtag.textsanitizer.php" ;
	$myts =& d3imgtagTextSanitizer::getInstance();
	while( $myrow = $xoopsDB->fetchArray($result) ) {

		// get context for module "search"
		if( function_exists( 'search_make_context' ) && $showcontext ) {
			$full_context = strip_tags( $myts->displayTarea( $myrow['description'] , 1 , 1 , 1 , 1 , 1 ) ) ;
			if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
			$context = search_make_context( $full_context , $keywords ) ;
		}

		$ret[] = array(
			"image" => "images/pict.png" ,
			"link" => "index.php?page=photo&lid=".$myrow["lid"] ,
			"title" => $myrow["title"] ,
			"time" => $myrow["date"] ,
			"uid" => $myrow["submitter"] ,
			"context" => $context
		) ;
	}
	return $ret;
}

}

?>