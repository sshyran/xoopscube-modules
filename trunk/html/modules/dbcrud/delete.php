<?php

require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once 'include/common.php';
$xoopsOption['template_main'] = $dirname . '_xgdb_delete.html';

$op = isset($_POST['op']) && $_POST['op'] !== '' ? $_POST['op'] : '';
$id = isset($_POST['id']) && $_POST['id'] !== '' ? intval($_POST['id']) : 0;

// 存在チェック
$sql = "SELECT d.*, u.uname FROM $data_tbl AS d LEFT OUTER JOIN $users_tbl AS u ON d.add_uid = u.uid WHERE d.id = $id";
$res = $xoopsDB->query($sql);
if ($xoopsDB->getRowsNum($res) == 0) {
    redirect_header($module_url . '/', 5, constant('_MD_' . $affix . '_NO_ERR_MSG'));
}

// 権限チェック
$row = $xoopsDB->fetchArray($res);
if (!checkPerm($gids, $cfg_manage_gids) && $uid != $row['add_uid']) {
    redirect_header($module_url . '/', 5, constant('_MD_' . $affix . '_PERM_ERR_MSG'));
}

$errors = array();
if ($op == 'delete') {
    // トークンチェック
    if (!XoopsMultiTokenHandler::quickValidate($dirname . '_delete')) {
        $errors[] = constant('_MD_' . $affix . '_TOKEN_ERR_MSG');
    } else {
        if (!$xoopsDB->query("DELETE FROM $data_tbl WHERE id = $id")) {
            $errors[] = constant('_MD_' . $affix . '_SYSTEM_ERR_MS');
        } else {
            foreach ($item_defs as $item_name => $item_def) {
                if ($item_def['type'] == 'file' || $item_def['type'] == 'image') {
                    @unlink($module_upload_dir . '/' . $row[$item_name]);
                }
            }

            $extra_tags = array(
                'ID'            => $id,
                'TITLE'         => $row[$list_link_item_name],
                'TITLE_CAPTION' => $list_link_item_def['caption']
            );
            $notification_handler =& xoops_gethandler('notification');
            $notification_handler->triggerEvent('change', $id, 'delete', $extra_tags);
            $notification_handler->unsubscribeByItem($xoopsModule->getVar('mid'), 'change', $id);

            redirect_header($module_url . '/', 5, constant('_MD_' . $affix . '_DELETE_MSG'));
        }
    }
} else {
    // 表示値割り当て
    foreach ($row as $key => $value) {
        if ($key == 'id' || $key == 'add_uid' || $key == 'update_uid' || $key == 'uname') {
            $item_defs[$key]['value'] = $myts->htmlSpecialChars($value);
        } elseif ($key == 'add_date' || $key == 'update_date') {
            $item_defs[$key]['value'] = date($cfg_date_format, strtotime($value));
        } elseif ($item_defs[$key]['type'] == 'text' || $item_defs[$key]['type'] == 'radio' || $item_defs[$key]['type'] == 'select') {
            $item_defs[$key]['value'] = sanitize($value, $item_defs[$key]);
        } elseif ($item_defs[$key]['type'] == 'cbox' || $item_defs[$key]['type'] == 'mselect') {
            $values = string2array($value);
            $item_defs[$key]['value'] = '';
            foreach ($values as $value) {
                $item_defs[$key]['value'] .= sanitize($value, $item_defs[$key]) . '<br />';
            }
        } elseif ($item_defs[$key]['type'] == 'tarea' || $item_defs[$key]['type'] == 'xtarea') {
            $item_defs[$key]['value'] = $myts->displayTarea($value, $item_defs[$key]['html'], $item_defs[$key]['smily'], $item_defs[$key]['xcode'], $item_defs[$key]['image'], $item_defs[$key]['br']);
        } elseif ($item_defs[$key]['type'] == 'image' || $item_defs[$key]['type'] == 'file') {
            if ($value != '') {
                $item_defs[$key]['value'] = $module_upload_url . '/' . $myts->htmlSpecialChars($value);
            }
        }
    }
    $xoopsTpl->assign('item_defs', $item_defs);
}

// トークン生成
$token =& XoopsMultiTokenHandler::quickCreate($dirname . '_delete');
$xoopsTpl->assign('token', $token->getHtml());

$xoopsTpl->assign('errors', $errors);

require_once XOOPS_ROOT_PATH . '/footer.php';

?>
