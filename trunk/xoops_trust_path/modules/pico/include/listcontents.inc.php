<?php

// auto-register
if( ! empty( $xoopsModuleConfig['wraps_auto_register'] ) && is_array( @$category4assign ) ) {
	require_once dirname(__FILE__).'/transact_functions.php' ;
	pico_auto_register_from_cat_vpath( $mydirname , $category4assign ) ;
}

// visible check
$whr4visible = $isadminormod ? '1' : 'o.visible' ;

// contents loop
$contents4assign = array() ;
$sql = "SELECT o.content_id FROM ".$xoopsDB->prefix($mydirname."_contents")." o WHERE o.cat_id=$cat_id AND ($whr4visible) AND o.created_time <= UNIX_TIMESTAMP()  ORDER BY o.weight,o.content_id" ;
if( ! $ors = $xoopsDB->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
while( list( $content_id ) = $xoopsDB->fetchRow( $ors ) ) {
	$contents4assign[] = pico_common_get_content4assign( $mydirname , $content_id , $xoopsModuleConfig , $category4assign , false ) ;
}

?>