<?php

// 変数を初期化
$dirname = basename(dirname(dirname(dirname(__FILE__))));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);
$myts =& MyTextSanitizer::getInstance();
$data_tbl = $xoopsDB->prefix($dirname . '_xgdb_data');
$item_tbl = $xoopsDB->prefix($dirname . '_xgdb_item');
$module_upload_dir = XOOPS_UPLOAD_PATH . '/' . $dirname;
$module_url = XOOPS_URL . '/modules/' . $dirname;
require_once XOOPS_ROOT_PATH . '/class/template.php';
$original_theme_fromfile = $xoopsConfig['theme_fromfile'];
$xoopsConfig['theme_fromfile'] = 1;
$xoopsTpl =& new XoopsTpl();
$xoopsConfig['theme_fromfile'] = $original_theme_fromfile;
$types = array(
    'text'    => constant('_AM_' . $affix . '_TYPE_TEXT'),
    'cbox'    => constant('_AM_' . $affix . '_TYPE_CBOX'),
    'radio'   => constant('_AM_' . $affix . '_TYPE_RADIO'),
    'select'  => constant('_AM_' . $affix . '_TYPE_SELECT'),
    'mselect' => constant('_AM_' . $affix . '_TYPE_MSELECT'),
    'tarea'   => constant('_AM_' . $affix . '_TYPE_TAREA'),
    'xtarea'  => constant('_AM_' . $affix . '_TYPE_XTAREA'),
    'file'    => constant('_AM_' . $affix . '_TYPE_FILE'),
    'image'   => constant('_AM_' . $affix . '_TYPE_IMAGE')
);
$value_types = array(
    'string' => constant('_AM_' . $affix . '_STRING'),
    'int'    => constant('_AM_' . $affix . '_INTEGER'),
    'float'  => constant('_AM_' . $affix . '_FLOAT')
);

if (function_exists('mb_language')) mb_language(_LANGCODE);
if (function_exists('mb_regex_encoding')) mb_regex_encoding(_CHARSET);

// 定数と変数をテンプレートに割り当てる
if (!isset($admin_consts)) include XOOPS_ROOT_PATH . '/modules/' . $dirname . '/language/' . $xoopsConfig['language'] . '/admin.php';
foreach ($admin_consts as $key => $value) {
    $xoopsTpl->assign($key, $value);
}

// 関数定義ファイルを読み込み
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once 'functions.php';

// GP変数の値のマジッククォートを無効化する
if (get_magic_quotes_gpc()) {
    $_POST = array_map('stripSlashesDeep', $_POST);
    $_GET = array_map('stripSlashesDeep', $_GET);
}

?>
