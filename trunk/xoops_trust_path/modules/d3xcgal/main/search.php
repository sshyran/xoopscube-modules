<?php
// $Id: search.php,v 1.3 2005/09/07 11:03:00 mcleines Exp $
//  ------------------------------------------------------------------------ //
//                    xcGal 2.0 - XOOPS Gallery Modul                        //
//  ------------------------------------------------------------------------ //
//  Based on      xcGallery 1.1 RC1 - XOOPS Gallery Modul                    //
//                    Copyright (c) 2003 Derya Kiran                         //
//  ------------------------------------------------------------------------ //
//  Based on Coppermine Photo Gallery 1.10 http://coppermine.sourceforge.net///
//                      developed by Gr��ory DEMAR                           //
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
define('IN_XCGALLERY', true);

require dirname(dirname(__FILE__)).'/include/init.inc.php' ;

$xoopsOption['template_main'] = $mydirname.'_search.html';
include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign('mydirname',$mydirname);
$xoopsTpl->assign('xoops_module_header', $d3xcgal_module_header);
$xoopsTpl->assign('search_title', _MD_D3XCGAL_SEARCH_TITLE);
user_save_profile();
$xoopsTpl->assign('gallery', $xoopsModule->getVar('name'));
include_once dirname(dirname(__FILE__)).'/include/theme_func.php';
main_menu();
do_footer();
include_once XOOPS_ROOT_PATH."/footer.php";

?>