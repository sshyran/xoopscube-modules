<?php

$dirname = basename(dirname(dirname(__FILE__)));

eval('function xoops_module_update_' . $dirname . '($module, $prev_version){
    return xgdb_onupdate($module, $prev_version, "' . $dirname . '");
}');

if (!function_exists('xgdb_onupdate')) {
    function xgdb_onupdate($module, $prev_version, $dirname) {
        global $msgs, $xoopsConfig;
        $myts =& MyTextSanitizer::getInstance();
        if (!is_array($msgs)) $msgs = array();
        $xoopsDB =& Database::getInstance();
        $tplfile_tbl = $xoopsDB->prefix("tplfile");
        $tplsource_tbl = $xoopsDB->prefix("tplsource");
        $newblocks_tbl = $xoopsDB->prefix("newblocks");
        $mid = $module->getVar('mid');

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

        return true;
    }
}

?>