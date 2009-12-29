<?php
// $Id: comment_new.php 40 2007-07-21 06:21:54Z hodaka $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.xoops.org/ http://jp.xoops.org/  http://www.myweb.ne.jp/  //
// Project: The XOOPS Project (http://www.xoops.org/)                        //
// ------------------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
if (XOOPS_COMMENT_APPROVENONE == $xoopsModuleConfig['com_rule']) {
    exit();
}

include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/comment.php';
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : $entry->bid();

// title
$com_title = $entry->getVar('title');

if ($com_itemid > 0) {
    $myts =& MyTextSanitizer::getInstance();
    $com_title = "Re: ".xoops_substr($com_title, 0, 56);

    $com_mode = isset($_GET['com_mode']) ? htmlspecialchars(trim($_GET['com_mode']), ENT_QUOTES) : '';
    if ($com_mode == '') {
        if (is_object($xoopsUser)) {
            $com_mode = $xoopsUser->getVar('umode');
        } else {
            $com_mode = $xoopsConfig['com_mode'];
        }
    }
    
    if (!isset($_GET['com_order'])) {
        if (is_object($xoopsUser)) {
            $com_order = $xoopsUser->getVar('uorder');
        } else {
            $com_order = $xoopsConfig['com_order'];
        }
    } else {
        $com_order = intval($_GET['com_order']);
    }
    $com_id = 0;
    $noname = 0;
    $dosmiley = 1;
    $dohtml = 0;
    $dobr = 1;
    $doxcode = 1;
    $com_icon = '';
    $com_pid = 0;
    $com_rootid = 0;
    $com_text = '';

    include_once dirname(dirname(__FILE__))."/include/comment_form.php";

}


?>