<?php
/*
 * $Id: comment_functions.php 319 2008-03-02 14:34:46Z hodaka $
 */

eval( '
function '.$mydirname.'_com_update( $bid, $total_num )
{
    return d3blog_com_update_base( "'.$mydirname.'" , $bid , $total_num ) ;
}
' ) ;

if( ! function_exists( 'd3blog_com_update_base' ) ) {
    function d3blog_com_update_base($mydirname, $bid, $total_num){
        $db =& Database::getInstance();
        $sql = "UPDATE ".$db->prefix($mydirname.'_entry')." SET comments = ".intval($total_num)." WHERE bid = ".intval($bid);
        $db->query($sql);
    }
}

eval( '
function '.$mydirname.'_com_approve( &$comment )
{
    return d3blog_com_approve_base( "'.$mydirname.'" , $comment ) ;
}
' ) ;

if( ! function_exists( 'd3blog_com_approve_base' ) ) {
    function d3blog_com_approve_base($mydirname, &$comment){
        // send notification mail
    }
}
?>