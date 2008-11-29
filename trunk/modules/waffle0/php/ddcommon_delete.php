<?php

function ddcommon_delete()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::delete_ok($_GET['t_dd']) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    $xoopsTpl->assign('md_delete_confirm', _MD_DELETE_CONFIRM);
    $xoopsTpl->assign('md_back', _MD_BACK);
    $xoopsTpl->assign('md_no_data', _MD_NO_DATA);
    $xoopsTpl->assign('md_delete', _MD_DELETE);
    $xoopsTpl->assign('view_one_template', 'db:' . $GLOBALS['waffle_mydirname'] . '_ddcommon_view_one.html');
    
    if (isset($_GET['id'])) {
	// IDがセットされている
	$row = $map->get_row(intval($_GET['id']));

	$images = array();
	if ($map->image_exists || $map->file_exists) {
	    $y = $GLOBALS['waffle_mydirname'].'_image.yml';
	    $image = WaffleMAP::new_with_cache($y);
	
	    $y = $GLOBALS['waffle_mydirname'].'_file.yml';
	    $file = WaffleMAP::new_with_cache($y);
	    
	    foreach ($map->column_map as $k => $v) {
		if ($v['type'] == 'image') {
		    if (isset($row[$k])) {
			$i = $image->get_row($row[$k]);
			$row[$k] = $i['path'];
		    }
		}
		
		if ($v['type'] == 'file') {
		    $f = $file->get_row($row[$k]);

		    if ($f['real_name']) {
			if ($f['name'] == '') {
			    $n = 'file';
			} else {
			    $n = $f['name'];
			}
			
			$a = '<a href="' . WAFFLE_DEFAULT_INDEX_PHP  . '?t_m=ddcommon_download&id=' . intval($row[$k]) . '&t_dd=' . htmlspecialchars($_GET['t_dd']). '">';
			$a .= htmlspecialchars($n);
			$a .= '(' . waffle_format_file_size($f['file_size']) . ')';
			$a .= '</a>';
		    }
		    
		    $row[$k] = $a;
		}
	    }
	}
	
	if (0 < $row[$map->primary_key_name]) {
	    $xoopsTpl->assign('map', $map);
	    $xoopsTpl->assign('row', $row);
	    $xoopsTpl->assign('id', intval($_GET['id']));
	} else {
	    // 検索されなかった
	    $xoopsTpl->assign('no_data', 1);
	}
    } else {
	// IDがセットされていない
	$xoopsTpl->assign('no_data', 1);
    }

    $xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_delete.html';
}

?>
