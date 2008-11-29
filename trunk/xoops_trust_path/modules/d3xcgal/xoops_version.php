<?php
// $Id: xoops_version.php,v 1.15 2006/03/28 08:47:35 mcleines Exp $
//  ------------------------------------------------------------------------ //
//                    xcGal 2.0 - XOOPS Gallery Modul                        //
//  ------------------------------------------------------------------------ //
//  Based on      xcGallery 1.1 RC1 - XOOPS Gallery Modul                    //
//                    Copyright (c) 2003 Derya Kiran                         //
//  ------------------------------------------------------------------------ //
//  Based on Coppermine Photo Gallery 1.10 http://coppermine.sourceforge.net///
//                      developed by GrñÈory DEMAR                           //
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
// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$modversion['name'] = $mydirname;
$modversion['version'] = '0.33';
$modversion['description'] = 'xcGallery D3 module for X2JP 2.0 and XCL 2.1 based on xcgal 2.03';
$modversion['credits'] = "xcgal 2.03 what is based on Coppermine 1.10 &copy; (http://coppermine.sourceforge.net)";
$modversion['author'] = "Original ver1.1 by Derya Kiran, edited for Xoops 2.2 by mcleines. <br />D3 configuration and edited for X2JP and XCL by manta (http://xoops.oceanblue-site.com)";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = $mydirname;

// DB
$modversion['sqlfile'] = false ;

// Tables
$modversion['tables'] = array() ;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/admin_menu.php";

// Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.php";
$modversion['search']['func'] = $mydirname."_d3xcgal_search";

// Blocks
$modversion['blocks'][1] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_D3XCGAL_SCROLL') ,
	'description'	=> 'Scrolling Thumbnails' ,
	'show_func'		=> 'd3xcgal_block_scroll_func' ,
	'edit_func'		=> 'd3xcgal_block_scroll_edit' ,
	'options'		=> "$mydirname|1|90|1|5" ,
	'template'		=> '' ,
	'can_clone'		=> true ,
) ;
$modversion['blocks'][2] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_D3XCGAL_STATIC') ,
	'description'	=> 'Static Thumbnails' ,
	'show_func'		=> 'd3xcgal_block_static_func' ,
	'edit_func'		=> 'd3xcgal_block_static_edit' ,
	'options'		=> "$mydirname|4|2|1|5" ,
	'template'		=> '' ,
	'can_clone'		=> true ,
) ;

// Templates
$modversion['templates'] = array() ;

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'pid';
$modversion['comments']['pageName'] = 'index.php';
$modversion['comments']['extraParams'] = array('page');

// Configs
$modversion['config'][1] = array(
	'name'			=> 'anosee' ,
	'title'			=> $constpref.'_ANONSEE' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'subcat_level' ,
	'title'			=> $constpref.'_SUBCAT_LEVEL' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 2 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'albums_per_page' ,
	'title'			=> $constpref.'_ALB_PER_PAGE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 12 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'album_list_cols' ,
	'title'			=> $constpref.'_ALB_LIST_COLS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 2 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'alb_list_thumb_size' ,
	'title'			=> $constpref.'_ALB_THUMB_SIZE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 50 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'main_page_layout' ,
	'title'			=> $constpref.'_MAIN_LAYOUT' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'catlist/alblist/random,2/lastup,2' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'thumbcols' ,
	'title'			=> $constpref.'_THUMBCOLS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 4 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'thumbrows' ,
	'title'			=> $constpref.'_THUMBROWS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 3 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'max_tabs' ,
	'title'			=> $constpref.'_MAX_TABS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 12 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'caption_in_thumbview' ,
	'title'			=> $constpref.'_TEXT_THUMBVIEW' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'display_comment_count' ,
	'title'			=> $constpref.'_COM_COUNT' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'default_sort_order' ,
	'title'			=> $constpref.'_DEF_SORT' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'na' ,
	'options'		=> array($constpref.'_SORT_NA' => 'na', $constpref.'_SORT_ND' => 'nd' ,  $constpref.'_SORT_DA' => 'da' , $constpref.'_SORT_DD' => 'dd')
) ;

