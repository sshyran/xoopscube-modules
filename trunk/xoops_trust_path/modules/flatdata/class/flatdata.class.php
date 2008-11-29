<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;


//---------------------------------------------------------------------
class Flatdata
{
	var $mydirname ;
	var $page = '' ;

	//DB
	var $db ;
	var $table ;

	//data field
	var $did      = 'did' ;
	var $data     = 'data' ;
	var $uid      = 'uid' ;
	var $regidate = 'regidate' ;
	var $embed    = 'embed' ;
	var $cat_id   = 'cat_id' ;
	var $hits     = 'hits' ;
	
	var $order ;
	var $sortfield = '' ;
	var $order_item ;
	var $searchWhere = '' ;

	var $embeddata = '' ;
	var $embeduid = NULL ;

	var $bbcode = false ;
	var $tempbb ;
	var $category = false ;
	var $maxbyte = 5000 ;

	function Flatdata( $mydirname , $page='' )
	{
		$this->db =& Database::getInstance();
		$this->mydirname = $mydirname ;
		if( !empty($page) ) $this->page = $page ;
		$this->table = $this->db->prefix( $mydirname ."_data" ) ;
		$this->order_item = $this->did ;
		$this->order = " ORDER BY ". $this->order_item ." DESC " ;
	}

	function setMaxByte( $b )
	{
		if( is_numeric($b) ){
			$this->maxbyte = intval( $b ) ;
		}
	}


	function useBBcode()
	{
		$this->bbcode = true ;
	}

	function useCategory()
	{
		$this->category = true ;
	}

	function getCount()
	{
		$sql = $this->baseSelectSql() ;
		$sql.= $this->getSearch() ;
		//var_dump($sql);
		$result = $this->db->query($sql) ;
		$rowsnum = $this->db->getRowsNum($result);
		return $rowsnum ;
	}

	function getAllDid()
	{
		$sql = $this->baseSelectSql() ;
		$sql.= $this->getSearch() ;
		$sql.= $this->getOrder() ;
		$result = $this->db->query($sql) ;
		$returnrow = array() ;
		while( $row = $this->db->fetchArray($result) ){
			$returnrow[] = intval($row[$this->did]) ;
		}
		return $returnrow ;
	}

	function getData( $did , $fidarr )
	{
		$row = false ;
		if( $did > 0 && is_array($fidarr) ){
			$sql = $this->baseSelectSql() ;
			$sql.= " WHERE ".$this->did."=". intval($did) ;
			$result = $this->db->query($sql) ;
			$row = $this->db->fetchArray($result);
			$this->tempbb = array() ;
			$row[$this->data] = $this->splitData($row[$this->data],$fidarr) ;
			if( $this->bbcode ){
				$row['data_bb'] = $this->tempbb ;
			}
			$row[$this->embed] = $this->outputData($row[$this->embed]) ;
			$row['embed_url'] = $this->splitEmbedURL($row[$this->embed]) ;
			$row['uname'] = $this->getUnameFromUid($row[$this->uid]) ;
			$row['cat_id'] = intval($row[$this->cat_id]);
			$row['hits'] = intval($row[$this->hits]);
		}
		return $row ;
	}


	function getUnameFromUid( $uid )
	{
		global $xoopsConfig ;
		if( $uid > 0 ) {
			$member_handler =& xoops_gethandler('member') ;
			$poster =& $member_handler->getUser($uid) ;
			if( is_object( $poster ) ) {
				$name = htmlspecialchars( $poster->uname() , ENT_QUOTES ) ;
			}else{
				$name = htmlspecialchars($xoopsConfig['anonymous'],ENT_QUOTES) ;
			}
		} else {
			$name = htmlspecialchars($xoopsConfig['anonymous'],ENT_QUOTES) ;
		}
		return $name ;
	}

