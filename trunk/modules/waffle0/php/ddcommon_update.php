<?php

function ddcommon_update()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::update_ok($_GET['t_dd']) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    if ($map->rel_exists) {
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

    $xoopsTpl->assign('time_input_hint', _MD_TIME_INPUT_HINT);
    $xoopsTpl->assign('date_input_hint', _MD_DATE_INPUT_HINT);
    $xoopsTpl->assign('datetime_input_hint', _MD_DATETIME_INPUT_HINT);
    $xoopsTpl->assign('not_null', _MD_NOT_NULL);
    $xoopsTpl->assign('action', 'ddcommon_update_do');
    $xoopsTpl->assign('form_type', 'update');
    $xoopsTpl->assign('md_update', _MD_UPDATE);
    $xoopsTpl->assign('md_back', _MD_BACK);
    $xoopsTpl->assign('md_no_data', _MD_NO_DATA);
    $xoopsTpl->assign('form_template', 'db:' . $GLOBALS['waffle_mydirname'] . '_ddcommon_form.html');
    
    if (intval($_GET['id'])) {
	// IDがセットされている
	$row = $map->get_row(intval($_GET['id']), false);
	
	if (0 < $row[$map->primary_key_name]) {
	    $xoopsTpl->assign('map', $map);
	    $xoopsTpl->assign('post', $row);
	    $xoopsTpl->assign('id', $_GET['id']);
	} else {
	    // 検索されなかった
	    $xoopsTpl->assign('no_data', 1);
	}
    } else {
	// IDがセットされていない
	$xoopsTpl->assign('no_data', 1);
    }

    $xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_update.html';
}

?>