$modversion['config'][] = array(
	'name'			=> 'min_votes_for_rating' ,
	'title'			=> $constpref.'_MIN_VOTES' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'display_pic_info' ,
	'title'			=> $constpref.'_DIS_PICINFO' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'jpeg_qual' ,
	'title'			=> $constpref.'_JPG_QUAL' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 80 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'thumb_width' ,
	'title'			=> $constpref.'_THUMB_WIDTH' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 100 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'make_intermediate' ,
	'title'			=> $constpref.'_MAKE_INTERM' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'picture_width' ,
	'title'			=> $constpref.'_PICTURE_WIDTH' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 400 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'max_upl_size' ,
	'title'			=> $constpref.'_MAX_UPL_SIZE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1024 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'max_upl_width_height' ,
	'title'			=> $constpref.'_MAX_UPL_WIDTH' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 2048 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'allow_private_albums' ,
	'title'			=> $constpref.'_ALLOW_PRIVATE' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'user_field1_name' ,
	'title'			=> $constpref.'_UF_NAME1' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'user_field2_name' ,
	'title'			=> $constpref.'_UF_NAME2' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'user_field3_name' ,
	'title'			=> $constpref.'_UF_NAME3' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'user_field4_name' ,
	'title'			=> $constpref.'_UF_NAME4' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'forbidden_fname_char' ,
	'title'			=> $constpref.'_FORB_FNAME' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> "$/\:*?\"'<>|`" ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'allowed_file_extensions' ,
	'title'			=> $constpref.'_FILE_EXT' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'GIF/PNG/JPG/JPEG/TIF/TIFF/AVI/MP3' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'thumb_method' ,
	'title'			=> $constpref.'_THUMB_METHOD' ,
	'description'	=> $constpref.'_THUMB_METHODDESC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'gd2' ,
	'options'		=> array( 'Image Magick' => 'im', 'Netpbm' => 'net', 'GD version 1.x' => 'gd1', 'GD version 2.x' => 'gd2')
) ;

$modversion['config'][] = array(
	'name'			=> 'impath' ,
	'title'			=> $constpref.'_IMPATH' ,
	'description'	=> $constpref.'_IMPATHDESC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'allowed_img_types' ,
	'title'			=> $constpref.'_ALLOW_IMG_TYPES' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'JPG/GIF/PNG/TIFF' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'im_options' ,
	'title'			=> $constpref.'_IM_OPTIONS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '-antialias' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'read_exif_data' ,
	'title'			=> $constpref.'_READ_EXIF' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'fullpath' ,
	'title'			=> $constpref.'_FULLPATH' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'albums/' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'userpics' ,
	'title'			=> $constpref.'_USERPICS' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'userpics/' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'normal_pfx' ,
	'title'			=> $constpref.'_NORMAL_PFX' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'normal_' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'thumb_pfx' ,
	'title'			=> $constpref.'_THUMB_PFX' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'thumb_' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'default_dir_mode' ,
	'title'			=> $constpref.'_DIR_MODE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '0755' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'default_file_mode' ,
	'title'			=> $constpref.'_PIC_MODE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '0644' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'cookie_name' ,
	'title'			=> $constpref.'_COOKIE_NAME' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'd3xcgal' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'cookie_path' ,
	'title'			=> $constpref.'_COOKIE_PATH' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '/' ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'debug_mode' ,
	'title'			=> $constpref.'_DEBUG_MODE' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'ecards_more_pic_target' ,
	'title'			=> $constpref.'_ECRAD_SEE_MORE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> XOOPS_URL ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'ecards_type' ,
	'title'			=> $constpref.'_ECRAD_TYPE' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array($constpref.'_TEXT_CARD' => 1, $constpref.'_HTML_CARD' => 2)
) ;

$modversion['config'][] = array(
	'name'			=> 'ecards_per_hour' ,
	'title'			=> $constpref.'_ECRAD_PER_HOUR' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 5 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'ecards_saved_db' ,
	'title'			=> $constpref.'_ECRAD_SAVE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 15 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'ecards_text' ,
	'title'			=> $constpref.'_ECRAD_TEXT' ,
	'description'	=> $constpref.'_ECRAD_TEXTDESC' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'text' ,
	'default'		=> constant($constpref.'_ECRAD_TEXTVALUE') ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'keep_votes_time' ,
	'title'			=> $constpref.'_KEEP_VOTES' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> 30 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'search_thumb' ,
	'title'			=> $constpref.'_SEARCH_THUMB' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'watermarking' ,
	'title'			=> $constpref.'_WATERMARKING' ,
	'description'	=> $constpref.'_WATERMARK_TEXTDESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'batch_all' ,
	'title'			=> $constpref.'_BATCHSHOWALL' ,
	'description'	=> $constpref.'_BATCHSHOWALLDESC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;

$modversion['config'][] = array(
	'name'			=> 'css_uri' ,
	'title'			=> $constpref.'_CSS_URI' ,
	'description'	=> $constpref.'_CSS_URIDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '{mod_url}/index.php?page=main_css' ,
	'options'		=> array()
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