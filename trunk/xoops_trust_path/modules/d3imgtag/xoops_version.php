<?php
// $Id: xoops_version.php,v 1.4 2003/02/12 11:37:53 okazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$modversion['name'] = $mydirname ;
$modversion['version'] = '0.24';
$modversion['description'] = constant($constpref.'_DESC') ;
$modversion['author'] = "Original MyAlbum Module v2.84 by GIJOE (http://www.peak.ne.jp/)<br />Modified by KickassAMD (http://www.kickassamd.com/)<br />Re-modified by manta (http://xoops.oceanblue-site.com/) for X2 and XCL based on myAlbum-p 2.88";
$modversion['credits'] = "";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = $mydirname ;

// DB
$modversion['sqlfile']['mysql'] = false ;

// Tables
$modversion['tables'] = array() ;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/admin_menu.php";

// Blocks
$modversion['blocks'][1] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_RANDOM') ,
	'description'	=> 'Shows a random photo' ,
	'show_func'		=> 'b_d3imgtag_rphoto_show' ,
	'edit_func'		=> 'b_d3imgtag_rphoto_edit' ,
	'options'		=> "$mydirname|140|1||1|60|1" ,
	'template'		=> '' ,
	'can_clone'		=> true ,
) ;

$modversion['blocks'][2] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_RECENT') ,
	'description'	=> 'Shows recently added photos' ,
	'show_func'		=> 'b_d3imgtag_topnews_show' ,
	'edit_func'		=> 'b_d3imgtag_topnews_edit' ,
	'options'		=> "$mydirname|10|20||1||1" ,
	'template'		=> '' ,
	'can_clone'		=> true ,
) ;

$modversion['blocks'][3] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_HITS') ,
	'description'	=> 'Shows most viewed photos' ,
	'show_func'		=> 'b_d3imgtag_tophits_show' ,
	'edit_func'		=> 'b_d3imgtag_tophits_edit' ,
	'options'		=> "$mydirname|10|20||1||1" ,
	'template'		=> '' ,
	'can_clone'		=> true ,
) ;

$modversion['blocks'][4] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_RECENT_P') ,
	'description'	=> 'Shows recently added photos' ,
	'show_func'		=> 'b_d3imgtag_topnews_p_show' ,
	'edit_func'		=> 'b_d3imgtag_topnews_p_edit' ,
	'options'		=> "$mydirname|5|20||1||1" ,
	'template'		=> '' ,
	'can_clone'		=> true ,
) ;

$modversion['blocks'][5] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_HITS_P') ,
	'description'	=> 'Shows most viewed photos' ,
	'show_func'		=> 'b_d3imgtag_tophits_p_show' ,
	'edit_func'		=> 'b_d3imgtag_tophits_p_edit' ,
	'options'		=> "$mydirname|5|20||1||1" ,
	'template'		=> '' ,
	'can_clone'		=> true ,
) ;


// Menu
global $xoopsDB , $xoopsUser , $d3imgtag_catonsubmenu , $d3imgtag_mid , $table_cat ;

$modversion['hasMain'] = 1 ;
$subcount = 1 ;
include dirname( __FILE__ ) . '/include/get_perms.php' ;
if($global_perms & 1) {	// GPERM_INSERTABLE
	$modversion['sub'][$subcount]['name'] = constant($constpref.'_TEXT_SMNAME1');
	$modversion['sub'][$subcount++]['url'] = "index.php?page=submit";
	$modversion['sub'][$subcount]['name'] = constant($constpref.'_TEXT_SMNAME4');
	$modversion['sub'][$subcount++]['url'] = "index.php?page=viewcat&uid=-1";
}
$modversion['sub'][$subcount]['name'] = constant($constpref.'_TEXT_SMNAME2');
$modversion['sub'][$subcount++]['url'] = "index.php?page=topten&hit=1";
if($global_perms & 256) {	// GPERM_RATEVIEW
	$modversion['sub'][$subcount]['name'] = constant($constpref.'_TEXT_SMNAME3');
	$modversion['sub'][$subcount++]['url'] = "index.php?page=topten&rate=1";
}
if(isset($d3imgtag_catonsubmenu) && $d3imgtag_catonsubmenu) {
	$crs = $xoopsDB->query("SELECT cid, title FROM $table_cat WHERE pid=0 ORDER BY title");
	if($crs !== false) {
		while(list($cid , $title) = $xoopsDB->fetchRow($crs)) {
			$modversion['sub'][$subcount]['name'] = " - $title";
			$modversion['sub'][$subcount++]['url'] = "index.php?page=viewcat&cid=$cid";
		}
	}
}

