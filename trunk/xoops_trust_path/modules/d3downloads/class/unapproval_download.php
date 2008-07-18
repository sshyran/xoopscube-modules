<?php

// for unapproval_data edit

if( ! class_exists( 'unapproval_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;

	class unapproval_download extends MyDownload
	{
		var $db;
		var $table;
		var $requestid;
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
		var $visible ;
		var $cancomment ;
		var $notify ;
		var $unapprovaldata=array();

		function unapproval_download( $mydirname )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->table = $this->db->prefix( "{$mydirname}_unapproval" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = implode( ',' , array_diff( $GLOBALS['d3download_tables']['unapproval'] , array( 'mail' , 'kanrisya' ) ) ) ;
			$this->columns = $columns ;
		}

		function get_unapprovaldata( $requestid, $category )
		{
			$result = $this->db->query("SELECT $this->columns  FROM ".$this->table."  WHERE requestid='".$requestid."'");
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result ) ;
			$cid = $this->return_cid() ;
			$modify = ! empty( $this->lid ) ? TRUE : FALSE ;
			$aprovalid = $this->return_lid() ;
			$submitter = $this->return_submitter() ;
			$user_url = $this->return_user_url( $submitter ) ;
			$url = $this->return_url('Edit') ;
			$filename = $this->return_filename('Edit') ;
			$ext = $this->return_ext('Edit') ;
			$filelink = $this->file_link_for_post( $url, $filename, $ext ) ;
			if( empty( $usealbum ) ){
				$logourl = $this->return_logourl('Edit') ;
			} else {
				$logourl = intval( $this->logourl ) ;
			}
			$unapprovaldata = array(
				'requestid' => $this->return_requestid() ,
				'lid' => $aprovalid ,
				'cid' => $cid ,
				'category' => $category ,
				'title' => $this->return_title('Edit') ,
				'url' => $url ,
				'filelink' => $filelink ,
				'filename' => $filename ,
				'ext' => $this->return_ext('Edit') ,
				'homepage' => $this->return_homepage('Edit') ,
				'version' => $this->return_version('Edit') ,
				'size' =>  $this->return_size() ,
				'platform' => $this->return_platform('Edit') ,
				'logourl' => $logourl ,
				'description' => $this->return_description('Edit') ,
				'html' => $this->return_html() ,
				'smiley' => $this->return_smiley() ,
				'br' => $this->return_br() ,
				'xcode' => $this->return_xcode() ,
				'submitter' => $submitter ,
				'postname' => $this->getlink_for_postname( $submitter ) ,
				'user_url' => $user_url ,
				'date' => $this->return_date() ,
				'modify' => $modify ,
				'visible' => $this->return_visible() ,
				'cancomment' => $this->return_cancomment() ,
				'notify' => $this->return_notify() ,
			) ;
			return array(
				'cid'  => $cid ,
				'aprovalid'  => $aprovalid,
				'user_url'  => $user_url,
				'unapprovaldata' => $unapprovaldata ,
			) ;
		}

		function return_requestid()
		{
			return intval( $this->requestid ) ;
		}

		function return_notify()
		{
			return $this->notify ? 1 : 0 ;
		}
	}
}

?>