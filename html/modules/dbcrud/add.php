<?php

require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once './include/common.php';
$xoopsOption['template_main'] = $dirname . '_xgdb_add.html';

// 権限チェック
if ($uid && !checkPerm($gids, $cfg_add_gids)) {
    redirect_header($module_url . '/index.php', 5, constant('_MD_' . $affix . '_PERM_ERR_MSG'));
} elseif (!$cfg_add_guest && !checkPerm($gids, $cfg_add_gids)) {
    redirect_header($module_url . '/index.php', 5, constant('_MD_' . $affix . '_PERM_ERR_MSG'));
}

$op = isset($_POST['op']) && $_POST['op'] !== '' ? $_POST['op'] : '';

$errors = array();
$uploaded_file_defs = array();
$upload_file_names = array();

// 登録処理
if ($op == 'add') {
    // トークンチェック
    if (!XoopsMultiTokenHandler::quickValidate($dirname . '_add')) {
        $errors[] = constant('_MD_' . $affix . '_TOKEN_ERR_MSG');
    }

    // 入力値初期化
    foreach ($item_defs as $item_name => $item_def) {
        $$item_name = '';
        // 項目が表示の場合
        if ($item_def['add']) {
            // ファイル、画像の場合
            if ($item_def['type'] == 'file' || $item_def['type'] == 'image') {
                if (isset($_FILES[$item_name]['tmp_name']) && $_FILES[$item_name]['tmp_name'] != '') {
                    if (!in_array($_FILES[$item_name]['type'], $item_def['allowed_mimes'])) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                    } elseif (!in_array(pathinfo($_FILES[$item_name]['name'], PATHINFO_EXTENSION), $item_def['allowed_exts'])) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                    } elseif ($_FILES[$item_name]['size'] > ($item_def['max_file_size'] * 1024 * 1024)) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_SIZE_ERR_MSG'), $item_def['caption']);
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_SIZE_ERR_MSG'), $item_def['caption']);
                    } else {
                        $$item_name = $_FILES[$item_name]['name'];
                        $uploaded_file_defs[$item_name] = $item_def;
                    }
                } else {
                    if ($item_def['required']) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
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
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($item_def['value_range_min'], $item_def['value_range_max']));
                    } elseif ($item_def['type'] == 'text' && isset($item_def['value_range_max']) && $$item_name > $item_def['value_range_max']) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($item_def['value_range_min'], $item_def['value_range_max']));
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_RANGE_ERR_MSG'), $item_def['caption'], getRangeText($item_def['value_range_min'], $item_def['value_range_max']));
                    }
                } else {
                    if ($item_def['required']) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_REQ_ERR_MSG'), $item_def['caption']);
                    }
                }
            }
        } else {
            // 項目が非表示の場合
            $$item_name = $item_def['default'];
        }
    }

    // 重複チェック
    $dup_item_defs = getDefs($item_defs, 'duplicate');
    if (count($dup_item_defs) > 0) {
        foreach ($dup_item_defs as $item_name => $item_def) {
            $sql = "SELECT * FROM $data_tbl WHERE ";
            $where_value = is_array($$item_name) ? array2string($$item_name) : $$item_name;
            if ($where_value === '') {
                $sql .= $item_name . " IS NULL";
            } else {
                $sql .= $item_name . " = '" . addslashes($where_value) . "'";
            }
            $res = $xoopsDB->query($sql);
            if ($xoopsDB->getRowsNum($res) > 0) {
                $item_defs[$item_name]['error'] = '<br />' . constant('_MD_' . $affix . '_DUPLICATE_ERR_MSG');
                if (!in_array(constant('_MD_' . $affix . '_DUPLICATE_ERR_MSG'), $errors)) $errors[] = constant('_MD_' . $affix . '_DUPLICATE_ERR_MSG');
            }
        }
    }

    // エラーなしの場合、登録処理
    if (count($errors) == 0) {
        $datetime = date('Y-m-d H:i:s');

        $insert_sql = "INSERT INTO $data_tbl (add_uid, add_date, update_uid, update_date, ";
        foreach ($item_defs as $item_name => $item_def) {
            $insert_sql .= $item_name . ', ';
        }
        $insert_sql = substr($insert_sql, 0, -2) . ") VALUES(";
        $insert_sql .= "$uid, '$datetime', $uid, '$datetime', ";
        foreach ($item_defs as $item_name => $item_def) {
            if (($item_def['type'] == 'cbox' || $item_def['type'] == 'mselect') && is_array($$item_name)) {
                $insert_sql .= "'" . addslashes(array2string($$item_name)) . "', ";
            } else {
                if ($$item_name === '') {
                    $insert_sql .= 'NULL, ';
                } else {
                    $insert_sql .= "'" . addslashes($$item_name) . "', ";
                }
            }
        }
        $insert_sql = substr($insert_sql, 0, -2) . ")";

        // 登録SQL処理成功の場合
        if ($xoopsDB->query($insert_sql)) {
            $id = $xoopsDB->getInsertId();

            // ファイル、画像がある場合
            if (count($uploaded_file_defs) > 0) {
                $update_sql = "UPDATE $data_tbl SET ";
                foreach ($uploaded_file_defs as $item_name => $item_def) {
                    $file_name = $_FILES[$item_name]['name'];
                    $enc_file_name = getRealFileName($id, $item_name, $file_name);
                    $update_sql .= "$item_name = '" . addslashes($file_name) . "', ";
                    if (!move_uploaded_file($_FILES[$item_name]['tmp_name'], $module_upload_dir . '/' . $enc_file_name)) {
                        $errors[] = sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                        $item_defs[$item_name]['error'] = '<br />' . sprintf(constant('_MD_' . $affix . '_FILE_TYPE_ERR_MSG'), $item_def['caption']);
                        break;
                    } else {
                        $upload_file_names[] = $enc_file_name;
                        if ($item_def['type'] == 'image') {
                            resizeImage($module_upload_dir . '/' . $enc_file_name, $item_def['max_image_size']);
                        }
                    }
                }

                // ファイル関係の処理でエラーなしの場合
                if (count($errors) == 0) {
                    $update_sql = substr($update_sql, 0, -2) . " WHERE id = $id";
                    if (!$xoopsDB->query($update_sql)) {
                        $xoopsDB->query("DELETE FROM $main_tbl WHERE id = $id");
                    }
                } else {
                    // 登録処理失敗の場合、アップロードされたファイルを削除
                    foreach ($upload_file_names as $upload_file_name) {
                        @unlink($module_upload_dir . '/' . $upload_file_name);
                    }
                }
            }

            // 詳細画面へリダイレクト
            $extra_tags = array(
                'ID'            => $id,
                'TITLE'         => $$list_link_item_name,
                'TITLE_CAPTION' => $list_link_item_def['caption']
            );
            $notification_handler =& xoops_gethandler('notification');
            $notification_handler->triggerEvent('global', 0, 'add', $extra_tags);

            redirect_header($module_url . '/detail.php?id=' . $id, 5, constant('_MD_' . $affix . '_ADD_MSG'));
        } else {
            // 登録SQL処理失敗の場合
            $errors[] = constant('_MD_' . $affix . '_SYSTEM_ERR_MSG');
        }
    }
} else {
    // 初期表示処理
    foreach ($item_defs as $item_name => $item_def) {
        $$item_name = $item_def['default'];
    }
}

// トークン生成
$token =& XoopsMultiTokenHandler::quickCreate($dirname . '_add');
$xoopsTpl->assign('token', $token->getHtml());

// フォーム生成
foreach ($item_defs as $item_name => $item_def) {
    if ($item_def['type'] == 'text') {
        $item_defs[$item_name]['value'] = makeTextForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'cbox') {
        $item_defs[$item_name]['value'] = makeCboxForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'radio') {
        $item_defs[$item_name]['value'] = makeRadioForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'select') {
        $item_defs[$item_name]['value'] = makeSelectForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'mselect') {
        $item_defs[$item_name]['value'] = makeMSelectForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'tarea') {
        $item_defs[$item_name]['value'] = makeTAreaForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'xtarea') {
        $item_defs[$item_name]['value'] = makeXTAreaForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'file' || $item_def['type'] == 'image') {
        $item_defs[$item_name]['value'] = makeFileForm($item_name, $item_def);
    }
}
$xoopsTpl->assign('item_defs', $item_defs);
$xoopsTpl->assign('errors', $errors);

require_once XOOPS_ROOT_PATH . '/footer.php';

?>
