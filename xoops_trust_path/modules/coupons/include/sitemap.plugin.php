<?php

if( !function_exists('b_sitemap_coupons') )
{

  function b_sitemap_coupons( $mydirname )
  {
	$db =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();
	$ret = array();

	require_once dirname(dirname(__FILE__)).'/class/categories.class.php' ;
	//$categories =& couponsCategoriesClass::getInstance( $db->prefix($mydirname."_cat") ) ;
	$categories = new couponsCategoriesClass( $db->prefix($mydirname."_cat") ) ;
	$firstCids = $categories->getFirstChild(0,"corder,cid");

	foreach( $firstCids as $cat ){
		$ret["parent"][] = array(
			"id"    => intval( $cat['cid'] ) ,
			"title" => $myts->makeTboxData4Show( $cat['title'] ) ,
			"url"   => "index.php?cid=".intval( $cat['cid'] ) ,
		) ;
	}

	return $ret;
  }

}
?>