$fontDir = opendir(XOOPS_TRUST_PATH."/modules/d3imgtag/fonts");
while (false !== ($font = readdir($fontDir)))
{
	$font = str_replace(".ttf", "", $font);
	$font = str_replace(".TTF", "", $font);
	if ($font != ".." && $font != ".")
	{
		$fontList[$font] = $font;
	}
}


// Config
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_photospath' ,
	'title'			=> $constpref.'_PHOTOSPATH' ,
	'description'	=> $constpref.'_DESCPHOTOSPATH' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> "/uploads/{$mydirname}/fulls" ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_thumbspath' ,
	'title'			=> $constpref.'_THUMBSPATH' ,
	'description'	=> $constpref.'_DESCTHUMBSPATH' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> "/uploads/{$mydirname}/thumbs" ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_previewspath' ,
	'title'			=> $constpref.'_PREVIEWSPATH' ,
	'description'	=> $constpref.'_DESCPREVIEWSPATH' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> "/uploads/{$mydirname}/previews" ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_imagingpipe' ,
	'title'			=> $constpref.'_IMAGINGPIPE' ,
	'description'	=> $constpref.'_DESCIMAGINGPIPE' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array( 'GD' => 0 , 'ImageMagick' => 1 , 'NetPBM' => 2 )
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_forcegd2' ,
	'title'			=> $constpref.'_FORCEGD2' ,
	'description'	=> $constpref.'_DESCFORCEGD2' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_imagickpath' ,
	'title'			=> $constpref.'_IMAGICKPATH' ,
	'description'	=> $constpref.'_DESCIMAGICKPATH' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_netpbmpath' ,
	'title'			=> $constpref.'_NETPBMPATH' ,
	'description'	=> $constpref.'_DESCNETPBMPATH' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_width' ,
	'title'			=> $constpref.'_WIDTH' ,
	'description'	=> $constpref.'_DESCWIDTH' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1024' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_height' ,
	'title'			=> $constpref.'_HEIGHT' ,
	'description'	=> $constpref.'_DESCHEIGHT' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1024' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_fsize' ,
	'title'			=> $constpref.'_FSIZE' ,
	'description'	=> $constpref.'_DESCFSIZE' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '100000' ,
	'options'		=> array()
);

