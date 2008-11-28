<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */

require_once "../../mainfile.php";
require_once dirname( __FILE__ )."/include/functions.php";

$myts = & MyTextSanitizer :: getInstance();

$mydir = basename( dirname( __FILE__ ) );
$myurl = XOOPS_URL . "/modules/$mydir" ;


//tab number
$tabno = isset($_GET['tabno']) ? intval($_GET['tabno']) : intval($xoopsModuleConfig['xcsearch_default_search']) ;
if( $tabno==2 && empty($xoopsModuleConfig['xcsearch_perpage']) ){
    $tabno = 1 ;
}

//get cx from DB
$table_cx = $xoopsDB->prefix( "xcsearch_cx" ) ;
$rs = $xoopsDB->query( "SELECT * FROM $table_cx ORDER BY cxorder ASC , cxid ASC" ) ;
$tcx = array();
$i = 0;
while( $cx = $xoopsDB->fetchArray($rs) ) {
    $tcx[ $i ]['cx'] = htmlSpecialChars( $cx['cxvalue'] , ENT_QUOTES );
    $tcx[ $i++ ]['title'] = htmlSpecialChars( $cx['cxtitle'] , ENT_QUOTES );
}

//present cx
if ( isset( $_GET['cx'] ) ){
    $ccx = htmlSpecialChars($myts->stripSlashesGPC( $_GET['cx'] ) , ENT_QUOTES );
} elseif ( !empty( $tcx[0]['cx'] ) ) {
    $ccx = $tcx[0]['cx'];
} else {
    $ccx = '000876635602239701517:sgphpglxyi8';    //default: XOOPS Cube
}

//query strings
$query = '';
if (isset($_GET['q'])) {
    $query = $myts->stripSlashesGPC(trim($_GET['q']));
    $query =  ( function_exists('mb_ereg_replace') && defined('_MD_XCSEARCH_SPACE') ) ? mb_ereg_replace( _MD_XCSEARCH_SPACE , " " , $query ) : $query ;
    if ( !empty ($xoopsModuleConfig['xcsearch_rank']) && !empty($query) ) {
        xcsearch_countup($query,$ccx);
    }
}

//breadcrumbs
$bread[] = array( 'name'=> $xoopsModule->getVar('name') , 'url'=>$myurl."/" );
if( $ccx ){
    $cxvalue = addslashes($ccx);
    $sql = "SELECT cxtitle FROM " . $xoopsDB->prefix('xcsearch_cx') . " WHERE cxvalue='$cxvalue'";
    $result = $xoopsDB->query($sql);
    list( $title ) = $xoopsDB->fetchRow( $result ) ;
    $bread[] = array( 'name'=> htmlSpecialChars( $title , ENT_QUOTES ) );
    if( !empty($query) ) $bread[] = array( 'name'=> htmlSpecialChars( $query , ENT_QUOTES ) );
}


//search this site
$andor = ( !isset($_GET['andor']) || $_GET['andor']=='AND' ) ? 'AND' : 'OR' ;
$num = intval($xoopsModuleConfig['xcsearch_perpage']) ;
list($searchresults,$nos_notice,$enable_search) = searchThisSite( $query , $andor , $num ) ;


//------------------------------------------------------------------
$xoopsOption['template_main'] = 'xcsearch_index.html';
require_once XOOPS_ROOT_PATH . "/header.php";

$xoopsTpl->assign( 'query_str' , htmlspecialchars($query,ENT_QUOTES) );
$xoopsTpl->assign( 'ccx' , $ccx );
$xoopsTpl->assign_by_ref( 'xcsearch_id' , $tcx );
$xoopsTpl->assign( 'xoops_breadcrumbs' , $bread );
$xoopsTpl->assign( 'xcsearch_apikey' , htmlSpecialChars($xoopsModuleConfig['xcsearch_apikey'],ENT_QUOTES) );
$xoopsTpl->assign( 'tabno' , $tabno );
$xoopsTpl->assign( 'andor' , $andor );
$xoopsTpl->assign( 'enable_search' , $enable_search );
$xoopsTpl->assign( 'per_page' , $num );
$xoopsTpl->assign( 'next_num' , intval($xoopsModuleConfig['xcsearch_next_num']) );
if( count($nos_notice)>0 ) $xoopsTpl->assign( 'nos_notice' , $nos_notice );
if( count($searchresults)>0 ) $xoopsTpl->assign( 'searchresult' , $searchresults );

$xoops_module_header = $xoopsTpl->get_template_vars("xoops_module_header") ;
$chk = '' ;
$prototype = '' ;
if( !strstr($xoops_module_header,'prototype.js') ){
  $prototype = '<script type="text/javascript" src="'.$myurl.'/jscss/prototype-1.6.0.2.js"></script>' ;
}
if( !empty($xoops_module_header) ){
  $chk = strstr($xoops_module_header,'xcsearch.js') ;
}
if( empty($chk) ){
  $xoopsTpl->assign( 'xoops_module_header' , '<link rel="stylesheet" type="text/css" media="all" href="'.$myurl.'/jscss/xcsearch.css" /><script type="text/javascript" src="'.$myurl.'/jscss/xcsearch.js"></script>'. $prototype . $xoopsTpl->get_template_vars("xoops_module_header") );//jquery-1.2.2.pack.js
}

require_once XOOPS_ROOT_PATH . "/footer.php";
//------------------------------------------------------------------
?>