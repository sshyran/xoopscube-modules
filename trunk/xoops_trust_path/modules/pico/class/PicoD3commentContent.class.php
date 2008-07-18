<?php

// a class for d3forum comment integration
class PicoD3commentContent extends D3commentAbstract {

function fetchSummary( $external_link_id )
{
	include_once dirname(dirname(__FILE__)).'/include/common_functions.php' ;

	$db =& Database::getInstance() ;
	$myts =& MyTextsanitizer::getInstance() ;

	$module_handler =& xoops_gethandler( 'module' ) ;
	$module =& $module_handler->getByDirname( $this->mydirname ) ;
	$config_handler =& xoops_gethandler('config');
	$configs = $config_handler->getConfigList( $module->mid() ) ;

	$content_id = intval( $external_link_id ) ;
	$mydirname = $this->mydirname ;
	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	// query
	$content_row = $db->fetchArray( $db->query( "SELECT * FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=$content_id AND allow_comment AND visible AND created_time <= UNIX_TIMESTAMP() AND approval" ) ) ;
	if( empty( $content_row ) ) return '' ;

	// dare to convert it irregularly
	$summary = str_replace( '&amp;' , '&' , htmlspecialchars( xoops_substr( strip_tags( $content_row['body_cached'] ) , 0 , 255 ) , ENT_QUOTES ) ) ;

	return array(
		'dirname' => $mydirname ,
		'module_name' => $module->getVar( 'name' ) ,
		'subject' => $myts->makeTboxData4Show( $content_row['subject'] ) ,
		'uri' => XOOPS_URL.'/modules/'.$mydirname.'/'.pico_common_make_content_link4html( $configs , $content_row ) ,
		'summary' => $summary ,
	) ;
}


function validate_id( $link_id )
{
	$content_id = intval( $link_id ) ;
	$mydirname = $this->mydirname ;

	$db =& Database::getInstance() ;
	
	list( $count ) = $db->fetchRow( $db->query( "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=$content_id AND allow_comment AND visible AND created_time <= UNIX_TIMESTAMP() AND approval" ) ) ;
	if( $count <= 0 ) return false ;
	else return $content_id ;
}


function onUpdate( $mode , $link_id , $forum_id , $topic_id , $post_id = 0 )
{
	$content_id = intval( $link_id ) ;
	$mydirname = $this->mydirname ;

	$db =& Database::getInstance() ;

	list( $count ) = $db->fetchRow( $db->query( "SELECT COUNT(*) FROM ".$db->prefix($this->d3forum_dirname."_posts")." p LEFT JOIN ".$db->prefix($this->d3forum_dirname."_topics")." t ON t.topic_id=p.topic_id WHERE t.forum_id=$forum_id AND t.topic_external_link_id='$content_id'" ) ) ;
	$db->queryF( "UPDATE ".$db->prefix($mydirname."_contents")." SET comments_count=$count WHERE content_id=$content_id" ) ;

	return true ;
}


}

?>