	function getDatas( $fidarr , $limit=20 , $offset=0 )
	{
		$sql = $this->baseSelectSql() ;
		$sql.= $this->getSearch() ;
		$sql.= $this->getOrder() ;
		$result = $this->db->query($sql,$limit,$offset) ;
		$returnrow = array() ;
		while( $row = $this->db->fetchArray($result) ){
			//var_dump($row['fld']);
			$this->tempbb = array() ;
			$row[$this->data] = $this->splitData($row[$this->data],$fidarr) ;
			if( $this->bbcode ){
				$row['data_bb'] = $this->tempbb ;
			}
			$row[$this->embed] = $this->outputData($row[$this->embed]) ;
			$row['embed_url'] = $this->splitEmbedURL($row[$this->embed]) ;
			$row['uname'] = $this->getUnameFromUid($row[$this->uid]) ;
			$row['cat_id'] = intval($row[$this->cat_id]);
			$row['hits'] = intval($row[$this->hits]);
			if( isset($row['fld']) ) $row['fld'] = NULL ;
			$returnrow[] = $row ;
		}
		//var_dump($returnrow);
		return $returnrow ;
	}

	function getOrder()
	{
		return $this->order ;
	}

	function setOrder( $ord )
	{
		if( strtoupper($ord) == 'A' ){
			$this->order = " ORDER BY ". $this->order_item ." ASC " ;
		}elseif( strtoupper($ord) == 'B' ){
			$this->order = " ORDER BY ". $this->order_item ." DESC " ;
		}elseif( strtoupper($ord) == 'C' ){
			$this->order = " ORDER BY ". $this->regidate ." ASC " ;
		}elseif( strtoupper($ord) == 'D' ){
			$this->order = " ORDER BY ". $this->regidate ." DESC " ;
		}elseif( strtoupper($ord) == 'E' ){
			$this->order = " ORDER BY ". $this->hits ." ASC " ;
		}elseif( strtoupper($ord) == 'F' ){
			$this->order = " ORDER BY ". $this->hits ." DESC " ;
		}elseif( strtoupper($ord) == 'R' ){
			$this->order = " ORDER BY rand() " ;
		}else{
			$f = "field".abs(intval($ord)) ;
			$l = strlen($f)+2 ;
			if( $this->mysqlVersion(40002) ){
				$cast_type = $this->getCastType() ;
				$this->sortfield = " , CAST(SUBSTRING(`".$this->data."`,CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[{$f}]',1))+{$l}+1,CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[/{$f}]',1))-CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[{$f}]',1))-{$l}) AS {$cast_type}) AS fld " ;
			}else{
				$this->sortfield = " , SUBSTRING(`".$this->data."`,CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[{$f}]',1))+{$l}+1,CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[/{$f}]',1))-CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[{$f}]',1))-{$l}) AS fld " ;
			}
			$asc_desc = ( $ord > 0 ) ? "ASC" : "DESC" ;
			$this->order = " ORDER BY fld $asc_desc , did $asc_desc ";
		}
	}

	function getCastType()
	{
		$t = isset($_GET['type']) ? strtoupper($_GET['type']) : 'BINARY' ;
		if( in_array( $t , array('BINARY','CHAR','DATE','DATETIME','TIME','SIGNED','UNSIGNED','DECIMAL') ) ){
			$type = $t ;
		}else{
			$type = 'BINARY' ;
		}
		return $type ;
	}

	function mysqlVersion($check_version)
	{
		$ret = false ;
		$result = $this->db->query("SELECT version()") ;
		$row = $this->db->fetchRow($result);
		list($v1,$v2,$v3) = explode('.',$row[0]);
		$version = intval($v1)*10000 + intval($v2)*100 + intval($v3) ;
		if( $version >= $check_version ) $ret = true ;
		return $ret ;
	}

	function getSearch()
	{
		return $this->searchWhere ;
	}

