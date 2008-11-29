<?php

function ddcommon_insert()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::add_ok($_GET['t_dd']) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    if ($map->rel_exists) {
	// relation
	foreach ($map->column_map as $key => $val) {
	    if (isset($val['rel_table']) && $val['rel_table']) {
		$d = WaffleMAP::new_with_cache($val['rel_table'] . '.yml');
		$ar = $d->get_all();
		$ar2 = array();
		foreach ($ar as $k2 => $v2) {
		    $ar2[$v2[$val['rel_column']]] = $v2[$val['rel_v_column']];
		}
		$map->column_map[$key]['rel_data'] = $ar2;
	    }
	}
    }

    if ($map->image_exists || $map->file_exists) {
	$xoopsTpl->assign('max_file_size', $maxsize = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_FILESIZE));
    }

    $xoopsTpl->assign('time_input_hint', _MD_TIME_INPUT_HINT);
    $xoopsTpl->assign('date_input_hint', _MD_DATE_INPUT_HINT);
    $xoopsTpl->assign('datetime_input_hint', _MD_DATETIME_INPUT_HINT);
    $xoopsTpl->assign('not_null', _MD_NOT_NULL);
    $xoopsTpl->assign('map', $map);
    $xoopsTpl->assign('action', 'ddcommon_insert_do');
    $xoopsTpl->assign('md_insert', _MD_INSERT);
    $xoopsTpl->assign('md_back', _MD_BACK);
    $xoopsTpl->assign('md_refer', _MD_REFER);
    $xoopsTpl->assign('form_template', 'db:' . $GLOBALS['waffle_mydirname'] . '_ddcommon_form.html');

    $xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_insert.html';
}

?>
