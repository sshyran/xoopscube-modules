<?php

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '
      
function '.$mydirname.'_global_search( $keywords , $andor , $limit , $offset , $uid )
{
    return cinemaru_global_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $uid ) ;
}

' ) ;

if( ! function_exists( 'cinemaru_global_search_base' ) ) {

function cinemaru_global_search_base($mydirname, $queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $sql = " SELECT distinct m.id AS id, m.title AS title, m.reg_time AS reg_time, m.reg_user AS reg_user";
    $sql .= " FROM ";
    $sql .= $xoopsDB->prefix($mydirname . "_movie") . " AS m LEFT JOIN ";
    $sql .= $xoopsDB->prefix($mydirname . "_tag_movie") . " AS tm ON tm.movie_id = m.id LEFT JOIN ";
    $sql .= $xoopsDB->prefix($mydirname . "_tags") . " AS t ON t.id = tm.tags_id ";
    $sql .= " WHERE ";
    $sql .= " m.valid = 1 ";
								       
    if ( $userid != 0 ) {
		$sql .= " AND m.reg_user=".intval($userid)." ";
    }
							     
    if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((m.title LIKE '%$queryarray[0]%' OR m.desc LIKE '%$queryarray[0]%' OR t.name LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
		    $sql .= " $andor ";
		    $sql .= "(m.title LIKE '%$queryarray[$i]%' OR m.desc LIKE '%$queryarray[$i]%' OR t.name LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
    }
    $sql .= "ORDER BY reg_time DESC";

    $result = $xoopsDB->query($sql,$limit,$offset);
    $ret = array();
    $i = 0;
    while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$i]['link'] = "movie.php?id=".$myrow['id']."";
		$ret[$i]['title'] = $myrow['title'];
		$ret[$i]['time'] = $myrow['reg_time'];
		$ret[$i]['uid'] = $myrow['reg_user'];
		$i++;
    }
    
    
     return $ret;
}

}
								 

