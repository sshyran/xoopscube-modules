<?php

require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once './include/common.php';
$xoopsOption['template_main'] = $dirname . '_xgdb_update.html';

$op = isset($_POST['op']) && $_POST['op'] !== '' ? $_POST['op'] : '';
$id = isset($_POST['id']) && $_POST['id'] !== '' ? intval($_POST['id']) : 0;
if (isset($_POST['cancel']) && $_POST['cancel'] !== '') {
    header('Location: ' . $module_url . '/detail.php?id=' . $id);
}

// 存在チェック
$sql = "SELECT d.*, u.uname FROM $data_tbl AS d LEFT OUTER JOIN $users_tbl AS u ON d.add_uid = u.uid WHERE d.id = $id";
$res = $xoopsDB->query($sql);
if ($xoopsDB->getRowsNum($res) == 0) {
    redirect_header($module_url . '/index.php', 5, constant('_MD_' . $affix . '_NO_ERR_MSG'));
}

// 権限チェック
$row = $xoopsDB->fetchArray($res);
if (!checkPerm($gids, $cfg_manage_gids) && $uid != $row['add_uid']) {
    redirect_header($module_url . '/index.php', 5, constant('_MD_' . $affix . '_PERM_ERR_MSG'));
}

$errors = array();
$uploaded_file_defs = array();
$delete_file_names = array();
$update_item_defs = getDefs($item_defs, 'update');

// 更新処理
if ($op == 'update') {
    // トークンチェック
    if (!XoopsMultiTokenHandler::quickValidate($dirname . '_update')) {
        $errors[] = constant('_MD_' . $affix . '_TOKEN_ERR_MSG');
    }

    // 入力値初期化
    foreach ($update_item_defs as $item_name => $item_def) {
        $$item_name = '';
        // ファイル、画像の場合
        if ($item_def['type'] == 'file' || $item_def['type'] == 'image') {
            // 削除の場合
            if ($row[$item_name] != '' && !$item_def['required'] && isset($_POST[$item_name . '_delete']) && $_POST[$item_name . '_delete'] !== '') {
                if (isset($_FILES[$item_name]['tmp_name']) && $_FILES[$item_name]['tmp_name'] != '') {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_SAME_ERR_MSG'), $item_def['caption']);
                    $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_SAME_ERR_MSG'), $item_def['caption']);
                } else {
                    $uploaded_file_defs[$item_name] = $item_def;
                    $delete_file_names[$item_name] = $row[$item_name];
                }
            } elseif (isset($_FILES[$item_name]['tmp_name']) && $_FILES[$item_name]['tmp_name'] != '') {
                // 更新の場合
                if (!in_array($_FILES[$item_name]['type'], $item_def['allowed_mimes'])) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                    $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                } elseif (!in_array(pathinfo($_FILES[$item_name]['name'], PATHINFO_EXTENSION), $item_def['allowed_exts'])) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                    $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                } elseif ($_FILES[$item_name]['size'] > ($item_def['max_file_size'] * 1024 * 1024)) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_SIZE_ERR_MSG'), $item_def['caption']);
                    $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_SIZE_ERR_MSG'), $item_def['caption']);
                } else {
                    $$item_name = $_FILES[$item_name]['name'];
                    $uploaded_file_defs[$item_name] = $item_def;
                }
            }
        } else {
            // ファイル、画像以外の場合
            if (isset($_POST[$item_name]) && $_POST[$item_name] !== '') {
                $$item_name = $_POST[$item_name];
                if ($item_def['type'] == 'text' && $item_def['value_type'] == 'int' && !is_intval($$item_name)) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_INT_ERR_MSG'), $item_def['caption']);
                    $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_INT_ERR_MSG'), $item_def['caption']);
                } elseif ($item_def['type'] == 'text' && $item_def['value_type'] == 'float' && !is_floatval($$item_name)) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_FLOAT_ERR_MSG'), $item_def['caption']);
                    $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FLOAT_ERR_MSG'), $item_def['caption']);
                } elseif ($item_def['type'] == 'text' && isset($item_def['value_range_min']) && $$item_name < $item_def['value_range_min']) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($item_def['value_range_min'], $item_def['value_range_max']));
                    $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($item_def['value_range_min'], $item_def['value_range_max']));
                } elseif ($item_def['type'] == 'text' && isset($item_def['value_range_max']) && $$item_name > $item_def['value_range_max']) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($item_def['value_range_min'], $item_def['value_range_max']));
                    $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($item_def['value_range_min'], $item_def['value_range_max']));
                }
            } else {
                if ($item_def['required']) {
                    $errors[] = sprintf(constant('_MD_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
                    $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
                }
            }
        }
    }

    // 重複チェック
    $dup_item_defs = getDefs($item_defs, 'duplicate');
    if (count($dup_item_defs) > 0) {
        foreach ($dup_item_defs as $item_name => $item_def) {
            $sql = "SELECT * FROM $data_tbl WHERE ";
            $where_value = is_array($$item_name) ? array2string($$item_name) : $$item_name;
            if ($where_value === '') {
                $sql .= $item_name . " IS NULL AND id != $id";
            } else {
                $sql .= $item_name . " = '" . addslashes($where_value) . "' AND id != $id";
            }
            $res = $xoopsDB->query($sql);
            if ($xoopsDB->getRowsNum($res) > 0) {
                $update_item_defs[$item_name]['error'] = '<br />' . constant('_MD_' . $affix . '_DUPLICATE_ERR_MSG');
                if (!in_array(constant('_MD_' . $affix . '_DUPLICATE_ERR_MSG'), $errors)) $errors[] = constant('_MD_' . $affix . '_DUPLICATE_ERR_MSG');
            }
        }
    }

    // エラーなしの場合、更新処理
    if (count($errors) == 0) {
        $datetime = date('Y-m-d H:i:s');
        $update_sql = "UPDATE $data_tbl SET update_uid = $uid, update_date = '$datetime', ";
        foreach ($update_item_defs as $item_name => $item_def) {
            // ファイル、画像がある場合
            if ($item_def['type'] == 'file' || $item_def['type'] == 'image') {
                if (isset($delete_file_names[$item_name])) {
                    $update_sql .= $item_name . " = '', ";
                } elseif (isset($uploaded_file_defs[$item_name])) {
                    $file_name = $_FILES[$item_name]['name'];
                    $enc_file_name = getRealFileName($id, $item_name, $file_name);
                    if (!move_uploaded_file($_FILES[$item_name]['tmp_name'], $module_upload_dir . '/' . $enc_file_name)) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                        $update_item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                        break;
                    } else {
                        if ($file_name !== $row[$item_name]) $delete_file_names[$item_name] = $row[$item_name];
                        if ($item_def['type'] == 'image') {
                            resizeImage($module_upload_dir . '/' . $enc_file_name, $item_def['max_image_size']);
                        }
                    }
                    $update_sql .= $item_name . " = '" . addslashes($file_name) . "', ";
                }
            } elseif (($item_def['type'] == 'cbox' || $item_def['type'] == 'mselect') && is_array($$item_name)) {
                $update_sql .= $item_name . " = '" . addslashes(array2string($$item_name)) . "', ";
            } else {
                if ($$item_name === '') {
                    $update_sql .= $item_name . " = NULL, ";
                } else {
                    $update_sql .= $item_name . " = '" . addslashes($$item_name) . "', ";
                }
            }
        }
        $update_sql = substr($update_sql, 0, -2) . " WHERE id = $id";

        // 更新処理成功の場合、古いファイルを削除して詳細ページへリダイレクト
        if ($xoopsDB->query($update_sql)) {
            foreach ($delete_file_names as $item_name => $delete_file_name) {
                @unlink($module_upload_dir . '/' . getRealFileName($id, $item_name, $delete_file_name));
            }

            $extra_tags = array(
                'ID'            => $id,
                'TITLE'         => $$list_link_item_name,
                'TITLE_CAPTION' => $list_link_item_def['caption']
            );
            $notification_handler =& xoops_gethandler('notification');
            $notification_handler->triggerEvent('change', $id, 'update', $extra_tags);

            redirect_header($module_url . '/detail.php?id=' . $id, 5, constant('_MD_' . $affix . '_UPDATE_MSG'));
        } else {
            $errors[] = constant('_MD_' . $affix . '_SYSTEM_ERR_MSG');
        }
    }
} else {
    foreach ($update_item_defs as $item_name => $item_def) {
        // 初期表示処理
        if ($item_def['type'] == 'cbox' || $item_def['type'] == 'mselect') {
            $$item_name = string2array($row[$item_name]);
        } elseif (isset($item_def['value_type']) && $item_def['value_type'] == 'float') {
            $$item_name = sanitize($row[$item_name], $item_def);
        } else {
            $$item_name = $row[$item_name];
        }
    }
}

