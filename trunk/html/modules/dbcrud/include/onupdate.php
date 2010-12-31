<?php

$dirname = basename(dirname(dirname(__FILE__)));

eval('function xoops_module_update_' . $dirname . '($module, $prev_version){
    return xgdb_onupdate($module, $prev_version, "' . $dirname . '");
}');

if (!function_exists('xgdb_onupdate')) {
    function xgdb_onupdate($module, $prev_version, $dirname) {
        global $msgs, $xoopsConfig, $xoopsUser;
        $myts =& MyTextSanitizer::getInstance();
        if (!is_array($msgs)) $msgs = array();
        $xoopsDB =& Database::getInstance();
        $tplfile_tbl = $xoopsDB->prefix("tplfile");
        $tplsource_tbl = $xoopsDB->prefix("tplsource");
        $data_tbl = $xoopsDB->prefix($dirname . '_xgdb_data');
        $item_tbl = $xoopsDB->prefix($dirname . '_xgdb_item');
        $newblocks_tbl = $xoopsDB->prefix("newblocks");
        $mid = $module->getVar('mid');
        $module_upload_dir = XOOPS_UPLOAD_PATH . '/' . $dirname;

        $tplfile_handler =& xoops_gethandler('tplfile');
        $template_dir = XOOPS_ROOT_PATH . '/modules/' . $dirname . '/templates';
        include_once XOOPS_ROOT_PATH . '/class/template.php';
        $msgs[] = 'Updating templates...';
        if ($dir_handler = @opendir($template_dir . '/')) {
            while (($template_file = readdir($dir_handler)) !== false) {
                if (substr($template_file, 0, 1) == '.') continue;
                elseif ($template_file == 'index.html') continue;

                $xgdb_template_file = $dirname . '_' . $template_file;
                $template_file_path = $template_dir . '/' . $template_file;
                if (is_file($template_file_path)) {
                    $mtime = intval(@filemtime($template_file_path));
                    $template =& $tplfile_handler->create();
                    $template->setVar('tpl_source', file_get_contents($template_file_path), true);
                    $template->setVar('tpl_refid', $mid);
                    $template->setVar('tpl_tplset', 'default');
                    $template->setVar('tpl_file', $xgdb_template_file);
                    $template->setVar('tpl_desc', '', true);
                    $template->setVar('tpl_module', $dirname);
                    $template->setVar('tpl_lastmodified', $mtime);
                    $template->setVar('tpl_lastimported', 0);
                    $template->setVar('tpl_type', 'module');
                    if (!$tplfile_handler->insert($template)) {
                        $msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not insert template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b> to the database.</span>';
                    } else {
                        $template_id = $template->getVar('tpl_id');
                        $msgs[] = '&nbsp;&nbsp;Template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b> inserted to the database.';
                        if ($xoopsConfig['template_set'] == 'default') {
                            if (!xoops_template_touch($template_id)) {
                                $msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not recompile template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b>.</span>';
                            } else {
                                $msgs[] = '&nbsp;&nbsp;Template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b> recompiled.</span>';
                            }
                        }
                    }
                }
            }
            closedir($dir_handler);
        }

        $blocks = $module->getInfo('blocks');
        foreach ($blocks as $func_num => $block) {
            $template_dir .= '/blocks';
            $xgdb_template_file = $block['template'];
            $template_file = substr($xgdb_template_file, strlen($dirname) + 1, strlen($xgdb_template_file));
            $template_file_path = "$template_dir/$template_file";
            if (file_exists($template_file_path)) {
                $sql = "SELECT bid FROM $newblocks_tbl WHERE mid = $mid AND func_num = $func_num AND show_func = '" . addslashes($block['show_func']) . "' AND func_file = '" . addslashes($block['file']) . "'";
                $res = $xoopsDB->query($sql);
                list($bid) = $xoopsDB->fetchRow($res);
                $xoopsDB->query("UPDATE $newblocks_tbl SET template = '" . addslashes($xgdb_template_file) . "' WHERE bid = $bid");

                $sql = "SELECT tpl_id FROM $tplfile_tbl WHERE tpl_tplset = 'default' AND tpl_file = '" . addslashes($xgdb_template_file) . "' AND tpl_module = '" . addslashes($dirname) . "' AND tpl_type = 'block'";
                $res = $xoopsDB->query($sql);
                list($tpl_id) = $xoopsDB->fetchRow($res);
                $xoopsDB->query("DELETE FROM $tplfile_tbl WHERE tpl_id = $tpl_id");
                $xoopsDB->query("DELETE FROM $tplsource_tbl WHERE tpl_id = $tpl_id");

                $mtime = intval(@filemtime($template_file_path));
                $template =& $tplfile_handler->create();
                $template->setVar('tpl_source', file_get_contents($template_file_path), true);
                $template->setVar('tpl_refid', $bid);
                $template->setVar('tpl_tplset', 'default');
                $template->setVar('tpl_file', $xgdb_template_file);
                $template->setVar('tpl_desc', '', true);
                $template->setVar('tpl_module', $dirname);
                $template->setVar('tpl_lastmodified', $mtime);
                $template->setVar('tpl_lastimported', 0);
                $template->setVar('tpl_type', 'block');

                if (!$tplfile_handler->insert($template)) {
                    $msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not update template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b>.</span>';
                } else {
                    $msgs[] = '&nbsp;&nbsp;Template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b> updated.';
                    if ($xoopsConfig['template_set'] == 'default') {
                        $template_id = $template->getVar('tpl_id');
                        if (!xoops_template_touch($template_id)) {
                            $msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not recompile template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b>.</span>';
                        } else {
                            $msgs[] = '&nbsp;&nbsp;Template <b>' . $myts->htmlSpecialChars($xgdb_template_file) . '</b> recompiled.';
                        }
                    }
                }
            }
        }

        if ($prev_version < 30) {
            $file = fopen(XOOPS_UPLOAD_PATH . "/" . $dirname . "/.htaccess", "w");
            flock($file, LOCK_EX);
            fputs($file, "order deny,allow\n");
            fputs($file, "deny from all\n");
            flock($file, LOCK_UN);
            fclose($file);

            $res_item = $xoopsDB->query("SELECT name FROM $item_tbl WHERE type = 'file' OR type = 'image'");
            while (list($col_name) = $xoopsDB->fetchRow($res_item)) {
                $res_data = $xoopsDB->query("SELECT id, $col_name FROM $data_tbl WHERE $col_name IS NOT NULL AND $col_name != ''");
                while (list($id, $file_name) = $xoopsDB->fetchRow($res_data)) {
                    $real_file_name = urlencode("$id-$col_name-$file_name");
                    @copy($module_upload_dir . '/' . $file_name, $module_upload_dir . '/' . $real_file_name);
                }
            }

            $xoopsDB->query("ALTER TABLE `$item_tbl` CHANGE `ambiguous` `search_cond` TINYINT(1) UNSIGNED NULL DEFAULT NULL;");
            $xoopsDB->query("ALTER TABLE `$item_tbl` ADD `disp_cond` TINYINT(1) UNSIGNED NULL AFTER `input_desc`;");
        }

        if ($prev_version < 40) {
            $xoopsDB->query("ALTER TABLE `$item_tbl` ADD `show_gids` VARCHAR(255) AFTER `required`;");

            $res = $xoopsDB->query("SELECT groupid FROM " . $xoopsDB->prefix('groups') . " ORDER BY groupid ASC");
            $gidstring = '|';
            while (list($groupid) = $xoopsDB->fetchRow($res)) {
                $gidstring .= $groupid . '|';
            }
            $xoopsDB->query("UPDATE `$item_tbl` SET show_gids = '$gidstring'");
        }

        return true;
    }
}

?>
