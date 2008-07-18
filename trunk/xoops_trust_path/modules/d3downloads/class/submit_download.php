<?php

// for submit_data edit

if( ! class_exists( 'submit_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;

	class submit_download extends MyDownload
	{
		var $db;
		var $table;
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
		var $visible ;
		var $cancomment ;
		var $comments ;
		var $downdata=array();

		function submit_download( $mydirname )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = implode( ',' , array_diff( $GLOBALS['d3download_tables']['downloads'] , array( 'mail' , 'kanrisya' ) ) ) ;
			$this->columns = $columns ;
		}

		function get_downdata_for_submit( $lid, $category )
		{
			$result = $this->db->query("SELECT  $this->columns  FROM ".$this->table."  WHERE lid='".$lid."'");
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result ) ;
			$lid = $this->return_lid() ;
			$cid = $this->return_cid() ;
			$submitter = $this->return_submitter() ;
			$user_url = $this->return_user_url( $submitter ) ;
			$url = $this->return_url('Edit') ;
			$filename = $this->return_filename('Edit') ;
			$ext = $this->return_ext('Edit') ;
			if( empty( $usealbum ) ){
				$logourl = $this->return_logourl('Edit') ;
			} else {
				$logourl = intval( $this->logourl ) ;
			}
			$title = $this->return_title('Edit') ;
			$hits = $this->return_hits() ;
			$totalrating = $this->return_rating() ;
			$totalvotes =  $this->return_votes() ;
			$comments = $this->return_cancomment() ;
			
			$downdata = array(
				'lid' => $lid ,
				'cid' => $cid ,
				'category' => $category ,
				'title' => $title ,
				'url' => $url ,
				'filename' => $filename ,
				'ext' => $ext ,
				'filelink' => $this->file_link_for_post( $this->return_url('Show'), $filename, $ext ) ,
				'homepage' => $this->return_homepage('Edit') ,
				'version' => $this->return_version('Edit') ,
				'size' =>  $this->return_size() ,
				'platform' => $this->return_platform('Edit') ,
				'logourl' => $logourl ,
				'description' => $this->return_description('Edit') ,
				'submitter' => $submitter ,
				'postname' => $this->getlink_for_postname( $submitter ) ,
				'user_url' => $user_url ,
				'html' => $this->return_html() ,
				'smiley' => $this->return_smiley() ,
				'br' => $this->return_br() ,
				'xcode' => $this->return_xcode() ,
				'date' => $this->return_date() ,
				'visible' => $this->return_visible() ,
				'cancomment' => $this->return_cancomment() ,
			) ;
			return array(
				'lid'  => $lid ,
				'cid'  => $cid ,
				'submitter'  => $submitter,
				'user_url'  => $user_url,
				'title'  => $title,
				'hits'  => $hits ,
				'totalrating' => $totalrating ,
				'totalvotes' => $totalvotes ,
				'comments' => $comments ,
				'downdata' => $downdata ,
			) ;
		}
	}
}

?>