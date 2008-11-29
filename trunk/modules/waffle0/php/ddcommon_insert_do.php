<?php

function ddcommon_insert_do() {
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::add_ok($_POST['t_dd']) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }

    // 入力エラーチェック
    $validate = $map->validate();

    if ($validate->error()) {
	// 入力エラーがあった

	if ($map->rel_exists) {
	    foreach ($map->column_map as $key => $val) {
		if ($val['rel_table']) {
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
	$xoopsTpl->assign('md_back', _MD_BACK);
	$xoopsTpl->assign('map', $map);
	$xoopsTpl->assign('errmsg', $validate->get_error());
	$xoopsTpl->assign('errmsg_key', $validate->get_error_key());
	$xoopsTpl->assign('post', $validate->get_post());
	$xoopsTpl->assign('action', 'ddcommon_insert_do');
	$xoopsTpl->assign('form_template', 'db:' . $GLOBALS['waffle_mydirname'] . '_ddcommon_form.html');
	$xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_insert.html';
    } else {
	// 入力エラーなし。INSERTする
	$map->insert($validate->get_post());

	if (WaffleMAP::get_config(WAFFLE_SETTING_USE_ADMIN_MAIL)){
	    global $xoopsDB;
	    $id = $xoopsDB->getInsertId();
	    
	    $subject = '[waffle]' . _MD_MAIL_SUBJECT_ADDED_DATA;
	    
	    $message = _MD_ADDED_DATA . "\r\n";
	    $message .= "\r\n";
	    
	    foreach ($validate->get_post() as $key => $val) {
		$message .= $key . ':' . $val . "\r\n";
	    }
	    $message .= "\r\n";
	    $message .= XOOPS_URL . '/modules/' . $GLOBALS['waffle_mydirname'] . '/index.php?t_m=ddcommon_view&id='.$id.'&t_dd='.$GLOBALS['dd'] . "\r\n";
	    
	    waffle_send_admin_mail($subject, $message);
	}

	if (isset($_POST['t_dd']) && WaffleGrant::read_ok($_POST['t_dd'])) {
	    redirect_header('index.php?t_m=ddcommon_list&t_dd=' . $_POST['t_dd'], 2, _MD_THANKSSUBMIT);
	} else {
	    redirect_header('index.php?t_dd=' . $_POST['t_dd'], 2, _MD_ADDED);
	}
	
	exit();

    }
}

?>
