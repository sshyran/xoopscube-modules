<?php

class PresentLocation
{
	var $db ;

	var $subid = array() ;

	var $gwhr ;

	var $table_menu ;
	var $table_addurl ;
	var $table_access ;
	var $mydirname ;

	var $request_uri ;
	var $script_name ;
	var $script_name_r ;
	var $query_str ;

	function PresentLocation()
	{
		global $xoopsUser ;
		if( is_object($xoopsUser) ) {
			$member_handler =& xoops_gethandler( 'member' ) ;
			$groups = $member_handler->getGroupsByUser( $xoopsUser->getVar('uid') ) ;
		} else {
			$groups = array( XOOPS_GROUP_ANONYMOUS );
		}
		$this->gwhr = ' ( groupid='. join(' OR groupid=',$groups) .' ) ';
		$this->db =& Database::getInstance();
	}
	
	function &getInstance()
	{
		static $instance ;
		if (!isset($instance)) {
			$instance = new PresentLocation();
		}
		return $instance;
	}

	function setting($mydirname)
	{
		$httphost = xoops_getenv('HTTP_HOST') ;
		$domain_dir = strstr( XOOPS_URL , $httphost );
		$dir = str_replace( $httphost , '' , $domain_dir );
		$request_uri = xoops_getenv('REQUEST_URI') ;
		$script_name = xoops_getenv('SCRIPT_NAME') ;
		if( !empty($dir) ){
			$request_uri = str_replace( $dir , '' , $request_uri );
			$script_name = str_replace( $dir , '' , $script_name );
		}
		$this->request_uri = addslashes( $request_uri ) ;
		$this->script_name = addslashes( $script_name ) ;
		$this->script_name_r = str_replace( 'index.php', '', $this->script_name );
		$this->query_str = xoops_getenv('QUERY_STRING') ;
		
		$this->mydirname = $mydirname ;
		$this->table_menu   = $this->db->prefix( $mydirname."_menu" ) ;
		$this->table_addurl = $this->db->prefix( $mydirname."_addurl" ) ;
		$this->table_access = $this->db->prefix( $mydirname."_access" ) ;
	}


	//search subid!
	function search()
	{
		//1
		if( empty($this->subid[$this->mydirname]) ){
			$whr = " url='". $this->request_uri ."' ";
						 //echo "1: " ;
						 //var_dump($whr);
			$this->tableMenuSearch($whr);
		}
		//2
		if( empty($this->subid[$this->mydirname]) && !empty($this->query_str) ){
			$whr = "( ". $this->QueryStringSql() ." )" ;
				//		 echo "2: " ;
			$this->tableMenuSearch($whr);
		}
		//3
		if( empty($this->subid[$this->mydirname]) ){
			$whr = " url='". $this->request_uri ."' ";
			if( !empty($this->query_str) ) $whr .= " OR " . $this->QueryStringSql();
			$whr = "( ". $whr ." )" ;
				//		 echo "3: " ;
			$this->tableAddurlSearch($whr);
		}
		//4
		if( empty($this->subid[$this->mydirname]) ){
		  if( $this->request_uri != $this->script_name_r && $this->script_name!=$this->script_name_r ){
			$whr = " url='".$this->script_name_r."'" ;
				//		 echo "4: " ;
			$this->tableMenuSearch($whr);
		  }
		}
		//5
		if( empty($this->subid[$this->mydirname]) ){
			$whr = " url='".$this->script_name."'" ;
				//		 echo "5: " ;
			$this->tableMenuSearch($whr);
		}
		//6
		if( empty($this->subid[$this->mydirname]) ){
			$whr = "( url='". $this->script_name ."' OR url LIKE '". $this->script_name ."%' )";
				//		 echo "6: " ;
			$this->tableAddurlSearch($whr);
		}
		//7
		if( empty($this->subid[$this->mydirname]) ){
			$cuturl = str_replace( strrchr($this->script_name,"/") , '' , $this->script_name ) ."/" ;
			if( $cuturl != '/' ){
				$whr = " url LIKE '$cuturl%' ";
				//		 echo "7: " ;
				$this->tableMenuSearch( $whr , false );
			}
		}
		if( empty($this->subid[$this->mydirname]) ) $this->subid[$this->mydirname] = 0 ;
				//		echo "<br />";
				//var_dump($this->subid[$this->mydirname]);
	}

	function tableMenuSearch( $whr , $asc=true )
	{
		$sql = "SELECT DISTINCT m.subid, m.hiera FROM ".$this->table_menu." AS m LEFT OUTER JOIN ".$this->table_access." AS a ON m.subid=a.subid WHERE $whr AND ".$this->gwhr." AND a.visible>0";
				//	 echo $sql."<br />";
		$result = $this->db->query($sql);
		$this->subid[$this->mydirname] = $this->sortSubids( $result , $asc );
	}

	function tableAddurlSearch( $whr )
	{
		$sql = "SELECT DISTINCT u.subid FROM ".$this->table_addurl." AS u LEFT OUTER JOIN ".$this->table_access." AS a ON u.subid=a.subid WHERE $whr AND ".$this->gwhr." AND a.visible>0";
		//			 echo $sql."<br />";
		$result = $this->db->query($sql);
		list( $subid ) = $this->db->fetchRow($result);
		$this->subid[$this->mydirname] = $subid ;
	}


	//Get subid of the deepest hierarcy //for table_menu
	function sortSubids( $result , $asc=true )
	{
		$subid_a = array();
		while( list( $subid,$hiera ) = $this->db->fetchRow($result) ){
			$subid_a[ $hiera ] = $subid;
		}
		if( $asc ) {
			ksort( $subid_a );
		}else{
			krsort( $subid_a );
		}
		return end( $subid_a );
	}

	//create SQL QUERY from $_SERVER['QUERY_STRING']
	function QueryStringSql()
	{
		$whr = '';
		if( !empty($this->query_str) ){
			$qrys = array();
			$qrys = explode("&", $this->query_str);
			for( $i=0; $i<count($qrys); $i++ ){
				$qry = addslashes($qrys[$i]) ;
				$whr .= ( $i == 0 ) ? '' : ' OR ' ;
				$whr .= " url LIKE '". $this->script_name ."%$qry%' ";
			}
		}
		return $whr;
	}
}
?>