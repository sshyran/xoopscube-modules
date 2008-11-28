<?php

function xcsearch_countup($query,$ccx)
{
    $query = addslashes($query);

    $myts = & MyTextSanitizer :: getInstance();
    $cxid = 0;
    //if( isset( $_GET['cx'] ) ){
        $cxvalue = addslashes($myts->stripSlashesGPC( $ccx ));
        $sql = "SELECT cxid FROM " . $GLOBALS['xoopsDB']->prefix('xcsearch_cx') . " WHERE cxvalue='$cxvalue'";
        $result = $GLOBALS['xoopsDB']->query($sql);
        list( $cxid ) = $GLOBALS['xoopsDB']->fetchRow( $result ) ;
    //}

    if ( (isset($_SESSION['xcsearch']) && !in_array($query, $_SESSION['xcsearch'])) || !isset($_SESSION['xcsearch']) ) {
        $day = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $year = date('Y');
        $month = date('n');
        $whereStr = "query='$query' AND day='$day' AND cxid='$cxid'";
        $sql = "SELECT * FROM " . $GLOBALS['xoopsDB']->prefix('xcsearch_rank') . " WHERE " . $whereStr;

        $result = $GLOBALS['xoopsDB']->query($sql);
        $cnt = mysql_num_rows($result);
        if( $cnt > 0 ) {
            $sql = "UPDATE " . $GLOBALS['xoopsDB']->prefix('xcsearch_rank') . " SET count=count+1 WHERE " . $whereStr;
        } else {
            $sql = "INSERT INTO " . $GLOBALS['xoopsDB']->prefix('xcsearch_rank') . " (`query`, `day`, `year`, `month`, `count`, `cxid`) VALUES ('$query', $day , $year , $month , 1 , $cxid )";
        }
        $GLOBALS['xoopsDB']->queryF($sql);
        if (!isset ($_SESSION['xcsearch']))
            $_SESSION['xcsearch'] = array ();
        $_SESSION['xcsearch'][] = $query;
        if (count($_SESSION['xcsearch']) > 20) {
            array_shift($_SESSION['xcsearch']);
        }
    }
}


function searchThisSite( $query , $andor='AND' , $num=5 )
{
  $config_handler =& xoops_gethandler('config');
  $xoopsConfigSearch =& $config_handler->getConfigsByCat(XOOPS_CONF_SEARCH);
  $nos_notice = $searchresults = array();
  if( $xoopsConfigSearch['enable_search']==1 && !empty($query) ){
    $module_handler =& xoops_gethandler('module');
    $criteria = new CriteriaCompo(new Criteria('hassearch', 1));
    $criteria->add(new Criteria('isactive', 1));
    $mids = array_keys($module_handler->getList($criteria));

    $separator = '/[\s,]+/';
    if (defined('_MD_LEGACY_FORMAT_SEARCH_SEPARATOR')) {
      $separator = _MD_LEGACY_FORMAT_SEARCH_SEPARATOR;
    }
    $qtemp_a = preg_split( $separator , $query);
    $qs = array();
    for( $i=0; $i<count($qtemp_a); $i++ ){
        $qt = trim($qtemp_a[$i]);
        if( strlen($qt)>= $xoopsConfigSearch['keyword_min'] ) {
            $qs[] = addslashes($qt);
        } else {
            $nos_notice[] = htmlspecialchars($qt,ENT_QUOTES)." : ".sprintf( _MD_XCSEARCH_KEYWORDSHORT , $xoopsConfigSearch['keyword_min'] );
        }
    }
    if( count($qs)>0 ){
        foreach ($mids as $mid) {
          $temp_results = searchModule( $qs , $andor , $num , 0 , $mid ) ;
          if( count($temp_results)>0 ) $searchresults[] = $temp_results ;
        }
        $_SESSION['xcsearch']['last_words'] = array_map( 'stripslashes' , $qs ) ;
    } else {
        $nos_notice[] = sprintf( _MD_XCSEARCH_KEYWORDSHORT , $xoopsConfigSearch['keyword_min'] );
    }
    $_SESSION['xcsearch']['last_andor'] = $andor ;
  }
  return array($searchresults,$nos_notice,$xoopsConfigSearch['enable_search']);
}

function searchModule( $qs , $andor , $num , $offset , $mid )	//(array)$qs
{
  global $xoopsUser ;
  $myts = & MyTextSanitizer :: getInstance();
  $gperm_handler = & xoops_gethandler( 'groupperm' );
  $groups = ( is_object($xoopsUser) ) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
  if ( $gperm_handler->checkRight('module_read', $mid, $groups)) {
    $module_handler =& xoops_gethandler('module');
    $module =& $module_handler->get($mid);
    $mod_dirname = $module->getVar('dirname') ;
    $results =& $module->search( $qs , $andor , $num , $offset , 0 );
    $count = count($results);
    if (is_array($results) && $count > 0) {
    for ($i = 0; $i < $count; $i++) {
        if (isset($results[$i]['image']) && $results[$i]['image'] != '') {
            $results[$i]['image'] = XOOPS_URL ."/modules/$mod_dirname/". $results[$i]['image'];
        } else {
            $results[$i]['image'] = XOOPS_URL ."/images/icons/posticon2.gif" ;
        }
        $results[$i]['link'] = XOOPS_URL ."/modules/$mod_dirname/". $results[$i]['link'] ;
        $results[$i]['title'] = $myts->makeTboxData4Show($results[$i]['title']) ;
        $results[$i]['time'] = $results[$i]['time'] ? formatTimestamp($results[$i]['time']) : '';
    }
    return array( 'name' => htmlspecialchars($module->getVar('name'),ENT_QUOTES), 'mid' => $mid, 'results' => $results );
    }
  }
}

?>