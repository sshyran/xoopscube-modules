<?php

if(! defined('D3IMGTAG_COMMENT_FUNCTIONS_INCLUDED')) {

define('D3IMGTAG_COMMENT_FUNCTIONS_INCLUDED' , 1);

// comment callback functions

eval( '
function '.$mydirname.'_comments_update( $lid, $total_num ){
    return d3imgtag_comments_update_base( "'.$mydirname.'" , $lid , $total_num ) ;
}
' ) ;

if( ! function_exists( 'd3imgtag_comments_update_base' ) ) {

	function d3imgtag_comments_update_base($mydirname, $lid , $total_num ) {
		$xoopsDB =& Database::getInstance();

		$ret = $xoopsDB->query( "UPDATE ".$xoopsDB->prefix($mydirname.'_photos')." SET comments=$total_num WHERE lid=$lid" ) ;
		return $ret ;
	}

}

eval( '
function '.$mydirname.'_comments_approve( &$comment ){
    return d3imgtag_comments_approve_base( "'.$mydirname.'" , &$comment ) ;
}
' ) ;

if( ! function_exists( 'd3imgtag_comments_approve_base' ) ) {

    function d3imgtag_comments_approve_base($mydirname, &$comment){
    	// notification mail here
    }

}

}

?>