<?php
require_once "../../../mainfile.php";
require_once dirname( __FILE__ )."/functions.php";

if( !(strpos(xoops_getenv('HTTP_REFERER'),XOOPS_URL)===0) ){
  exit() ;
}

$cxid = empty($_POST['cxid']) ? 0 : intval($_POST['cxid']) ;
$ym = empty($_POST['ym']) ? 0 : intval($_POST['ym']) ;
$num = empty($_POST['num']) ? 10 : intval($_POST['num']) ;
$len = empty($_POST['len']) ? 16 : intval($_POST['len']) ;


$timelimit = 3 ;//TODO
if( isset($_SESSION['xcsearch']['last_searchtime']) ){
  $gaptime = time() - $_SESSION['xcsearch']['last_searchtime'];
  if( $gaptime < $timelimit ) sleep(ceil($timelimit-$gaptime));
}else{
  sleep($timelimit);
}

//cx
$table_cx = $xoopsDB->prefix( "xcsearch_cx" ) ;
$sql = "SELECT * FROM $table_cx ORDER BY cxorder ASC, cxid ASC" ;
$rs = $xoopsDB->query( $sql ) ;
$cxdata = array() ;
while( $cx = $xoopsDB->fetchArray($rs) ) {
  $cxdata[$cx['cxid']] = htmlspecialchars($cx['cxvalue'],ENT_QUOTES) ;
}
if( $cxid > 0 && isset($cxdata[$cxid]) ){
  $present_cx = $cxdata[$cxid] ;
}else{
  $cxdata2 = array_values($cxdata);
  $present_cx = $cxdata2[0] ;
}

$where = '' ;
if( !empty($cxid) ){
  $where = " WHERE cxid=$cxid " ;
}
if( !empty($ym) ){
  $year = intval($ym/100) ;
  $month = $ym - intval($ym/100)*100 ;
  $ym_where = " year=$year AND month=$month " ;
  if( empty($where) ){
    $where = " WHERE $ym_where " ;
  }else{
    $where .= " AND $ym_where ";
  }
}

$table_rank = $xoopsDB->prefix( "xcsearch_rank" ) ;
$sql = "SELECT query, sum(count) AS x FROM $table_rank $where GROUP BY query ORDER BY x DESC LIMIT 0,$num" ;
$rs = $xoopsDB->query( $sql ) ;


//JSON
$return_data = '[' ;
while( $kw = $xoopsDB->fetchArray($rs) ) {
  $query = $kw['query'] ;
  $query = preg_replace( '/[[:cntrl:]]/' , '' , $query ) ;
  $query = preg_replace( 
    array("/javascript:/si","/about:/si","/vbscript:/si") , 
    array("java script :","about :","vb script :") ,
    $query 
  );
  if( strlen($query)>$len ){
    $query_s = function_exists('mb_strcut') ? mb_strcut($query,0,$len).'..' : substr($query,0,$len).'..' ;
  }else{
    $query_s = $query ;
  }
  $keyword = htmlspecialchars($query,ENT_QUOTES) ;
  $keyword_s = htmlspecialchars($query_s,ENT_QUOTES) ;
  $keyword_enc = htmlspecialchars(rawurlencode($query),ENT_QUOTES) ;
  $count = intval($kw['x']) ;
  if( $return_data != '[' ) $return_data .= "," ;
  $return_data .= "{'keyword':'$keyword','count':'$count','keyword_enc':'$keyword_enc','keyword_s':'$keyword_s'}" ;
}
$return_data .= "]" ;
$return_data = "[{'cxvalue':'$present_cx','charset':'". _CHARSET ."','results':$return_data}]";


$_SESSION['xcsearch']['last_searchtime'] = time() ;
print $return_data ;
exit;

?>