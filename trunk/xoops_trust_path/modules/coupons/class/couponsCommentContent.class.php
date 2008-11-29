<?php
//require_once dirname(dirname(__FILE__)) .'/include/functions.php' ;


// a class for d3forum comment integration
class couponsCommentContent extends D3commentAbstract {

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
	$sql = "SELECT * FROM ".$db->prefix($mydirname."_coupons")." l, ".$db->prefix($mydirname."_text")." t WHERE l.lid=$content_id AND l.lid=t.lid" ;
	$content_row = $db->fetchArray( $db->query($sql) ) ;

	$summary = $content_row['description'];
	$summary = $myts->displayTarea( $summary , 0 , 0 , 0 , 0 , 0 ) ;
	$summary = $myts->nl2Br($summary);
	$summary = preg_replace( '/(<br \/>){2,}/' , '<br />' , $summary ) ;
	if( function_exists('mb_strlen') && function_exists('mb_strcut') ){
		if( mb_strlen($summary) > 150 ) $summary = mb_strcut($summary,0,300)."..";
	}else{
		if( strlen($summary) > 300 ) $summary = substr($summary,0,300)."..";
	}

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