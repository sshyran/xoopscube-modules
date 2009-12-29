<?php
if ( !isset($_GET['cid']) || empty($_GET['cid'])  ) {
  redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
  exit();
}

$getcid = intval($_GET['cid']);

//number per page
$show = isset($_GET['show']) ? intval($_GET['show']) : $xoopsModuleConfig['perpage'] ;
$p = isset($_GET['p']) ? intval($_GET['p']) : 0;//page point
if (!isset($max)) {
    $max = $p + $show;
}


//---------------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_viewcat.html';
include XOOPS_ROOT_PATH."/header.php";


//cid
$xoopsTpl->assign('category_id', $getcid);


$subcats = $categories->makeCategoryBlockByViewcat($mydirname,$getcid) ;
$xoopsTpl->assign( 'subcategories' , $subcats ) ;



$allcid = $categories->getAllcatKeyCid( "corder,cid" );


$fullcountresult = $xoopsDB->query("SELECT count(*) FROM $table_coupons WHERE cid=$getcid AND status>0 AND starttime<".time()." AND endtime>".time() );
list($numrows) = $xoopsDB->fetchRow($fullcountresult);
$page_nav = '';
if($numrows>0){
  $couponData = $coupons->getCoupons( $getcid , 0 , $show , $p );
  $xoopsTpl->assign( 'coupons' , $couponData );

    //$orderby = convertorderbyout($orderby);
    //Calculates how many pages exist.  Which page one should be on, etc...
    $linkpages = ceil($numrows / $show);
    //Page Numbering
    if ($linkpages!=1 && $linkpages!=0) {
        $cid = intval(@$_GET['cid']);
        $prev = $p - $show;
        if ($prev>=0) {
            $page_nav .= "<a href='index.php?cid=$cid&amp;min=$prev&amp;show=$show'><b><u>&laquo;</u></b></a>&nbsp;";//&amp;orderby=$orderby
        }
        $counter = 1;
        $currentpage = ($max / $show);
        while ( $counter<=$linkpages ) {
            $mintemp = ($show * $counter) - $show;
            if ($counter == $currentpage) {
                $page_nav .= "<b>($counter)</b>&nbsp;";
            } else {
                $page_nav .= "<a href='index.php?cid=$cid&amp;min=$mintemp&amp;show=$show'>$counter</a>&nbsp;";//&amp;orderby=$orderby
            }
            $counter++;
        }
        if ( $numrows>$max ) {
            $page_nav .= "<a href='index.php?cid=$cid&amp;min=$max&amp;show=$show'>";//&amp;orderby=$orderby
            $page_nav .= "<b><u>&raquo;</u></b></a>";
        }
    }

    // Navigation
    if( $p >= $numrows ) $p = 0 ;
    if( $numrows > $show ) {
        include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' ) ;
        $extra_arg = "cid={$getcid}&amp;show={$show}" ;//&amp;orderby={$orderby}
        $nav = new XoopsPageNav( $numrows , $show , $p , 'p' , $extra_arg ) ;//NE+, "num=$num"
        $nav_html = $nav->renderNav( 10 ) ;
        $last = $p + $show ;
        if( $last > $numrows ) $last = $numrows ;
        $navinfo = sprintf( _MD_COUPONS_NAVINFO , $p + 1 , $last , $numrows ) ;
        $xoopsTpl->assign( 'navdisp' , true ) ;
        $xoopsTpl->assign( 'nav' , $nav_html ) ;
        $xoopsTpl->assign( 'navinfo' , $navinfo ) ;
    } else {
        $xoopsTpl->assign( 'navdisp' , false ) ;
    }

}

$xoopsTpl->assign('lang_thereare', sprintf(_MD_CATEGORYIS,$numrows));

$xoopsTpl->assign('page_nav', $page_nav);
$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign('allcat', $categories->getAllcatKeyCid() );

//comment integration
//$xoopsTpl->assign( 'comment_allow' , intval($xoopsModuleConfig['comment_allow']) ) ;
$xoopsTpl->assign( 'comment_dirname' , htmlspecialchars($xoopsModuleConfig['comment_dirname'],ENT_QUOTES) ) ;
$xoopsTpl->assign( 'comment_forum_id' , intval($xoopsModuleConfig['comment_forum_id']) ) ;

include XOOPS_ROOT_PATH.'/footer.php';
?>
