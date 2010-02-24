<?php

require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/header.php';
include XOOPS_ROOT_PATH . '/include/comment_view.php';
require_once 'include/common.php';
$xoopsOption['template_main'] = $dirname . '_xgdb_detail.html';

// 存在チェック
$id = isset($_GET['id']) && $_GET['id'] != '' ? intval($_GET['id']) : 0;
$sql = "SELECT d.*, u.uname FROM $data_tbl AS d LEFT OUTER JOIN $users_tbl AS u ON d.add_uid = u.uid WHERE d.id = $id";
$res = $xoopsDB->query($sql);
if ($xoopsDB->getRowsNum($res) == 0) {
    redirect_header($module_url . '/', 5, constant('_MD_' . $affix . '_NO_ERR_MSG'));
}

// 表示値割り当て
$row = $xoopsDB->fetchArray($res);
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

$perm = checkPerm($gids, $cfg_manage_gids) || $uid == $row['add_uid'] ? true : false;
$xoopsTpl->assign('perm', $perm);

require_once XOOPS_ROOT_PATH . '/footer.php';

?>
