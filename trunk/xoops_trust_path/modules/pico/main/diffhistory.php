<?php

define( 'ALTSYS_DIR' , XOOPS_TRUST_PATH.'/libs/altsys' ) ;

if( ! file_exists( ALTSYS_DIR.'/include/Text_Diff.php' ) ) die( 'Install altsys' ) ;

require_once ALTSYS_DIR.'/include/Text_Diff.php' ;
require_once ALTSYS_DIR.'/include/Text_Diff_Renderer.php' ;
require_once ALTSYS_DIR.'/include/Text_Diff_Renderer_unified.php' ;
require_once ALTSYS_DIR.'/include/Text_Diff_Renderer_inline.php' ;
include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;
include dirname(dirname(__FILE__)).'/include/history_functions.php' ;

// get $content_history_id
$older_history_id = intval( @$_GET['older_history_id'] ) ;
$newer_history_id = intval( @$_GET['newer_history_id'] ) ;

// get $history_profile from the id
$older_profile = pico_get_content_history_profile( $mydirname , $older_history_id ) ;
if( empty( $newer_history_id ) ) {
	$newer_profile = pico_get_content_history_profile( $mydirname , 0 , intval( $older_profile[1] ) ) ;
} else {
	$newer_profile = pico_get_content_history_profile( $mydirname , $newer_history_id ) ;
}

// check each content_ids
if( $older_profile[1] != $newer_profile[1] ) die( 'Differenct content_ids each other' ) ;

list( $cat_id , $content_id , ) = $newer_profile ;

// get&check this category ($category4assign, $category_row), override options
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// special check for viewhistory
if( ! $category4assign['can_edit'] ) die( _MD_PICO_ERR_EDITCONTENT ) ;

// get diff
$diff_from_file4disp = '' ;
$diff =& new Text_Diff( explode("\n",$older_profile[2]) , explode("\n",$newer_profile[2]) ) ;
//$renderer =& new Text_Diff_Renderer_unified();
//$diff_str = htmlspecialchars( $renderer->render( $diff ) , ENT_QUOTES ) ;
$renderer =& new Text_Diff_Renderer_inline();
$diff_str = $renderer->render( $diff ) ;

echo '<html><meta http-equiv="Content-Type" content="text/html; charset='._CHARSET.'" /><head>'.pico_main_render_moduleheader( $mydirname , $xoopsModuleConfig ).'</head><body><pre class="pico_history_diff" id="'.$mydirname.'_history_diff">'.$diff_str.'</pre></body></html>' ;
exit ;

?>