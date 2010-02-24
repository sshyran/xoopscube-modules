<?php

require_once '../../../include/cp_header.php';
require_once 'include/common.php';

$op = isset($_POST['op']) && $_POST['op'] !== '' ? $_POST['op'] : '';
$iid = isset($_POST['iid']) && $_POST['iid'] != '' ? intval($_POST['iid']) : 0;
if ($iid == '') $iid = isset($_GET['iid']) && $_GET['iid'] != '' ? intval($_GET['iid']) : 0;
if (isset($_POST['cancel']) && $_POST['cancel'] !== '') {
    header('Location: ' . $module_url . '/admin/detail.php?iid=' . $iid);
}

if ($iid < 1) {
    redirect_header($module_url . '/admin/', 5, constant('_AM_' . $affix . '_NO_ERR_MSG'));
}
$res = $xoopsDB->query("SELECT * FROM $item_tbl WHERE iid = $iid");
if ($xoopsDB->getRowsNum($res) == 0) {
    redirect_header($module_url . '/admin/', 5, constant('_AM_' . $affix . '_NO_ERR_MSG'));
}
$row = $xoopsDB->fetchArray($res);

$errors = array();
$item_defs = getAdminItemDefs($row['type']);
if ($row['value_type'] == 'string') {
    unset($item_defs['value_range_min']);
    unset($item_defs['value_range_max']);
} elseif ($row['value_type'] == 'int' || $row['value_type'] == 'float') {
    unset($item_defs['ambiguous']);
}

if ($op == 'update') {
    // トークンチェック
    if (!XoopsMultiTokenHandler::quickValidate($dirname . '_update')) {
        $errors[] = constant('_AM_' . $affix . '_TOKEN_ERR_MSG');
    }

    foreach ($item_defs as $item_name => $item_def) {
        $$item_name = '';
        if ($item_name == 'name' || $item_name == 'type' || $item_name == 'value_type') {
            $$item_name = $row[$item_name];
        } else {
            if (isset($_POST[$item_name]) && $_POST[$item_name] !== '') {
                $$item_name = $_POST[$item_name];
                if ($item_def['type'] == 'text' && isset($item_def['value_range_min']) && $$item_name < $item_def['value_range_min']) {
                    $errors[] = sprintf(constant('_AM_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($dirname, $item_def['value_range_min'], $item_def['value_range_max']));
                    $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_AM_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($dirname, $item_def['value_range_min'], $item_def['value_range_max']));
                } elseif ($item_def['type'] == 'text' && isset($item_def['value_range_max']) && $$item_name > $item_def['value_range_max']) {
                    $errors[] = sprintf(constant('_AM_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($dirname, $item_def['value_range_min'], $item_def['value_range_max']));
                    $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_AM_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($dirname, $item_def['value_range_min'], $item_def['value_range_max']));
                }
            } elseif ($item_def['required']) {
                if (!($item_name == 'list_link' && $row['list_link'])) {
                    $errors[] = sprintf(constant('_AM_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
                    $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_AM_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
                }
            }
        }
    }

    if (isset($required) && !$required && isset($list_link) && $list_link) {
        $errors[] = constant('_AM_' . $affix . '_REQ_LINK_ERR_MSG');
        $item_defs['required']['error'] = '<br />' . constant('_AM_' . $affix . '_REQ_LINK_ERR_MSG');
    }
    if (isset($list) && !$list && isset($list_link) && $list_link) {
        $errors[] = constant('_AM_' . $affix . '_LIST_LINK_ERR_MSG');
        $item_defs['list']['error'] = '<br />' . constant('_AM_' . $affix . '_LIST_LINK_ERR_MSG');
    }
    if (isset($list_link) && $list_link) {
        if ((isset($required) && !$required) || (isset($list) && !$list)) {
            $errors[] = constant('_AM_' . $affix . '_LINK_ERR_MSG');
            $item_defs['list_link']['error'] = '<br />' . constant('_AM_' . $affix . '_LINK_ERR_MSG');
        }
    }

    if (isset($list_link) && $list_link === '0') {
        $res = $xoopsDB->query("SELECT * FROM $item_tbl WHERE list_link = 1 AND iid != $iid");
        if ($xoopsDB->getRowsNum($res) == 0) {
            $errors[] = constant('_AM_' . $affix . '_UPDATE_LINK_ERR_MSG');
        }
    }

    if (count($errors) == 0) {
        $sql = "UPDATE $item_tbl SET ";
        foreach ($item_defs as $item_name => $item_def) {
            if ($item_name == 'name') continue;
            if ($$item_name === '') {
                $sql .= '`' . addslashes($item_name) . "` = NULL, ";
            } else {
                $sql .= '`' . addslashes($item_name) . "` = '" . addslashes($$item_name) . "', ";
            }
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE iid = $iid";
        if ($xoopsDB->query($sql)) {
            redirect_header($module_url . '/admin/detail.php?iid=' . $iid, 5, constant('_AM_' . $affix . '_UPDATE_MSG'));
        }
        $errors[] = constant('_AM_' . $affix . '_SYSTEM_ERR_MSG');
    }
} else {
    foreach ($item_defs as $item_name => $item_def) {
        $$item_name = $row[$item_name];
    }
}

xoops_cp_header();

foreach ($item_defs as $item_name => $item_def) {
    if ($item_name == 'name') {
        $item_defs[$item_name]['required'] = false;
        $item_defs[$item_name]['value'] = $myts->htmlSpecialChars($$item_name);
    } elseif ($item_name == 'type') {
        $item_defs[$item_name]['required'] = false;
        $item_defs[$item_name]['value'] = $types[$$item_name];
    } elseif ($item_name == 'value_type') {
        $item_defs[$item_name]['required'] = false;
        $item_defs[$item_name]['value'] = $value_types[$$item_name];
    } elseif ($item_def['type'] == 'text') {
        $item_defs[$item_name]['value'] = makeTextForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'cbox') {
        $item_defs[$item_name]['value'] = makeCboxForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'radio') {
        $item_defs[$item_name]['value'] = makeRadioForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'select') {
        $item_defs[$item_name]['value'] = makeSelectForm($dirname, $item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'mselect') {
        $item_defs[$item_name]['value'] = makeMSelectForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'tarea') {
        $item_defs[$item_name]['value'] = makeTAreaForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'xtarea') {
        $item_defs[$item_name]['value'] = makeXTAreaForm($item_name, $item_def, $$item_name);
    }
}
$xoopsTpl->assign('iid', $iid);
$xoopsTpl->assign('type', $myts->htmlSpecialChars($row['type']));
$xoopsTpl->assign('item_defs', $item_defs);
$token =& XoopsMultiTokenHandler::quickCreate($dirname . '_update');
$xoopsTpl->assign('token', $token->getHtml());
$xoopsTpl->assign('errors', $errors);

$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/' . $dirname . '/templates/admin/xgdb_admin_update.html');

xoops_cp_footer();

?>