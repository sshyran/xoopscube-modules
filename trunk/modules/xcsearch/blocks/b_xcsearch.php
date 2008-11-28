<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */

//-----------------------------------------------------------------------
function b_xcsearch_show() {
    global $xoopsDB;

    $table_cx = $xoopsDB->prefix( "xcsearch_cx" ) ;
    $rs = $xoopsDB->query( "SELECT * FROM $table_cx ORDER BY cxorder ASC , cxid ASC" ) ;

    $tcx = array();
    $i = 0;
    while( $cx = $xoopsDB->fetchArray($rs) ) {
        $tcx[ $i ]['cx'] = htmlspecialchars( $cx['cxvalue'] , ENT_QUOTES );
        $tcx[ $i++ ]['title'] = htmlspecialchars( $cx['cxtitle'] , ENT_QUOTES );
    }

    $block['dirname'] = basename( dirname(dirname(__FILE__)) );
    $block['xcsearch_id'] = $tcx;

    return $block;
}


//-----------------------------------------------------------------------
function b_xcsearch_keywords_show($options) {
    global $xoopsDB , $xoopsTpl ;
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : $options[0] ;
    $number = empty( $options[1] ) ? 10 : intval($options[1]) ;
    $len = empty( $options[2] ) ? 10 : intval($options[2]) ;
    $selector = empty( $options[3] ) ? 0 : intval($options[3]) ;
    
    $table_cx = $xoopsDB->prefix( "xcsearch_cx" ) ;
    $table_rank = $xoopsDB->prefix( "xcsearch_rank" ) ;

    $cxs = $yearmonth = array();
    if($selector){
      //xoops_module_header
      if( is_object($xoopsTpl) ){
        //require_once XOOPS_ROOT_PATH.'/class/template.php';
        //$xoopsTpl =& new XoopsTpl();
        $xoops_module_header = $xoopsTpl->get_template_vars("xoops_module_header") ;
        $chk = '' ;
        $prototype = '' ;
        if( empty($xoops_module_header) || !strstr($xoops_module_header,'prototype.js') ){
          $prototype = '<script type="text/javascript" src="'.XOOPS_URL.'/modules/'.$mydirname.'/jscss/prototype-1.6.0.2.js"></script>' ;
        }
        if( !empty($xoops_module_header) ){
          $chk = strstr($xoops_module_header,'xcsearch.js') ;
        }
        if( empty($chk) ){
          $xoopsTpl->assign( 'xoops_module_header' , '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/modules/'.$mydirname.'/jscss/xcsearch.css" /><script type="text/javascript" src="'.XOOPS_URL.'/modules/'.$mydirname.'/jscss/xcsearch.js"></script>'. $prototype . $xoops_module_header ) ;
        }
      }
      //CXS
      $sql = "SELECT * FROM $table_cx ORDER BY cxorder ASC, cxid ASC" ;
      $rs = $xoopsDB->query( $sql ) ;
      while( $cx = $xoopsDB->fetchArray($rs) ) {
        $cxs[] = array(
          'cxid'    => $cx['cxid'] ,
          'cxvalue' => htmlspecialchars(preg_replace( array("/[[:cntrl:]]/","/javascript:/si","/about:/si","/vbscript:/si"),array("","java script:","about :","vb script :"),$cx['cxvalue']), ENT_QUOTES ) ,
          'cxtitle' => htmlspecialchars($cx['cxtitle'], ENT_QUOTES ) ,
        );
      }
      //YEAR MONTH
      $sql = "SELECT year*100+month AS y FROM $table_rank GROUP BY year*100+month DESC" ;
      $rs = $xoopsDB->query( $sql ) ;
      while( $ym = $xoopsDB->fetchArray($rs) ) {
        $yearmonth[] = $ym['y'] ;
      }
    }
    //RANKING
    $sql = "SELECT cxid, query, sum(count) AS x FROM $table_rank GROUP BY query ORDER BY x DESC LIMIT 0,$number" ;
    $rs = $xoopsDB->query( $sql ) ;
    $keywords = array();
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
      $keywords[] = array( 
        'keyword'      => htmlspecialchars($query,ENT_QUOTES) ,
        'keyword_s'    => htmlspecialchars($query_s,ENT_QUOTES) ,
        'keyword_enc'  => htmlspecialchars(rawurlencode($query),ENT_QUOTES) ,
        'count'        => $kw['x'] ,
        'cxid'         => $kw['cxid'] ,
      ) ;
    }

    $block = array(
      'cxs'       => $cxs ,
      'ym'        => $yearmonth ,
      'kw'        => $keywords ,
      'mydirname' => $mydirname,
      'num'       => $number ,
      'len'       => $len ,
    ) ;
    return $block ;
}


function b_xcsearch_keywords_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname(__FILE__))) : htmlspecialchars($options[0],ENT_QUOTES) ;
    $number = empty( $options[1] ) ? 10 : intval($options[1]) ;
    $len = empty( $options[2] ) ? 10 : intval($options[2]) ;
    $selector = empty( $options[3] ) ? 0 : intval($options[3]) ;

    $sel0 = $sel1 = '' ;
    $sel = "sel$selector" ;
    $$sel = "CHECKED='CHECKED'" ;

    $form = "
        <input type='hidden' name='options[0]'  value='$mydirname' />
        ". _MB_XCSEARCH_KWR_NUMBER ."
        <input type='text' name='options[1]' value='$number' /><br />
        ". _MB_XCSEARCH_KWR_LENGTH ."
        <input type='text' name='options[2]' value='$len' /><br />
        ". _MB_XCSEARCH_KWR_SELECTOR ."
        <input type='radio' name='options[3]' value='0' $sel0 />"._NO."<input type='radio' name='options[3]' value='1' $sel1 />"._YES."
        <br />\n
    " ;

    return $form ;
}


/*
function xcsearch_option($conf_name) {
    $module_handler = & xoops_gethandler('module');
    $module = $module_handler->getByDirname('xcsearch');
    $mid = $module->getVar('mid');
    $xcsearchConfig = & xoops_gethandler('config');

    $records = & $xcsearchConfig->getConfigList($mid);
    $value = $records[$conf_name];
    return ($value);
}
*/

?>