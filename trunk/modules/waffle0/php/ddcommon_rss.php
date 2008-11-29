<?php

function ddcommon_rss()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $xoopsConfig;
    global $map;
    global $waffle_mydirname;
    
    $mydirname = $waffle_mydirname;

    if (WaffleGrant::is_ok($_GET['t_dd'], WAFFLE_GRANT_READ) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    include_once XOOPS_ROOT_PATH.'/class/template.php';
    include_once XOOPS_ROOT_PATH.'/modules/news/class/class.newsstory.php';
    if (function_exists('mb_http_output')) {
	mb_http_output('pass');
    }
    header ('Content-Type:text/xml; charset=utf-8');
    $tpl = new XoopsTpl();
//    $tpl->xoops_setCaching(2);
//    $tpl->xoops_setCacheTime(3600);
    $tpl->xoops_setCaching(0);
    $tpl->xoops_setCacheTime(0);
    
    $y = $mydirname.'_table.yml';
    $column = WaffleMAP::new_with_cache($y);
    preg_match('/^waffle._data(.+)$/', $_GET['t_dd'], $i);
    $table_id = $i[1];
    $t = $column->get_row(intval($i[1]));

    if ($t['rss'] == 0) {
	exit();
    }

    if (!$tpl->is_cached('db:' . $mydirname . '_ddcommon_rdf.html')) {
	if ($t['rss_title'] != '') {
	    $name = $t['rss_title'];
	} else {
	    $name = $t['name'];
	}
    
	$tpl->assign('rss_title', xoops_utf8_encode(htmlspecialchars($name, ENT_QUOTES)));
	$tpl->assign('xoops_url', htmlspecialchars(XOOPS_URL . '/', ENT_QUOTES));
	
	if ($t['rss_top_url'] != '') {
	    $rss_top_url = $t['rss_top_url'];
	} else {
	    $rss_top_url = XOOPS_URL . '/modules/' . $mydirname . '/' . WAFFLE_DEFAULT_INDEX_PHP . '?t_dd=' . $_GET['t_dd'];
	}
    
	//$tpl->assign('rss_title', xoops_utf8_encode(htmlspecialchars($rss_top_url, ENT_QUOTES)));
	$tpl->assign('rss_top_url', $rss_top_url);
	$tpl->assign('server_tz', $xoopsConfig['server_TZ']);
	$tpl->assign('time', time());
	
	if ($t['rss_summary'] != '') {
	    $rss_summary = $t['rss_summary'];
	} else {
	    $rss_summary = $t['summary'];
	}
    
	$tpl->assign('rss_summary', xoops_utf8_encode(htmlspecialchars($rss_summary, ENT_QUOTES)));
	$tpl->assign('gmdate', gmdate("D, d M Y H:i:s"));
	$tpl->assign('gmdate_r', gmdate("r"));
	
	$y = $mydirname.'_column.yml';
	$column = WaffleMAP::new_with_cache($y);
	$c = $column->get_all('table_id = ' . $table_id, 'id');

	$y = $_GET['t_dd'].'.yml';
	$data = WaffleMAP::new_with_cache($y);
	$d = $data->get_all('', array('t' . $table_id . '_reg_time DESC', 't' . $table_id . '_mod_time DESC'));
	
	if (is_array($d)) {
	    $items = array();
	    foreach ($d as $key => $val) {
		if ($t['rss_url_column']) {
		    $url = $t['rss_url_column'];
		} else {
		    $url = XOOPS_URL . '/modules/' . $mydirname . '/' . WAFFLE_DEFAULT_INDEX_PHP . '?t_dd=' . $_GET['t_dd'];
		    $url .= '&t_m=ddcommon_view&id=' . intval($val['t' . $table_id . '_id']);
		}
		$url_encoded = htmlspecialchars($url);
		
		$item = array();
		$item['url'] = $url;
		$item['url_encoded'] = $url_encoded;
		

		if ($t['rss_title_column']) {
		    $name = $t['rss_title_column'];
		} else {
		    $name = 't' . $table_id . '_c1';
		}
		$item['title'] = xoops_utf8_encode(htmlspecialchars($val[$name], ENT_QUOTES));
		
		if ($t['rss_body_column']) {
		    $name = $t['rss_body_column'];
		} else {
		    $name = 't' . $table_id . '_c2';
		}
		$item['body'] = xoops_utf8_encode(htmlspecialchars($val[$name], ENT_QUOTES));
		$item['body_encoded'] = xoops_utf8_encode(nl2br(htmlspecialchars($val[$name], ENT_QUOTES)));

		if ($val[$data->update_datetime_column_name]) {
		    $item['date'] = $val[$data->update_datetime_column_name];
		} else {
		    $item['date'] = $val[$data->create_datetime_column_name];
		}

		if (0 <= $xoopsConfig['server_TZ']) {
		    $item['time_zone_sign'] = '+';
		} else {
		    $item['time_zone_sign'] = '-';
		}

		$items[] = $item;
	    }
	    $tpl->assign('items', $items);
	}
    }

//    exit();
    
    ob_clean();
    if ($_GET['t_type'] == 'rss092') {
	$tpl->display('db:' . $mydirname . '_ddcommon_rss092.html');
    } else if ($_GET['t_type'] == 'rss20') {
	$tpl->display('db:' . $mydirname . '_ddcommon_rss20.html');
    } else if ($_GET['t_type'] == 'atom03') {
	$tpl->display('db:' . $mydirname . '_ddcommon_atom03.html');
    } else {
	$tpl->display('db:' . $mydirname . '_ddcommon_rdf.html');
    }
    exit();
}

?>
