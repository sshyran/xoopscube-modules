<?php

function waffle_admin_add_table()
{
    print _AD_ADD_TABLE_INFO;
    print '<br>';
    print '<br>';
    print '<form>';
    print '<input type="hidden" name="op" value="add_table_do">';
    print '<input type="submit" value="' . _AD_ADD_TABLE . '">';
    print '</form><br><br>';
}

function waffle_admin_add_table_do()
{
    global $xoopsDB;
    
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );

    $sql = implode('', file('../sql/add_table.sql'));
    $next_table_no = WaffleMAP::get_config_inc(WAFFLE_TABLE_NO, WAFFLE_TABLE_DEFAULT_NO + 1);
    
    $sql = preg_replace('/waffle0/', $mydirname, $sql);
    $sql = preg_replace('/_TABLE_NO_/', $next_table_no, $sql);
    $sql = trim($sql);

    include_once XOOPS_ROOT_PATH.'/class/database/sqlutility.php';
    SqlUtility::splitMySqlFile($pieces, $sql);

    foreach ($pieces as $piece) {
	$sql = preg_replace('/xoops_/', $xoopsDB->prefix() . '_', $piece);

	if (!$xoopsDB->queryF($sql)) {
	    print "error!";
	    return;
	}
    }

    ob_clean();
    redirect_header('index.php', 2, _AD_ADD_TABLE_SUCCESSFUL);
    exit();
}

?>
