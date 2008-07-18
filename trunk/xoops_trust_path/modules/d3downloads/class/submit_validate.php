<?php

// for Get_Post , Submit_Validate , Set4sql etc.

if( ! class_exists( 'Submit_Validate' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class Submit_Validate
	{
		var $mode = "" ;
		var $requests_01 = array( 'html', 'smiley' , 'br' , 'xcode' ) ;
		var $requests_int = array( 'lid' ,'cid' , 'size' , 'submitter' , 'date' ) ;
		var $requests_text = array( 'title' , 'url' , 'filename' , 'ext' , 'homepage' , 'version', 'platform', 'logourl', 'description' ) ;
		var $requests_admin = array( 'visible',  'cancomment' ) ;
		var $title_length = 100 ;
		var $url_length = 250 ;
		var $filename_length = 50 ;
		var $ext_length = 10 ;
		var $homepage_length = 100 ;
		var $version_length = 10 ;
		var $size_length = 8 ;
		var $platform_length = 50 ;
		var $logourl_length = 60 ;
		var $html ;
		var $smiley ;
		var $br ;
		var $xcode ;
		var $lid ;
		var $cid ;
		var $size ;
		var $submitter ;
		var $date ;
		var $title ;
		var $url ;
		var $filename ;
		var $ext ;
		var $homepage ;
		var $version ;
		var $platform ;
		var $logourl ;
		var $description ;
		var $visible ;
		var $cancomment ;

		function Submit_Validate( $mydirname="", $mode="" )
		{
			if( ! empty( $mydirname ) ) $this->mydirname = $mydirname ;
			if( ! empty( $mode ) ) $this->mode = $mode ;

			if( ! empty( $mydirname ) ) {
				global $xoopsUser ;

				$this->db =& Database::getInstance();
				$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
				$this->post_check = new Post_Check() ;
				$this->user_access = new user_access( $mydirname ) ;
				if( isset( $_POST['charset'] ) && extension_loaded( 'mbstring' ) ) {
					$this->encode = mb_detect_encoding( $_POST['charset'] );
				} else {
					$this->encode = "";
				}
				$module_handler =& xoops_gethandler('module');
				$module =& $module_handler->getByDirname( $mydirname );
				if( is_object( $xoopsUser ) ) {
					$this->xoops_isuser = TRUE ;
					$this->xoops_userid = $xoopsUser->getVar('uid') ;
					$mid = $module->getVar('mid') ;
					$this->xoops_isadmin = $xoopsUser->isAdmin( $mid ) ;
				} else {
					$this->xoops_isuser = FALSE ;
					$this->xoops_userid = 0 ;
					$this->xoops_isadmin = FALSE ;
				}

				// Delete_Nullbyte
				$myts =& d3downloadsTextSanitizer::getInstance() ;
				$_POST = $myts->Delete_Nullbyte( $_POST ) ;

				// Encoding_Check
				if( extension_loaded( 'mbstring' ) ) {
					$this->Encoding_Check( $_POST );
				}

				// requests_01 Initialization
				$html = 0 ;
				$smiley = 0 ;
				$br =0 ;
				$xcode = 0 ;

				// requests_int Initialization
				$lid = 0 ;
				$cid = 0 ;
				$size = 0 ;
				$submitter = 0 ;
				$date = 0 ;

				// requests_text Initialization
				$title = "" ;
				$url = "" ;
				$filename = "" ;
				$ext = "" ;
				$homepage = "" ;
				$version = "" ;
				$platform = "" ;
				$logourl = "" ;
				$description = "" ;

				// requests_admin Initialization
				$visible = 0 ;
				$cancomment = 0 ;

				// set4sql Initialization
				$set4sql = "" ;
			}
		}

		function get_requests_01()
		{
			// get 01
			foreach( $this->requests_01 as $key ) {
				$$key = empty( $_POST[ $key ] ) ? 0 : 1 ;
			}

			// set4sql
			$set4sql = "" ;
			foreach( $this->requests_01 as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}

			return array(
				'html' => $html ,
				'smiley' => $smiley ,
				'br' => $br ,
				'xcode' => $xcode ,
				'set4sql' => $set4sql ,
			) ;
		}

		function get_requests_int()
		{
			if( $this->mode == 'submit' ) {
				$current_requests_int = array_diff( $this->requests_int, array( 'lid' , 'size' , 'submitter' , 'date' ) );
			} elseif( $this->mode == 'modfile' ) {
				$current_requests_int = array_diff( $this->requests_int, array( 'lid' , 'size' , 'date' ) );
			} elseif( $this->mode == 'approval' ) {
				$current_requests_int = array_diff( $this->requests_int, array( 'lid' , 'date' ) );
			}

			// intval
			foreach( $current_requests_int as $key ) {
				$$key = intval( @$_POST[ $key ] ) ;
			}

			$lid = intval( @$_POST['lid'] ) ;
			if( $this->mode == 'submit' ) $submitter = $this->xoops_userid ;
			$size = intval( @$_POST['size'] ) ;

			// set4sql
			$set4sql = "" ;
			foreach( $current_requests_int as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}

			return array(
				'cid' => $cid ,
				'submitter' => $submitter ,
				'lid' => $lid ,
				'size' => $size ,
				'set4sql' => $set4sql ,
			) ;
		}

		function get_requests_text( $use_htmlpurifierl, $html , $smiley , $xcode , $br )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			if( $this->mode == 'approval' ) {
				$current_requests_text = array_diff( $this->requests_text, array( 'logourl', 'description' ) );
			} else {
				$current_requests_text = array_diff( $this->requests_text, array( 'url' , 'filename' , 'ext' , 'logourl', 'description' ) );
			}

			// stripSlashesGPC
			foreach( $current_requests_text as $key ) {
				$$key =  $myts->MystripSlashesGPC( @$_POST[ $key ] , $this->encode ) ;
			}

			$posturl = $myts->MystripSlashesGPC( @$_POST['url'], $this->encode ) ;
			$searches = array() ;
			$replacements = array() ;
			$searches = array( 'XOOPS_TRUST_PATH' , 'XOOPS_ROOT_PATH' ) ;
			$replacements = array( XOOPS_TRUST_PATH , XOOPS_ROOT_PATH ) ;
			$url = str_replace( $searches , $replacements , $posturl ) ;

			$filename = $myts->MystripSlashesGPC( @$_POST['filename'], $this->encode ) ;
			$ext = $myts->MystripSlashesGPC( @$_POST['ext'], $this->encode ) ;
			if( $this->mode == 'approval' ) {
				$description = $myts->stripSlashesGPC( @$_POST['description'], $this->encode ) ;
			} else {
				$description = $myts->stripSlashesGPC( @$_POST['desc'], $this->encode ) ;
			}

			// Data4Edit
			$title4edit = $myts->makeTboxData4Edit( $title );
			$homepage4edit = $myts->makeTboxData4Edit( $homepage );
			$version4edit = $myts->makeTboxData4Edit( $version );
			$platform4edit = $myts->makeTboxData4Edit( $platform );
			$url4edit = $myts->makeTboxData4Edit( $posturl );
			$filename4edit = $myts->makeTboxData4Edit( $filename );
			$ext4edit = $myts->makeTboxData4Edit( $ext );
			$description4edit = $myts->makeTareaData4Edit( $description );

			// previewdata
			$title4preview = $myts->makeTboxData4Show( $title ) ;
			$description4preview = $this->return_body_for_preview( $description, $use_htmlpurifierl, $html, $smiley, $xcode, $br ) ;

			// set4sql
			$set4sql = "" ;
			foreach( $current_requests_text as $key ) {
				$set4sql .= ",$key='".addslashes( $$key )."'" ;
			}
			if( ! empty( $html ) && ! empty( $use_htmlpurifierl ) ){
				$text = $myts->myFilter( $description ) ;
				$description4sql = addslashes( $text ) ;
			} else {
				$description4sql = addslashes( $description ) ;
			}
			$set4sql .= ",description='".$description4sql."'" ;

			return array(
				'title' => $title ,
				'homepage' => $homepage ,
				'version' => $version ,
				'platform' => $platform ,
				'url' => $url ,
				'filename' => $filename ,
				'ext' => $ext ,
				'description' => $description ,
				'title4edit' => $title4edit ,
				'homepage4edit' => $homepage4edit ,
				'version4edit' => $version4edit ,
				'platform4edit' => $platform4edit ,
				'url4edit' => $url4edit ,
				'filename4edit' => $filename4edit ,
				'ext4edit' => $ext4edit ,
				'description4edit' => $description4edit ,
				'title4preview' => $title4preview ,
				'description4preview' => $description4preview ,
				'description4sql' => $description4sql ,
				'set4sql' => $set4sql ,
			) ;
		}

		function get_requests_logourl( $usealbum )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			// stripSlashesGPC or intval/Edit data
			if( empty( $usealbum ) ){
				$logourl = $myts->MystripSlashesGPC( @$_POST['logourl'] , $this->encode ) ;
				$logourl4edit = $myts->makeTboxData4Edit( $logourl ) ;
			} else {
				$logourl = intval( @$_POST['logourl'] ) ;
				$logourl4edit = $logourl ;
			}

			// set4sql
			$set4sql = "" ;
			if( empty( $usealbum ) ){
				$set4sql .= ",logourl='".addslashes( $logourl )."'" ;
			} else {
				$set4sql .= ",logourl='".$logourl."'" ;
			}

			return array(
				'logourl' => $logourl ,
				'logourl4edit' => $logourl4edit ,
				'set4sql' => $set4sql ,
			) ;
		}

		function get_requests_admin()
		{
			// get 01
			foreach( array_diff( $this->requests_admin, array( 'cancomment' ) ) as $key ) {
				$$key = empty( $_POST[ $key ] ) ? 0 : 1 ;
			}
			$cancomment = empty( $_POST['comment'] ) ? 0 : 1 ;

			// set4sql
			$set4sql = "" ;
			foreach( array_diff( $this->requests_admin, array( 'cancomment' ) ) as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}
			$set4sql .= ",cancomment='".$cancomment."'" ;

			return array(
				'visible' => $visible ,
				'cancomment' => $cancomment ,
				'set4sql' => $set4sql ,
			) ;
		}

		function return_body_for_preview( $text, $use_htmlpurifierl, $html, $smiley, $xcode, $br )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			if ( strstr ( $text , '[pagebreak]' ) ){
				$text = str_replace( '[pagebreak]','', $text  ) ;
			}
			if( ! empty( $use_htmlpurifierl ) && ! empty( $html ) ){
				$text = $myts->myFilter( $text );
			}
			return $myts->displayTarea( $text, $html, $smiley, $xcode, 1, $br ) ;
		}

		function Validate( $url, $filename )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			// get post data
			$current_requests_text = array_diff( $this->requests_text, array( 'url' , 'filename', 'description' ) );
			foreach( $current_requests_text as $key ) {
				$this->$key = $myts->MystripSlashesGPC( @$_POST[ $key ] ) ;
			}
			if( $this->mode == 'approval' ) {
				$this->description = $myts->stripSlashesGPC( @$_POST['description'] ) ;
			} else {
				$this->description = $myts->stripSlashesGPC( @$_POST['desc'] ) ;
			}
			$this->size = @$_POST['size'] ;

			// Validate
			$void_check = array();
			$void_check = array(
				array(
					'value' => $this->title,
					'type' => array('void'),
					'message' => _MD_D3DOWNLOADS_TITLE_NONE
				), 
				array(
					'value' => $url,
					'type' => array('void'),
					'message' => _MD_D3DOWNLOADS_URL_NONE
				), 
				array(
					'value' => $this->description,
					'type' => array('void'),
					'message' => _MD_D3DOWNLOADS_DESCRIPTION_NONE
				), 
			);

			$url_check = array();
			if ( preg_match('/^'.preg_quote( XOOPS_TRUST_PATH, '/' ).'|^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', $url ) ) {
				$url_check = array(
					array(
						'value' => $url,
						'type' => array('is_file'),
						'message' => _MD_D3DOWNLOADS_URL_CHECK
					), 
				);
			} else {
				$url_check = array(
					array(
						'value' => $url,
						'type' => array('url'),
						'message' => _MD_D3DOWNLOADS_URL_CHECK
					), 
				);
			}

			$homepage_check = array();
			if( $this->homepage != "http://" && ! empty( $this->homepage ) ){
				$homepage_check = array(
					array(
						'value' => $this->homepage,
						'type' => array('url'),
						'message' => _MD_D3DOWNLOADS_HOMEPAGE_CHECK
					), 
				);
			}

			$size_check = array();
			if( ! empty( $this->size ) ) $size_check = array(
				array(
					'value' => array( $this->size, '/^[0-9]+$/' ),
					'type' => array('format'),
					'message' => _MD_D3DOWNLOADS_SIZE_CHECK
				), 
			);

			$max_check = array();
			$max_check = array(
				array(
					'value' => array( $this->title, $this->title_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_TITLE_TOOLONG, $this->title_length )
				), 
				array(
					'value' => array( $url, $this->url_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_URL_TOOLONG, $this->url_length )
				), 
				array(
					'value' => array( $filename, $this->filename_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_FILENAME_TOOLONG, $this->filename_length )
				), 
				array(
					'value' => array( $this->size, $this->size_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_SIZE_TOOLONG, $this->size_length )
				), 
				array(
					'value' => array( $this->homepage, $this->homepage_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_HOMEPAGE_TOOLONG, $this->homepage_length )
				), 
				array(
					'value' => array( $this->version, $this->version_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_VERSION_TOOLONG, $this->version_length )
				), 
				array(
					'value' => array( $this->platform, $this->platform_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_PLATFORM_TOOLONG, $this->platform_length )
				), 
			);

			$params = array_merge( $void_check, $url_check, $homepage_check, $size_check, $max_check );
			$result = $this->post_check->check( $params );

			if( $this->post_check->getErrorCount() && ! preg_match( '/^(https?|ftp):\/\/.+\..+/' , $url ) && ! empty( $filename ) ){
				$this->delete_file( $url ) ;
			}

			return array(
				'error' => $this->post_check->getErrorCount() ,
				'message' => $this->post_check->getErrorMessege() ,
			) ;
		}

		// 不正な文字エンコーディングのチェック
		function Encoding_Check( $value )
		{
			$encoding = _CHARSET ;
			if( is_array( $value ) ){
				return array_map( array( &$this, 'Encoding_Check' ), $value ) ;
			} else {
				if ( function_exists('mb_check_encoding') ) {
					// use mb_check_encoding
					if ( ! mb_check_encoding( $value, $encoding ) ) die( _MD_D3DOWNLOADS_CHECK_ENCODING );
				} else {
					// use mb_convert_encoding
					$str = mb_convert_encoding( $value, $encoding, $encoding );
					if ( $str != $value ) die( _MD_D3DOWNLOADS_CHECK_ENCODING );
				}
			}
		}

		function delete_file( $url )
		{
			if ( file_exists( $url ) ){
				$hql = "SELECT COUNT(*) FROM ".$this->table." WHERE url='".$url."'";
				list( $hcont ) = $this->db->fetchRow( $this->db->query( $hql ) );
				if ( empty( $hcont ) ){
					@unlink( $url );
				}
			}
		}

		function Validate_for_html( $cid )
		{
			$canhtml = $this->user_access->can_html4cid( $cid ) ;
			if( ! $canhtml ) die( 'You cannot use html.' );
		}

		function Validate_for_upload( $cid )
		{
			$canupload = $this->user_access->can_upload4cid( $cid ) ;
			if( ! $canupload ) die( 'You cannot use upload.' );
		}

		function Validate_for_delete( $cid, $lid )
		{
			$candelete = $this->user_access->can_delete4cid( $cid ) ;
			$submitter = $this->xoops_userid ;
			if( ! $candelete ) die( _MD_D3DOWNLOADS_NODELEPERM );
			$sql = "SELECT COUNT(*) FROM ".$this->table." WHERE submitter='".$submitter."' AND lid='".$lid."'";
			list( $count ) = $this->db->fetchRow( $this->db->query( $sql ) );
			if( empty( $count ) ) die( _MD_D3DOWNLOADS_NODELEPERM );
		}

		function Validate_check_url( $url )
		{
			$res = $this->db->query( "SELECT COUNT(*) FROM ".$this->table." WHERE url='".$url."'") ;
			list( $urlsum ) = $this->db->fetchRow( $res ) ;
			if( ! empty( $urlsum ) ){
				redirect_header( XOOPS_URL.'/modules/'.$this->mydirname.'/',3, _MD_D3DOWNLOADS_URL_ONCE );
				exit();
			}
		}

		function Validate_check_unapproval( $url )
		{
			$res = $this->db->query( "SELECT COUNT(*) FROM ".$this->db->prefix( $this->mydirname."_unapproval" )." WHERE url='".$url."'") ;
			list( $sum ) = $this->db->fetchRow( $res ) ;
			if( ! empty( $sum ) ){
				redirect_header(XOOPS_URL.'/modules/'.$this->mydirname.'/',3, _MD_D3DOWNLOADS_UNAPPROVAL_ONCE );
				exit();
			}
		}
	}
}

?>