// 表示値割り当て
foreach ($row as $key => $value) {
    if ($key == 'id' || $key == 'add_uid' || $key == 'update_uid' || $key == 'uname') {
        $item_defs[$key]['value'] = $myts->htmlSpecialChars($value);
    } elseif ($key == 'add_date' || $key == 'update_date') {
        $item_defs[$key]['value'] = date($cfg_date_format, strtotime($value));
    } elseif (!isset($item_defs[$key])) {
        continue;
    }
}
$xoopsTpl->assign('item_defs', $item_defs);

// トークン生成
$token =& XoopsMultiTokenHandler::quickCreate($dirname . '_update');
$xoopsTpl->assign('token', $token->getHtml());

// フォーム生成
foreach ($update_item_defs as $item_name => $item_def) {
    if ($item_def['type'] == 'text') {
        $update_item_defs[$item_name]['value'] = makeTextForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'cbox') {
        $update_item_defs[$item_name]['value'] = makeCboxForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'radio') {
        $update_item_defs[$item_name]['value'] = makeRadioForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'select') {
        $update_item_defs[$item_name]['value'] = makeSelectForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'mselect') {
        $update_item_defs[$item_name]['value'] = makeMSelectForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'tarea') {
        $update_item_defs[$item_name]['value'] = makeTAreaForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'xtarea') {
        $update_item_defs[$item_name]['value'] = makeXTAreaForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'image') {
        if ($$item_name != '') {
            $update_item_defs[$item_name]['width'] = getImageWidth($module_upload_dir . '/' . getRealFileName($id, $item_name, $$item_name), $cfg_detail_image_width);
            $update_item_defs[$item_name]['current_value'] = $myts->htmlSpecialChars($$item_name);
        }
        $update_item_defs[$item_name]['value'] = makeFileForm($item_name, $item_def);
    } elseif ($item_def['type'] == 'file') {
        if ($$item_name != '') {
            $update_item_defs[$item_name]['current_value'] = $myts->htmlSpecialChars($$item_name);
        }
        $update_item_defs[$item_name]['value'] = makeFileForm($item_name, $item_def);
    }
}
$xoopsTpl->assign('update_item_defs', $update_item_defs);
$xoopsTpl->assign('errors', $errors);

require_once XOOPS_ROOT_PATH . '/footer.php';

?>
