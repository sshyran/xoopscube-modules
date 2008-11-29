<?php

function ddcommon_csv()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::csv_output_ok($_GET['t_dd']) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    $y = $GLOBALS['waffle_mydirname'].'_grant_group.yml';
    $grant_user = WaffleMAP::new_with_cache($y);
    $g = $grant_user->get_all('table_id = ' . intval(1) .
			      ' AND grant_no = ' . intval(1));
    $limit = WAFFLEMAP_DEFAULT_LIMIT;
    
    $alldata = $map->get_for_list();

    $maxlength = $map->get_count();

    if (WAFFLE_USE_PLUGIN) {
	$d = dir(PLUGIN_DIR);

	while (false !== ($i = $d->read())) {
	    if (preg_match('/^plugin_ddcommon_csv.*\.php$/',$i) &&
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

    $s = '';

    // set subject
    $ar = array();
    foreach ($map->column_map as $k => $v) {
	$t = $v['desc'];
	if (function_exists('mb_convert_encoding')) {
	    $t = mb_convert_encoding($t, WAFFLE_CSV_OUTPUT_TO_ENCODING, WAFFLE_CSV_OUTPUT_FROM_ENCODING);
	}
	$ar[] = '"' . preg_replace('/"/', '""', $t) . '"';
    }
    $s .= implode(',', $ar);
    $s .= "\r\n";

    // set data
    foreach ($alldata as $v1) {
	$ar = array();
	foreach ($map->column_map as $k2 => $v2) {
	    if ($v2['type'] == 'epoctime') {
		if (isset($v1[$k2]) && $v1[$k2]) {
		    $ar[] = '"' . strftime('%Y-%m-%d %H:%M:%S', $v1[$k2]) . '"';
		} else {
		    $ar[] = '""';
		}
	    } else {
		$t = $v1[$k2];
		if (function_exists('mb_convert_encoding')) {
		    $t = mb_convert_encoding($t, WAFFLE_CSV_OUTPUT_TO_ENCODING, WAFFLE_CSV_OUTPUT_FROM_ENCODING);
		}
		$ar[] = '"' . preg_replace('/"/', '""', $t) . '"';
	    }
	}
	$s .= implode(',', $ar);
	$s .= "\r\n";
    }

    $size_file = strlen($s);
    header("Content-Type:application/octet-stream; charset=Shift-JIS");
    header("Content-Disposition:attachment; filename=download.csv");
    header("Content-Transfer-Encoding: binary"); 
    header("Content-Length: $size_file");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    print $s;
    exit();
}

?>
