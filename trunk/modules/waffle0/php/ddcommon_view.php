<?php

function ddcommon_view()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    $g = WaffleGrant::get_grant_set($_GET['t_dd']);
    if ($g[WAFFLE_GRANT_READ] != 1) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    $xoopsTpl->assign('id', $_REQUEST['id']);
    $xoopsTpl->assign('grant_update', $g[WAFFLE_GRANT_UPDATE]);
    $xoopsTpl->assign('grant_delete', $g[WAFFLE_GRANT_DELETE]);
    $xoopsTpl->assign('md_update', _MD_UPDATE);
    $xoopsTpl->assign('md_delete', _MD_DELETE);
    $xoopsTpl->assign('md_back', _MD_BACK);
    $xoopsTpl->assign('md_no_data', _MD_NO_DATA);
    $xoopsTpl->assign('view_one_template', 'db:' . $GLOBALS['waffle_mydirname'] . '_ddcommon_view_one.html');
    
    if (isset($_GET['id'])) {
	// IDがセットされている
	$row = $map->get_row(intval($_GET['id']));

	$images = array();
	if ($map->image_exists || $map->file_exists || $map->php_code_exists) {
	    $y = $GLOBALS['waffle_mydirname'].'_image.yml';
	    $image = WaffleMAP::new_with_cache($y);
	
	    $y = $GLOBALS['waffle_mydirname'].'_file.yml';
	    $file = WaffleMAP::new_with_cache($y);
	    
	    $maxsize = WaffleMAP::get_config(WAFFLE_IMAGE_VIEW_MAX_SIZE);
	    if ($maxsize <= 0) {
		$maxsize = WAFFLE_IMAGE_DEFAULT_VIEW_MAX_SIZE;
	    }
	    
	    foreach ($map->column_map as $k => $v) {
		if ($v['type'] == 'image') {
		    if (isset($row[$k])) {
			$i = $image->get_row($row[$k]);
			$img = XOOPS_URL . '/uploads/' . $GLOBALS['waffle_mydirname'] . '_image/' . $i['path'];
			$a = '<a href="'.$img.'"><img src="' . $img . '"';
			$width = 0;
			$height = 0;
			if ($maxsize < $i['width'] && $maxsize < $i['height']) {
			    if ($i['width'] < $i['height']) {
				$width = $i['width'] * $maxsize / $i['height'];
				$height = $maxsize;
			    } else {
				$width = $maxsize;
				$height = $i['height'] * $maxsize / $i['width'];
			    }
			} else if ($maxsize < $i['width']) {
			    $width = $maxsize;
			    $height = $i['height'] * $maxsize / $i['width'];
			} else if ($maxsize < $i['height']) {
			    $width = $i['width'] * $maxsize / $i['height'];
			    $height = $maxsize;
			} else {
			    $width = $i['width'];
			    $height = $i['height'];
			}
			$a .= ' width="' . intval($width) . '" height="' . intval($height) . '" ';
			$a .= ' border="0"></a>';
			$row[$k] = $a;
		    }
		}
		if ($v['type'] == 'file') {
		    $f = $file->get_row($row[$k]);
		    $a = '';
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

		if ($v['type'] == 'php_code') {
		    ob_start();
		    echo eval($row[$k]);
		    $row[$k] = ob_get_contents();
		    ob_end_clean();
		}
	    }
	}
	
	if (0 < $row[$map->primary_key_name]) {
	    $xoopsTpl->assign('map', $map);
	    $xoopsTpl->assign('row', $row);
	} else {
	    // 検索されなかった
	    $xoopsTpl->assign('no_data', 1);
	}
    } else {
	// IDがセットされていない
	$xoopsTpl->assign('no_data', 1);
    }

    $xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_view.html';
}

?>
