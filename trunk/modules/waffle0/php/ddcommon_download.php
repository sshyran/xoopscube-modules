<?php

function ddcommon_download()
{
    global $xoopsTpl;
    global $xoopsOption;
    global $map;

    if (WaffleGrant::is_ok($_GET['t_dd'], WAFFLE_GRANT_READ) == false) {
	ob_clean();
	redirect_header('index.php', 2, _MD_NORIGHT);
	exit();
    }
    
    $xoopsTpl->assign('md_back', _MD_BACK);
    $xoopsTpl->assign('md_no_data', _MD_NO_DATA);
    $xoopsTpl->assign('view_one_template', 'db:' . $GLOBALS['waffle_mydirname'] . '_ddcommon_view_one.html');
    
    if (isset($_GET['id'])) {
	$y = $GLOBALS['waffle_mydirname'].'_file.yml';
	$file = WaffleMAP::new_with_cache($y);
	
	// no ID
	$row = $file->get_row(intval($_GET['id']));

	if (is_array($row) && $row['id']) {
	    $f = XOOPS_ROOT_PATH . '/uploads/' . $GLOBALS['waffle_mydirname'] . '_file/' . $row['real_name'];

	    $filename = $m = $row['name'];
	      
	    if (preg_match('/compatible; MSIE 6.0/', $_SERVER['HTTP_USER_AGENT'])) {
		$filename = mb_convert_encoding($filename, 'SJIS', 'auto');
	    } else {
		$filename = mb_convert_encoding($filename, 'UTF-8', 'auto');
	    }
	    $filename = htmlspecialchars($filename);
	    
	    header("Content-Type: application/octet-stream");
	    header('Content-Disposition:attachment; filename="' . $filename . '"');
	    header("Content-Transfer-Encoding: binary"); 
	    header("Content-Length: " . filesize($f));
	    header("Pragma: no-cache");
	    header("Expires: 0");
    
	    readfile($f);
	    exit();

	} else {
	    ob_clean();
	    redirect_header('index.php?t_dd=' . $_GET['t_dd'], 2, _MD_FILE_NOT_FOUND);
	    exit();
	}
    } else {
	ob_clean();
	redirect_header('index.php?t_dd=' . $_GET['t_dd'], 2, _MD_FILE_NOT_FOUND);
	exit();
    }
}

?>
