<?php


eval( '
function '. $mydirname .'_search( $keywords , $andor , $limit , $offset , $userid )
{
	return miniamazonD3_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}
' ) ;

if( ! function_exists( 'miniamazonD3_search_base' ) ) {

  function miniamazonD3_search_base( $mydirname , $keywords , $andor , $limit , $offset , $userid )
  {
	global $xoopsDB ;
	$table_items = $xoopsDB->prefix( $mydirname."_items" ) ;

	// XOOPS Search module
	$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$select4con = $showcontext ? ",l.description" : "" ;

	$sql = "SELECT l.lid,l.uid,l.title,l.regdate,l.Creator,l.Manufacturer $select4con FROM $table_items l LEFT JOIN ".$xoopsDB->prefix("users")." u ON l.uid=u.uid WHERE l.stats>0" ;

	if( $userid > 0 ) {
		$sql .= " AND l.uid=".$userid." ";
	}

	$whr = "" ;
	if( is_array( $keywords ) && count( $keywords ) > 0 ) {
		$whr = "AND (" ;
		switch( strtolower( $andor ) ) {
			case "and" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(l.title,' ',l.Creator,' ',l.Manufacturer,' ',l.description,' ',IFNULL(u.uname,'')) LIKE '%$keyword%' AND " ;
				}
				$whr = substr( $whr , 0 , -5 ) ;
				break ;
			case "or" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(l.title,' ',l.Creator,' ',l.Manufacturer,' ',l.description,' ',IFNULL(u.uname,'')) LIKE '%$keyword%' OR " ;
				}
				$whr = substr( $whr , 0 , -4 ) ;
				break ;
			default :
				$whr .= "CONCAT(l.title,'  ',l.Creator,' ',l.Manufacturer,' ',l.description,' ',IFNULL(u.uname,'')) LIKE '%{$keywords[0]}%'" ;
				break ;
		}
		$whr .= ")" ;
	}

	$sql = "$sql $whr ORDER BY regdate DESC";
	$result = $xoopsDB->query( $sql , $limit , $offset ) ;
	$ret = array() ;
	$context = '' ;
	$myts = & MyTextSanitizer :: getInstance();
	while( $myrow = $xoopsDB->fetchArray($result) ) {
		// get context for module "search"
		if( function_exists( 'search_make_context' ) && $showcontext ) {
			$full_context = strip_tags( $myts->displayTarea( $myrow['description'] , 0 , 1 , 1 , 1 , 1 ) ) ;
			if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
			$context = search_make_context( $full_context , $keywords ) ;
		}

		$ret[] = array(
			"image"   => "images/ma_dot.gif" ,
			"link"    => "index.php?lid=".$myrow["lid"] ,	//act=item&amp;
			"title"   => htmlspecialchars($myrow["title"],ENT_QUOTES) ,
			"time"    => $myrow["regdate"] ,
			"uid"     => $myrow["uid"] ,
			"context" => $context
		) ;
	}
	return $ret;
  }

}

?>