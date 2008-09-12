<?php

include 'header.php';

require_once('include/groupperm_function.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$mydirname = basename( dirname( __FILE__ ) ) ;
$xoopsTpl->assign('mydirname', $mydirname);
$constpref = strtoupper( $mydirname ) ;

$groupperm_insertable = cinemaru_checkright(constant($constpref.'_GROUPPERM_INSERTABLE'));
if ($groupperm_insertable == 0) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_REG_AUTH);
    exit();
}

// richtext check
if ($xoopsModuleConfig['richtext']) {
    require_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    $f = new XoopsFormDhtmlTextArea("", 'desc', @$desc, 15, 50);
    $xoopsTpl->assign('rich_form', $f->render());
}

$groupperm_superinsert = cinemaru_checkright(constant($constpref.'_GROUPPERM_SUPERINSERT'));

$xoopsTpl->assign('superinsert', $groupperm_superinsert);
$xoopsTpl->assign('xoops_module_config', $xoopsModuleConfig);
$xoopsTpl->assign('max_file_size', sprintf('%4.1f', $xoopsModuleConfig['cinemaru_movie_max_size'] / 1024 / 1024));

$xoopsOption['template_main'] = $mydirname . '_movie_form.html';

include XOOPS_ROOT_PATH.'/footer.php';



