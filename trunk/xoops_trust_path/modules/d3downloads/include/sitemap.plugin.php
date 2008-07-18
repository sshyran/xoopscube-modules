<?php

if ( ! function_exists('b_sitemap_d3downloads') ) {
	function b_sitemap_d3downloads( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$ret = array() ;
		$i = 0 ;
		$category = array();
		$user_access = new user_access( $mydirname ) ;
		$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
		$crs = $db->query("SELECT cid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE ( $whr_cat ) AND pid='0' ORDER BY cat_weight ASC");
		while( list( $id, $name ) = $db->fetchRow( $crs ) ) {
			$cid = intval( $id );
			$ret['parent'][$i] = array(
				'title' => $myts->makeTboxData4Show( $name ) ,
				'url' => 'index.php?cid='.$cid  ,
				'image' => 1 ,
			) ;
			$ret['parent'][$i]['child'] = b_sitemap_d3downloads_child( $mydirname, $cid, $whr_cat );
			$i++ ;
		}
		return $ret ;
	}
}

if ( ! function_exists('b_sitemap_d3downloads_child') ) {
	function b_sitemap_d3downloads_child( $mydirname, $cid, $whr_cat )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
		$arr = $mytree->getChildTreeArray( $cid ,$whr_cat );
		$ret = array() ;
		foreach ( $arr as $child ) {
			$child_id = intval( $child['cid'] );
			$count = strlen( $child['prefix'] ) + 1;
			$ret[] = array(
				'title' => $myts->makeTboxData4Show( $child['title'] ) ,
				'url' => 'index.php?cid='.$child_id  ,
				'image' =>( ( $count > 3 ) ? 4 : $count ) ,
			) ;
		}
		return $ret ;
	}
}

?>