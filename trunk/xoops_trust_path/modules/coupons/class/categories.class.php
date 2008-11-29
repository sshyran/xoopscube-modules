<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

require_once XOOPS_ROOT_PATH . "/class/xoopstree.php" ;
require_once dirname(dirname(__FILE__)) .'/include/functions.php';

class couponsCategoriesClass extends XoopsTree
{
	//DB category table
	var $table;
	
	//field
	var $id;
	var $pid;
	var $title = 'title' ;
	var $order = 'corder' ;
	var $imgurl = 'imgurl' ;

	//single[1] or multi
	var $single = 1 ;
	
	var $myts ;

	function couponsCategoriesClass( $table_name , $id_name='cid', $pid_name='pid' )
	{
		parent::XoopsTree( $table_name, $id_name, $pid_name ) ;
		$this->id   = $id_name;
		$this->pid  = $pid_name;
		$this->myts =& MyTextSanitizer::getInstance();
	}

/*    function &getInstance( $table_name , $id_name='cid', $pid_name='pid' )
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new couponsCategoriesClass( $table_name , $id_name, $pid_name );
        }
        return $instance;
    }*/


	//$field : 'title', 'order', 'imgurl'
    function setFiledName( $field , $fieldname )
    {
        if( !empty($this->$field) ) $this->$field  = $fieldname ;
    }

    function setSingleMulti( $single )
    {
        $this->single = $single ;//1:single
    }

	function getPOSTcid( $istext=true ){
		if( $this->single == 1 ){
			$cid = isset($_POST[$this->id]) ? intval($_POST[$this->id]) : 0 ;
			return $cid ;
		}else{
			$cid = array_unique($_POST[$this->id]) ;
			sort( $cid , SORT_NUMERIC ) ;
			if( $cid[0]==0 ) $cid = array_splice($cid,1,count($cid)-1);
			if(count($cid)==0){
				return false ;
			}
			$cid = array_map('intval',$cid);
			if( $istext ){  //[1][2][3]
				$cidtext = '[' .implode('][',$cid). ']';
				return $cidtext ;
			}else{  //arrya(1,2,3)
				return $cid ;
			}
		}
	}

	function update($cid=0){
		$rtn = false;
		if( $cid>0 && $this->getCategory($cid) ){
			$postdata = $this->getPOST();
			if( !empty($postdata[$this->title]) || $postdata[$this->pid]!=$cid ){
				$sql = "UPDATE ". $this->table ." SET ";
				$sql.= $this->pid ."='". $postdata[$this->pid] ."' , " ;
				$sql.= $this->title ."='". addslashes($postdata[$this->title]) ."' , " ;
				$sql.= $this->order ."='". $postdata[$this->order] ."' , " ;
				$sql.= $this->imgurl ."='". addslashes($postdata[$this->imgurl]) ."'" ;
				$sql.= " WHERE cid='$cid'" ;
				$this->db->query($sql) or die( "DB Error: update category" );
				$rtn = true;
			}
		}
		return $rtn ;
	}
	
	function insert(){
		$rtn = false;
		$postdata = $this->getPOST();
		if( !empty($postdata[$this->title]) ){
			$sql = "INSERT INTO ". $this->table ." SET " ;
			$sql.= $this->pid ."='". $postdata[$this->pid] ."' , " ;
			$sql.= $this->title ."='". addslashes($postdata[$this->title]) ."' , " ;
			$sql.= $this->order ."='". $postdata[$this->order] ."' , " ;
			$sql.= $this->imgurl ."='". addslashes($postdata[$this->imgurl]) ."'" ;
			$this->db->query($sql) or die( "DB Error: insert category" );
			$rtn = true;
		}
		return $rtn;
	}
	
	//function delete($cid=0,$table_coupons=''){
	function delete( $cid=0 ){
		$rtn = false;
		if( $cid>0 && $this->getCategory($cid) ){
			$childIds =& $this->getAllChildId($cid);
			$childIds[] = $cid ;
			//delete categories
			if( $this->deleteCats($childIds) ){
				$rtn = true ;
			}
		}
		return $rtn ;
	}
	
	function deleteCats($cids){
		$rtn = false;
		if( is_array($cids) ){
			$whr = '';
			foreach( $cids as $id ){
				if( $whr!='' ) $whr.= " OR ";
				$whr.= " cid=$id ";
			}
			$sql = "DELETE FROM ". $this->table ." WHERE $whr";
			$this->db->query($sql) or die( "DB Error: delete category" );
			$rtn = true ;
		}
		return $rtn ;
	}


