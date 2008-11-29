<?php
function ma_get_sub_categories( $parent_id , $cattree )
{
	global $xoopsDB , $table_cat , $table_items ;
	$myts =& MyTextSanitizer::getInstance() ;

	$ret = array() ;

	$crs = $xoopsDB->query( "SELECT cid, pid, ctitle, corder FROM $table_cat WHERE pid=$parent_id ORDER BY corder") or die( "Error: Get Category." ) ;

	while( list( $cid , $pid , $ctitle, $corder ) = $xoopsDB->fetchRow( $crs ) ) {
		// Show first child of this category
		$subcat = array() ;
		$arr = $cattree->getFirstChild( $cid , "corder" ) ;
		foreach( $arr as $child ) {
			$subcat[] = array(
				'cid' => $child['cid'] ,
				'title' => $myts->makeTboxData4Show( $child['ctitle'] ) ,
				'photo_small_sum' => ma_get_item_small_sum_from_cat( $child['cid'] , "stats>0" ) ,
				'number_of_subcat' => sizeof( $cattree->getFirstChildId( $child['cid'] ) )
			) ;
		}

		// Total sum of photos
		$cids = $cattree->getAllChildId( $cid ) ;
		array_push( $cids , $cid ) ;
		$photo_total_sum = ma_get_item_total_sum_from_cats( $cids , "stats>0" ) ;

		$ret[] = array(
			'cid' => $cid ,
			//'imgurl' => $myts->makeTboxData4Edit( $imgurl ) ,
			'photo_small_sum' => ma_get_item_small_sum_from_cat( $cid , "stats>0" ) ,
			'photo_total_sum' => $photo_total_sum ,
			'title' => $myts->makeTboxData4Show( $ctitle ) ,
			'subcategories' => $subcat
		) ;
	}

	//カテゴリーなし
	if( $parent_id == 0 ){
		$rs = $xoopsDB->query( "SELECT count(*) FROM $table_items WHERE cid=0 AND stats>0") or die( "Error: Get cid 0" ) ;
		list( $num_cat0 ) = $xoopsDB->fetchRow( $rs );
		if( $num_cat0 > 0 ){
			$ret[] = array(
				'cid' => 0 ,
				'photo_small_sum' => $num_cat0 ,
				'photo_total_sum' => '' ,
				'title' => _MD_MINIAMAZON_CAT . _MD_MINIAMAZON_NOCID 
			) ;
		}
	}
	
	return $ret ;
}

