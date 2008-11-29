<?php

require_once('../include/WaffleGrant.php');

function waffle_admin_grant() 
{
    waffle_admin_grant_group();
}

function waffle_admin_grant_group()
{
    global $xoopsDB;
    global $xoopsUser;
    global $no2grant;
    
    $y = $GLOBALS['waffle_mydirname'].'_table.yml';
    $table = WaffleMAP::new_with_cache($y);
    $t = $table->get_row($_GET['id']);
    
    $member_handler =& xoops_gethandler('member');
    
    $grant = WaffleGrant::get_grant_group($_GET['id']);
    $groups = $member_handler->getGroups();
    
    if (isset($_GET['grant_id']) && $_GET['grant_id']) {
	$a = array();
	foreach ($_GET['group'] as $v) {
	    $a[$v] = 1;
	}
	    
	foreach ($groups as $v) {
	    if (isset($grant[$_GET['grant_id']][$v->getVar('groupid')]) &&
		isset($a[$v->getVar('groupid')]) && 
		$grant[$_GET['grant_id']][$v->getVar('groupid')] ==
		$a[$v->getVar('groupid')]) {
		continue;
	    }
	    
	    if (isset($a[$v->getVar('groupid')]) && $a[$v->getVar('groupid')]) {
		WaffleGrant::add_group($_GET['id'], $_GET['grant_id'], $v->getVar('groupid'));
	    } else {
		WaffleGrant::delete_group($_GET['id'], $_GET['grant_id'], $v->getVar('groupid'));
	    }
	}
	
	$grant = WaffleGrant::get_grant_group($_GET['id']);
    }
    
    echo _AD_TABLE . ':' . $t['name'] . "<br>\n";
    printf("<a href='index.php?op=grant_group&id=%d'>%s</a> ", $_GET['id'], _AD_GRANT_GROUP);
    printf("<a href='index.php?op=grant_user&id=%d'>%s</a> ", $_GET['id'], _AD_GRANT_USER);
    echo "<table border='0' cellpadding='0' cellspacing='1' width='70%' class='outer'>\n";

    
    echo "<tr><th colspan=2>" . _AD_EDIT_GRANT. "</th></tr>\n";

    foreach ($no2grant as $k => $v) {
    
	echo "<tr><td class='head'>" . constant('_AD_GRANT_' . $v) . "</td>";
	echo "<td class='even'>\n";
	echo "<form action='index.php'>\n";
	echo "<select name='group[]' size='5' multiple>\n";
	foreach ($groups as $key => $val) {
	    if (isset($grant[constant('WAFFLE_GRANT_' . $v)][$val->getVar('groupid')])) {
		$g = $grant[constant('WAFFLE_GRANT_' . $v)][$val->getVar('groupid')];
	    } else {
		$g = 0;
	    }
	    printf("<option value='%d' %s>%s</option>\n", $val->getVar('groupid'), ($g) ? 'selected' : '', $val->getVar('name'));
	}
	echo "</select>";
	printf("<input type='hidden' name='id' value='%d'>\n", $_GET['id']);
	printf("<input type='hidden' name='op' value='grant_group'><br>\n");
	printf("<input type='hidden' name='grant_id' value='%d'>\n", constant('WAFFLE_GRANT_' . $v));
	echo "<input type='submit'>";
	echo "<input type='reset'>";
	echo "</form>\n";
	echo "</td></tr>\n";
    }

    echo "</table>\n";
    
}

function waffle_admin_grant_user()
{
    global $xoopsDB;
    global $xoopsUser;
    global $no2grant;
    
    $y = $GLOBALS['waffle_mydirname'].'_table.yml';
    $table = WaffleMAP::new_with_cache($y);
    $t = $table->get_row($_GET['id']);
    
    $member_handler =& xoops_gethandler('member');
    $users = $member_handler->getUsers();
    
    $grant = WaffleGrant::get_grant_user($_GET['id']);
    
    if (isset($_GET['grant_id']) && $_GET['grant_id']) {
	$a = array();
	if (isset($_GET['user']) && is_array($_GET['user'])) {
	    foreach ($_GET['user'] as $v) {
		$a[$v] = 1;
	    }
	}
	    
	foreach ($users as $v) {
	    if (isset($grant[$_GET['grant_id']][$v->getVar('uid')]) &&
		isset($a[$v->getVar('uid')]) &&
		$grant[$_GET['grant_id']][$v->getVar('uid')] ==
		$a[$v->getVar('uid')]) {
		continue;
	    }
	    
	    if (isset($a[$v->getVar('uid')]) && $a[$v->getVar('uid')]) {
		WaffleGrant::add_user($_GET['id'], $_GET['grant_id'], $v->getVar('uid'));
	    } else {
		WaffleGrant::delete_user($_GET['id'], $_GET['grant_id'], $v->getVar('uid'));
	    }
	}
	
	$grant = WaffleGrant::get_grant_user($_GET['id']);
    }
    
    echo _AD_TABLE . ':' . $t['name'] . "<br>\n";
    printf("<a href='index.php?op=grant_group&id=%d'>%s</a> ", $_GET['id'], _AD_GRANT_GROUP);
    printf("<a href='index.php?op=grant_user&id=%d'>%s</a> ", $_GET['id'], _AD_GRANT_USER);
    
    echo "<table border='0' cellpadding='0' cellspacing='1' width='70%' class='outer'>\n";

    
    echo "<tr><th colspan=2>" . _AD_EDIT_GRANT. "</th></tr>\n";

    foreach ($no2grant as $k => $v) {
    
	echo "<tr><td class='head'>" . constant('_AD_GRANT_' . $v) . "</td>";
	echo "<td class='even'>\n";
	echo "<form action='index.php'>\n";
	echo "<select name='user[]' size='5' multiple>\n";
	foreach ($users as $key => $val) {
	    if (isset($grant[constant('WAFFLE_GRANT_' . $v)][$val->getVar('uid')])) {
		$g = $grant[constant('WAFFLE_GRANT_' . $v)][$val->getVar('uid')];
	    } else {
		$g = 0;
	    }
	    printf("<option value='%d' %s>%s</option>\n", $val->getVar('uid'), ($g) ? 'selected' : '', $val->getVar('uname'));
	}
	echo "</select>";
	printf("<input type='hidden' name='id' value='%d'>\n", $_GET['id']);
	printf("<input type='hidden' name='op' value='grant_user'><br>\n");
	printf("<input type='hidden' name='grant_id' value='%d'>\n", constant('WAFFLE_GRANT_' . $v));
	echo "<input type='submit'>";
	echo "<input type='reset'>";
	echo "</form>\n";
	echo "</td></tr>\n";
    }

    echo "</table>\n";
    
}

?>