	function getPOST(){
		//$myts =& MyTextSanitizer::getInstance();
		$ret = array();
		$ret[$this->pid] = isset($_POST[$this->pid]) ? intval($_POST[$this->pid]) : 0 ;
		$ret[$this->order] = isset($_POST[$this->order]) ? intval($_POST[$this->order]) : 0 ;
		$ret[$this->id] = isset($_POST[$this->id]) ? intval($_POST[$this->id]) : 0 ;
		$ret[$this->title] = isset($_POST[$this->title]) ? $this->myts->stripSlashesGPC($_POST[$this->title]) : "" ;
		$ret[$this->imgurl] = isset($_POST[$this->imgurl]) ? $this->myts->stripSlashesGPC($_POST[$this->imgurl]) : "" ;
		return $ret;
	}

	function getCategory($cid=0){
		$row = false;
		if($cid>0){
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id."=$cid";
			$row = $this->db->fetchArray( $this->db->query($sql) );
		}
		return $row ;
	}
	
	function makeCategoryBlock( $mydirname )
	{
		$ret = array();
		$firstCids = $this->getFirstChild( 0 , "corder,cid" );
		foreach( $firstCids as $myrow) {
		  $imgurl = '';
		  if ($myrow['imgurl'] && $myrow['imgurl'] != "http://"){
		    $imgurl = coupons_urlCheckReplace( $myrow['imgurl'] );
		    $imgurl = $this->myts->makeTboxData4Edit($imgurl);
		  }
		  $totallink = getTotalItems($myrow['cid'],1,true);
		  // get child category objects
		  $arr = array();
		  $arr = $this->getFirstChild($myrow['cid'], "corder,cid");
		  $subcount = 0;
		  $subcategories = '';
		  foreach($arr as $ele){
		    $chtitle = htmlspecialchars($ele['title'],ENT_QUOTES);
		    if ($subcount > 5) {
		      $subcategories .= "...";
		      break;
		    }
		    if ($subcount>0) {
		      $subcategories .= ", ";
		    }
		    $subcategories .= "<a href=\"".XOOPS_URL."/modules/$mydirname/index.php?cid=".$ele['cid']."\">".$chtitle."</a>";
		    $subcount++;
		  }
		  $ret[] = array('image' => $imgurl, 'id' => $myrow['cid'], 'title' => htmlspecialchars($myrow['title'],ENT_QUOTES), 'subcategories' => $subcategories, 'totallink' => $totallink ) ;
		}
		return $ret ;
	}

	function makeCategoryBlockByViewcat( $mydirname , $cid )
	{
		$ret = array();
		$arr = $this->getFirstChild( $cid , "corder,cid" );
		if ( count($arr) > 0 ) {
		    $scount = 1;
		    foreach($arr as $ele){
		        $sub_arr = array();
		        $sub_arr = $this->getFirstChild($ele['cid'], "title");
		        $subcount = 0;
		        $infercategories = "";
		        foreach($sub_arr as $sub_ele){
		            $chtitle = htmlspecialchars($sub_ele['title'],ENT_QUOTES);
		            if ( $subcount > 5 ){
		                $infercategories .= "..." ;
		                break;
		            }
		            if ( $subcount > 0 ){
		                $infercategories .= ", " ;
		            }
		            $infercategories .= "<a href=\"".XOOPS_URL."/modules/$mydirname/index.php?cid=".$sub_ele['cid']."\">".$chtitle."</a>";
		            $subcount++;
		        }
		        $ret[] = array(
		          'title'           => htmlspecialchars($ele['title'],ENT_QUOTES) , 
		          'id'              => $ele['cid'] , 
		          'infercategories' => $infercategories , 
		          'totallinks'      => getTotalItems($ele['cid'], 1,true) , 
		          'count'           => $scount ,
		        );
		        $scount++;
		    }
		}
		return $ret ;
	}

	/*function getAllcatKeyCid( $order='' )
	{
		$arr = array();
		$whr = ( $order!='' ) ? " ORDER BY $order " : "" ;
		$result = $this->db->query( "SELECT * FROM ".$this->table . $whr );
		while( $row = $this->db->fetchArray($result) ){
			$arr[$row[$this->id]] = htmlspecialchars($row[$this->title],ENT_QUOTES) ;
		}
		return $arr;
	}*/
	function getAllcatKeyCid( $order='',$pid=0 , $return_array=array() )
	{
		$whr = $this->pid."=".$pid ;
		$odr = ( $order!='' ) ? " ORDER BY $order " : "" ;
		$sql = "SELECT * FROM ".$this->table . " WHERE $whr $odr" ;
		$result = $this->db->query( $sql );
		$count = $this->db->getRowsNum($result);
		if ( $count == 0 ) {
			return $return_array ;
		}
		while( $row = $this->db->fetchArray($result) ){
			$arr = array();
			$return_array[$row[$this->id]] = htmlspecialchars($row[$this->title],ENT_QUOTES) ;
			$return_array = $this->getAllcatKeyCid( $order , $row[$this->id] , $return_array ) ;
		}
		return $return_array ;
	}


