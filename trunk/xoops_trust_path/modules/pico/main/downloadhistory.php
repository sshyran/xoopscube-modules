<?php

include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;
require_once dirname(dirname(__FILE__)).'/include/history_functions.php' ;

// get $content_history_id
$content_history_id = intval( @$_GET['content_history_id'] ) ;

// get $history_profile from the id
list( $cat_id , $content_id , $history_body ) = pico_get_content_history_profile( $mydirname , $content_history_id ) ;

// get&check this category ($category4assign, $category_row), override options
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// special check for viewhistory
if( ! $category4assign['can_edit'] ) die( _MD_PICO_ERR_EDITCONTENT ) ;

if( headers_sent() ) die( 'headers are already sent' ) ;

header( 'Content-Type: text/plain' ) ;
header( 'Content-Disposition: attachment; filename="content_history_'.sprintf('%010d',$content_history_id).'.txt"' ) ;

echo $history_body ;

exit ;

?>