	function setSearch( $ao , $sf , $sq )
	{
	/*global $xoopsUser ;
	if( isset($xoopsUser) && $xoopsUser->isAdmin() ) {
		var_dump($ao);var_dump($sf);var_dump($sq);
	}*/
		$f = ( $sf > 0 ) ? "field".intval($sf) : "" ;
		if( function_exists('mb_ereg_replace') && defined('_MD_FULL_SPACE') ) $sq = mb_ereg_replace(_MD_FULL_SPACE," ",$sq) ;
		$sq_arr = preg_split( '/[\s,]+/' , $sq ) ;
		//var_dump($sq_arr);
		if( count($sq_arr) > 0 ){
			$where = " ( " ;
			for( $i=0 ; $i<count($sq_arr) ; $i++ ){
				if( empty($f) ){
					$where .= "`".$this->data."` LIKE BINARY '%". addslashes($sq_arr[$i]) ."%' " ;
				}else{
					//$reg = $sq_arr[$i] = $this->numericSearchCheck( $sq_arr[$i] ) ;
					//if( empty($reg) ){
						$where .= "`".$this->data."` LIKE BINARY '%[{$f}]%". addslashes($sq_arr[$i]) ."%[/{$f}]%' " ;
					//}else{
					//	$where .= $this->numericWhere( $f , $reg[1] , $reg[2] ) ;
					//}
				}
				if( count($sq_arr)>0 && count($sq_arr)!=$i+1 ){
					$where .= ( $ao==0 ) ? " AND " : " OR " ;
				}
			}
			$where.= " ) " ;
			if( $this->searchWhere ){
				$this->searchWhere .= " AND " ;
			}else{
				$this->searchWhere = " WHERE " ;
			}
			$this->searchWhere .= $where ;
		}
	}
/*
	function numericWhere( $f , $sign , $val )
	{
		$whr = '' ;
		$whr = " SUBSTRING(`".$this->data."`,CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[{$f}]',1))+{$l}+1,CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[/{$f}]',1))-CHAR_LENGTH(SUBSTRING_INDEX(`".$this->data."`,'[{$f}]',1))-{$l}) AS ff {$sign}". floatval($val) ;
		//var_dump($whr);
		return $whr ;
	}
*//*
	function numericSearchCheck( $val )
	{
		$reg = '' ;
		ereg( '^(>=|=>|<=|=<|==|!=|=!|<>|><|>|<|=)(.*)$', $val , $reg ) ;
		if( !empty($reg) ){
			if( in_array( $reg[1] , array('!=','<>','><','=!') ) ){
				$reg[1] = '!=' ;
			}elseif( in_array( $reg[1] , array('>=','=>') ) ){
				$reg[1] = '>=' ;
			}elseif( in_array( $reg[1] , array('<=','=<') ) ){
				$reg[1] = '<=' ;
			}elseif( in_array( $reg[1] , array('==','=') ) ){
				$reg[1] = '=' ;
			}
		}
		//var_dump($reg);
		return $reg ;
	}
*/
	function setAllSearch( $queryarray , $andor , $userid )
	{
		$whr = '' ;
		if ( $userid != 0 ) {
			$whr = " WHERE `uid`=".$userid;
		}
		if ( is_array($queryarray) && $count = count($queryarray) ) {
			$whr .= ($userid!=0) ? " AND " : " WHERE " ;
			$whr .= " `data` LIKE '%".addslashes($queryarray[0])."%' ";
			for($i=1;$i<$count;$i++){
				$whr .= (strtolower($andor)=='and') ? " AND " : " OR " ;
				$whr .= " `data` LIKE '%".addslashes($queryarray[$i])."%' ";
			}
		}
		$this->searchWhere = $whr ;
	}


	function setWhere( $item , $wh , $sign='=' , $andor='AND' )
	{
		if( isset($item) && isset($wh) ){
			if( strtoupper($sign)=='LIKE' ){
				$datewhere = " ". addslashes($item) ." ". addslashes($sign) ." '". addslashes($wh) ."' " ;
			}else{
				$datewhere = " ". addslashes($item) . addslashes($sign) . addslashes($wh) ." " ;
			}
			if( $this->searchWhere ){
				$this->searchWhere .= ( strtoupper($andor)=='AND' ) ? " AND " : " OR " ;
			}else{
				$this->searchWhere = " WHERE " ;
			}
			$this->searchWhere .= $datewhere ;
		}
	}

	function setEmbedWhere( $where )
	{
		$this->searchWhere = " WHERE embed LIKE '". addslashes($where) ."' " ;
	}

	function baseSelectSql()
	{
		$sql = "SELECT * ". $this->sortfield ." FROM ". $this->table ;
		return $sql ;
	}

	function splitData( $d , $fidarr )
	{
		$rtn = array() ;
		for( $i=0; $i<count($fidarr); $i++ ){
			$fid = $fidarr[$i] ;
			$f = "field".$fid ;
			preg_match( "/\[".$f."\](.*)\[\/".$f."\]/s" , $d , $regs );
			if( !empty($regs[1]) ){
				$rtn[$fid] = $this->outputData($regs[1]) ;
				if( $this->bbcode ) $this->tempbb[$fid] = $this->outputBBcode($regs[1]) ;
			}
			//$rtn[$fid] = unserialize($rtn[$fid]) ;
		}
		return $rtn ;
	}

