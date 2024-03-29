<?php

require_once '../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once './include/common.php';
$xoopsOption['template_main'] = $dirname . '_xgdb_index.html';

$queries = '';
$params = array('op', 'order_item', 'order');
foreach ($params as $param_name) {
    if (isset($_POST[$param_name]) && $_POST[$param_name] !== '') {
        $$param_name = $_POST[$param_name];
    } elseif (isset($_GET[$param_name]) && $_GET[$param_name] !== '') {
        $$param_name = $_GET[$param_name];
    } else {
        $$param_name = '';
    }
    if ($$param_name !== '') $queries .= $param_name . '=' . urlencode($myts->htmlSpecialChars($$param_name)) . '&amp;';
}

$search_defs = getDefs($item_defs, 'search');

// 検索処理
if ($op == 'search' || $op == 'back_search') {
    if ($op == 'search') unset($_SESSION['search_conds']);

    foreach ($search_defs as $item_name => $item_def) {
        $$item_name = '';
        if ($op == 'search') {
            if (isset($_POST[$item_name]) && $_POST[$item_name] !== '') {
                $$item_name = $_POST[$item_name];
                $_SESSION['search_conds'][$item_name] = $$item_name;
            } elseif (isset($_GET[$item_name]) && $_GET[$item_name] !== '') {
                $$item_name = $_GET[$item_name];
                $_SESSION['search_conds'][$item_name] = $$item_name;
            }
        } elseif ($op == 'back_search') {
            if (isset($_SESSION['search_conds'][$item_name]) && $_SESSION['search_conds'][$item_name] !== '') {
                $$item_name = $_SESSION['search_conds'][$item_name];
            }
        }

        if ($$item_name !== '') {
            if (is_array($$item_name)) {
                foreach ($$item_name as $value) {
                    $queries .= $item_name . '[]=' . urlencode($myts->htmlSpecialChars($value)) . '&amp;';
                }
            } else {
                $queries .= $item_name . '=' . urlencode($myts->htmlSpecialChars($$item_name)) . '&amp;';
            }
        }

        $andor_item_name = $item_name . '_andor';
        $$andor_item_name = '';
        if ($op == 'search') {
            if (isset($_POST[$andor_item_name]) && $_POST[$andor_item_name] !== '') {
                $$andor_item_name = $_POST[$andor_item_name];
                $_SESSION['search_conds'][$andor_item_name] = $$andor_item_name;
            } elseif (isset($_GET[$andor_item_name]) && $_GET[$andor_item_name] !== '') {
                $$andor_item_name = $_GET[$andor_item_name];
                $_SESSION['search_conds'][$andor_item_name] = $$andor_item_name;
            }
        } elseif ($op == 'back_search') {
            if (isset($_SESSION['search_conds'][$andor_item_name]) && $_SESSION['search_conds'][$andor_item_name] !== '') {
                $$andor_item_name = $_SESSION['search_conds'][$andor_item_name];
            }
        }
        if ($$andor_item_name !== '') $queries .= $andor_item_name . '=' . urlencode($myts->htmlSpecialChars($$andor_item_name)) . '&amp;';
    }

    $sql = "SELECT d.*, u.uname FROM $data_tbl AS d LEFT OUTER JOIN $users_tbl AS u ON d.add_uid = u.uid";
    // WHERE区以降のクエリ生成
    $where = ' WHERE ';
    foreach ($search_defs as $item_name => $item_def) {
        if (isset($$item_name) && $$item_name !== '') {
            $andor_item_name = $item_name . '_andor';
            if ($$andor_item_name === '') $$andor_item_name = intval($item_def['search_cond']);

            // テキストエリア(あいまい一致)
            if ($item_def['type'] == 'tarea' || $item_def['type'] == 'xtarea') {
                $where .= " $item_name LIKE '%" . addslashes($$item_name) . "%' AND ";
            } elseif ($item_def['type'] == 'text' || $item_def['type'] == 'image' || $item_def['type'] == 'file') {
                // テキストボックス、ファイル、画像
                if ($$andor_item_name) {
                    $where .= " $item_name = '" . addslashes($$item_name) . "' AND ";
                } else {
                    $where .= " $item_name LIKE '%" . addslashes($$item_name) . "%' AND ";
                }
            } elseif ($item_def['type'] == 'radio' || $item_def['type'] == 'select') {
                // ラジオボタン、プルダウンメニュー
                $where .= ' (';
                foreach ($$item_name as $value) {
                    $where .= " $item_name = '" . addslashes($value) . "' OR ";
                }
                $where = substr($where, 0, -4) . ') AND ';
            } elseif ($item_def['type'] == 'cbox' || $item_def['type'] == 'mselect') {
                // チェックボックス、リストボックス
                if ($$andor_item_name) {
                    $where .= " $item_name = '";
                    foreach ($$item_name as $value) {
                        $where .= addslashes($value) . '|';
                    }
                    $where = substr($where, 0, -1) . "' AND ";
                } else {
                    $where .= ' (';
                    foreach ($$item_name as $value) {
                        $where .= " $item_name LIKE '%" . addslashes($value) . "%' OR ";
                    }
                    $where = substr($where, 0, -4) . ') AND ';
                }
            }
        }
    }
    if ($where != ' WHERE ') {
        $sql .= substr($where, 0, -5);
    }

    if (array_key_exists($order_item, $item_defs) && ($order == 'desc' || $order == 'asc')) {
        $sql .= " ORDER BY d.$order_item $order";
    } elseif ($order_item == 'id' && ($order == 'desc' || $order == 'asc')) {
        $sql .= " ORDER BY d.id $order";
    } elseif ($order_item == 'uname' && ($order == 'desc' || $order == 'asc')) {
        $sql .= " ORDER BY u.uname $order";
    } elseif ($order_item == 'add_date' && ($order == 'desc' || $order == 'asc')) {
        $sql .= " ORDER BY d.add_date $order";
    } else {
        $sql .= " ORDER BY d.id DESC";
    }
    $res = $xoopsDB->query($sql);
    $total = $xoopsDB->getRowsNum($res);

    // ページ切り替え
    if (isset($_POST['button']) && $_POST['button'] !== '') {
        $start = 0;
    } else {
        $start = isset($_GET['start']) && $_GET['start'] != '' ? intval($_GET['start']) : 0;
    }
    $xoopsTpl->assign('start', $start);
    if ($queries !== '') $queries = substr($queries, 0, -5);
    $xoopsTpl->assign('queries', $queries);
    $xoopsTpl->assign('order_item', $order_item);
    $xoopsTpl->assign('order', $order);
    if ($total > $cfg_result_num) {
        require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenavi = new XoopsPageNav($total, $cfg_result_num, $start, 'start', $queries);
        $pagenavi_html = $pagenavi->renderNav();
        $xoopsTpl->assign('pagenavi_html', $pagenavi_html);
        $res = $xoopsDB->query($sql, $cfg_result_num, $start);
    }
    $last = $start + $cfg_result_num;
    if ($last > $total) $last = $total;
    $pagenavi_info = sprintf(constant('_MD_' . $affix . '_PAGENAVI_INFO'), number_format($total), number_format($start + 1), number_format($last));
    $xoopsTpl->assign('pagenavi_info', $pagenavi_info);

    // 表示値割り当て
    while ($row = $xoopsDB->fetchArray($res)) {
        $info = array();
        foreach ($row as $key => $value) {
            if ($key == 'id' || $key == 'add_uid' || $key == 'update_uid' || $key == 'uname') {
                $info[$key] = $myts->htmlSpecialChars($value);
            } elseif ($key == 'add_date' || $key == 'update_date') {
                $info[$key] = date($cfg_date_format, strtotime($value));
            } elseif (!isset($item_defs[$key])) {
                continue;
            } elseif ($item_defs[$key]['type'] == 'text' || $item_defs[$key]['type'] == 'radio' || $item_defs[$key]['type'] == 'select') {
                $info[$key] = sanitize($value, $item_defs[$key]);
            } elseif ($item_defs[$key]['type'] == 'cbox' || $item_defs[$key]['type'] == 'mselect') {
                $values = string2array($value);
                $info[$key] = '';
                foreach ($values as $value) {
                    $info[$key] .= sanitize($value, $item_defs[$key]) . '<br />';
                }
            } elseif ($item_defs[$key]['type'] == 'tarea' || $item_defs[$key]['type'] == 'xtarea') {
                $info[$key] = $myts->displayTarea($value, $item_defs[$key]['html'], $item_defs[$key]['smily'], $item_defs[$key]['xcode'], $item_defs[$key]['image'], $item_defs[$key]['br']);
            } elseif ($item_defs[$key]['type'] == 'image' && $value != '') {
                $item_defs[$key]['width'] = getImageWidth($module_upload_dir . '/' . getRealFileName($row['id'], $key, $value), $cfg_list_image_width);
                $info[$key] = $myts->htmlSpecialChars($value);
            } elseif ($item_defs[$key]['type'] == 'file' && $value != '') {
                $info[$key] = $myts->htmlSpecialChars($value);
            }
        }
        $xoopsTpl->append('infos', $info);
    }
    $list_defs = getDefs($item_defs, 'list');
    $xoopsTpl->assign('list_item_num', count($list_defs) + 2);
    $xoopsTpl->assign('item_defs', $item_defs);
    $xoopsTpl->assign('op', 'search');
} else {
    foreach ($search_defs as $item_name => $item_def) {
        $$item_name = '';
        if ($item_def['type'] == 'text' || $item_def['type'] == 'cbox' || $item_def['type'] == 'mselect' || $item_def['type'] == 'file' || $item_def['type'] == 'image') {
            $andor_item_name = $item_name . '_andor';
            $$andor_item_name = $item_def['search_cond'];
        }
    }
}