	//generates path from the root id to a given id($sel_id)
	function getPathFromId($sel_id, $path="")
	{
		global $mydirurl ;
		$result = $this->db->query("SELECT ".$this->pid.", ".$this->title." FROM ".$this->table." WHERE ".$this->id."=$sel_id");
		if ( $this->db->getRowsNum($result) == 0 ) {
			//$path = substr($path, 1);
			return $path;
		}
		list($parentid,$name) = $this->db->fetchRow($result);
		$name = htmlspecialchars($name,ENT_QUOTES);
		$path = "/<a href='$mydirurl/index.php?cid=$sel_id'>".$name."</a>".$path."";	//
		if ( $parentid == 0 ) {
			$path = substr($path, 1);
			return $path;
		}
		$path = $this->getPathFromId($parentid, $path);
		return $path;
	}


	//$preset_id is not array
	function makeMySelBox($order="",$preset_id=0, $none=0, $sel_name="", $onchange="", $elm_id=""/*, $multiple=0*/)
	{
	  $temp_text = '' ;
	  ob_start();
		if ( $sel_name == "" ) {
			$sel_name = $this->id;
		}
		echo "<select name='".$sel_name."'";
		if( $onchange != "" ){
			echo " onchange='".$onchange."'";
		}
		if( $elm_id != "" ){
			echo " id='". $elm_id ."' " ;
		}
		if( $this->single!=1 ){
			echo " multiple='multiple' " ;
		}
		echo ">\n";
		$sql = "SELECT ".$this->id.", ".$this->title." FROM ".$this->table." WHERE ".$this->pid."=0";
		if ( $order != "" ) {
			$sql .= " ORDER BY $order";
		}
		$result = $this->db->query($sql);
		if ( $none ) {
			echo "<option value='0'>----</option>\n";
		}
		while ( list($catid, $name) = $this->db->fetchRow($result) ) {
			$sel = "";
			if( is_array($preset_id) ){
				if ( in_array($catid,$preset_id) ){
					$sel = " selected='selected'";
				}
			}else{
				if ( $catid == $preset_id ){
					$sel = " selected='selected'";
				}
			}
			echo "<option value='$catid'$sel>".$this->myts->makeTboxData4Show($name)."</option>\n";
			$sel = "";
			$arr = $this->getChildTreeArray($catid, $order);
			foreach ( $arr as $option ) {
				$option['prefix'] = str_replace(".","--",$option['prefix']);
				$catpath = $option['prefix']."&nbsp;".$this->myts->makeTboxData4Show($option[$this->title]);
				if( is_array($preset_id) ){
					if( in_array($option[$this->id],$preset_id) ){
						$sel = " selected='selected'";
					}
				}else{
					if( $option[$this->id] == $preset_id ){
						$sel = " selected='selected'";
					}
				}
				echo "<option value='".$option[$this->id]."'$sel>$catpath</option>\n";
				$sel = "";
			}
		}
		echo "</select>\n";
	  $temp_text = ob_get_contents();
	  ob_end_clean();
	  
	  return $temp_text ; 
	}

	//title|bg_exists for mobile or print
	function checkItems( $mydirname , $mp ){
		if( $mp=='mobile' ) $dir = 'm' ;
		if( $mp=='print' ) $dir = 'p' ;
		if( !($dir=='m' || $dir=='p') ) return ;
		$allcid = $this->getAllcatKeyCid( "corder,cid" );
		$check = array();
		foreach( $allcid as $k=>$v ){
			$check[$k]['title'] = $check[$k]['bg'] = false ;
			if( file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/images/$dir/title_$k.jpg") ){
				$check[$k]['title'] = 'jpg' ;
			}elseif( file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/images/$dir/title_$k.gif") ){
				$check[$k]['title'] = 'gif' ;
			}elseif( file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/images/$dir/title_$k.png") ){
				$check[$k]['title'] = 'png' ;
			}
			if(  file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/images/$dir/bg_$k.jpg") ){
				$check[$k]['bg'] = 'jpg' ;
			}elseif(  file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/images/$dir/bg_$k.gif") ){
				$check[$k]['bg'] = 'gif' ;
			}elseif(  file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/images/$dir/bg_$k.png") ){
				$check[$k]['bg'] = 'png' ;
			}
		}
		return $check ;
	}
}
?>