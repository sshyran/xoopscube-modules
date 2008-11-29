<?php

function ddcommon_list()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::read_ok($_GET['t_dd']) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    $y = $GLOBALS['waffle_mydirname'].'_grant_group.yml';
    
    $g = WaffleGrant::get_grant_set($_GET['t_dd']);
    $xoopsTpl->assign('grant_set', $g);
    $xoopsTpl->assign('grant_read',       $g[WAFFLE_GRANT_READ]);
    $xoopsTpl->assign('grant_add',        $g[WAFFLE_GRANT_ADD]);
    $xoopsTpl->assign('grant_update',     $g[WAFFLE_GRANT_UPDATE]);
    $xoopsTpl->assign('grant_delete',     $g[WAFFLE_GRANT_DELETE]);
    $xoopsTpl->assign('grant_csv_output', $g[WAFFLE_GRANT_CSV_OUTPUT]);

    $cookie_limit = $GLOBALS['waffle_mydirname'] . '_' . $_GET['t_dd'] . '_limit';
    if (isset($_GET['t_limit'])) {
	$limit = intval($_GET['t_limit']);
	setcookie($cookie_limit, intval($_GET['t_limit']), 0);
    } else if (isset($_COOKIE[$cookie_limit])) {
	$limit = $_COOKIE[$cookie_limit];
    } else {
	$limit = WAFFLEMAP_DEFAULT_LIMIT;
    }

    $t_offset  = isset($_GET['t_offset']) ? $_GET['t_offset'] : '';
    $t_order   = isset($_GET['t_order']) ? $_GET['t_order'] : '';
    $t_order_r = isset($_GET['t_order_r']) ? $_GET['t_order_r'] : '';

    $alldata = $map->get_for_list(intval($t_offset),
				  intval($t_order),
				  intval($t_order_r),
				  intval($limit)
				  );

    $maxlength = $map->get_count();
    
    if ($map->image_exists || $map->file_exists || $map->php_code_exists) {
	$y = $GLOBALS['waffle_mydirname'].'_image.yml';
	$image = WaffleMAP::new_with_cache($y);
	
	$y = $GLOBALS['waffle_mydirname'].'_file.yml';
	$file = WaffleMAP::new_with_cache($y);

	$maxsize = WaffleMAP::get_config(WAFFLE_IMAGE_VIEW_MAX_SIZE);
	if ($maxsize <= 0) {
	    $maxsize = WAFFLE_IMAGE_DEFAULT_VIEW_MAX_SIZE;
	}

	foreach ($alldata as $key => $val) {
	    foreach ($map->column_map as $k => $v) {
		if ($v['type'] == 'image') {
		   if (isset($val[$k])) {
			$i = $image->get_row($val[$k]);

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
			$alldata[$key][$k] = $a;
		    }
		}
		
		if ($v['type'] == 'file') {
		    if ($val[$k]) {
			$f = $file->get_row($val[$k]);

			if ($f['real_name']) {
			    if ($f['name'] == '') {
				$n = 'file';
			    } else {
				$n = $f['name'];
			    }
			
			    $a = '<a href="' . WAFFLE_DEFAULT_INDEX_PHP  . '?t_m=ddcommon_download&id=' . intval($val[$k]) . '&t_dd=' . htmlspecialchars($_GET['t_dd']). '">';
			    $a .= htmlspecialchars($n);
			    $a .= '(' . waffle_format_file_size($f['file_size']) . ')';
			    $a .= '</a>';
			    
			    $alldata[$key][$k] = $a;
			}
		    }
		}
		if ($v['type'] == 'php_code') {
		    ob_start();
		    $GLOBALS['val'] = $val;
		    echo eval($val[$k]);
		    $alldata[$key][$k] = ob_get_contents();
		    ob_end_clean();
		}
	    }
	}
    }
    
    if ($map->image_exists || $map->file_exists) {
	$maxsize = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_FILESIZE);
	$xoopsTpl->assign('max_file_size', $maxsize);
    }
    
    if (WAFFLE_USE_PLUGIN) {
	$d = dir(PLUGIN_DIR);

	while (false !== ($i = $d->read())) {
	    if (preg_match('/^plugin_ddcommon_list.*\.php$/',$i) &&
		is_readable(PLUGIN_DIR . $i)) {
		require_once(PLUGIN_DIR . $i);
		$a = split('\.', $i);
		if (function_exists($a[0])) {
		    $b = $a[0];
		    $b($map, $alldata);
		}
	    }
	}
    }
    
    if (!isset($limit) || $limit == 0) {
	$limit = 10;
    }
    
    $num_of_page = ceil($maxlength / $limit);
    $num_of_pages = array();
    for ($i=1; $i <= $num_of_page; $i++) {
	$num_of_pages[] = $i;
    }
    $curr_page = 1;
    if (0 < intval($t_offset)) {
	$curr_page = $t_offset / $limit + 1;
    }

    $xoopsTpl->assign('list_navi_bar', 'db:' . $GLOBALS['waffle_mydirname'] . '_list_navi_bar.html');
    
    $xoopsTpl->assign('num_of_pages', $num_of_pages);
    $xoopsTpl->assign('curr_page', $curr_page);
    
    $xoopsTpl->assign('md_insert', _MD_INSERT);
    $xoopsTpl->assign('md_update', _MD_UPDATE);
    $xoopsTpl->assign('md_delete', _MD_DELETE);
    $xoopsTpl->assign('md_detail', _MD_DETAIL);
    $xoopsTpl->assign('md_r_mark', _MD_R_MARK);
    $xoopsTpl->assign('md_no_data', _MD_NO_DATA);
    $xoopsTpl->assign('md_csv_output', _MD_CSV_OUTPUT);
    
    $xoopsTpl->assign('t_offset',  intval($t_offset));
    $xoopsTpl->assign('t_order',   intval($t_order));
    $xoopsTpl->assign('t_order_r', intval($t_order_r));
    $xoopsTpl->assign('t_limit',   $limit);

    $xoopsTpl->assign('xoops_upload_path',   XOOPS_UPLOAD_PATH);
    $xoopsTpl->assign('maxlength',   $maxlength);
    $xoopsTpl->assign('listlength',   count($alldata));

    $xoopsTpl->assign('map', $map);
    $xoopsTpl->assign('alldata', $alldata);
    
    $xoopsOption['template_main'] = $GLOBALS['waffle_mydirname'] . '_ddcommon_list.html';
}

?>
