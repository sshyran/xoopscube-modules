<?php
// $Id: topten.php,v 1.1 2004/01/29 14:45:12 buennagel Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
//
//  modify by photosite 2008/03/14 18:18:50 for d3downloads
//

include XOOPS_ROOT_PATH.'/header.php';
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$myts =& d3downloadsTextSanitizer::getInstance() ;
$db =& Database::getInstance() ;

$mytree = new MyTree($db->prefix( $mydirname."_cat" ),"cid","pid");
$xoopsOption['template_main'] = $mydirname.'_main_topten.html' ;

$breadcrumbs[0] = d3download_breadcrumbs( $mydirname ) ;

//generates top 10 charts by rating and hits for each main category
if( isset( $_GET['rate'] ) ){
	$sort = _MD_D3DOWNLOADS_TOP_TEN_RATING;
	$sortDB = "rating";
	$pagetitle4assign = _MD_D3DOWNLOADS_TOP_TEN_TITLE_RATING ;
	$breadcrumbs[] = array( 'name' => _MD_D3DOWNLOADS_TOP_TEN_TITLE_RATING ) ;
} else {
	$sort = _MD_D3DOWNLOADS_TOP_TEN_HITS;
	$sortDB = "hits";
	$pagetitle4assign = _MD_D3DOWNLOADS_TOP_TEN_TITLE_HITS ;
	$breadcrumbs[] = array( 'name' => _MD_D3DOWNLOADS_TOP_TEN_TITLE_HITS ) ;
}
$xoopsTpl->assign('lang_sortby' ,$sort);
$xoopsTpl->assign('lang_rank' , _MD_D3DOWNLOADS_TOP_TEN_RANK);
$xoopsTpl->assign('lang_title' , _MD_D3DOWNLOADS_TOP_TEN_TITLE);
$xoopsTpl->assign('lang_category' , _MD_D3DOWNLOADS_TOP_TEN_CATEGORY);
$xoopsTpl->assign('lang_hits' , _MD_D3DOWNLOADS_TOP_TEN_HITS);
$xoopsTpl->assign('lang_rating' , _MD_D3DOWNLOADS_TOP_TEN_RATING);
$xoopsTpl->assign('lang_vote' , _MD_D3DOWNLOADS_TOP_TEN_VOTE);

$user_access = new user_access( $mydirname ) ;
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
$result=$db->query("SELECT cid, title FROM ".$db->prefix( $mydirname."_cat" )." WHERE pid=0 AND ($whr_cat) ORDER BY cat_weight ASC");
$e = 0;
$rankings = array();
$arr=array();
while(list( $cid,$ctitle )=$db->fetchRow( $result ) ){
	$rankings[$e]['title'] = sprintf( _MD_D3DOWNLOADS_TOP_TEN_TOP10 , $myts->htmlSpecialChars( $ctitle ) );
	$query = "SELECT lid, cid, title, hits, rating, votes FROM ".$db->prefix( $mydirname."_downloads" )." WHERE visible = '1' AND ( $whr_cat ) AND (cid=$cid";
// get all child cat ids for a given cat id
	$arr=$mytree->getAllChildId( $cid, $whr_cat );
	$size = count( $arr );
	for( $i=0; $i < $size ; $i++ ){
		$query .= " or cid=".$arr[$i]."";
	}
	$query .= ") order by ".$sortDB." DESC";
	$result2 = $db->query( $query, 10, 0 );
	$rank = 1;
	while( list( $did, $dcid, $dtitle, $hits, $rating, $votes )=$db->fetchRow( $result2 ) ){
		$catpath = $mytree->getPathFromId( $dcid, $whr_cat, "title" );
		$catpath= substr( $catpath, 1 );
		$catpath = str_replace("/"," <span class='fg2'>&raquo;&raquo;</span> ", $catpath );
		$dtitle = $myts->makeTboxData4Show( $dtitle );
		$rankings[$e]['file'][] = array( 'id' => $did, 'cid' => $dcid, 'rank' => $rank, 'title' => $dtitle, 'category' => $catpath, 'hits' => $hits, 'rating' => number_format( $rating, 2 ), 'votes' => $votes );
		$rank++;
	}
	$e++;
}

// 閲覧可能なカテゴリのリストを SELECTボックス用に取得
$category4assin = array();
$category4assin = d3download_makecache_for_selbox( $mydirname, $mytree, $whr_cat, 0, 1 );
$lang_directcatsel = _MD_D3DOWNLOADS_SEL_CATEGORY;

// 閲覧可能な登録件数を SELECTボックス用に取得
$mydownload = new MyDownload( $mydirname );
$num = $mydownload->Total_Num( $whr_cat );
$total_num = sprintf( _MD_D3DOWNLOADS_TOTAL_NUM , intval( $num ) );
$xoopsTpl->assign( 'download_total_num' , $total_num ) ;

$xoops_module_header = d3download_dbmoduleheader( $mydirname );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars( 'xoops_module_header' ) );

$xoopsTpl->assign('rankings', $rankings);

$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'category' => $category4assin ,
	'lang_directcatsel' => $lang_directcatsel ,
	'xoops_pagetitle' => $pagetitle4assign ,
	'xoops_breadcrumbs' => $breadcrumbs ,
) ) ;
include_once XOOPS_ROOT_PATH.'/footer.php';

?>
