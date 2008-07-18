<?php

if( !class_exists( 'MyTree' ) )
{
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class MyTree
	{
		var $table;     // table with parent-child structure
		var $id;        // name of unique id for records in table $table
		var $pid;       // name of parent id used in table $table
		var $whr;       // specifies the where of query results
		var $title;     // name of a field in table $table which will be used when  selection box and paths are generated
		var $db;

		function MyTree( $table_name, $id_name, $pid_name )
		{
			$this->db =& Database::getInstance();
			$this->table = $table_name;
			$this->id = $id_name;
			$this->pid = $pid_name;
		}

		function getFirstChild( $select_id , $whr='' )
		{
			$arr =array();
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->pid."=".$select_id."";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$sql .= " ORDER BY cat_weight";
			$result = $this->db->query( $sql );
			$count = $this->db->getRowsNum( $result );
			if ( $count==0 ) {
				return $arr;
			}
			while ( $myrow=$this->db->fetchArray( $result ) ) {
				array_push( $arr, $myrow );
			}
			return $arr;
		}

		function getFirstChildId( $select_id, $whr='' )
		{
			$idarray =array();
			$sql = "SELECT ".$this->id." FROM ".$this->table." WHERE ".$this->pid."=".$select_id."";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result=$this->db->query( $sql );
			$count = $this->db->getRowsNum( $result );
			if ( $count == 0 ) {
				return $idarray;
			}
			while ( list( $id ) = $this->db->fetchRow( $result ) ) {
				array_push( $idarray, $id );
			}
			return $idarray;
		}

		function getAllChildId( $select_id, $whr='', $idarray = array() )
		{
			$sql = "SELECT ".$this->id." FROM ".$this->table." WHERE ".$this->pid."=".$select_id."";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$sql .= " ORDER BY cat_weight";
			$result=$this->db->query( $sql );
			$count = $this->db->getRowsNum( $result );
			if ( $count==0 ) {
				return $idarray;
			}
			while ( list( $r_id ) = $this->db->fetchRow( $result ) ) {
				array_push( $idarray, $r_id );
				$idarray = $this->getAllChildId( $r_id, $whr, $idarray );
			}
			return $idarray;
		}

		function getAllParentId( $select_id, $whr='', $idarray = array() )
		{
			$sql = "SELECT ".$this->pid." FROM ".$this->table." WHERE ".$this->id."=".$select_id."";
			if ( $whr != '' ) {
				$sql .= ' AND ( $whr )';
			}
			$sql .= " ORDER BY cat_weight";
			$result=$this->db->query( $sql );
			list( $r_id ) = $this->db->fetchRow( $result );
			if ( $r_id == 0 ) {
				return $idarray;
			}
			array_push($idarray, $r_id);
			$idarray = $this->getAllParentId( $r_id, $whr, $idarray );
			return $idarray;
		}

		function getPathFromId( $select_id, $whr='' , $title, $path='' )
		{
			$sql = "SELECT ".$this->pid.", ".$title." FROM ".$this->table." WHERE ".$this->id."=$select_id";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result=$this->db->query($sql);
			if ( $this->db->getRowsNum($result) == 0 ) {
				return $path;
			}
			list( $parentid, $name ) = $this->db->fetchRow( $result );
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			$name = $myts->makeTboxData4Show( $name );
			$path = '/'.$name.$path.'';
			if ( $parentid == 0 ) {
				return $path;
			}
			$path = $this->getPathFromId( $parentid, $whr, $title, $path );
			return $path;
		}

		function getNicePathFromId( $select_id, $title, $whr='' , $funcURL, $path='')
		{
			$sql = "SELECT ".$this->pid.", ".$title." FROM ".$this->table." WHERE ".$this->id."=$select_id";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return $path;
			}
			list( $parentid, $name ) = $this->db->fetchRow( $result );
			$myts =& d3downloadsTextSanitizer::getInstance() ;
			$name = $myts->makeTboxData4Show( $name );
			$path = '<a href="'.$funcURL.'&amp;'.$this->id.'='.$select_id.'">'.$name.'</a>&nbsp;:&nbsp;'.$path.'';
			if ( $parentid == 0 ) {
				return $path;
			}
			$path = $this->getNicePathFromId( $parentid, $title, $whr, $funcURL, $path );
			return $path;
		}

		function getNicePathArrayFromId( $select_id, $title, $whr='', $funcURL, $path=array() )
		{
			$sql = "SELECT ".$this->pid.", ".$title." FROM ".$this->table." WHERE ".$this->id."=$select_id";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array_reverse( $path );
			}
			list( $parentid, $name ) = $this->db->fetchRow( $result );
			$name = htmlspecialchars( $name , ENT_QUOTES );
			$liason = ( ereg("\?", $funcURL ) )?'&amp;':'?';
			$path[] = array(
				'url'=>$funcURL.$liason.'cid='.intval( $select_id ),
				'name'=>$name
			);
			$path = $this->getNicePathArrayFromId( $parentid, $title, $whr, $funcURL, $path );
			return $path;
		}

		function getIdPathFromId( $select_id, $whr='' , $path='' )
		{
			$sql = "SELECT ".$this->pid." FROM ".$this->table." WHERE ".$this->id."=$select_id";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return $path;
			}
			list( $parentid ) = $this->db->fetchRow( $result );
			$path = '/'.$select_id.$path.'';
			if ( $parentid == 0 ) {
				return $path;
			}
			$path = $this->getIdPathFromId( $parentid, $path );
			return $path;
		}

		function getAllChild( $select_id=0, $whr='',$parray = array() )
		{
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->pid."=".$select_id."";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$sql .= " ORDER BY cat_weight";
			$result = $this->db->query( $sql );
			$count = $this->db->getRowsNum( $result );
			if ( $count == 0 ) {
				return $parray;
			}
			while ( $row = $this->db->fetchArray( $result ) ) {
				array_push($parray, $row);
				$parray=$this->getAllChild( $row[$this->id], $parray );
			}
			return $parray;
		}

		function getChildTreeArray( $select_id=0, $whr='',$parray = array(), $r_prefix='' )
		{
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->pid."=".$select_id."";
			if ( $whr != '' ) {
				$sql .= " AND ( $whr )";
			}
			$sql .= " ORDER BY cat_weight";
			$result = $this->db->query( $sql );
			$count = $this->db->getRowsNum( $result );
			if ( $count == 0 ) {
				return $parray;
			}
			while ( $row = $this->db->fetchArray( $result ) ) {
				$row['prefix'] = $r_prefix.'.';
				array_push( $parray, $row );
				$parray = $this->getChildTreeArray( $row[ $this->id ], $whr , $parray, $row['prefix'] );
			}
			return $parray;
		}
	}
}

?>