	function splitEmbedURL( $text )
	{
		$rtn = '' ;
		if( !empty($text) ){
			preg_match( "/\[(.*)\]\[.*\]\[(.*)\]\[(.*)\]/" , $text , $regs );
			if( isset($regs) && !empty($regs[1]) && !empty($regs[3]) ){
				$rtn = XOOPS_URL."/" ;
				if( !in_array($regs[1] , array('userinfo.php','edituser.php','register.php')) ){//TODO
					$rtn .= "modules/".$regs[1]."/" ;
				}elseif( $regs[1]=='edituser.php' || $regs[1]=='register.php' ){
					$regs[3] = "userinfo.php?uid=".intval($regs[2]) ;
				}
				$rtn .= $regs[3] ;
				$rtn = $this->outputData($rtn) ;
				$rtn = str_replace(array('&amp;'),array('&'),$rtn);
			}
		}
		return $rtn ;
	}

	//empty check
	function embed_preCheck($fidarr)
	{
		$counter = 0 ;
		for( $i=0; $i<count($fidarr); $i++ ){
			$fid = $fidarr[$i] ;
			$f_name = $this->mydirname ."_field". $fid ;
			$f = "field". $fid ;
			if( (isset($_POST[$f_name])&&!empty($_POST[$f_name])) || (isset($_POST[$f])&&!empty($_POST[$f])) ){
				$counter++ ;
				break ;
			}
		}
		$rtn = $counter>0 ? true : false ;
		return $rtn ;
	}

	function embedData()
	{
		$embed_dir  = isset($_POST['flatdata_embed_dir'])  ? $this->receiveData($_POST['flatdata_embed_dir']) : '' ;
		$item_field = isset($_POST['flatdata_item_field']) ? $this->receiveData($_POST['flatdata_item_field']) : '' ;
		$item_id    = isset($_POST['flatdata_item_id'])    ? intval($_POST['flatdata_item_id']) : 0 ;
		$filequery  = isset($_POST['flatdata_filequery'])  ? $this->receiveData($_POST['flatdata_filequery']) : '' ;
		$this->embeduid = isset($_POST['flatdata_embed_uid'])  ? intval($_POST['flatdata_embed_uid']) : 0 ;

		$embed_dir = preg_replace( '/[^a-zA-Z0-9._-]/' , '' , $embed_dir ) ;
		$item_field = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $item_field ) ;
		$filequery  = preg_replace( '/[^a-zA-Z0-9\.\?=&_-]/' , '' , $filequery ) ;

