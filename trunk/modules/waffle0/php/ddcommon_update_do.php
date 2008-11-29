<?php

function ddcommon_update_do() {
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::update_ok($_POST['t_dd']) == false) {
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
	$xoopsTpl->assign('map', $map);
	$xoopsTpl->assign('errmsg', $validate->get_error());
	$xoopsTpl->assign('errmsg_key', $validate->get_error_key());
	$xoopsTpl->assign('post', $validate->get_post());
	$xoopsTpl->assign('action', 'ddcommon_update_do');
	$xoopsTpl->assign('form_type', 'update');
	$xoopsTpl->assign('md_update', _MD_UPDATE);
	$xoopsTpl->assign('form_template', 'db:' . $GLOBALS['waffle_mydirname'] . '_ddcommon_form.html');
	
	if (isset($_POST['id'])) {
	    // IDがセットされている
	    $row = $map->get_row(intval($_POST['id']));

	    if (0 < $row[$map->primary_key_name]) {
		$xoopsTpl->assign('map', $map);
		$xoopsTpl->assign('row', $row);
		$xoopsTpl->assign('id', intval($_POST['id']));
	    } else {
		// 検索されなかった
		$xoopsTpl->assign('no_data', 1);
	    }
	} else {
	    // IDがセットされていない
	    $xoopsTpl->assign('no_data', 1);
	}
	
	$xoopsTpl->assign('post', $validate->get_post());
	$xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_update.html';
    } else {
	//入力エラーなし。
	
	if (isset($_POST['id'])) {
	    // UPDATEする
	    $validate->set_post_data($map->primary_key_name, intval($_POST['id']));
	    $map->update_one($validate->get_post());

	    // send mail to admin
	    if (WaffleMAP::get_config(WAFFLE_SETTING_USE_ADMIN_MAIL)){
		global $xoopsDB;
		$id = $xoopsDB->getInsertId();
	    
		$subject = '[waffle]' . _MD_MAIL_SUBJECT_UPDATED_DATA;
	    
		$message = _MD_UPDATED_DATA . "\r\n";
		$message .= "\r\n";
	    
		foreach ($validate->get_post() as $key => $val) {
		    $message .= $key . ':' . $val . "\r\n";
		}
		$message .= "\r\n";
		$message .= XOOPS_URL . '/modules/' . $GLOBALS['waffle_mydirname'] . '/index.php?t_m=ddcommon_view&id='.$id.'&t_dd='.$GLOBALS['dd'] . "\r\n";
	    
		waffle_send_admin_mail($subject, $message);
	    }
	    
	    if (isset($_POST['t_dd']) && WaffleGrant::read_ok($_POST['t_dd'])) {
		redirect_header('index.php?t_m=ddcommon_list&t_dd=' . $_POST['t_dd'], 2, _MD_UPDATED);
	    } else {
		redirect_header('index.php?t_dd=' . $_POST['t_dd'], 2, _MD_UPDATED);
	    }
	    
	    exit();
	} else {
	    // IDが見付からなかった。
	    redirect_header('index.php', 2, _MD_IDNOTFOUND);
	    exit();
	}
    }
}

?>
