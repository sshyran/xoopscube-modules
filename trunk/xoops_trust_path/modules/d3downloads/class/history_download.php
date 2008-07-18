<?php

// for history_data , history_list

if( ! class_exists( 'history_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class history_download extends MyDownload
	{
		var $db;
		var $table;
		var $id;
		var $lid;
		var $cid;
		var $title;
		var $url;
		var $filename;
		var $ext;
		var $description;
		var $date;
		var $category;
		var $history=array();

		function history_download( $mydirname )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;
			$this->db =& Database::getInstance();
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads_history" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = 'h.'.implode( ',h.' , $GLOBALS['d3download_tables']['downloads_history'] ) ;
			$columns .= ', c.title AS category';
			$this->columns = $columns ;
			$columns4list = implode( ',' , $GLOBALS['d3download_tables']['downloads_history'] ) ;
			$this->columns4list = $columns4list ;
		}

		function get_history_data( $history_id )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			$result = $this->db->query("SELECT $this->columns FROM ".$this->table." h LEFT JOIN ".$this->cat_table." c ON h.cid=c.cid WHERE id='".$history_id."'");
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result );
			$lid = intval( $this->lid );
			$url = $myts->makeTboxData4URLShow( $this->url );
			$filename = $myts->makeTboxData4Show( $this->filename ) ;
			$ext = $myts->makeTboxData4Show( $this->ext ) ;
			$filelink = $this->file_link( $url, $filename, $ext );
			$history = array(
				'id' => intval( $this->id ) ,
				'lid' => $lid ,
				'cid' => intval( $this->cid ) ,
				'title' => $myts->makeTboxData4Show( $this->title ) ,
				'url' => $url ,
				'filelink' => $filelink ,
				'filename' => $filename ,
				'ext' => $ext ,
				'description' => $myts->displayTarea( $this->description, 0, 1, 1, 1, 1 ) ,
				'date' => formatTimestamp( intval( $this->date ) ) ,
				'ctitle' => $myts->makeTboxData4Show( $this->category ) ,
			) ;
			return array(
				'lid'  => $lid ,
				'historydata' => $history ,
			) ;
		}

		function get_history_list( $lid, $id=0 )
		{
			$myts =& d3downloadsTextSanitizer::getInstance() ;

			$sql = "SELECT $this->columns4list FROM ".$this->table." WHERE lid='".$lid."'" ;
			if ( ! empty( $id ) ){
				$sql .= " AND id NOT IN ('".$id."')" ;
			}
			$sql .= " ORDER BY id DESC" ;
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array();
			}
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$history[] = array(
					'history_id' => intval( $this->id ) ,
					'history_lid' => intval( $this->lid ) ,
					'history_cid' => intval( $this->cid ) ,
					'history_title' => $myts->makeTboxData4Show( $this->title ) ,
					'history_url' => $myts->makeTboxData4URLShow( $this->url ) ,
					'history_filename' => htmlspecialchars( $this->filename , ENT_QUOTES ) ,
					'history_ext' => htmlspecialchars( $this->ext , ENT_QUOTES ) ,
					'history_description' => $myts->makeTboxData4Show( $this->description ) ,
					'history_date' => formatTimestamp( intval( $this->date ) ) ,
				) ;
			}
			return $history ;
		}

		function file_link( $url, $filename, $ext )
		{
			$exception = '\.'.implode( '|\.',$this->Exception_extension() );
			if ( ! preg_match('/^(https?|ftp):\/\//', $url ) ) {
				if( ! file_exists( $url ) ){
					$filelink = $url.'<br />( <font color="#FF0000"><b>broken file !!</b></font> )';
				} elseif( filesize( $url ) == 0) {
					$filelink = $url.'<br />( <font color="#FF0000"><b>broken file !!</b></font> )';
				} else {
					if ( ! empty( $filename ) ){
						$filelink =  '<a href="'.$this->mod_url.'/index.php?page=visit_url&url='.$url.'&filename='.$filename.'&ext='.$ext.'" id="access_url">'.$url.'</a>' ;
					} else {
						$filelink =  '<a href="'.$this->mod_url.'/index.php?page=visit_url&url='.$url.'" id="access_url">'.$url.'</a>' ;
					}
				}
			} elseif ( preg_match('/('.$exception.')$/i', $url ) ) {
				$filelink =  '<a href="'.$url.'" id="access_url">'.$url.'</a>' ;
			} else {
				$filelink =  '<a href="'.$url.'" id="access_url" target="_blank">'.$url.'</a>' ;
			}
			return $filelink ;
		}
	}
}

?>