$modversion['config'][] = array(
	'name'			=> 'd3imgtag_minfile' ,
	'title'			=> $constpref.'_MINFILE' ,
	'description'	=> $constpref.'_MINFILEDESC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_maxfile' ,
	'title'			=> $constpref.'_MAXFILE' ,
	'description'	=> $constpref.'_MAXFILEDESC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '50' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_filerule' ,
	'title'			=> $constpref.'_FILERULE' ,
	'description'	=> $constpref.'_FILERULEDESC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array(
		'Alpha Only' => 0 , 'Numeric Only' => 1 , 'Alpha-Numeric' => 2, 'Alpha-Numeric-Special' => 3)
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_middlepixel' ,
	'title'			=> $constpref.'_MIDDLEPIXEL' ,
	'description'	=> $constpref.'_DESCMIDDLEPIXEL' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '480x480' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_allownoimage' ,
	'title'			=> $constpref.'_ALLOWNOIMAGE' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_makethumb' ,
	'title'			=> $constpref.'_MAKETHUMB' ,
	'description'	=> $constpref.'_DESCMAKETHUMB' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_makepreview' ,
	'title'			=> $constpref.'_MAKEPREVIEW' ,
	'description'	=> $constpref.'_DESCMAKEPREVIEW' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_thumbsize' ,
	'title'			=> $constpref.'_THUMBSIZE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '140' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_thumbrule' ,
	'title'			=> $constpref.'_THUMBRULE' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'w' ,
	'options'		=> array(
		$constpref.'_OPT_CALCFROMWIDTH' => 'w' , $constpref.'_OPT_CALCFROMHEIGHT' => 'h' , $constpref.'_OPT_CALCWHINSIDEBOX' => 'b')
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_previewsize' ,
	'title'			=> $constpref.'_PREVIEWSIZE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '400' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_previewrule' ,
	'title'			=> $constpref.'_PREVIEWRULE' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'w' ,
	'options'		=> array(
		$constpref.'_OPT_CALCFROMWIDTH' => 'w' , $constpref.'_OPT_CALCFROMHEIGHT' => 'h' , $constpref.'_OPT_CALCWHINSIDEBOX' => 'b')
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_popular' ,
	'title'			=> $constpref.'_POPULAR' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '100' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_newdays' ,
	'title'			=> $constpref.'_NEWDAYS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '7' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_newphotos' ,
	'title'			=> $constpref.'_NEWPHOTOS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_defaultorder' ,
	'title'			=> $constpref.'_DEFAULTORDER' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'dateD' ,
	'options'		=> array(
		"photo_id ASC" => 'lidA' ,
		"title ASC" => 'titleA' ,
		"date ASC" => 'dateA' ,
		"hits ASC" => 'hitsA' ,
		"rating ASC" => 'ratingA' ,
		"photo_id DESC" => 'lidD' ,
		"title DESC" => 'titleD' ,
		"date DESC" => 'dateD' ,
		"hits DESC" => 'hitsD' ,
		"rating DESC" => 'ratingD'
		)
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_perpage' ,
	'title'			=> $constpref.'_PERPAGE' ,
	'description'	=> $constpref.'_DESCPERPAGE' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '10|20|50|100' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_addposts' ,
	'title'			=> $constpref.'_ADDPOSTS' ,
	'description'	=> $constpref.'_DESCADDPOSTS' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_catonsubmenu' ,
	'title'			=> $constpref.'_CATONSUBMENU' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_nameoruname' ,
	'title'			=> $constpref.'_NAMEORUNAME' ,
	'description'	=> $constpref.'_DESCNAMEORUNAME' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'uname' ,
	'options'		=> array($constpref.'_OPT_USENAME'=> 'name', $constpref.'_OPT_USEUNAME' => 'uname')
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_viewcattype' ,
	'title'			=> $constpref.'_VIEWCATTYPE' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'list' ,
	'options'		=> array($constpref.'_OPT_VIEWLIST'=>'list', $constpref.'_OPT_VIEWTABLE'=>'table')
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_colsoftableview' ,
	'title'			=> $constpref.'_COLSOFTABLEVIEW' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '4' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_allowedexts' ,
	'title'			=> $constpref.'_ALLOWEDEXTS' ,
	'description'	=> $constpref.'_DESCALLOWEDEXTS' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'jpg|jpeg|gif|png' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_allowedmime' ,
	'title'			=> $constpref.'_ALLOWEDMIME' ,
	'description'	=> $constpref.'_DESCALLOWEDMIME' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'image/gif|image/pjpeg|image/jpeg|image/x-png|image/png' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_usesiteimg' ,
	'title'			=> $constpref.'_USESITEIMG' ,
	'description'	=> $constpref.'_DESCUSESITEIMG' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_deletebatch' ,
	'title'			=> $constpref.'_DELETEBATCH' ,
	'description'	=> $constpref.'_DELETEBATCHDESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_enableajax' ,
	'title'			=> $constpref.'_AJAX' ,
	'description'	=> $constpref.'_AJAXDESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_ajaxeffect' ,
	'title'			=> $constpref.'_AJAXEFFECT' ,
	'description'	=> $constpref.'_AJAXEFFECTDESC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array(
	'Minimal' => 0 , 'Full' => 1)
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_extendedinfo' ,
	'title'			=> $constpref.'_EXINFO' ,
	'description'	=> $constpref.'_EXINFODESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_imagedateformat' ,
	'title'			=> $constpref.'_DATEFORMAT' ,
	'description'	=> $constpref.'_DATEFORMATDESC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> "F j, Y, g:i a" ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_enableshare' ,
	'title'			=> $constpref.'_SHARE' ,
	'description'	=> $constpref.'_SHAREDESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_checkreferer' ,
	'title'			=> $constpref.'_CHECKREFERER' ,
	'description'	=> $constpref.'_CHECKREFERERDESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name' 			=> 'd3imgtag_allowedreferers',
	'title' 		=> $constpref.'__REFERERS',
	'description' 	=> $constpref.'__REFERERSDESC',
	'formtype' 		=> 'textarea',
	'default'		=> XOOPS_URL,
	'valuetype' 	=> 'array'
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_badrefcheck' ,
	'title'			=> $constpref.'_BADREFCHECK' ,
	'description'	=> $constpref.'_BADREFCHECKDESC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array(
	'Blank Page' => 0 , 'Redirect & Warning' => 1 , 'Image Notice' => 2)
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_badreftxt' ,
	'title'			=> $constpref.'_BADREFTXT' ,
	'description'	=> $constpref.'_BADREFTXTDESC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'Please do not hot link our images.' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_enablewater' ,
	'title'			=> $constpref.'_WATER' ,
	'description'	=> $constpref.'_WATERDESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_watervalue' ,
	'title'			=> $constpref.'_WATERVALUE' ,
	'description'	=> $constpref.'_WATERVALUEDESC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> XOOPS_URL ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_watersize' ,
	'title'			=> $constpref.'_WATERSIZE' ,
	'description'	=> $constpref.'_WATERSIZEDESC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '20' ,
	'options'		=> array()
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_waterfont' ,
	'title'			=> $constpref.'_WATERFONT' ,
	'description'	=> $constpref.'_WATERFONTDESC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> $fontList
);
$modversion['config'][] = array(
	'name'			=> 'd3imgtag_waterpos' ,
	'title'			=> $constpref.'_WATERPOS' ,
	'description'	=> $constpref.'_WATERPOSDESC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array(
	'Middle' => 0 , 'Top Middle' => 1, 'Bottom Middle' => 2, 'Bottom Right' => 3, 'Top Left' => 4 )
);

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "search.php";
$modversion['search']['func'] = $mydirname."_global_search";

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'lid';
$modversion['comments']['pageName'] = 'index.php';
$modversion['comments']['extraParams'] = array('page');

