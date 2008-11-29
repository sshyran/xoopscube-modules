<?php
// $Id: index.php,v 1.3 2006/07/20 14:05:52 mcleines Exp $
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
define('IN_XCGALLERY', true);

include dirname(__FILE__).'/header.php' ;
include_once XOOPS_ROOT_PATH.'/include/version.php' ;	//check XOOPS_VERSION

$result=$xoopsDB->query("SELECT count(*) FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'NO'");
$nbEnr = $xoopsDB->fetchArray($result);
$pic_count = $nbEnr['count(*)'];
if ($pic_count > 0) $pics= "<span style='color: #ff0000; font-weight: bold'>$pic_count</span>";
else $pics= "<span style='font-weight: bold'>$pic_count</span>";

xoops_cp_header();
include(dirname(__FILE__).'/mymenu.php');

echo "<h4>"._AM_D3XCGAL_CONFIG."</h4>";
echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
if (preg_match("/\bLegacy\b/i", XOOPS_VERSION)) {
	echo " - <b><a href='".XOOPS_URL."/modules/legacy/admin/index.php?action=PreferenceEdit&amp;confmod_id=".$xoopsModule->getVar('mid')."'>"._AM_D3XCGAL_GENERALCONF."</a></b><br /><br />\n";
} else {
	echo " - <b><a href='".XOOPS_URL.'/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$xoopsModule->getVar('mid')."'>"._AM_D3XCGAL_GENERALCONF."</a></b><br /><br />\n";
}
echo " - <b><a href='index.php?page=catmgr'>"._AM_D3XCGAL_CATMNGR."</a></b>";
echo "<br /><br />\n";
echo " - <b><a href='index.php?page=usermgr'>"._AM_D3XCGAL_USERMNGR."</a></b>\n";
echo "<br /><br />\n";
echo " - <b><a href='index.php?page=groupmgr'>"._AM_D3XCGAL_GROUPMNGR."</a></b>\n";
echo "<br /><br />\n";
echo " - <b><a href='index.php?page=searchnew'>"._AM_D3XCGAL_BATCHADD."</a></b>\n";
echo "<br /><br />\n";
echo " - <b><a href='index.php?page=ecardmgr'>"._AM_D3XCGAL_ECARDMNGR."</a></b>\n";
echo "<br /><br />\n";
echo " - <b><a href='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/index.php?page=editpics&mode=upload_approval'>"._AM_D3XCGAL_PICAPP." ({$pics})</a></b>\n";
echo"</td></tr></table>";
xoops_cp_footer();



?>