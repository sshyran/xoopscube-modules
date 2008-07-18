<?php

// subcategory loop
$subcategories4assign = array() ;
$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_categories")." c WHERE $whr_read4cat AND c.pid=$cat_id ORDER BY cat_weight" ;
if( ! $srs = $xoopsDB->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
while( $subcat_row = $xoopsDB->fetchArray( $srs ) ) {

	$subcat_id = intval( $subcat_row['cat_id'] ) ;
	$subcat_isadminormod = ! empty( $category_permissions[ $subcat_id ]['is_moderator'] ) || $isadmin ;
	$subcategories4assign[] = array(
		'id' => intval( $subcat_row['cat_id'] ) ,
		'link' => pico_common_make_category_link4html( $xoopsModuleConfig , $subcat_row ) ,
		'pid' => $subcat_row['pid'] ,
		'title' => $myts->makeTboxData4Show( $subcat_row['cat_title'] ) ,
		'desc' => $myts->displayTarea( $subcat_row['cat_desc'] , 1 ) ,
		'isadminormod' => $subcat_isadminormod ,
		'can_post' => ( $subcat_isadminormod || @$category_permissions[ $subcat_id ]['can_post'] ) ,
		'can_edit' => ( $subcat_isadminormod || @$category_permissions[ $subcat_id ]['can_edit'] ) ,
		'can_delete' => ( $subcat_isadminormod || @$category_permissions[ $subcat_id ]['can_delete'] ) ,
		'can_makesubcategory' => ( $subcat_isadminormod || @$category_permissions[ $subcat_id ]['can_makesubcategory'] ) ,
		'paths_raw' => @unserialize( $subcat_row['cat_path_in_tree'] ) ,
		'redundants' => @unserialize( $subcat_row['cat_redundants'] ) ,
	) ;

}

?>