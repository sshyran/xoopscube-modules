<?php

function waffle_admin_version_up()
{
    print _AD_VERSION_UP_INFO;
    print '<br>';
    print '<br>';
    print '<form>';
    print '<input type="hidden" name="op" value="version_up_insert_from_0_3">';
    print '<input type="submit" value="' . _AD_VERSION_UP_FROM_0_3 . '">';
    print '</form><br><br>';
    print '<form>';
    print '<input type="hidden" name="op" value="version_up_insert_from_0_4">';
    print '<input type="submit" value="' . _AD_VERSION_UP_FROM_0_4 . '">';
    print '</form>';
    print '<br>';
    print '<br>';
    print '<form>';
    print '<input type="hidden" name="op" value="version_up_insert_from_0_6">';
    print '<input type="submit" value="' . _AD_VERSION_UP_FROM_0_6 . '">';
    print '</form>';
    print '<br>';
    print '<br>';
    print '<form>';
    print '<input type="hidden" name="op" value="version_up_cache_clear">';
    print '<input type="submit" value="' . _AD_VERSION_UP_CACHE_CLEAR . '">';
    print '</form>';
}

function waffle_admin_version_up_insert_from_0_3()
{
    global $xoopsDB;
    
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    
    $sql = implode('', file('../sql/version_up_from_0_3_to_0_4.sql'));
    $sql .= implode('', file('../sql/version_up_from_0_4_to_0_5.sql'));
    $sql .= implode('', file('../sql/version_up_from_0_6_to_0_7.sql'));
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
    redirect_header('index.php?op=version_up', 2, _AD_VERSION_UP_SUCCESSFUL);
    exit();
}

function waffle_admin_version_up_insert_from_0_4()
{
    global $xoopsDB;
    
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    
    $sql = implode('', file('../sql/version_up_from_0_4_to_0_5.sql'));
    $sql .= implode('', file('../sql/version_up_from_0_6_to_0_7.sql'));
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
    redirect_header('index.php?op=version_up', 2, _AD_VERSION_UP_SUCCESSFUL);
    exit();
}

function waffle_admin_version_up_insert_from_0_6()
{
    global $xoopsDB;
    
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    
    $sql = implode('', file('../sql/version_up_from_0_6_to_0_7.sql'));
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
    redirect_header('index.php?op=version_up', 2, _AD_VERSION_UP_SUCCESSFUL);
    exit();
}

function waffle_admin_version_up_cache_clear()
{
    global $xoopsDB;
    
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    
    $sql = "DELETE FROM xoops_waffle0_config WHERE name LIKE '%_cache' ";
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
    redirect_header('index.php?op=version_up', 2, _AD_UPDATED);
    exit();
}

?>
