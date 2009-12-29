<?php
// $Id: comment_form.php 323 2008-03-04 12:01:28Z hodaka $
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

if (!defined('XOOPS_ROOT_PATH') || !is_object($xoopsModule)) {
    exit();
}
$com_modid = $xoopsModule->getVar('mid');
include_once XOOPS_ROOT_PATH."/class/xoopslists.php";

if (isset($xoopsModuleConfig['com_rule'])) {
    include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
    switch ($xoopsModuleConfig['com_rule']) {
    case XOOPS_COMMENT_APPROVEALL:
        $rule_text = _CM_COMAPPROVEALL;
        break;
    case XOOPS_COMMENT_APPROVEUSER:
        $rule_text = _CM_COMAPPROVEUSER;
        break;
    case XOOPS_COMMENT_APPROVEADMIN:
        default:
        $rule_text = _CM_COMAPPROVEADMIN;
        break;
    }
    $xoopsTpl->assign('rule_text', $rule_text);
}

$xoopsTpl->assign('com_title', $com_title);

$subject_icons = XoopsLists::getSubjectsList();

$xoopsTpl->assign('com_icons', $subject_icons);

$xoopsTpl->assign('com_text', $com_text);

if (is_object($xoopsUser)) {
    if ($xoopsModuleConfig['com_anonpost'] == 1) {
        $noname = !empty($noname) ? 1 : 0;
        $xoopsTpl->assign('noname', $noname);
    }
    if (false != $xoopsUser->isAdmin($com_modid)) {
        // show status change box when editing (comment id is not empty)
        if (!empty($com_id)) {
            include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
            $xoopsTpl->assign('com_status_option', array(XOOPS_COMMENT_PENDING => _CM_PENDING, XOOPS_COMMENT_ACTIVE => _CM_ACTIVE, XOOPS_COMMENT_HIDDEN => _CM_HIDDEN));
            $xoopsTpl->assign('com_status', $com_status);
        }
        $xoopsTpl->assign('dohtml', $dohtml);
    }
}

$xoopsTpl->assign('dosmiley', $dosmiley);

$xoopsTpl->assign('doxcode', $doxcode);

$xoopsTpl->assign('dobr', $dobr);

$xoopsTpl->assign(array(
    'com_pid' => intval($com_pid),
    'com_rootid' => intval($com_rootid),
    'com_id' => $com_id,
    'com_itemid' => $com_itemid,
    'com_order' => $com_order,
    'com_mode' => $com_mode
    )
);

// add module specific extra params
$comment_config = $xoopsModule->getInfo('comments');
if (isset($comment_config['extraParams']) && is_array($comment_config['extraParams'])) {
    $myts =& MyTextSanitizer::getInstance();
    foreach ($comment_config['extraParams'] as $extra_param) {
        // This routine is included from forms accessed via both GET and POST
        if (isset($_POST[$extra_param])) {
            $hidden_value = $myts->stripSlashesGPC($_POST[$extra_param]);
        } elseif (isset($_GET[$extra_param])) {
            $hidden_value = $myts->stripSlashesGPC($_GET[$extra_param]);
        } else {
            $hidden_value = '';
        }
        $xoopsTpl->append('extra_params', array('param'=>$extra_param, 'value'=>htmlspecialchars($hidden_value, ENT_QUOTES)));
    }
}

?>