		//$this->embeddata = '' ;
		if( !empty($embed_dir) && !empty($item_field) && !empty($item_id) ){
			$this->embeddata = '['. $embed_dir .']['. $item_field .']['. $item_id .']['. $filequery .']' ;
		}
	}


	function insert($fidarr)
	{
		global $xoopsUser ;
		$postdata = $this->getPOSTDATA($fidarr) ;
		$cat_id = ($this->category && isset($_POST['cat_id'])) ? intval($_POST['cat_id']) : 0 ;

		$uid = 0 ;
		if( $this->embeduid > 0 ){
			$uid = $this->embeduid ;
		}elseif( is_object($xoopsUser) ){
			$uid = $xoopsUser->uid() ;
		}

		$sql = sprintf("INSERT INTO %s 
			(".$this->data." , ".$this->uid." , ".$this->regidate." , ".$this->embed." , ".$this->cat_id." ) VALUES 
			('%s', %u, %u, '%s', %u)", 
			$this->table , 
			addslashes($postdata) ,
			intval($uid) ,
			time() ,
			addslashes($this->embeddata) ,
			$cat_id
		);
		$this->db->query($sql) or die( "DB Error: INSERT data" );
		$newid = $this->db->getInsertId();
		return $newid ;
	}

	function update($did,$fidarr,$staytime=false)
	{
		$postdata = $this->getPOSTDATA($fidarr) ;
		$cat_id = ($this->category && isset($_POST['cat_id'])) ? intval($_POST['cat_id']) : 0 ;
		$time = $staytime ? $staytime : time() ;

		$sql = sprintf("UPDATE %s 
			SET ".$this->data."='%s', ".$this->regidate."=%u , ". $this->cat_id ."=%u WHERE did=%u",
			$this->table ,
			addslashes($postdata) ,
			$time ,
			$cat_id , 
			intval($did) 
		) ;
		$this->db->queryF($sql) or die( "DB Error: UPDATE data" );
		return ;
	}

	function delete( $did )
	{
		$sql = "DELETE FROM ". $this->table ." WHERE did=".intval($did) ;
		$this->db->query($sql) or die( "DB Error: DELETE data" ) ;
		return ;
	}

	function getPOSTDATA( $fidarr )
	{
		$data = "" ;
		for( $i=0; $i<count($fidarr); $i++ ){
			$fid = $fidarr[$i] ;
			$f_name = $this->mydirname ."_field". $fid ;
			$f = "field". $fid ;
			$temp = isset($_POST[$f_name]) ? $this->receiveData($_POST[$f_name]) : "" ;
			if( empty($temp) ){
				$temp = isset($_POST[$f]) ? $this->receiveData($_POST[$f]) : "" ;
			}
			$data .= "[{$f}]{$temp}[/{$f}]" ;
			unset($temp) ;
		}
		return $data ;
	}

	function receiveData( $data )
	{
		$myts = & MyTextSanitizer::getInstance() ;
		//$data = serialize($data) ;
		$data = $myts->stripSlashesGPC(trim($data)) ;
		$data = preg_replace( 
			array("/\[field/si","/\[\/field/si") , 
			array("[ field","[ /field") ,
			$data 
		);
		$data = $this->checkLength( $data ) ;
		return $data ;
	}

	function checkLength( $data )
	{
		if( function_exists('mb_strlen') && function_exists('mb_strcut') ){
			if( mb_strlen($data) > $this->maxbyte ){
				$data = mb_strcut( $data , 0 , $this->maxbyte ) . "..." ;
			}
		}else{
			if( strlen($data) > $this->maxbyte ){
				$data = mb_strcut( $data , 0 , $this->maxbyte ) . "..." ;
			}
		}
		return $data ;
	}

	function outputData( $data )
	{
		$data = $this->outputForUrl($data) ;
		$data = htmlspecialchars($data,ENT_QUOTES) ;
		return $data ;
	}

	function outputBBcode( $data )
	{
		$myts = & MyTextSanitizer::getInstance() ;
		$codetag = strpos( $data , '[code]' ) ;
		$data = $myts->displayTarea($data,0,1,1,1,1) ;//($data, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1)
		$data = $this->outputForUrl($data,true,$codetag) ;
		return $data ;
	}

	function outputForUrl( $data , $bb=false , $codetag=false )
	{
		if( ($bb==false || $codetag===false) && $this->page!='edit' ){
			$data = preg_replace( "/[[:cntrl:]]/" , "" , $data );
		}
		$data = preg_replace( 
			array("/javascript:/si","/about:/si","/vbscript:/si") , 
			array("java script :","about :","vb script :") ,
			$data 
		);
		return $data ;
	}

	function countByCategory( $cattree , $all=false )
	{
		$ret = array();
		if( is_array($cattree) ){
			$uid_where = ( isset($_GET['uid']) && $_GET['uid']>0 && $all==false ) ? "WHERE uid=".intval($_GET['uid']) : "" ;
			$sql = "SELECT ".$this->cat_id.", COUNT(*) FROM ".$this->table." $uid_where GROUP BY ".$this->cat_id ;
			$result = $this->db->query($sql) ;
			while( $row = $this->db->fetchRow($result) ){
				if( in_array($row[0],array_keys($cattree)) ) $ret[$row[0]] = $row[1] ;
			}
		}
		return $ret ;
	}

	function countup( $did )
	{
		if( $did > 0 ){
			//$sql = "SELECT ".$this->hits." FROM ".$this->table." WHERE did=".intval($did) ;
			//$result = $this->db->query($sql) ;
			//$row = $this->db->fetchArray($result) ;
			//$hits = intval($row['hits']) + 1 ;
			$sql = "UPDATE ". $this->table ." SET ". $this->hits ."=". $this->hits ."+1 WHERE did=". intval($did) ;
			$this->db->queryF($sql) or die( "DB Error: UPDATE hits" );
			return ;
		}
	}

}
?>