<?php

eval( '

function '.$mydirname.'_new( $limit=0, $offset=0 )
{
	return d3downloads_whatsnew_base( "'.$mydirname.'", "'.$category_option.'", $limit, $offset, $rss=0 ) ;
}

' ) ;
// --- eval end ---

// === d3downloads_whatsnew_base begin ===
if ( ! function_exists('d3downloads_whatsnew_base') ) {
	function d3downloads_whatsnew_base( $mydirname, $category_option, $limit=0, $offset=0, $rss=0 )
	{
		require_once dirname( dirname(__FILE__) ).'/class/user_access.php';
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$permit = false ;
		if( empty( $rss ) ) $permit = d3downloads_whatsnew_get_permit( $mydirname );
		$user_access = new user_access( $mydirname ) ;
		$whr_cat = "d.cid IN (".implode(",", $user_access->can_read( $permit ) ).")" ;
		$categories = trim( @$category_option ) === '' ? array() : array_map( 'intval' , explode( ',' , $category_option ) ) ;
		// categories
		if( $categories === array() ) {
			$whr_categories = '1' ;
		} else {
			$whr_categories = 'd.cid IN ('.implode(',',$categories).')' ;
		}

		$columns = 'd.'.implode( ',d.' , array_diff( $GLOBALS['d3download_tables']['downloads'] , array( 'mail' , 'visible' , 'kanrisya' ) ) ) ;
		$columns .= ', c.title AS category';
		$sql = "SELECT $columns FROM ".$db->prefix( $mydirname."_downloads" )." d LEFT JOIN ".$db->prefix( $mydirname."_cat" )." c ON d.cid=c.cid WHERE d.visible = '1' AND ( $whr_cat ) AND ( $whr_categories ) ORDER BY d.date DESC";
		$result = $db->query( $sql, $limit, $offset );

		$URL_MOD = XOOPS_URL."/modules/".$mydirname;

		$i = 0;
		$ret = array();

		while( $array = $db->fetchArray( $result ) )
		{
			foreach ( $array as $key=>$value ){
				$$key = $value;
			}
			$id     = intval( $lid );
			$catid  = intval( $cid );
			$ret[$i]['link'] = $URL_MOD."/index.php?page=singlefile&amp;cid=".$catid."&amp;lid=".$id;
			$ret[$i]['cat_link'] = $URL_MOD."/index.php?cid=".$catid;
			$ret[$i]['title'] = $myts->makeTboxData4Show( $title );
			$ret[$i]['cat_name'] = $myts->makeTboxData4Show( $category );
			$ret[$i]['time'] = intval( $date );
			$ret[$i]['uid'] = intval( $submitter );
			$ret[$i]['hits'] = intval( $hits );
			$ret[$i]['id'] = $id;
			$ret[$i]['cid'] = $catid;
// replies
			$ret[$i]['replies'] = intval( $comments );

// description
			$html = intval( $html );
			$smiley = intval( $smiley );
			$xcode = intval( $xcode );
			$br = intval( $br );
			$body = $myts->displayTarea( $description , $html, $smiley, $xcode, 1, $br ) ;
			$ret[$i]['description'] = d3downloads_whatsnew_return_body( $body , 1 );
			$i++;
		}
		return $ret;
	}
// --- d3downloads_whatsnew_base end ---
}

// === d3downloads_whatsnew_get_permit begin ===
if ( ! function_exists('d3downloads_whatsnew_get_permit') ) {
	function d3downloads_whatsnew_get_permit( $mydirname )
	{
		global $xoopsUser ;

		if( is_object( $xoopsUser ) ) {
			return false;
		} else {
			$groups = intval( XOOPS_GROUP_ANONYMOUS );

			$db =& Database::getInstance() ;

			$module_handler =& xoops_gethandler('module');
			$module =& $module_handler->getByDirname( $mydirname );
			$mid = intval( $module->getVar('mid') );
			$moduleperm_handler =& xoops_gethandler('groupperm');
			$whatsnewdir = 'whatsnew';
			if ( $moduleperm_handler->checkRight('module_read', $mid, $groups) ){
				return false ;
			} elseif( XOOPS_ROOT_PATH.'/modules/'.$whatsnewdir ) {
				$whatsnewmodule =& $module_handler->getByDirname( $whatsnewdir );
				$whatsnewver = intval( $whatsnewmodule->getVar('version'));
				if ( $whatsnewver >= 240 ){
					$permit_result = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $whatsnewdir."_module" )." WHERE mid = $mid AND permit = 1" );
					list( $permit ) = $db->fetchRow( $permit_result );
				}
				if ( ! empty( $permit ) ){
					return true ;
				} else {
					return false;
				}
			}
		}
	}
// --- d3downloads_whatsnew_get_permit end ---
}

// === d3downloads_whatsnew_return_body begin ===
if ( ! function_exists('d3downloads_whatsnew_return_body') ) {
	function d3downloads_whatsnew_return_body( $body, $single )
	{
		if ( empty( $single ) ){
			if ( strstr ( $body , '[pagebreak]' ) ){
				$str = explode( '[pagebreak]', $body , 2 ) ;
				$body = $str[0];
			}
		} else {
			if ( strstr ( $body , '[pagebreak]' ) ){
				$body = str_replace( '[pagebreak]','', $body  ) ;
			}
		}
		return $body;
	}
// --- d3downloads_whatsnew_return_body end ---
}

?>