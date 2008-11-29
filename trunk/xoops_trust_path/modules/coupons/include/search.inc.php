<?php
eval( '
function '. $mydirname .'_search( $keywords , $andor , $limit , $offset , $userid )
{
	return coupons_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}
' ) ;


if( ! function_exists( 'coupons_search_base' ) ) 
{

	function coupons_search_base( $mydirname, $queryarray, $andor, $limit, $offset, $userid){
		global $xoopsDB;
		$table_coupons = $xoopsDB->prefix($mydirname."_coupons") ;
		$table_text  = $xoopsDB->prefix($mydirname."_text") ;

		// XOOPS Search module
		$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
		$SELECT4CON = $LEFTJOIN = '' ;
		if( $showcontext == 1 ){
			$SELECT4CON = ",t.description";
			$LEFTJOIN = "LEFT JOIN $table_text t ON t.lid=l.lid";
		}

		$sql = "SELECT l.lid,l.title,l.uid,l.regidate $SELECT4CON FROM $table_coupons l $LEFTJOIN WHERE l.status>0 ";
		if ( $userid != 0 ) {
			$sql .= " AND l.uid=".$userid;
		}
		if ( is_array($queryarray) && $count = count($queryarray) ) {
			$sql .= " AND (( l.title LIKE '%".addslashes($queryarray[0])."%' ";
			if( $showcontext == 1 ){
				$sql .= " OR t.description LIKE '%".addslashes($queryarray[0])."%' ";
			}
			$sql .= " ) " ;
			for($i=1;$i<$count;$i++){
				$sql .= " $andor ";
				$sql .= "(l.title LIKE '%".addslashes($queryarray[$i])."%' ";
				if( $showcontext == 1 ){
					$sql .= " OR t.description LIKE '%".addslashes($queryarray[$i])."%' ";
				}
				$sql .= " ) " ;
			}
			$sql .= ") ";
		}
		$sql .= " ORDER BY l.regidate DESC";
		$result = $xoopsDB->query($sql,$limit,$offset);
		$ret = array();
		$i = 0;
	 	while($myrow = $xoopsDB->fetchArray($result)){
			// get context for module "search"
			if( function_exists( 'search_make_context' ) && $showcontext ) {
				$full_context = strip_tags( $myts->displayTarea( $myrow['description'] , 0 , 1 , 1 , 1 , 1 ) ) ;
				if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
				$context = search_make_context( $full_context , $keywords ) ;
				$ret[$i]['context'] = $context;
			}
			$ret[$i]['image']   = "images/coupon.png";
			$ret[$i]['link']    = "index.php?lid=".$myrow['lid']."";
			$ret[$i]['title']   = $myrow['title'];
			$ret[$i]['time']    = $myrow['regidate'];
			$ret[$i]['uid']     = $myrow['uid'];
			$i++;
		}
		return $ret;
	}

}
?>
