<?php

function waffle_admin_confirm()
{
    print _AD_CONFIRM . ":<br>\n<br>\n";
    
    $y = $GLOBALS['waffle_mydirname'].'_data' . $_REQUEST['id'] . '.yml';
    $data = WaffleMAP::new_with_cache($y);
    
    if (isset($_REQUEST['confirm']) && isset($_REQUEST['id'])) {
	$d = $data->get_all($data->yaml['validable_column'] . ' = 0', '', 10, 0);
	
	foreach ($d as $key => $val) {
	    $id = 't'. $_REQUEST['id'] . '_id';
	    if ($_REQUEST['chk' . $val[$id]]) {
		$ar = array();
		$ar[$id] = $val[$id];
		$ar[$data->yaml['validable_column']] = 1;
		
		$data->update($ar);
	    }
	}
	
	ob_clean();
	redirect_header('index.php?op=confirm&id=' . intval($_REQUEST['id']), 2, _AD_UPDATED);
	exit();
    }
    
    $d = $data->get_all($data->yaml['validable_column'] . ' = 0', '', 10, 0);
    
    if (count($d) == 0) {
	print _AD_CONFIRM_NO_DATA;
	return;
    }

    print _AD_CONFIRM_DESC;
    print '<br>';
    print '<br>';
    print "<form>\n";
    print "<intput type='hidden' action='confirm.php'>\n";
    print '<table border="0" cellpadding="0" cellspacing="1" class="outer">';
    
    print '<tr>';
    print '<th></th>';
    print '<th>ID</th>';
    print '<th>' . _AD_CONFIRM_BODY . '</th>';
    print '<th> </th>';
    print '</tr>';

    $i = 0;
    foreach ($d as $key => $val) {
	$class = $i++ % 2 ? 'odd' : 'even';
        print "<tr class='$class'>\n";
	print '<td><input type="checkbox" name="chk' . $val['t' . $_REQUEST['id'] . '_id'] . '" value="1"></td>';
	print '<td>' . $val['t' . $_REQUEST['id'] . '_id'] . '</td>';
	print '<td>' . htmlspecialchars($val['t' . $_REQUEST['id'] . '_c1']) . '</td>';
	print '<td><a href="' . XOOPS_URL . '/modules/' . $GLOBALS['waffle_mydirname'] . '/index.php?t_m=ddcommon_view&id=' . $val['t' . $_REQUEST['id'] . '_id'] . '&t_dd=' . $GLOBALS['waffle_mydirname'] . '_data' . $_REQUEST['id'] . '" target="_blank">URL</a></td>';
	print '</tr>';
    }
    
    print '</table>';
    print "<input type='hidden' name='confirm' value='confirm'>\n";
    print "<input type='hidden' name='op' value='confirm'>\n";
    print "<input type='hidden' name='id' value='" . intval($_REQUEST['id']) . "'>\n";
    print "<input type='reset' name=''> ";
    print "<input type='submit' name=''>\n";
    print '</form>';
}

?>
