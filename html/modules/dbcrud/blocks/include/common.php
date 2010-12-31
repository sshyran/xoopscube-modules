<?php

// 変数を初期化
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);
$xoopsDB =& Database::getInstance();
$myts =& MyTextSanitizer::getInstance();
$module_url = XOOPS_URL . '/modules/' . $dirname . '/';
$module_upload_url = XOOPS_UPLOAD_URL . '/' . $dirname;
$data_tbl = $xoopsDB->prefix($dirname . '_xgdb_data');
$item_tbl = $xoopsDB->prefix($dirname . '_xgdb_item');
$users_tbl = $xoopsDB->prefix('users');
$modules_tbl = $xoopsDB->prefix("modules");
$config_tbl = $xoopsDB->prefix("config");

if (function_exists('mb_language')) mb_language(_LANGCODE);
if (function_exists('mb_regex_encoding')) mb_regex_encoding(_CHARSET);

// モジュールの一般設定値を初期化する
$sql = "SELECT conf_name, conf_value FROM $config_tbl c, $modules_tbl m WHERE c.conf_modid=m.mid AND m.dirname='$dirname'";
$res = $xoopsDB->query($sql);
while (list($conf_name, $conf_value) = $xoopsDB->fetchRow($res)) {
    $conf_name = 'cfg_' . str_replace($dirname . '_', '', $conf_name);
    $$conf_name = $conf_value;
}

// 定数をテンプレートに割り当てる
if (!isset($block_consts)) include XOOPS_ROOT_PATH . '/modules/' . $dirname . '/language/' . $xoopsConfig['language'] . '/blocks.php';
foreach ($block_consts as $key => $value) {
    $block['langs'][$key] = $value;
}

// ユーザ情報を初期化
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
    $gids = $xoopsUser->getGroups();
} else {
    $uid = 0;
    $gids = array(3);
}

// 関数定義ファイルを読み込み
require_once XOOPS_ROOT_PATH . '/modules/' . $dirname . '/include/functions.php';

// 項目定義情報を初期化する
$item_defs = getItemDefs($dirname, $gids);
$block['item_defs'] = $item_defs;

// GP変数の値のマジッククォートを無効化する
if (get_magic_quotes_gpc()) {
    $_POST = array_map('stripSlashesDeep', $_POST);
    $_GET = array_map('stripSlashesDeep', $_GET);
}

?>
