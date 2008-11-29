<?php
require_once dirname(dirname(__FILE__)) .'/include/functions.php' ;


// a class for d3forum comment integration
class maD3commentContent extends D3commentAbstract {

  function fetchSummary( $external_link_id )
  {
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
	$content_row = $db->fetchArray( $db->query( "SELECT * FROM ".$db->prefix($mydirname."_items")." WHERE lid=$content_id" ) ) ;

	$summary = $content_row['description'];
	$summary = strip_tags($myts->displayTarea( $summary , 0 , 0 , 1 , 1 , 0 ) );
	$summary = $myts->nl2Br($summary);
	$summary = preg_replace( '/(<br \/>){2,}/' , '<br />' , $summary ) ;
	if( function_exists('mb_strlen') && function_exists('mb_strcut') ){
		if( mb_strlen($summary) > 150 ) $summary = mb_strcut($summary,0,300)."..";
	}else{
		if( strlen($summary) > 300 ) $summary = substr($summary,0,300)."..";
	}

	//ADD image
	$image_url = "http://images-jp.amazon.com/images/P/". $content_row['ASIN'] .".09.MZZZZZZZ.jpg";
	if (! check_Image_URL($image_url)) {
		$image_url = FALSE;
	} else {
		$imgsize = @getimagesize($image_url);
		if( $imgsize != false && $imgsize[0] == 1 && $imgsize[1] == 1 ){
			$image_url = FALSE;
		}
	}

	$height = 100 ;
	if( $image_url === FALSE ) {
		$image_url = XOOPS_URL . "/modules/$mydirname/images/noimage40.gif";
		$height = 40 ;
	}
	$summary = '<div style="float:left;padding-right:6px;"><img src="'. $image_url .'" height="'. $height .'" /></div>' . $summary ;

	return array(
		'dirname'     => $mydirname ,
		'module_name' => $module->getVar( 'name' ) ,
		'subject'     => $myts->makeTboxData4Show( $content_row['title'] ) ,
		'uri'         => XOOPS_URL.'/modules/'.$mydirname.'/index.php?lid='.intval( $content_row['lid'] ) ,
		'summary'     => $summary ,
	) ;

  }

}

?>