function ma_get_cat_options( $order = 'corder' , $preset = 99999 , $prefix = '--' , $none = null )
{
	global $xoopsDB ,$table_cat, $table_items;
	$myts =& MyTextSanitizer::getInstance() ;

	$cats[0] = array( 'cid' => 0 , 'pid' => -1 , 'next_key' => -1 , 'depth' => 0 , 'title' => '' , 'num' => 0 ) ;

	$rs = $xoopsDB->query( "SELECT c.ctitle,c.cid,c.pid,COUNT(p.lid) AS num FROM $table_cat c LEFT JOIN $table_items p ON c.cid=p.cid GROUP BY c.cid ORDER BY c.pid DESC, c.$order DESC, c.cid DESC" ) ;//ORDER BY pid ASC,$order DESC

	$key = 1 ;
	while( list( $title , $cid , $pid , $num ) = $xoopsDB->fetchRow( $rs ) ) {
		$cats[ $key ] = array( 'cid' => intval( $cid ) , 'pid' => intval( $pid ) , 'next_key' => $key + 1 , 'depth' => 0 , 'title' => $myts->makeTboxData4Show( $title ) , 'num' => intval( $num ) ) ;
		$key ++ ;
	}
	$sizeofcats = $key ;

	$loop_check_for_key = 1024 ;
	for( $key = 1 ; $key < $sizeofcats ; $key ++ ) {
		$cat =& $cats[ $key ] ;
		$target =& $cats[ 0 ] ;
		if( -- $loop_check_for_key < 0 ) $loop_check = -1 ;
		else $loop_check = 4096 ;

		while( 1 ) {
			if( $cat['pid'] == $target['cid'] ) {
				$cat['depth'] = $target['depth'] + 1 ;
				$cat['next_key'] = $target['next_key'] ;
				$target['next_key'] = $key ;
				break ;
			} else if( -- $loop_check < 0 ) {
				$cat['depth'] = 1 ;
				$cat['next_key'] = $target['next_key'] ;
				$target['next_key'] = $key ;
				break ;
			} else if( $target['next_key'] < 0 ) {
				$cat_backup = $cat ;
				array_splice( $cats , $key , 1 ) ;
				array_push( $cats , $cat_backup ) ;
				-- $key ;
				break ;
			}
			$target =& $cats[ $target['next_key'] ] ;
		}
	}

	if( isset( $none ) ) $ret = "<option value=''>$none</option>\n" ;
	else $ret = '' ;
	$cat =& $cats[ 0 ]  ;
	for( $weight = 1 ; $weight < $sizeofcats ; $weight ++ ) {
		$cat =& $cats[ $cat['next_key'] ] ;
		$pref = str_repeat( $prefix , $cat['depth'] - 1 ) ;
		$selected = $preset == $cat['cid'] ? "selected='selected'" : '' ;
		$ret .= "<option value='{$cat['cid']}' $selected>$pref {$cat['title']} ({$cat['num']})</option>\n" ;
	}
	
	//カテゴリーなし
	$rs = $xoopsDB->query( "SELECT count(*) FROM $table_items WHERE cid=0 AND stats>0") or die( "Error: Get cid 0" ) ;
	list( $num_cat0 ) = $xoopsDB->fetchRow( $rs );
	if( $num_cat0 > 0 ){
		$selected =  ( $preset == 0 ) ? "selected='selected'" : '' ;
		$ret .= "<option value='0' $selected>". _MD_MINIAMAZON_CAT . _MD_MINIAMAZON_NOCID ." ($num_cat0)</option>\n" ;
	}

	return $ret ;
}

function ma_get_item_total_sum_from_cats( $cids , $whr_append = "" )
{
	global $xoopsDB , $table_items ;

	if( $whr_append ) $whr_append = "AND ($whr_append)" ;

	$whr = "cid IN (" ;
	foreach( $cids as $cid ) {
		$whr .= "$cid," ;
	}
	$whr = substr_replace( $whr , "" , -1 );
	$whr = "$whr)" ;

	$sql = "SELECT COUNT(lid) FROM $table_items WHERE $whr $whr_append" ;
	$rs = $xoopsDB->query( $sql ) ;
	list( $numrows ) = $xoopsDB->fetchRow( $rs ) ;

	return $numrows ;
}

function ma_get_item_small_sum_from_cat( $cid , $whr_append = "" )
{
	global $xoopsDB , $table_items ;

	if( $whr_append ) $whr_append = "AND ($whr_append)" ;

	$sql = "SELECT COUNT(lid) FROM $table_items WHERE cid=$cid $whr_append" ;
	$rs = $xoopsDB->query( $sql ) ;
	list( $numrows ) = $xoopsDB->fetchRow( $rs ) ;

	return $numrows ;
}


function maCodeDecode($text){
	$patterns[] = "/javascript:/si";
	$replacements[] = "java script:";
	$patterns[] = "/about:/si";
	$replacements[] = "about :";
	$ret = preg_replace($patterns, $replacements, $text);
	return $ret;
}

function check_Image_URL( $url )
{
	$flag = FALSE ;
	if( !empty($url) && preg_match("/^http[s]{0,1}:\/\//i",$url) ){
		include_once XOOPS_ROOT_PATH . '/class/snoopy.php' ;
		$snoopy = New Snoopy ;
		@$snoopy->fetch($url) ;
		if( @$snoopy->response_code ){
			$res = explode( ' ' , $snoopy->response_code ) ;
		}
		if( isset($res[1]) ) $statusCode = intval($res[1]) ;
		if ($statusCode == 200) {
			$flag = TRUE ;
		}
	}
	return $flag ;
}

?>