// フォーム生成
foreach ($search_defs as $item_name => $item_def) {
    if ($item_def['type'] == 'text' || $item_def['type'] == 'tarea' || $item_def['type'] == 'xtarea' || $item_def['type'] == 'file' || $item_def['type'] == 'image') {
        $search_defs[$item_name]['value'] = makeTextForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'cbox' || $item_def['type'] == 'radio') {
        $search_defs[$item_name]['value'] = makeCboxForm($item_name, $item_def, $$item_name);
    } elseif ($item_def['type'] == 'select' || $item_def['type'] == 'mselect') {
        $search_defs[$item_name]['value'] = makeMSelectForm($item_name, $item_def, $$item_name);
    }

    if ($item_def['type'] == 'text' || $item_def['type'] == 'file' || $item_def['type'] == 'image') {
        $andor_item_name = $item_name . '_andor';
        $search_defs[$item_name]['condition'] = makeCondForm($andor_item_name, array(constant('_MD_' . $affix . '_COMP_MATCH') => 1, constant('_MD_' . $affix . '_PART_MATCH') => 0), $$andor_item_name);
    } elseif ($item_def['type'] == 'radio' || $item_def['type'] == 'select') {
        $search_defs[$item_name]['condition'] = '<br />' . constant('_MD_' . $affix . '_COND_LABEL') . ' ' . constant('_MD_' . $affix . '_OR_MATCH');
    } elseif ($item_def['type'] == 'tarea' || $item_def['type'] == 'xtarea') {
        $search_defs[$item_name]['condition'] = '<br />' . constant('_MD_' . $affix . '_COND_LABEL') . ' ' . constant('_MD_' . $affix . '_PART_MATCH');
    } elseif ($item_def['type'] == 'cbox' || $item_def['type'] == 'mselect') {
        $andor_item_name = $item_name . '_andor';
        $search_defs[$item_name]['condition'] = makeCondForm($andor_item_name, array(constant('_MD_' . $affix . '_AND_MATCH') => 1, constant('_MD_' . $affix . '_OR_MATCH') => 0), $$andor_item_name);
    }
}
$xoopsTpl->assign('search_defs', $search_defs);

require_once XOOPS_ROOT_PATH . '/footer.php';

?>