// Comment callback functions
$modversion['comments']['callbackFile'] = 'comment.php';
$modversion['comments']['callback']['approve'] = "{$mydirname}_comments_approve";
$modversion['comments']['callback']['update'] = "{$mydirname}_comments_update";

// Templates
$modversion['templates'] = array() ;

// Notification
$modversion['hasNotification'] = 1 ;
$modversion['notification'] = array(
	'lookup_file' => 'notification.php' ,
	'lookup_func' => "{$mydirname}_notify_iteminfo" ,
	'category' => array(
		array(
			'name' => 'global' ,
			'title' => constant($constpref.'_GLOBAL_NOTIFY') ,
			'description' => constant($constpref.'_GLOBAL_NOTIFYDSC') ,
			'subscribe_from' => array('index.php') ,
		) ,
		array(
			'name' => 'category' ,
			'title' => constant($constpref.'_CATEGORY_NOTIFY') ,
			'description' => constant($constpref.'_CATEGORY_NOTIFYDSC') ,
			'subscribe_from' => array('index.php') ,
			'item_name' => 'cid' ,
			'allow_bookmark' => 1 ,
		) ,
		array(
			'name' => 'photo' ,
			'title' => constant($constpref.'_PHOTO_NOTIFY') ,
			'description' => constant($constpref.'_PHOTO_NOTIFYDSC') ,
			'subscribe_from' => array('index.php') ,
			'item_name' => 'lid' ,
			'allow_bookmark' => 1 ,
		) ,
	) ,
	'event' => array(
		array(
			'name' => 'new_photo' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_GLOBAL_NEWPHOTO_NOTIFY') ,
			'caption' => constant($constpref.'_GLOBAL_NEWPHOTO_NOTIFYCAP') ,
			'description' => constant($constpref.'_GLOBAL_NEWPHOTO_NOTIFYDSC') ,
			'mail_template' => 'global_newphoto_notify' ,
			'mail_subject' => constant($constpref.'_GLOBAL_NEWPHOTO_NOTIFYSBJ') ,
		) ,
		array(
			'name' => 'new_photo' ,
			'category' => 'category' ,
			'title' => constant($constpref.'_CATEGORY_NEWPHOTO_NOTIFY') ,
			'caption' => constant($constpref.'_CATEGORY_NEWPHOTO_NOTIFYCAP') ,
			'description' => constant($constpref.'_CATEGORY_NEWPHOTO_NOTIFYDSC') ,
			'mail_template' => 'category_newphoto_notify' ,
			'mail_subject' => constant($constpref.'_CATEGORY_NEWPHOTO_NOTIFYSBJ') ,
		) ,
	) ,
) ;


// onInstall, onUpdate, onUninstall
$modversion['onInstall'] = 'oninstall.php' ;~
$modversion['onUpdate'] = 'onupdate.php' ;~
$modversion['onUninstall'] = 'onuninstall.php' ;

// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 
        && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) 
        && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' 
        && $_POST['dirname'] == $modversion['dirname'] ) {
	include dirname(__FILE__).'/include/x20_keepblockoptions.inc.php' ;
}

?>