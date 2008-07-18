<?php

// a class for d3forum comment integration
if( ! class_exists( 'd3downloadsComment' ) )
{
	require_once XOOPS_TRUST_PATH.'/modules/d3forum/class/D3commentAbstract.class.php' ;

	class d3downloadsComment extends D3commentAbstract
	{
		function fetchSummary( $external_link_id )
		{
			require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

			$db =& Database::getInstance() ;
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			$module_handler =& xoops_gethandler( 'module' ) ;
			$module =& $module_handler->getByDirname( $this->mydirname ) ;

			$down_id = intval( $external_link_id ) ;
			$mydirname = $this->mydirname ;
			if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

			$content_row = $db->fetchArray( $db->query( "SELECT lid, cid, title, description FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid=$down_id" ) ) ;
			if( empty( $content_row ) ) return '' ;

			$cid = intval( $content_row['cid'] );
			$uri = XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=singlefile&cid='.$cid.'&lid='.$down_id;

			$str = strip_tags( $myts->displayTarea(strip_tags( $content_row['description'] ) ) );
			$summary = xoops_substr( $str , 0 , 255 );

			return array(
				'dirname' => $mydirname ,
				'module_name' => $module->getVar( 'name' ) ,
				'subject' => $myts->makeTboxData4Show( $content_row['title'] ) ,
				'uri' => $uri,
				'summary' => $summary,
			) ;
		}

		function validate_id( $link_id )
		{
			include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
			$down_id = intval( $link_id ) ;
			$mydirname = $this->mydirname ;

			$db =& Database::getInstance() ;
			$user_access = new user_access( $mydirname ) ;
			$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
			list( $count ) = $db->fetchRow( $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid=$down_id AND visible = '1' AND cancomment = '1' AND ( $whr_cat )" ) ) ;
			if( $count <= 0 ) return false ;
			else return $down_id ;
		}

		function onUpdate( $mode , $link_id , $forum_id , $topic_id , $post_id = 0 )
		{
			include_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
			$down_id = intval( $link_id ) ;
			$mydirname = $this->mydirname ;

			$db =& Database::getInstance() ;

			list( $count ) = $db->fetchRow( $db->query( "SELECT COUNT(*) FROM ".$db->prefix($this->d3forum_dirname."_posts")." p LEFT JOIN ".$db->prefix($this->d3forum_dirname."_topics")." t ON t.topic_id=p.topic_id WHERE t.forum_id=$forum_id AND t.topic_external_link_id='$down_id'" ) ) ;
			$db->queryF( "UPDATE ".$db->prefix( $mydirname."_downloads" )." SET comments=$count WHERE lid=$down_id" ) ;
			d3download_delete_topview_cache( $mydirname ) ;
			return true ;
		}

		// get id from <{$file_id}>
		function external_link_id( $params )
		{
			$file = $this->smarty->get_template_vars( 'file' ) ;
			return intval( $file['id'] ) ;
		}

		// get escaped subject from <{$file.title}>
		function getSubjectRaw( $params )
		{
			$file = $this->smarty->get_template_vars( 'file' ) ;
			return $this->unhtmlspecialchars( $file['title'] , ENT_QUOTES ) ;
		}

		// set d3forum_dirname from config
		function setD3forumDirname( $d3forum_dirname = '' )
		{
			$this->d3forum_dirname = $this->mod_config['comment_dirname'] ;
		}

		// get forum_id from config
		function getForumId( $params )
		{
			return $this->mod_config['comment_forum_id'] ;
		}

		// get view from config
		function getView( $params )
		{
			return $this->mod_config['comment_view'] ;
		}
	}
}

?>