<?php
// $Id: modinfo.php,v 1.6 2006/03/28 08:47:35 mcleines Exp $
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
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3xcgal' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;
global $xoopsConfig;	//add for line 104

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

define($constpref."_D3XCGAL_NAME","xcGalleryD3");
define($constpref."_D3XCGAL_ADMENU1", "Admin overview");
define($constpref."_D3XCGAL_ADMENU2", "Categories");
define($constpref."_D3XCGAL_ADMENU3", "Users");
define($constpref."_D3XCGAL_ADMENU4", "Groups");
define($constpref."_D3XCGAL_ADMENU5", "Ecards");
define($constpref."_D3XCGAL_ADMENU6", "Batch Add Pictures");

define($constpref."_D3XCGAL_SCROLL","Scrolling Thumbnails");
define($constpref."_D3XCGAL_CATMENU","xcGallery Categories");
define($constpref."_D3XCGAL_STATIC","Static Thumbnails");
define($constpref."_D3XCGAL_METAALB","Meta Albums");

// configs
define($constpref."_ANONSEE", "Allow anonymous users to see Pictures?");
define($constpref."_SUBCAT_LEVEL", "Album list view: Number of levels of categories to display");
define($constpref."_ALB_PER_PAGE", "Album list view: Number of albums to display");
define($constpref."_ALB_LIST_COLS", "Album list view: Number of columns for the album list");
define($constpref."_ALB_THUMB_SIZE", "Album list view: Size of thumbnails in pixels");
define($constpref."_MAIN_LAYOUT", "Album list view: The content of the main page");
define($constpref."_THUMBCOLS", "Thumbnail view: Number of columns on thumbnail page");
define($constpref."_THUMBROWS", "Thumbnail view: Number of rows on thumbnail page");
define($constpref."_MAX_TABS", "Thumbnail view: Maximum number of tabs to display");
define($constpref."_TEXT_THUMBVIEW", "Thumbnail view: Display picture description (in addition to title) below the thumbnail");
define($constpref."_COM_COUNT", "Thumbnail view: Display number of comments below the thumbnail");
define($constpref."_DEF_SORT", "Thumbnail view: Default sort order for pictures");
define($constpref."_SORT_NA", "Name ascending");
define($constpref."_SORT_ND", "Name descending");
define($constpref."_SORT_DA", "Date ascending");
define($constpref."_SORT_DD", "Date descending");
define($constpref."_MIN_VOTES", "Thumbnail view: Minimum number of votes for a picture to appear in the 'top-rated' list ");
define($constpref."_DIS_PICINFO", "Image Display: Picture information are visible by default");
define($constpref."_JPG_QUAL", "Pictures and thumbnails settings: Quality for JPEG files");
define($constpref."_THUMB_WIDTH", "Pictures and thumbnails settings: Max width or height of a thumbnail *");
define($constpref."_MAKE_INTERM", "Pictures and thumbnails settings: Create intermediate pictures");
define($constpref."_PICTURE_WIDTH", "Pictures and thumbnails settings: Max width or height of an intermediate picture *");
define($constpref."_MAX_UPL_SIZE", "Pictures and thumbnails settings: Max size for uploaded pictures (KB)");
define($constpref."_MAX_UPL_WIDTH", "Pictures and thumbnails settings: Max width or height for uploaded pictures (pixels)");
define($constpref."_ALLOW_PRIVATE", "User settings: Users can can have private albums");
define($constpref."_UF_NAME1", "Custom field 1 name for image description (leave blank if unused)");
define($constpref."_UF_NAME2", "Custom field 2 name for image description (leave blank if unused)");
define($constpref."_UF_NAME3", "Custom field 3 name for image description (leave blank if unused)");
define($constpref."_UF_NAME4", "Custom field 4 name for image description (leave blank if unused)");
define($constpref."_FORB_FNAME", "Characters forbidden in filenames");
define($constpref."_FILE_EXT", "Accepted file extensions for uploaded pictures");
define($constpref."_THUMB_METHOD", "Method for resizing images");
define($constpref."_THUMB_METHODDESC", "ImageMagick or NetPBM recommended");
define($constpref."_IMPATH", "Path to ImageMagick/Netpbm");
define($constpref."_IMPATHDESC", "Path of 'convert' utility (example /usr/bin/X11/)");
define($constpref."_ALLOW_IMG_TYPES", "Allowed image types (only valid for ImageMagick)");
define($constpref."_IM_OPTIONS", "Command line options for ImageMagick");
define($constpref."_READ_EXIF", "Read EXIF data in JPEG files (needs php exif extension");
define($constpref."_FULLPATH", "The album directory *");
define($constpref."_USERPICS", "The directory for user pictures *");
define($constpref."_NORMAL_PFX", "The prefix for intermediate pictures *");
define($constpref."_THUMB_PFX", "The prefix for thumbnails *");
define($constpref."_DIR_MODE", "Default mode for directories");
define($constpref."_PIC_MODE", "Default mode for pictures");
define($constpref."_COOKIE_NAME", "Name of the cookie used by the script");
define($constpref."_COOKIE_PATH", "Path of the cookie used by the script");
define($constpref."_DEBUG_MODE", "Enable Gallery debug mode");
define($constpref."_ECRAD_SEE_MORE", "Target address for the 'See more pictures' link in e-cards");
define($constpref."_ECRAD_TYPE", "Select ecard type");
define($constpref."_TEXT_CARD", "Text");
define($constpref."_HTML_CARD", "Html");
define($constpref."_ECRAD_PER_HOUR", "Allowed ecards, that a user can send per hour");
define($constpref."_ECRAD_SAVE", "How long should ecards be saved in db (days)");
define($constpref."_ECRAD_TEXT","Ecard text");
define($constpref."_ECRAD_TEXTDESC","(for text ecards and as alternative text for html ecards)<br /><b>Useful Tags</b><br />{X_SITEURL} will print ".XOOPS_URL."<br />{X_SITENAME} will print the site name<br />{R_NAME} will print recipient name<br />{R_MAIL} will print recipient email<br />{S_NAME} will print sender name<br />{S_MAIL} will print sender email<br />{SAVE_DAYS} will print number of day an ecard is saved in db<br />{CARD_LINK} will print the ecard pick-up url");
define($constpref."_ECRAD_TEXTVALUE","Dear {R_NAME},\n\n{S_NAME}({S_MAIL}) has sent an ecard for you.\nPlease, pick it up at {CARD_LINK}.\nYour ecard will be saved {SAVE_DAYS} days in our database.\n\nregards\n{X_SITENAME} team ({X_SITEURL})");
define($constpref."_KEEP_VOTES", "How long should votes be saved in db (days) (0 if they should not be deleted");
define($constpref."_SEARCH_THUMB", "Show thumbnail instead of xcGallery icon on search and userinfo pages");
define($constpref."_WATERMARKING", "Use watermarking for JPG");
define($constpref."_WATERMARK_TEXTDESC", "Watermark must be saved at xcgal/images/watermark.png");
define($constpref."_BATCHSHOWALL", "Batchupload - Show all");
define($constpref."_BATCHSHOWALLDESC", "All files are shown, also files that are already in an album. For NO only new files are displayed");
define($constpref.'_CSS_URI','URI of CSS file for this module');
define($constpref.'_CSS_URIDSC','relative or absolute path can be set. default: {mod_url}/index.php?page=main_css');

// admin menu
define($constpref.'_ADMENU_MYLANGADMIN','Languages');
define($constpref.'_ADMENU_MYTPLSADMIN','Templates');
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocks/Permissions');
define($constpref.'_ADMENU_MYPREFERENCES','Preferences');

}

?>