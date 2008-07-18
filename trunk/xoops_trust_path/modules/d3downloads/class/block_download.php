<?php

// for block_view

if( ! class_exists( 'block_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;

	class block_download extends MyDownload
	{
		var $db;
		var $table;
		var $whr;
		var $entry = 10;
		var $title_size = 25;
		var $date_format = 'Y/m/d';
		var $order = 'd.date DESC';
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

		function block_download( $mydirname )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = 'd.'.implode( ',d.' , array_diff( $GLOBALS['d3download_tables']['downloads'] , array( 'mail' , 'visible' , 'kanrisya' ) ) ) ;
			$columns .= ', c.title AS category';
			$this->columns = $columns ;
		}

		function get_downdata_for_block( $whr, $entry, $title_size, $date_format, $type, $order, $categories='' )
		{
			$sql = "SELECT $this->columns FROM ".$this->table." d LEFT JOIN ".$this->cat_table." c ON d.cid=c.cid WHERE d.visible = '1' AND ( $whr )";
			if( ! empty( $categories ) ){
				$sql .= " AND ( $categories )";
			}
			$sql .= " ORDER BY $order";
			$result = $this->db->query( $sql, $entry, 0 );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			} else {
				return $this->get_downdata( $result, $title_size, $date_format, $type );
			}
		}

		function get_downdata( $result, $title_size, $date_format, $type )
		{
			global $xoopsConfig ;

			require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$lid = $this->return_lid() ;
				$cid = $this->return_cid() ;
				$title = $this->return_title('Show') ;
				if ( $type != 3 && $title_size ) {
					if ( strlen( $title ) >=  $title_size ) {
						$title = xoops_substr( $title,  0 , ( $title_size -1 ) ) ;
					}
				}
				$submitter = $this->return_submitter() ;
				$date = $this->return_date() ;
				$html = $this->return_html() ;
				$smiley = $this->return_smiley() ;
				$xcode = $this->return_xcode() ;
				$br = $this->return_br() ;
				$str = $this->return_body( $lid, $cid, $this->return_description('Show'), 0, 1 ) ;
				$body = $myts->displayTarea( $str, $html, $smiley, $xcode, 1, $br ) ;
				$downdata[] = array(
					'lid' => $lid,
					'cid' => $cid,
					'title' => $title,
					'category' => $this->return_category('Show'),
					'url' => $this->return_url('Show') ,
					'homepage' => $this->return_homepage('Show') ,
					'version' => $this->return_version('Show') ,
					'size' =>  $this->PrettySize( $this->return_size(), 1 ),
					'platform' => $this->return_platform('Show') ,
					'logourl' => $this->return_logourl('Show') ,
					'description' => $myts->MyhtmlSpecialChars( $this->return_description('Show') ) ,
					'body' =>  $body,
					'postname' =>  $this->getlink_for_postname( $submitter ),
					'updated' => formatTimestamp( $date, $date_format, $xoopsConfig['default_TZ'] ),
					'date' => $date ,
					'hits' => $this->return_hits() ,
					'rating' => $this->return_rating() ,
					'votes' => $this->return_votes() ,
					'comments' => $this->return_comments() ,
				);
			}
			return $downdata;
		}
	}
}

?>