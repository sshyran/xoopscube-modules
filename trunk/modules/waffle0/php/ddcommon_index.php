<?php

function ddcommon_index()
{
    global $xoopsTpl;
    global $xoopsOption;

    $y = $GLOBALS['waffle_mydirname'].'_table.yml';
    $table = WaffleMAP::new_with_cache($y);

    $t = $table->get_all('valid = 1', 'id');

    if (count($t) == 1 &&
	WaffleMAP::get_config(WAFFLE_ONE_TABLE_TO_LIST)) {
	$a = $t[0];
	$url = XOOPS_URL . '/modules/' . $GLOBALS['waffle_mydirname'] . '/index.php?t_m=ddcommon_list&t_dd=' . $GLOBALS['waffle_mydirname'] .  '_data' . $a['id'];
	header('Location: ' . $url);
	exit();
    }

    $xoopsTpl->assign('md_no_tables', _MD_NO_TABLES);
    $xoopsTpl->assign('ok_list', WaffleGrant::is_ok_list());
    $xoopsTpl->assign('table', $table->get_all('', array('order', 'id')));

    $xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_index.html';
}

?>
