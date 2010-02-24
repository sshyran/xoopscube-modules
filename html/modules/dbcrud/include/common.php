<?php

// �ѿ�������
$dirname = basename(dirname(dirname(__FILE__)));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);
$myts =& MyTextSanitizer::getInstance();
$module_url = XOOPS_URL . '/modules/' . $dirname;
$module_upload_url = XOOPS_UPLOAD_URL . '/' . $dirname;
$module_upload_dir = XOOPS_UPLOAD_PATH . '/' . $dirname;
$data_tbl = $xoopsDB->prefix($dirname . '_xgdb_data');
$item_tbl = $xoopsDB->prefix($dirname . '_xgdb_item');
$users_tbl = $xoopsDB->prefix('users');

if (function_exists('mb_language')) mb_language(_LANGCODE);
if (function_exists('mb_regex_encoding')) mb_regex_encoding(_CHARSET);

// �⥸�塼��ΰ��������ͤ����������ƥ�ץ졼�Ȥ˳�����Ƥ�
foreach ($xoopsModuleConfig as $cfg_key => $cfg_val) {
    $cfg_key = 'cfg_' . str_replace($dirname . '_', '', $cfg_key);
    $$cfg_key = $cfg_val;
    $xoopsTpl->assign($cfg_key, $cfg_val);
}

// �����ƥ�ץ졼�Ȥ˳�����Ƥ�
if (!isset($main_consts)) include XOOPS_ROOT_PATH . '/modules/' . $dirname . '/language/' . $xoopsConfig['language'] . '/main.php';
foreach ($main_consts as $key => $value) {
    $xoopsTpl->assign($key, $value);
}

// �桼�����������
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
    $gids = $xoopsUser->getGroups();
} else {
    $uid = 0;
    $gids = array(3);
}

// �ؿ�����ե�������ɤ߹���
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/modules/' . $dirname . '/include/functions.php';

// �ƥ�ץ졼�Ȥμ�ư����
if ($cfg_auto_update) {
    $template_dir_path = XOOPS_ROOT_PATH . '/modules/' . $dirname . '/templates';
    if ($handler = @opendir($template_dir_path . '/')) {
        while (($file = readdir($handler)) !== false) {
            $file_path = $template_dir_path . '/' . $file;
            if (is_file($file_path) && substr($file, -5) == '.html' && $file != 'index.html') {
                $mtime = intval(@filemtime($file_path));
                $file = $dirname . '_' . $file;
                list($count) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("tplfile") . " WHERE tpl_tplset = '" . addslashes($xoopsConfig['template_set']) . "' AND tpl_file = '" . addslashes($file) . "' AND tpl_lastmodified >= $mtime"));
                if ($count == 0) {
                    updateTemplate($xoopsConfig['template_set'], $file, implode('', file($file_path)), $mtime);
                }
            }
        }
    }

    if ($handler = @opendir($template_dir_path . '/blocks/')) {
        while (($file = readdir($handler)) !== false) {
            $file_path = $template_dir_path . '/blocks/' . $file;
            if (is_file($file_path) && substr($file, -5) == '.html' && $file != 'index.html') {
                $mtime = intval(@filemtime($file_path));
                $file = $dirname . '_' . $file;
                list($count) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("tplfile") . " WHERE tpl_tplset = '" . addslashes($xoopsConfig['template_set']) . "' AND tpl_file = '" . addslashes($file) . "' AND tpl_lastmodified >= $mtime"));
                if ($count == 0) {
                    updateTemplate($xoopsConfig['template_set'], $file, implode('', file($file_path)), $mtime);
                }
            }
        }
    }
}

// ��������������������
$item_defs = getItemDefs($dirname);
$list_link_item_def = getListLinkItemDef($item_defs);
$list_link_item_name = $list_link_item_def['item_name'];

// GP�ѿ����ͤΥޥ��å��������Ȥ�̵��������
if (get_magic_quotes_gpc()) {
    $_POST = array_map('stripSlashesDeep', $_POST);
    $_GET = array_map('stripSlashesDeep', $_GET);
}

?>
