<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;


class flatdataFieldsClass
{
	//DB
	var $db ;
	var $table;
	
	//field
	var $fid     = 'fid' ;
	var $fname   = 'fname' ;
	var $forder  = 'forder' ;
	var $visible = 'visible' ;

	function flatdataFieldsClass( $mydirname )
	{
		$this->db =& Database::getInstance() ;
		$this->table = $this->db->prefix( $mydirname."_field" ) ;
	}

	function getAllFields(){
		$sql = $this->baseSelectSql() ;
		$sql.= " ORDER BY ". $this->forder ." ASC , ". $this->fid ." ASC " ;
		$result = $this->db->query($sql) ;
		$returnrow = array() ;
		while( $row = $this->db->fetchArray($result) ){
			$row[$this->fname] = htmlspecialchars($row[$this->fname], ENT_QUOTES) ;
			$returnrow[] = $row ;
		}
		return $returnrow ;
	}
	
	function baseSelectSql(){
		$sql = "SELECT * FROM ". $this->table ;
		return $sql ;
	}
	
	function getField( $fid ){
		$row = false;
		if($fid>0){
			$sql = $this->baseSelectSql() ;
			$sql.= " WHERE ".$this->fid."=$fid";
			$result = $this->db->query($sql) ;
			$row = $this->db->fetchArray($result);
			$row[$this->fname] = htmlspecialchars( $row[$this->fname] , ENT_QUOTES ) ;
		}
		return $row ;
	}

	function getPOSTDATA(){
		$myts =& MyTextSanitizer::getInstance();
		$ret = array();
		$ret[$this->fid]    = isset($_POST[$this->fid])     ? intval($_POST[$this->fid])    : 0 ;
		$ret[$this->forder] = isset($_POST[$this->forder])  ? intval($_POST[$this->forder]) : 0 ;
		$ret[$this->fname]  = isset($_POST[$this->fname])   ? $myts->stripSlashesGPC($_POST[$this->fname]) : "" ;
		$ret[$this->visible] = isset($_POST[$this->visible]) ? intval($_POST[$this->visible]) : 0 ;
		return $ret;
	}

	function insert(){
		$rtn = false;
		$postdata = $this->getPOSTDATA();
		if( !empty($postdata[$this->fname]) ){
			//SQL
			$sql = "INSERT INTO ". $this->table ." SET " ;
			$sql.= $this->forder ."='". $postdata[$this->forder] ."' , " ;
			$sql.= $this->fname  ."='". addslashes($postdata[$this->fname]) ."' , " ;
			$sql.= $this->visible."='". $postdata[$this->visible] ."'" ;
			//var_dump($sql);
			$this->db->query($sql) or die( "DB Error: Insert Field" );
			$rtn = true;
		}
		return $rtn;
	}
	
	function update( $fid=0 ){
		$rtn = false;
		if( $fid>0 && $this->getField($fid) ){
			$postdata = $this->getPOSTDATA();
			if( !empty($postdata[$this->fname]) ){
				$sql = "UPDATE ". $this->table ." SET ";
				$sql.= $this->fname  ."='". addslashes($postdata[$this->fname]) ."' , " ;
				$sql.= $this->forder ."='". $postdata[$this->forder] ."' , " ;
				$sql.= $this->visible."='". $postdata[$this->visible] ."' " ;
				$sql.= " WHERE fid='$fid'" ;
				$this->db->query($sql) or die( "DB Error: UPDATE field" );
				$rtn = true;
			}
		}
		return $rtn ;
	}

	function delete( $fid=0 ){
		$rtn = false;
		if( $fid>0 && $this->getField($fid) ){
			$sql = "DELETE FROM ". $this->table ." WHERE fid=". intval($fid) ;
			$this->db->query($sql) or die( "DB Error: DELETE field" );
			$rtn = true ;
		}
		return $rtn ;
	}

	function getFidArray($type='all'){
		$sql = $this->baseSelectSql() ;
		$sql.= " ORDER BY ". $this->forder ." ASC , ". $this->fid ." ASC " ;
		$result = $this->db->query($sql) ;
		$returnrow = array() ;
		while( $row = $this->db->fetchArray($result) ){
			if( ($type=='list' && $row[$this->visible]==1) || $type=='all' ){
				$returnrow[] = $row[$this->fid] ;
			}
		}
		return $returnrow ;
	}

}
?>