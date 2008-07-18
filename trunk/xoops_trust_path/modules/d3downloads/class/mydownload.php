<?php

// for Topview , Cateview , Singleview etc.

if( ! class_exists( 'MyDownload' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class MyDownload
	{
		var $db ;
		var $table ;
		var $whr ;
		var $order = "" ;
		var $lid ;
		var $cid ;
		var $title ;
		var $url ;
		var $filename ;
		var $ext ;
		var $homepage ;
		var $version ;
		var $size ;
		var $platform ;
		var $logourl ;
		var $description ;
		var $html ;
		var $smiley ;
		var $br ;
		var $xcode ;
		var $submitter ;
		var $date ;
		var $hits ;
		var $rating ;
		var $votes ;
		var $cancomment ;
		var $comments ;
		var $category ;
		var $downdata=array();

		function MyDownload( $mydirname, $whr='', $lid= 0 )
		{
			global $xoopsUser ;
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$columns = 'd.'.implode( ',d.' , array_diff( $GLOBALS['d3download_tables']['downloads'] , array( 'mail' , 'visible' , 'kanrisya' ) ) ) ;
			$columns .= ', c.title AS category';
			$this->columns = $columns ;
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname( $mydirname );
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );
			$this->mod_config = $mod_config ;
			if( is_object( $xoopsUser ) ) {
				$this->xoops_isuser = true ;
				$this->xoops_userid = $xoopsUser->getVar('uid') ;
				$mid = $module->getVar('mid') ;
				$this->xoops_isadmin = $xoopsUser->isAdmin( $mid ) ;
			} else {
				$this->xoops_isuser = false ;
				$this->xoops_userid = 0 ;
				$this->xoops_isadmin = false ;
			}
			if( ! empty( $lid ) ) {
				$this->GetMyDownload( $whr='', $lid ) ;
			}
		}

		function GetMyDownload( $whr='', $lid )
		{
			$sql = "SELECT $this->columns FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid WHERE d.lid='".$lid."' AND d.visible = '1'";
			if ( ! empty( $whr ) ) {
				$sql .= " AND ( $whr )";
			}
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result );
		}

		function getData( $result )
		{
			$array = $this->db->fetchArray( $result );
			foreach ( $array as $key=>$value ){
				$this->$key = $value;
			}
		}

		function Total_Num( $whr='', $cid=0 )
		{
			$sql = "SELECT COUNT( lid ) FROM ".$this->table." WHERE visible = '1'";
			if ( ! empty( $whr ) ) {
				$sql .= " AND ( $whr )";
			}
			if( ! empty( $cid ) ){
				$sql .= " AND cid='".$cid."'";
			}
			$res = $this->db->query( $sql );
			list( $num ) = $this->db->fetchRow( $res ) ;
			return intval( $num );
		}

		function All_Num( $cid=0 )
		{
			$sql = "SELECT COUNT( lid ) FROM ".$this->table."";
			if( ! empty( $cid ) ){
				$sql .= " WHERE cid='".$cid."'";
			}
			$res = $this->db->query( $sql );
			list( $num ) = $this->db->fetchRow( $res ) ;
			return intval( $num );
		}

		function Hits_Count( $lid )
		{
			$sql = "UPDATE ".$this->table." SET hits = hits+1 WHERE lid = ".$lid."  AND visible = '1'";
			$this->db->queryF( $sql );
		}

		function get_downdata_for_singleview( $whr='', $lid, $cid=0, $single=0, $novisit=0, $block=0 )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			$sql = "SELECT $this->columns FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid WHERE d.lid='".$lid."' AND d.visible = '1'";
			if ( ! empty( $whr ) ) {
				$sql .= " AND ( $whr )";
			}
			if ( ! empty( $cid ) ) {
				$sql .= " AND d.cid='".$cid."'";
			}
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result );
			$broken_link = 0 ;
			$filelink = '' ;
			$id = $this->return_lid() ;
			$cid = $this->return_cid() ;
			$url = $this->return_url('Show') ;
			$submitter =  $this->return_submitter() ;
			$filename = $this->return_filename('Show') ;
			$ext = $this->return_ext('Show') ;
			$file_info = $this->file_link( $id, $cid, $url, $filename, $ext, $novisit ) ;
			$filelink = $file_info['filelink'] ;
			$logourl = $this->return_logourl('Show') ;
			$html = $this->return_html() ;
			$smiley = $this->return_smiley() ;
			$xcode = $this->return_xcode() ;
			$br = $this->return_br() ;
			$body = $this->return_body( $id, $cid, $this->return_description('Show'), $single, $block ) ;
			$date = $this->return_date() ;
			$hits = $this->return_hits() ;
			$downdata = array(
				'id' => $id ,
				'cid' => $cid ,
				'category' => $this->return_category('Show') ,
				'title' => $this->return_title('Show') ,
				'url' => $url ,
				'filelink' => $filelink ,
				'broken_link' =>  $file_info['broken_link'] ,
				'gif_image' =>  $file_info['gif_image']  ,
				'homepage' => $this->return_homepage('Show') ,
				'version' => $this->return_version('Show') ,
				'size' =>  $this->PrettySize( $this->return_size() , $block ) ,
				'platform' => $this->return_platform('Show') ,
				'description' => $myts->displayTarea( $body, $html, $smiley, $xcode, 1, $br ) ,
				'submitter' =>  $submitter ,
				'postname' =>  $this->getlink_for_postname( $submitter ) ,
				'user_url' => $this->return_user_url( $submitter ) ,
				'updated' => formatTimestamp( $date,'s') ,
				'date' => $date ,
				'hits' => $hits ,
				'rating' => $this->return_rating() ,
				'votes' => $this->return_votes() ,
				'd3comment' => $this->config_d3comment() ,
				'cancomment' => $this->return_cancomment() ,
				'comments' => $this->return_comments() ,
				'canedit' => $this->can_edit_for_cat( $cid, $submitter ) ,
				'new' => $this->newdownloadgraphic( $date, $id, $block ) ,
				'pop' => $this->popgraphic( $hits, $block ) ,
				'shots' => $this->shots_link( $cid, $url, $filelink, $logourl ) ,
				'singlelink' => TRUE ,
				'mail_link' => $this->mail_link( $id, $cid, $block ) ,
			) ;
			return $downdata;
		}

		function get_downdata_for_catview( $cid, $whr, $order, $perpage, $current_start )
		{
			$sql = "SELECT $this->columns FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid WHERE d.cid='".$cid."' AND d.visible = '1' AND ( $whr ) ORDER BY $order";
			$result = $this->db->query( $sql, $perpage, $current_start );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			} else {
				return $this->get_downdata( $result );
			}
		}

		function get_downdata_for_topview( $whr, $limit )
		{
			$cache_time = 30 * 60 ;
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$cache = XOOPS_TRUST_PATH.'/cache/'.$this->mydirname.'_topview_'.$site_salt.'.php' ;
			if( $this->xoops_isuser || ! file_exists( XOOPS_TRUST_PATH.'/cache/' ) ) {
				$data = $this->get_data_of_topview( $whr, $limit ) ;
			} elseif ( file_exists( $cache ) && filemtime( $cache ) + $cache_time > time() ){
				$data = unserialize( join( '', file( $cache ) ) ) ;
			} else {
				$data = $this->get_data_of_topview( $whr, $limit ) ;
				if ( $fp = @fopen( $cache, 'wb' ) ){
					fputs( $fp,serialize( $data ) ) ;
					fclose( $fp );
				}
			}
			return $data ;
		}

		function get_data_of_topview( $whr, $limit )
		{
			$result = $this->db->query( "SELECT $this->columns FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid WHERE d.visible = '1' AND ( $whr ) ORDER BY d.date DESC", $limit, 0 );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			} else {
				return $this->get_downdata( $result );
			}
		}

		function get_downdata( $result )
		{
			global $xoopsConfig ;
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$broken_link = 0 ;
				$filelink = '' ;
				$id = $this->return_lid() ;
				$cid = $this->return_cid() ;
				$url = $this->return_url('Show') ;
				$submitter = $this->return_submitter() ;
				$filename = $this->return_filename('Show') ;
				$ext = $this->return_ext('Show') ;
				$file_info = $this->file_link( $id, $cid, $url, $filename, $ext ) ;
				$filelink = $file_info['filelink'] ;
				$logourl = $this->return_logourl('Show') ;
				$html = $this->return_html() ;
				$smiley = $this->return_smiley() ;
				$xcode = $this->return_xcode() ;
				$br = $this->return_br() ;
				$body = $myts->displayTarea( $this->return_description('Show'), $html, $smiley, $xcode, 1, $br ) ;
				$date = $this->return_date() ;
				$hits = $this->return_hits() ;
				$downdata[] = array(
					'id' => $id ,
					'cid' => $cid ,
					'category' => $this->return_category('Show') ,
					'title' => $this->return_title('Show') ,
					'url' => $url ,
					'filelink' =>  $filelink ,
					'broken_link' =>  $file_info['broken_link'] ,
					'gif_image' =>  $file_info['gif_image']  ,
					'homepage' => $this->return_homepage('Show') ,
					'version' => $this->return_version('Show') ,
					'size' =>  $this->PrettySize( $this->return_size() ) ,
					'platform' => $this->return_platform('Show') ,
					'description' => $this->return_body( $id, $cid, $body, 0, 0 ) ,
					'submitter' =>  $submitter ,
					'postname' =>  $this->getlink_for_postname( $submitter ) ,
					'user_url' => $this->return_user_url( $submitter ) ,
					'updated' => formatTimestamp( intval( $date ),'s' ) ,
					'date' => $date ,
					'hits' => $hits ,
					'rating' => $this->return_rating() ,
					'votes' => $this->return_votes() ,
					'd3comment' => $this->config_d3comment() ,
					'cancomment' => $this->return_cancomment() ,
					'comments' => $this->return_comments() ,
					'canedit' => $this->can_edit_for_cat( $cid, $submitter ) ,
					'new' => $this->newdownloadgraphic( $date, $id ) ,
					'pop' => $this->popgraphic( $hits ) ,
					'shots' => $this->shots_link( $cid, $url, $filelink, $logourl ) ,
					'mail_link' => $this->mail_link( $id, $cid ) ,
				) ;
			}
			return $downdata;
		}

		function return_lid()
		{
			return intval( $this->lid ) ;
		}

		function return_cid()
		{
			return intval( $this->cid ) ;
		}

		function return_title( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->makeTboxData4Show( $this->title ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->title ) ;
			}
		}

		function return_url( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->makeTboxData4URLShow( $this->url ) ;
			} elseif( $mode == 'Edit') {
				if ( preg_match("/^(https?|ftp):\/\//",  $this->url ) ) {
					$str = $myts->makeTboxData4Edit( $this->url ) ;
				} elseif( preg_match('/^'.preg_quote( XOOPS_TRUST_PATH, '/' ).'/i', $this->url ) ) {
					$str = preg_replace( '/^'.preg_quote( XOOPS_TRUST_PATH, '/' ).'/i', 'XOOPS_TRUST_PATH', $this->url ) ;
				} elseif( preg_match('/^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', $this->url ) ) {
					$str = preg_replace( '/^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', 'XOOPS_ROOT_PATH', $this->url ) ;
				}
				return $myts->makeTboxData4Edit( $str ) ;
			}
		}

		function return_filename( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->MyhtmlSpecialChars( $this->filename ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->filename ) ;
			}
		}

		function return_ext( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->MyhtmlSpecialChars( $this->ext ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->ext ) ;
			}
		}

		function return_homepage( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return  $myts->makeTboxData4URLShow( $this->homepage ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->homepage ) ;
			}
		}

		function return_version( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->makeTboxData4Show( $this->version ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->version ) ;
			}
		}

		function return_size()
		{
			return intval( $this->size ) ;
		}

		function return_platform( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->makeTboxData4Show( $this->platform ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->platform ) ;
			}
		}

		function return_logourl( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->makeTboxData4Show( $this->logourl ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->logourl ) ;
			}
		}

		function return_description( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $this->description ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTareaData4Edit( $this->description ) ;
			}
		}

		function return_html()
		{
			return $this->html ? 1 : 0 ;
		}

		function return_smiley()
		{
			return $this->smiley ? 1 : 0 ;
		}

		function return_br()
		{
			return $this->br ? 1 : 0 ;
		}

		function return_xcode()
		{
			return $this->xcode ? 1 : 0 ;
		}

		function return_submitter()
		{
			return intval( $this->submitter ) ;
		}

		function return_date()
		{
			return intval( $this->date ) ;
		}

		function return_hits()
		{
			return intval( $this->hits ) ;
		}

		function return_rating()
		{
			return intval( $this->rating ) ;
		}

		function return_votes()
		{
			return intval( $this->votes ) ;
		}

		function return_cancomment()
		{
			return $this->cancomment ? 1 : 0 ;
		}

		function return_visible()
		{
			return $this->visible ? 1 : 0 ;
		}

		function return_comments()
		{
			return intval( $this->comments ) ;
		}

		function return_category( $mode )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $mode == 'Show'){
				return $myts->makeTboxData4Show( $this->category ) ;
			} elseif( $mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->category ) ;
			}
		}

		function return_body( $id, $cid, $body ,$single, $block )
		{
			if ( empty( $single ) ){
				if ( strstr ( $body , '[pagebreak]' ) ){
					$str = explode( '[pagebreak]', $body , 2 ) ;
					if( empty( $block) ){
						$body = $str[0].'<br /><div align="right"><a href="'.$this->mod_url.'/index.php?page=singlefile&amp;cid='.$cid.'&lid='.$id.'">'._MD_D3DOWNLOADS_SHOWSINGLEFILE.'</a></div>';
					} else {
						$body = $str[0].'<br /><div align="right"><a href="'.$this->mod_url.'/index.php?page=singlefile&amp;cid='.$cid.'&lid='.$id.'">'._MB_D3DOWNLOADS_LANG_SHOWSINGLEFILE.'</a></div>';
					}
				} else {
					$body = $body ;
				}
			} else {
				if ( strstr ( $body , '[pagebreak]' ) ){
					$body = str_replace( '[pagebreak]','', $body  ) ;
				} else {
					$body = $body ;
				}
			}
			return $body;
		}

		function get_postname( $submitter )
		{
			if ( $submitter > 0 ) {
				$member_handler =& xoops_gethandler('member');
				$member =& $member_handler->getUser( $submitter );
				if ( $member ) {
					$postname = $member->getvar('name');
					if ( ! $postname ) {
						$postname = $member->getvar('uname');
					}
				}
			} else {
				global $xoopsConfig;
				$postname = $xoopsConfig['anonymous'];
			}
			return $postname ;
		}

		function getlink_for_postname( $submitter )
		{
			$postname = $this->get_postname( $submitter );
			if ( $submitter > 0 ) $user_url = $this->return_user_url( $submitter );
			if ( $submitter > 0 ) {
				return '<a href="'.$user_url.'">'.$postname.'</a>';
			} else {
				return $postname;
			}
		}

		function return_user_url( $submitter )
		{
			if ( $submitter > 0 ) {
				return XOOPS_URL."/userinfo.php?uid=$submitter";
			} else {
				return '' ;
			}
		}

		function return_gif_image( $ext )
		{
			if( $ext == 'gz' ) $ext = 'tgz' ;
			else if( $ext == 'tbz' ) $ext = 'bz2' ;
			$image_path = XOOPS_ROOT_PATH.'/modules/'.$this->mydirname.'/images/'. $ext .'.gif';

			if( $ext == 'zip' ) $image = 'zip.gif' ;
			elseif( $ext == 'lzh' ) $image = 'lzh.gif' ;
			elseif( $ext == 'tgz' ) $image = 'tgz.gif' ;
			elseif( $ext == 'cab' ) $image = 'cab.gif' ;
			elseif( $ext == 'bz2' ) $image = 'bz2.gif' ;
			elseif( $ext == 'xls' ) $image = 'xls.gif' ;
			elseif( $ext == 'doc' ) $image = 'doc.gif' ;
			elseif( $ext == 'pdf' ) $image = 'pdf.gif' ;
			elseif( file_exists( $image_path ) ) $image = $ext .'.gif' ;
			else $image = 'download.gif' ;
			return $image;
		}

		function newdownloadgraphic( $time, $id, $block=0 )
		{
			$count = $this->mod_config['newmark'] ;
			$new = '';
			$startdate = ( time() - ( 86400 * $count ) );
			$sql = "SELECT COUNT(*) FROM ".$this->db->prefix( $this->mydirname."_downloads_history" )." WHERE lid= ".$id."";
			list( $count ) = $this->db->fetchRow( $this->db->query( $sql) );
			if ( $startdate < $time ) {
				if( empty( $count ) ){
					$new = '&nbsp;<img src="'.$this->mod_url.'/images/newred.gif"';
					if( empty( $block ) ){
						$new .= ' alt="'._MD_D3DOWNLOADS_NEWTHISWEEK.'" title="'._MD_D3DOWNLOADS_NEWTHISWEEK.'" />';
					} else {
						$new .= ' alt="'._MB_D3DOWNLOADS_NEWTHISWEEK.'" title="'._MB_D3DOWNLOADS_NEWTHISWEEK.'" />';
					}
				} else {
					$new = '&nbsp;<img src="'.$this->mod_url.'/images/update.gif"';
					if( empty( $block ) ){
						$new .= ' alt="'._MD_D3DOWNLOADS_UPTHISWEEK.'" title="'._MD_D3DOWNLOADS_UPTHISWEEK.'" />';
					} else {
						$new .= ' alt="'._MB_D3DOWNLOADS_UPTHISWEEK.'" title="'._MB_D3DOWNLOADS_UPTHISWEEK.'" />';
					}
				}
			}
			return $new;
		}

		function popgraphic( $hits, $block=0 )
		{
			$pop = '';
			if ( $hits >= $this->mod_config['popular'] ) {
				$pop = '&nbsp;<img src ="'.$this->mod_url.'/images/pop.gif"';
				if( empty( $block ) ){
					$pop .= ' alt="'._MD_D3DOWNLOADS_POPULAR.'" title="'._MD_D3DOWNLOADS_POPULAR.'" />';
				} else {
					$pop .= ' alt="'._MB_D3DOWNLOADS_POPULAR.'" title="'._MB_D3DOWNLOADS_POPULAR.'" />';
				}
			}
			return $pop;
		}

		function Exception_extension()
		{
			return array( 'arj' , 'bz2' , 'cab' , 'gz' , 'jar' , 'lzh' , 'rar' , 'tar' , 'taz' , 'tbz' , 'tgz' , 'z' , 'zip' ) ;
		}

		function file_link( $id, $cid, $url, $filename, $ext, $novisit=0 )
		{
			$broken_link = 0 ;
			$filelink = '' ;
			$exception = '\.'.implode( '|\.',$this->Exception_extension() );
			if ( ! preg_match("/^(https?|ftp):\/\//", $url ) ) {
				if( ! is_file( $url ) ){
					// ファイル破損の場合はリンクを表示しない
					// 管理者には broken link!! と表示して警告する
					$broken_link = 1 ;
					$gif_image = "";
				} elseif( filesize( $url ) == 0 ) {
					$broken_link = 1 ;
					$gif_image = "";
				} else {
					if( empty( $filename ) ){
						$f_info = pathinfo( $url );
						$filename = $f_info['basename'];
						$ext = strtolower( $f_info['extension'] ) ;
					}
					if( empty( $novisit ) ){
						$filelink =  '<a href="'.$this->mod_url.'/index.php?page=visit&cid='.$cid.'&lid='.$id.'">' ;
					} else {
						$filelink =  '<a href="'.$this->mod_url.'/index.php?page=visit_url&url='.$url.'&filename='.$filename.'&ext='.$ext.'">' ;
					}
					$gif_image = $this->return_gif_image( $ext );
				}
			} elseif ( preg_match('/('.$exception.')$/i', $url ) ) {
				if( empty( $novisit ) ){
					$filelink =  '<a href="'.$this->mod_url.'/index.php?page=visit&cid='.$cid.'&lid='.$id.'">' ;
				} else {
					$filelink =  '<a href="'.$url.'">' ;
				}
				$gif_image = 'download.gif';
			} else {
				if( empty( $novisit ) ){
					$filelink =  '<a href="'.$this->mod_url.'/index.php?page=visit&cid='.$cid.'&lid='.$id.'" target="_blank">' ;
				} else {
					$filelink =  '<a href="'.$url.'" target="_blank">' ;
				}
				$gif_image = 'download.gif';
			}
			return array(
				'broken_link'  => $broken_link ,
				'filelink'  => $filelink ,
				'gif_image'  => $gif_image ,
			) ;
		}

		function file_link_for_post( $url, $filename, $ext )
		{
			$exception = '\.'.implode( '|\.',$this->Exception_extension() );
			if ( ! preg_match("/^(https?|ftp):\/\//", $url) ) {
				if( ! file_exists( $url ) ){
					$filelink = '( <font color="#FF0000"><b>broken file !!</b></font> )';
				} elseif( filesize( $url ) == 0) {
					$filelink = '( <font color="#FF0000"><b>broken file !!</b></font> )';
				} else {
					if ( preg_match('/^'.preg_quote( XOOPS_TRUST_PATH, '/' ).'/i', $url ) ) {
						$url = preg_replace( '/^'.preg_quote( XOOPS_TRUST_PATH, '/' ).'/i', 'XOOPS_TRUST_PATH', $url ) ;
					} elseif( preg_match('/^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', $this->url ) ) {
						$url = preg_replace( '/^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', 'XOOPS_ROOT_PATH', $url ) ;
					}
					if ( ! empty( $filename ) ){
						$filelink =  '[<a href="'.$this->mod_url.'/index.php?page=visit_url&url='.$url.'&filename='.$filename.'&ext='.$ext.'" id="access_url">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
					} else {
						$filelink =  '[<a href="'.$this->mod_url.'/index.php?page=visit_url&url='.$url.'" id="access_url">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
					}
				}
			} elseif ( preg_match('/('.$exception.')$/i', $url ) ) {
				$filelink =  '[<a href="'.$url.'" id="access_url">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
			} else {
				$filelink =  '[<a href="'.$url.'" id="access_url" target="_blank">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
			}
			return $filelink ;
		}

		function shots_link( $cid, $url, $filelink, $logourl )
		{
			$exception = '\.'.implode( '|\.',$this->Exception_extension() );
			$maxwidth = intval( $this->mod_config['shotwidth'] );
			$myalbum_dirname = htmlspecialchars( $this->mod_config['albumselect'] , ENT_QUOTES );
			$usealbum = $this->can_albumselect( $myalbum_dirname );
			if( preg_match ('/(\.gif|\.jpe?g|\.png)$/i', $logourl ) ){
				$shots_link = $this->shots_img_link( $cid, $url, $filelink, $logourl, $maxwidth );
			} elseif ( ! empty( $usealbum ) && preg_match ('/^[0-9]+$/', $logourl ) ){
				$shots_link = $this->get_album_link( $myalbum_dirname, $logourl, $maxwidth );
			} elseif( empty( $logourl ) && preg_match('/('.$exception.')$/i', $url ) ) {
				$shots_link = '';
			} elseif( ! empty( $this->mod_config['shotselect'] ) && preg_match ('/^https?:\/\/.+\..+/i', $url ) ) {
				$shots_link = $filelink.'<img src="http://mozshot.nemui.org/shot/large?'.$url.'" width="'.$maxwidth.'" height="'.$maxwidth.'" align="left"></a>';
			} else {
				$shots_link = '';
			}
			return $shots_link ;
		}

		function shots_img_link( $cid, $url, $filelink, $logourl, $maxwidth )
		{
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $this->mydirname, 'Show', $cid ) ;
			$cate_shotsdir = $mycategory->return_shotsdir() ;
			if( ! empty( $cate_shotsdir ) && file_exists( XOOPS_ROOT_PATH.'/'.$cate_shotsdir ) ){
				$shots_dir = XOOPS_URL.'/'.$cate_shotsdir.'/'.$logourl;
				$shots_path = XOOPS_ROOT_PATH.'/'.$cate_shotsdir.'/'.$logourl;
			} else {
				$shots_dir = $this->mod_url.'/images/shots/'.$logourl;
				$shots_path = XOOPS_ROOT_PATH.'/modules/'.$this->mydirname.'/images/shots/'.$logourl;
			}
			if ( file_exists( $shots_path ) ){
				$size = getimagesize( $shots_path ) ;
				if ( $size ){
					$width  = intval( $size[0] );
					$height = intval( $size[1] );
					if ( $width > $maxwidth ){
						$showsize = $maxwidth / $width ;
						$width  = $width * $showsize ;
						$height = $height * $showsize ;
					}
				}
				return $filelink.'<img src="'.$shots_dir.'" width="'.$width.'" height="'.$height.'" align="left"></a>';
			}
		}

		function get_album_link( $myalbum_dirname, $logourl, $maxwidth )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			$myalbum_path = XOOPS_ROOT_PATH .'/modules/'. $myalbum_dirname;
			include $myalbum_path .'/include/read_configs.php';

			$prs = $this->db->query( "SELECT lid, title, ext, res_x, res_y FROM $table_photos WHERE lid=$logourl AND status > 0" );
			while( list( $id, $name, $ex, $res_x, $res_y ) = $this->db->fetchRow( $prs ) ) {
				$title = $myts->makeTboxData4Show( $name ) ;
				$lid = intval( $id ) ;
				$ext = $myts->makeTboxData4Show( $ex );
				$window_x = intval( $res_x ) ;
				$window_y = intval( $res_y ) ;
				$image_target = $photos_url .'/'. $lid .'.'. $ext;
				$photos_image = $thumbs_dir .'/'. $lid .'.'. $ext;
				$icons_image = $myalbum_path .'/icons/'. $ext .'.gif';
				if ( file_exists( $photos_image ) ){
					$image_url = $thumbs_url .'/'. $lid .'.'. $ext;
					$size = getimagesize( $photos_image );
					if ( $size ){
						$width  = intval( $size[0] );
						$height = intval( $size[1] );
						if ( $width > $maxwidth ){
							$showsize = $maxwidth / $width ;
							$width  = $width * $showsize ;
							$height = $height * $showsize ;
						}
						return '<a href="'.$image_target.'" target="_blank" onClick="window.open(\''.$image_target.'\',\'\',\'width='.$window_x.',height='.$window_y.'\');return(false);"><img src="'.$image_url.'" width="'.$width.'" height="'.$height.'" alt="'.$title.'" title="'.$title.'" align="left" /></a>';
					}
				} elseif ( file_exists( $icons_image ) ){
					$image_url = XOOPS_URL .'/modules/'. $myalbum_dirname.'/icons/'. $ext .'.gif';
					$size = getimagesize( $icons_image ) ;
					if ( $size ){
						$width  = intval( $size[0] );
						$height = intval( $size[1] );
						return '<a href="'.$image_target.'" target="_blank"><img src="'.$image_url.'" width="'.$width.'" height="'.$height.'" alt="'.$title.'" title="'.$title.'" align="left" /></a>';
					}
				}
			}
		}

		function can_albumselect( $myalbum_dirname='' )
		{
			if( empty( $myalbum_dirname ) ){
				$myalbum_dirname = htmlspecialchars( $this->mod_config['albumselect'] , ENT_QUOTES );
			}
			$usealbum = 0;
			if( ! empty( $this->mod_config['usealbum'] )  && ! empty( $this->mod_config['albumselect'] ) ){
				$myalbm_path = XOOPS_ROOT_PATH .'/modules/'.$myalbum_dirname ;
				$usealbum = file_exists( $myalbm_path ) ? 1 : 0 ;
			}
			return $usealbum;
		}

		function can_edit_for_cat( $cid, $submitter )
		{
			if( $this->xoops_isadmin ){
				$canedit = 1 ;
			} elseif( $submitter == $this->xoops_userid &&  $this->xoops_isuser ){
				include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
				$user_access = new user_access( $this->mydirname ) ;
				$whr_cat4edit = "cid IN (".implode(",", $user_access->can_edit() ).")" ;
				$canedit = $user_access->can_edit4cid( $cid, $whr_cat4edit ) ;
			} else {
				$canedit = 0 ;
			}
			return $canedit;
		}

		function config_d3comment()
		{
			// コメント統合の設定をしていない場合は「コメント」のリンクを表示しない
			if ( ! empty ( $this->mod_config['comment_dirname'] ) && ! empty ( $this->mod_config['comment_forum_id'] ) ){
				return TRUE;
			} else {
				return FALSE;
			}
		}

		function mail_link( $id, $cid, $block=0 )
		{
			global $xoopsConfig ;

			if( $this->mod_config['use_tell_a_frined'] ){
				if( empty( $block ) ){
					return XOOPS_URL.'/modules/tellafriend/index.php?target_uri='.rawurlencode( "$this->mod_url/index.php?page=singlefile&cid=$cid&lid=$id" ).'&amp;subject='.rawurlencode( sprintf( _MD_D3DOWNLOADS_INTARTFOUND, $xoopsConfig['sitename'] ) ) ;
				} else {
					return XOOPS_URL.'/modules/tellafriend/index.php?target_uri='.rawurlencode( "$this->mod_url/index.php?page=singlefile&cid=$cid&lid=$id" ).'&amp;subject='.rawurlencode( sprintf( _MB_D3DOWNLOADS_INTARTFOUND, $xoopsConfig['sitename'] ) ) ;
				}
			} else {
				if( empty( $block ) ){
					return 'mailto:?subject='.$this->mailto_escape( sprintf( _MD_D3DOWNLOADS_INTARTICLE, $xoopsConfig['sitename'] ) ).'&amp;body='.$this->mailto_escape( sprintf( _MD_D3DOWNLOADS_INTARTFOUND, $xoopsConfig['sitename'] ) ).'%0A'. rawurlencode( $this->mod_url.'/index.php?page=singlefile&cid='.$cid.'&lid='.$id ) ;
				} else {
					return 'mailto:?subject='.$this->mailto_escape( sprintf( _MB_D3DOWNLOADS_INTARTICLE, $xoopsConfig['sitename'] ) ).'&amp;body='.$this->mailto_escape( sprintf( _MB_D3DOWNLOADS_INTARTFOUND, $xoopsConfig['sitename'] ) ).'%0A'. rawurlencode( $this->mod_url.'/index.php?page=singlefile&cid='.$cid.'&lid='.$id ) ;
				}
			}
		}

		function mailto_escape( $text )
		{
			if ( ! extension_loaded( 'mbstring' ) && ! class_exists( 'HypMBString' ) ) {
				require_once dirname( dirname( __FILE__ ) ).'/class/mbemulator/mb-emulator.php' ;
			}
			if( defined( '_MD_D3DOWNLOADS_MAILTOENCODING' ) ) {
				$text = mb_convert_encoding( $text , _MD_D3DOWNLOADS_MAILTOENCODING ) ;
			}
			return rawurlencode( $text ) ;
		}

		function PrettySize( $size, $block=0 )
		{
			$mb = 1024 * 1024;
			if ( $size > $mb ) {
				$mysize = sprintf ("%01.2f",$size/$mb) . " MB";
			} elseif ( $size >= 1024 ) {
				$mysize = sprintf ("%01.2f",$size/1024) . " KB";
			} else {
				if ( empty( $block ) ){
			    	$mysize = sprintf( _MD_D3DOWNLOADS_NUMBYTES , $size );
			    } else {
			    	$mysize = sprintf( _MB_D3DOWNLOADS_NUMBYTES , $size );
			    }
			}
			return $mysize;
		}
	}
}

?>