<?php
require_once "../../../mainfile.php";
require_once dirname( __FILE__ )."/functions.php";
$mydirname = basename(dirname(dirname(__FILE__)));

if( !(strpos(xoops_getenv('HTTP_REFERER'),XOOPS_URL."/modules/$mydirname/")===0) ){
  exit() ;
}

$mid = isset($_POST['mid']) ? intval($_POST['mid']) : 0 ;
$page = isset($_POST['page']) ? intval($_POST['page']) : 0 ;
$num = isset($_POST['num']) ? intval($_POST['num']) : 20 ;

if( $mid > 0 && is_array($_SESSION['xcsearch']['last_words']) ){
  $timelimit = 3 ;//TODO
  if( isset($_SESSION['xcsearch']['last_searchtime']) ){
    $gaptime = time() - $_SESSION['xcsearch']['last_searchtime'];
    if( $gaptime < $timelimit ) sleep(ceil($timelimit-$gaptime));
  }else{
    sleep($timelimit);
  }

  //search
  $qs = array_map( 'addslashes' , $_SESSION['xcsearch']['last_words'] ) ;
  $andor = ( $_SESSION['xcsearch']['last_andor']=='AND' ) ? 'AND' : 'OR' ;
  $offset = ($page>0) ? ($page-1)*$num : 0 ;
  $temp_results = array();
  $temp_results = searchModule( $qs , $andor , $num , $offset , $mid ) ;

  //JSON
  $return_data = '' ;
  if( count($temp_results) >0 ){
    $return_data = "[{'name':'". $temp_results['name'] ."','mid':". intval($temp_results['mid']) .",'results':[" ;
    $results = $temp_results['results'];
    for( $i=0; $i<count($results); $i++ ){
      if( $i>0 ) $return_data .= "," ;
      $link = preg_replace( array("/[[:cntrl:]]/","/javascript:/si","/about:/si","/vbscript:/si") , array("","java script:","about :","vb script :") , $results[$i]['link'] ) ;
      $image = preg_replace( array("/[[:cntrl:]]/","/javascript:/si","/about:/si","/vbscript:/si") , array("","java script:","about :","vb script :") , $results[$i]['image'] ) ;
      $return_data .= "{'link':'$link','image':'$image','title':'". $results[$i]['title'] ."','time':'". $results[$i]['time'] ."'}" ;
    }
    $return_data .= "]}]" ;
  }


  $_SESSION['xcsearch']['last_searchtime'] = time() ;
  print $return_data ;
}
?>