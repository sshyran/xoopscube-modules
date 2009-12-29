<?php
if( !function_exists('makeDateSelector') ){
	function makeDateSelector( $timestamp ){
		$d = getdate($timestamp) ;
		$select_tag = '<select name="%s">%s</select>';
		$option_tag = '<option %s>%u</option>';
		$selected = 'selected="selected"';
		$dateselector = $temp_option = '' ;
		for($i=$d['year']+1; $i>=$d['year']-1; $i--){
		  $sel = ( $i==$d['year'] ) ? $selected : '' ;
		  $temp_option .= sprintf($option_tag , $sel,$i);
		}
		$dateselector .= sprintf( $select_tag , 'year' , $temp_option );
		$temp_option = '' ;
		for($i=1;$i<=12;$i++){
		  $sel = ( $i==$d['mon'] ) ? $selected : '' ;
		  $temp_option .= sprintf($option_tag , $sel,$i);
		}
		$dateselector .= sprintf( $select_tag , 'month' , $temp_option );
		$temp_option = '' ;
		for($i=1;$i<=31;$i++){
		  $sel = ( $i==$d['mday'] ) ? $selected : '' ;
		  $temp_option .= sprintf($option_tag , $sel,$i);
		  if( in_array($d['mon'],array(4,6,9,11)) && $i==30 ) break;
		  if( $d['mon']==2 ){
		    if( $d['year']%4==0 && $d['year']%100!=0 ){
		      if( $i==29 ) break;
		    }else{
		      if( $i==28 ) break;
		    }
		  }
		}
		$dateselector .= sprintf( $select_tag , 'day' , $temp_option ) . "&nbsp;";
		$temp_option = '' ;
		for($i=0;$i<24;$i++){
		  $sel = ( $i==$d['hours'] ) ? $selected : '' ;
		  $temp_option .= sprintf($option_tag , $sel,$i);
		}
		$dateselector .= sprintf( $select_tag , 'hours' , $temp_option ) . ":";
		$temp_option = '' ;
		for($i=0;$i<60;$i++){
		  $sel = ( $i==$d['minutes'] ) ? $selected : '' ;
		  $temp_option .= sprintf($option_tag , $sel,$i);
		}
		$dateselector .= sprintf( $select_tag , 'minutes' , $temp_option ) . ":";
		$temp_option = '' ;
		for($i=0;$i<60;$i++){
		  $sel = ( $i==$d['seconds'] ) ? $selected : '' ;
		  $temp_option .= sprintf($option_tag , $sel,$i);
		}
		$dateselector .= sprintf( $select_tag , 'seconds' , $temp_option );
		return $dateselector ;
	}
}


if( !function_exists('coupons_urlCheckReplace') ){
	function coupons_urlCheckReplace( $text )
	{
	  $returntext = '' ;
	  $returntext = preg_replace( 
	    array("/javascript:/si","/about:/si","/vbscript:/si") , 
	    array("java script :","about :","vb script :") ,
	    $text 
	  );
	  return $returntext ;
	}
}

//encoding in SJIS as for coupon data
if( !function_exists('sjisEncode') ){
	function sjisEncode( $data )
	{
		if( empty($data) ) return ;
		if( !function_exists('mb_convert_encoding') ) return $data ;
		foreach( $data as $k=>$d ){
			if( is_array($d) ){//for addfields
				for($i=0;$i<count($d);$i++){
					$temp[$k][$i] = array_map('convert_encoding_sjis',$d[$i]) ;
				}
			}else{
				$temp[$k] = convert_encoding_sjis( $d ) ;
			}
		}
		return $temp;
	}
}

if( !function_exists('convert_encoding_sjis') ){
	function convert_encoding_sjis($var)
	{
		if( !function_exists('mb_convert_encoding') ) return $var ;
		return mb_convert_encoding( $var , 'SJIS' , 'auto' ) ;
	}
}




if( !function_exists('getTotalItems') ){
	function getTotalItems( $sel_id, $status="", $dist=false )
	{
	    global $categories ;
	    $arr = $categories->getAllChildId($sel_id);
	    if( $dist ){
	      $arr[] = $sel_id ;
	      $count = getItemsNum( $arr , $status );
	    }else{
	      $count = getItemsNum($sel_id, $status);
	      for($i=0;$i<count($arr);$i++){
	        $subcount = getItemsNum($arr[$i], $status);
	        $count += $subcount ;
	      }
	    }
	    return $count;
	}
}

if( !function_exists('getItemsNum') ){
	function getItemsNum( $sel_id, $status="" )
	{
	    global $table_coupons ;
	    $db =& Database::getInstance() ;
	    if( is_array($sel_id) ){
	      $cidwhere = "" ;
	      for( $i=0 ; $i<count($sel_id); $i++ ){
	        if( $cidwhere != "" ) $cidwhere .= " OR " ;
	        $cidwhere .= " cid=". $sel_id[$i] ." " ;
	      }
	    }else{
	      $cidwhere = "cid=".$sel_id." ";
	    }
	    $time_where = " starttime<". time() ." AND endtime>" .time() ;
	    $sql = "SELECT count(*) FROM $table_coupons WHERE $time_where AND ( $cidwhere )";
	    if($status!="") $sql .= " AND status>=$status";
	    $result = $db->query($sql);
	    list($count) = $db->fetchRow($result);
	    return $count;
	}
}



if( !function_exists('assign_get_breadcrumbs_by_tree') )
{
  function assign_get_breadcrumbs_by_tree( $table, $id_col, $pid_col, $name_col, $id_val, $url_fmt, $paths=array() )
  {
	$db =& Database::getInstance() ;

	$sql = "SELECT `$pid_col`,`$name_col` FROM ".$table." WHERE `$id_col`=".intval($id_val) ;
	$result = $db->query( $sql ) ;
	if( $db->getRowsNum( $result ) == 0 ) return $paths ;
	list( $pid , $name ) = $db->fetchRow( $result ) ;
	$paths = array_merge( array( array(
		'name' => htmlspecialchars( $name , ENT_QUOTES ) ,
		'url'  => sprintf( $url_fmt , $id_val ) ,
	) ) , $paths ) ;

	return assign_get_breadcrumbs_by_tree( $table, $id_col, $pid_col, $name_col, $pid, $url_fmt, $paths ) ;
  }
}

?>