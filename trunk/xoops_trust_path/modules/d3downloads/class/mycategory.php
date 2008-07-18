<?php

// for Category_Data , Edit , set4sql etc.

if( ! class_exists( 'MyCategory' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class MyCategory
	{
		var $mode = "" ;
		var $db ;
		var $cat_table ;
		var $cid ;
		var $pid ;
		var $title ;
		var $imgurl ;
		var $shotsdir ;
		var $cat_weight ;
		var $submit_message ;
		var $categorydata = array();
		var $requests_text = array( 'title' , 'imgurl' , 'shotsdir' , 'submit_message' ) ;
		var $title_length = 50 ;
		var $imgurl_length = 150 ;
		var $shotsdir_length = 150 ;
		var $cat_weight_length = 5 ;

		function MyCategory( $mydirname, $mode, $cid= 0, $whr='' )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->mydirname = $mydirname ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$columns = implode( ',' , $GLOBALS['d3download_tables']['cat'] ) ;
			$this->columns = $columns ;
			$this->mode = $mode ;
			if( $mode == 'Show' && ! empty( $cid ) ) {
				$this->GetMyCategory( $cid, $whr ) ;
			}
			if( $mode == 'Edit') {
				require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
				$this->post_check = new Post_Check() ;

				// Delete_Nullbyte
				$myts =& d3downloadsTextSanitizer::getInstance() ;
				$_POST = $myts->Delete_Nullbyte( $_POST ) ;

				// requests_int Initialization
				$cid = 0 ;
				$pid = 0 ;
				$cat_weight = 0 ;
				// requests_text Initialization
				$title = "" ;
				$imgurl = "" ;
				$shotsdir = "" ;
				$submit_message = "" ;
			}
		}

		function GetMyCategory( $cid, $whr=''  )
		{
			$sql = "SELECT $this->columns FROM ".$this->cat_table." WHERE cid='".$cid."'";
			if ( $whr != '' ) {
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

		function Category_Sum()
		{
			$sql = "SELECT COUNT(*) FROM ".$this->cat_table."";
			list( $count ) = $this->db->fetchRow( $this->db->query( $sql ) );
			return $count ;
		}

		function return_cid()
		{
			return intval( $this->cid ) ;
		}

		function return_pid()
		{
			return intval( $this->pid ) ;
		}

		function return_title()
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $this->mode == 'Show'){
				return $myts->makeTboxData4Show( $this->title ) ;
			} elseif( $this->mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->title ) ;
			}
		}

		function return_imgurl()
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $this->mode == 'Show'){
				return $myts->makeTboxData4Show( $this->imgurl ) ;
			} elseif( $this->mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->imgurl ) ;
			}
		}

		function return_shotsdir()
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $this->mode == 'Show'){
				return $myts->makeTboxData4Show( $this->shotsdir ) ;
			} elseif( $this->mode == 'Edit') {
				return $myts->makeTboxData4Edit( $this->shotsdir ) ;
			}
		}

		function return_cat_weight()
		{
			return intval( $this->cat_weight ) ;
		}

		function return_submit_message()
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			if( $this->mode == 'Show'){
				return $myts->displayTarea( $this->submit_message , 1, 1, 1, 1, 1 ) ;
			} elseif( $this->mode == 'Edit') {
				return $myts->makeTareaData4Edit( $this->submit_message ) ;
			}
		}

		function MyCategory_for_Edit( $cid )
		{
			if( empty( $cid ) ){
				$count = $this->Category_Sum() ;
				return array(
					'cat_weight' =>  $count ,
				) ;
			} else {
				$this->GetMyCategory( $cid ) ;
				return array(
					'cid' => $this->return_cid() ,
					'pid' => $this->return_pid() ,
					'title' => $this->return_title() ,
					'imgurl' => $this->return_imgurl() ,
					'shotsdir' => $this->return_shotsdir() ,
					'cat_weight' =>  $this->return_cat_weight() ,
					'submit_message' => $this->return_submit_message() ,
				) ;
			}
		}

		function requests_int_categories()
		{
			// get requests_int
			$cid = intval( @$_POST['cid'] ) ;
			$pid = intval( @$_POST['maincategory'] ) ;
			$cat_weight = intval( @$_POST['cat_weight'] ) ;

			// set4sql
			$set4sql = "cid='".$cid."'" ;
			$set4sql .= ",cat_weight='".$cat_weight."'" ;
			$set4sql .= ",pid='".$pid."'" ;

			return array(
				'cid' => $cid ,
				'pid' => $pid ,
				'cat_weight' => $cat_weight ,
				'set4sql' => $set4sql ,
			) ;
		}

		function requests_text_categories()
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			// stripSlashesGPC
			foreach( $this->requests_text as $key ) {
				$$key = $myts->MystripSlashesGPC( @$_POST[ $key ] ) ;
			}

			// Data4Edit
			$title4edit = $myts->makeTboxData4Edit( $title );
			$imgurl4edit = $myts->makeTboxData4Edit( $imgurl );
			$shotsdir4edit = $myts->makeTboxData4Edit( $shotsdir );
			$submit_message4edit = $myts->makeTareaData4Edit( $submit_message );

			// set4sql
			$set4sql = "" ;
			foreach( $this->requests_text as $key ) {
				$set4sql .= ",$key='".addslashes($$key)."'" ;
			}

			return array(
				'title' => $title ,
				'imgurl' => $imgurl ,
				'shotsdir' => $shotsdir ,
				'title4edit' => $title4edit ,
				'imgurl4edit' => $imgurl4edit ,
				'shotsdir4edit' => $shotsdir4edit ,
				'submit_message4edit' => $submit_message4edit ,
				'set4sql' => $set4sql ,
			) ;
	    }

		function Validate()
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			// get post data
			$current_requests_text = array_diff( $this->requests_text, array( 'submit_message' ) );
			foreach( $current_requests_text as $key ) {
				$this->$key = $myts->MystripSlashesGPC( @$_POST[ $key ] ) ;
			}
			$this->cat_weight = @$_POST['cat_weight'] ;

			// Validate
			$void_check = array();
			$void_check = array(
				array(
					'value' => $this->title,
					'type' => array('void'),
					'message' => _MD_D3DOWNLOADS_TITLE_NONE
				), 
			);

			$imgurl_check = array();
			if( $this->imgurl != 'http://' && ! empty( $this->imgurl ) ) {
				$imgurl_check = array(
					array(
						'value' => $this->imgurl,
						'type' => array('url'),
						'message' => _MD_D3DOWNLOADS_IMGURL_CHECK
					), 
				);
			}

			$shotsdir_check = array();
			if( ! empty( $this->shotsdir ) ){
				$cate_shotsdir = XOOPS_ROOT_PATH.'/'.$this->shotsdir ;
				$shotsdir_check = array(
					array(
						'value' => $cate_shotsdir,
						'type' => array('file_exists'),
						'message' => _MD_D3DOWNLOADS_SHOTSDIR_CHECK
					), 
				);
			}

			$max_check = array();
			$max_check = array(
				array(
					'value' => array( $this->title, $this->title_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_TITLE_TOOLONG, $this->title_length )
				), 
				array(
					'value' => array( $this->imgurl, $this->imgurl_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_IMGURL_TOOLONG, $this->imgurl_length )
				), 
				array(
					'value' => array( $this->shotsdir, $this->shotsdir_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_SHOTSDIR_TOOLONG, $this->shotsdir_length )
				), 
				array(
					'value' => array( $this->cat_weight, $this->cat_weight_length ),
					'type' => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_CAT_WEIGHT_TOOLONG, $this->cat_weight_length )
				), 
			) ;

			$params = array_merge( $void_check, $imgurl_check, $shotsdir_check, $max_check ) ;
			$result = $this->post_check->check( $params );
			return array(
				'error' => $this->post_check->getErrorCount() ,
				'message' => $this->post_check->getErrorMessege() ,
			) ;
		}
	}
}

?>