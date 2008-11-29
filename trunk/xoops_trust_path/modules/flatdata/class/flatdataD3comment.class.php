<?php
require_once XOOPS_TRUST_PATH ."/modules/d3forum/class/D3commentAbstract.class.php" ;

class flatdataD3comment extends D3commentAbstract {

	function displayCommentsInline($params)
	{
		$this->setD3forumDirname( @$params['forum_dirname'] ) ;//

		$new_params = $this->restructParams( $params ) ;
		d3forum_render_comments( $this->d3forum_dirname , $new_params['forum_id'] , $new_params , $this->smarty ) ;
	}

	function displayCommentsCount( $params )
	{
		$this->setD3forumDirname( @$params['forum_dirname'] ) ;//

		$comments_count = $this->countComments( $this->restructParams( $params ) ) ;

		if( empty( $params['var'] ) ) {
			// display
			echo intval($comments_count) ;//
		} else {
			// assign as "var"
			$this->smarty->assign( $params['var'] , intval($comments_count) ) ;//
		}
	}

	function fetchSummary( $external_link_id )
	{
		$module_handler =& xoops_gethandler( 'module' ) ;
		$module =& $module_handler->getByDirname( $this->mydirname ) ;

		$content_id = intval( $external_link_id ) ;
		$mydirname = $this->mydirname ;
		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		require_once XOOPS_TRUST_PATH ."/modules/flatdata/class/fields.class.php" ;
		require_once XOOPS_TRUST_PATH ."/modules/flatdata/class/flatdata.class.php" ;

		$fields = new flatdataFieldsClass( $mydirname ) ;
		$flatdata = new Flatdata( $mydirname ) ;
		$fidarr = $fields->getFidArray('list');
		$data = $flatdata->getData( $content_id , $fidarr ) ;
		$allfields = $fields->getAllFields();
		for($i=0; $i<count($allfields); $i++){
			$keyfid[$allfields[$i]['fid']] = $allfields[$i]['fname'] ;
		}

		$summary = '' ;
		foreach( $fidarr as $f ){
			$summary .= $keyfid[$f] ." : ". @$data['data'][$f] ."\n";
		}
		if( function_exists('mb_strlen') && function_exists('mb_strcut') ){
			if( mb_strlen($summary) > 200 ) $summary = mb_strcut($summary,0,200)."...";
		}else{
			if( strlen($summary) > 200 ) $summary = substr($summary,0,200)."...";
		}
		$summary = nl2Br($summary);

		return array(
			'dirname'     => $mydirname ,
			'module_name' => $module->getVar( 'name' ) ,
			'subject'     => "ID : ".$content_id ,
			'uri'         => XOOPS_URL.'/modules/'.$mydirname.'/index.php?did='.$content_id ,
			'summary'     => $summary ,
		) ;
	}

}

?>