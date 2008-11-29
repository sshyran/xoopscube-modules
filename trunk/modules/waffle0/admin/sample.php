<?php

function waffle_admin_sample()
{
    print _AD_SAMPLE_CONFIRM;
    print '<br>';
    print '<br>';
    print '<form>';
    print '<input type="hidden" name="op" value="sample_insert">';
    print '<input type="submit" value="' . _AD_SAMPLE_INSERT . '">';
    print '</form>';
}

function waffle_admin_sample_insert()
{
    global $xoopsDB;
    
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    
    $sql = implode('', file('../sql/sampledb.sql'));
    $sql = preg_replace('/waffle0/', $mydirname, $sql);
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

    waffle_admin_misc_yaml_remake();
    
    ob_clean();
    redirect_header('index.php?op=sample', 2, _AD_SAMPLE_SUCCESSFUL);
    exit();
}

?>
