<?php

include '../../../include/cp_header.php';
if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include "../language/".$xoopsConfig['language']."/main.php";
} else {
	include "../language/english/main.php";
}

include_once XOOPS_ROOT_PATH . "/class/xoopstopic.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
require_once('../include/WaffleMAP.php');
require_once('../include/db2yaml.php');
require_once('grant.php');
require_once('setting.php');
require_once('confirm.php');
require_once('rss.php');
require_once('versionup.php');
require_once('add_table.php');
require_once('admin_misc.php');

if (is_readable('../custom/sample.php')) {
    include_once('../custom/sample.php');
} else {
    require_once('sample.php');
}



$myts =& MyTextSanitizer::getInstance();

waffle_admin_dispatch();
exit();

function waffle_admin_dispatch() 
{
    $mydirname = basename( dirname( dirname( __FILE__ ) ) );
    $GLOBALS['waffle_mydirname'] = $mydirname;
    
    $op = 'default';
    if (isset($_GET['op'])) {
	$op = $_GET['op'];
    } else if(isset($_POST['op'])) {
	$op = $_POST['op'];
    }
    
    xoops_cp_header();

    if (preg_match('/version_up/', $op)) {
	waffle_admin_menu_bar(4);
    } else if (preg_match('/sample/', $op)) {
	waffle_admin_menu_bar(3);
    } else if (preg_match('/setting/', $op)) {
	waffle_admin_menu_bar(2);
    } else {
	waffle_admin_menu_bar(1);
    }
    
    $f = 'waffle_admin_' . $op;
    if (function_exists($f)) {
	eval($f . '();');
    } else {
	waffle_admin_default();
    }
    
    xoops_cp_footer();
}

function waffle_admin_yaml_update($table_id)
{
    print "debug:a<br>\n";
    if (intval($table_id) == 0) {
	die('table_id = 0');

    }
    print "debug:b<br>\n";
    
    $table_id = intval($table_id);
    
    $yaml_data = waffle_db2yaml($table_id);
    print "debug:c<br>\n";
    $t_table = $GLOBALS['waffle_mydirname'].'_data' . $table_id;
    WaffleMAP::set_config($t_table . '.yml', $yaml_data);
    print "debug:d<br>\n";
}

function waffle_admin_menu_bar($menu)
{
    echo "<div style='text-align:left;width:98%;'><div style='float:left;height:1.5em;'><nobr>";

    echo '<nobr>';
    
    echo '<A HREF="'.XOOPS_URL.'/modules/'.$GLOBALS['waffle_mydirname'].'/admin/index.php"  style="background-color:#' . ($menu == 1 ? 'FFCCCC' : 'DDDDDD'). ';font:normal normal bold 9pt/12pt;">'._AD_TABLE.'</A> ';
    
    echo ' | ';

    echo '<A HREF="'.XOOPS_URL.'/modules/'.$GLOBALS['waffle_mydirname'].'/admin/index.php?op=setting"  style="background-color:#' . ($menu == 2 ? 'FFCCCC' : 'DDDDDD'). ';font:normal normal bold 9pt/12pt;">'._AD_GENERAL_SETTING.'</A> ';
    
    echo ' | ';

    echo '<A HREF="'.XOOPS_URL.'/modules/'.$GLOBALS['waffle_mydirname'].'/admin/index.php?op=sample"  style="background-color:#' . ($menu == 3 ? 'FFCCCC' : 'DDDDDD'). ';font:normal normal bold 9pt/12pt;">'._AD_SAMPLE.'</A> ';
    
    echo ' | ';
    
    echo '<A HREF="'.XOOPS_URL.'/modules/'.$GLOBALS['waffle_mydirname'].'/admin/index.php?op=version_up"  style="background-color:#' . ($menu == 4 ? 'FFCCCC' : 'DDDDDD'). ';font:normal normal bold 9pt/12pt;">'._AD_VERSION_UP.'</A> ';
    
    echo '</nobr>';
    echo '</div> ';
    echo "";
    
    echo '<br />';
    echo '</DIV>';
    echo '<HR>';
}

function waffle_admin_default()
{
    global $xoopsDB;
    
    $y = $GLOBALS['waffle_mydirname'].'_table.yml';
    $table = WaffleMAP::new_with_cache($y);
    
    $num_of_table = WaffleMAP::get_config(WAFFLE_TABLE_NO, WAFFLE_TABLE_DEFAULT_NO);
    if ($num_of_table == 0) {
	WaffleMAP::set_config(WAFFLE_TABLE_NO, WAFFLE_TABLE_DEFAULT_NO);
	$num_of_table = WAFFLE_TABLE_DEFAULT_NO;
    }

    if (isset($_GET['name1'])) {
	for ($i=1; $i<=$num_of_table; $i++) {
	    if (isset($_GET['name' . $i]) == false) {
		continue;
	    }
	    
	    $arr = array();

	    $arr['id'] = $i;
	    $arr['name'] = $_GET['name' . $i];
	    $arr['order'] = $_GET['order' . $i];
	    if (isset($_GET['rss' . $i])) {
		$arr['rss'] = '1';
	    } else {
		$arr['rss'] = '0';
	    }
	    if (isset($_GET['valid' . $i])) {
		$arr['valid'] = '1';
	    } else {
		$arr['valid'] = '0';
	    }
	    if (isset($_GET['validable' . $i])) {
		$arr['validable'] = '1';
	    } else {
		$arr['validable'] = '0';
	    }

	    $table->update_one($arr);
	    
	    $yaml_data = waffle_db2yaml($i);
	    $t_table = $GLOBALS['waffle_mydirname'].'_data' . $i;
	    WaffleMAP::set_config($t_table . '.yml', $yaml_data);
	}
    }
    
    $alldata = $table->get_all('', array('order', 'id'));

    echo "
        <form action='index.php'>

	<table border='0' cellpadding='0' cellspacing='1' class='outer'>
	<tr>
	<th>" . _AD_TABLE_NAME . "</th>
	<th>" . _AD_DESC . "</th>
	<th>" . _AD_ORDER . "</th>
	<th>" . _AD_VALID . "</th>
	<th>" . _AD_VALIDABLE . "</th>
	<th>" . _AD_RSS_OUTPUT . "</th>
	<th>" . _AD_ACTION . "</th>
	</tr>
			       ";
    $i = 0;
    foreach ($alldata as $key => $val) {
	$class = $i++ % 2 ? 'odd' : 'even';
	print "<tr class='$class'>\n";
	printf("<td align='left'>%s</td>", $xoopsDB->prefix($GLOBALS['waffle_mydirname'] . '_data' . $val['id']));
	printf("<td align='left'><input type='text' name='name%s' value='%s' maxlength='%d'></td>", $val['id'], addslashes($val['name']), WAFFLE_MAX_TABLE_NAME_SIZE);
	printf("<td align='left'><input type='text' name='order%s' value='%s' size='5'></td>", $val['id'], intval($val['order']));
	print "<td align='center'>";
	if ($val['valid']) {
	    printf("<input type='checkbox' name='valid%s' checked>", $val['id']);
	} else {
	    printf("<input type='checkbox' name='valid%s'>", $val['id']);
	}
	print "</td>\n";
	print "<td align='center'>";
	if ($val['validable']) {
	    printf("<input type='checkbox' name='validable%s' checked>", $val['id']);
	} else {
	    printf("<input type='checkbox' name='validable%s'>", $val['id']);
	}
	print "</td>\n";
	print "<td align='center'>";
	if ($val['rss']) {
	    printf("<input type='checkbox' name='rss%s' checked>", $val['id']);
	} else {
	    printf("<input type='checkbox' name='rss%s'>", $val['id']);
	}
	print "</td>\n";
	printf("<td align='left'>");
	printf("<a href='index.php?op=edit_table&id=%s'>%s</a> ", $val['id'], _AD_EDIT);
	printf("<a href='index.php?op=grant&id=%s'>%s</a> ", $val['id'], _AD_GRANT);
	printf("<a href='index.php?op=confirm&id=%s'>%s</a> ", $val['id'], _AD_CONFIRM);
	printf("<a href='index.php?op=rss&id=%s'>%s</a> ", $val['id'], _AD_RSS);
	printf(" </td>\n");
	print "</tr>\n";
    }
    
    print "<tr><td class='foot' align='center' colspan='7'>\n";
    print "<input type='hidden' name='op' value='default' />\n";
    print "<input type='submit' name='submit' value='" . _SUBMIT . "' />\n";
    print "<input type='reset' />\n";
    print "</td></tr></table>\n";
    print "</form>\n";
    print "<br>";
    
    $next_table_no = WaffleMAP::get_config(WAFFLE_TABLE_NO);

    if ($next_table_no < WAFFLE_TABLE_MAX) {
	print "	<table border='0' cellpadding='0' cellspacing='1' class='outer'>";
	print "<tr>";
	print "<td class='odd'><a href='?op=add_table'>"._AD_ADD_TABLE."</a> </td>";
	print "</tr></table>";
    } else {
	printf(_AD_ADD_TABLE_DESC, WAFFLE_TABLE_MAX);
    }
}

function waffle_admin_table_list()
{
    echo 'table_list';
}

function waffle_admin_edit_table()
{
    global $no2type;
    global $edit_column_ok;
    global $myts;
    global $search_column;

    $y = $GLOBALS['waffle_mydirname'].'_table.yml';
    $table = WaffleMAP::new_with_cache($y);
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);


    if (isset($_POST['desc1'])) {
	for ($i=1; $i < WAFFLE_COLUMN_MAX; $i++) {
	    if (isset($_POST['desc' . $i]) == false) {
		continue;
	    }

	    $arr = array();
	    
	    $arr['id'] = $_POST['column' . $i];
	    $arr['desc']     = $_POST['desc' . $i];
	    
	    if ($_POST['fixed' . $i] == 0) {
		if (isset($_POST['valid' . $i]) && $_POST['valid' . $i]) {
		    $arr['valid'] = 1;
		} else {
		    $arr['valid'] = 0;
		}
		if (isset($_POST['uniq' . $i]) && $_POST['uniq' . $i]) {
		    $arr['uniq'] = 1;
		} else {
		    $arr['uniq'] = 0;
		}
		if (isset($_POST['not_null' . $i]) && $_POST['not_null' . $i]) {
		    $arr['not_null'] = 1;
		} else {
		    $arr['not_null'] = 0;
		}
		if (isset($_POST['default' . $i]) && $_POST['default' . $i]) {
		    $arr['default'] = $_POST['default' . $i];
		}
	    }

	    if (isset($_POST['detailview' . $i]) && $_POST['detailview' . $i]) {
		$arr['detailview'] = 1;
	    } else {
		$arr['detailview'] = 0;
	    }
	    if (isset($_POST['insertview' . $i]) && $_POST['insertview' . $i]) {
		$arr['insertview'] = 1;
	    } else {
		$arr['insertview'] = 0;
	    }
	    if (isset($_POST['updateview' . $i]) && $_POST['updateview' . $i]) {
		$arr['updateview'] = 1;
	    } else {
		$arr['updateview'] = 0;
	    }
	    if (isset($_POST['listview' . $i]) && $_POST['listview' . $i]) {
		$arr['listview'] = 1;
	    } else {
		$arr['listview'] = 0;
	    }
	    if (isset($_POST['updatable' . $i]) && $_POST['updatable' . $i]) {
		$arr['updatable'] = 1;
	    } else {
		$arr['updatable'] = 0;
	    }
	    if (isset($search_column[$_POST['type' . $i]]) && $search_column[$_POST['type' . $i]]) {
		$arr['search'] = $_POST['search' . $i] ? 1 : 0;
	    }
	    $arr['order']    = intval($_POST['order' . $i]);

	    $column->update_one($arr);
	}
	
	$yaml_data = waffle_db2yaml($_POST['id']);
	$t_table = $GLOBALS['waffle_mydirname'].'_data' . $_POST['id'];
	WaffleMAP::set_config($t_table . '.yml', $yaml_data);
    }
    
    $alldata = $column->get_all('table_id = ' .intval($_GET['id']), 'order');
    $t = $table->get_row($_GET['id']);

    echo _AD_EDIT_TABLE . " : ";
    echo $t['name'] . "<br>\n";
    echo "
	<form method='post'>
	<table border='0' cellpadding='0' cellspacing='1' width='100%' class='outer'>
	<tr>
	<th align='center'>" . _AD_COLUMN_NAME . "</th>
	<th align='center'>" . _AD_DESC . "</th>
	<th align='center' align='center'>" . _AD_TYPE . "</th>
	<!-- <th align='center'>" . _AD_VALID . "</th> -->
	<th align='center'><nobr>" . _AD_UNIQ . "</nobr></th>
	<th align='center'>not-null</th>
	<th align='center'>" . _AD_DEFAULT . "</th>
	<th align='center'>" . _AD_ORDER . "</th>
	<th align='center'>" . _AD_DETAILVIEW . "</th>
	<th align='center'>" . _AD_INSERTVIEW . "</th>
	<th align='center'>" . _AD_UPDATEVIEW . "</th>
	<th align='center'>" . _AD_LISTVIEW . "</th>
	<th align='center'>" . _AD_UPDATABLE . "</th>
	<th align='center'>" . _AD_SEARCH . "</th>
	<th align='center'>" . _AD_ACTION . "</th>
	</tr>\n";

    $i = 1;
    foreach ($alldata as $key => $val) {
	$class = $i % 2 ? 'odd' : 'even';
	print "<tr class='$class'>\n";
	printf("<td align='left'>%s</td>\n", $val['name']);
	printf("<td align='left'>");
	printf("<input type='text' name='desc%d' value='%s' maxlength='%d'>", $i, $myts->htmlSpecialChars($myts->stripSlashesGPC($val['desc'])), WAFFLE_MAX_COLUMN_NAME_SIZE);
	printf("<input type='hidden' name='column%d' value='%d'>", $i, $val['id']);
	printf("<input type='hidden' name='fixed%d' value='%d'>", $i, $val['fixed']);
	printf("<input type='hidden' name='type%d' value='%d'>", $i, $val['type']);
	printf("</td>\n");
	printf("<td align='left'>%s</td>\n", constant('_AD_COLUMN_' . strtoupper($no2type[$val['type']])));
	/*
	printf("<td align='center'>");
	if ($val['fixed']) {
	    printf("%d", $val['valid']);
	} else {
	    printf("<input type='checkbox' name='valid%d' %s>\n", $i, $val['valid'] ? 'checked' : '');
	}
        printf("</td>\n");
	 */
	printf("<td align='center'>");
	if ($val['fixed']) {
	    printf("%d", intval($val['uniq']));
	} else {
	    printf("<input type='checkbox' name='uniq%d' %s>\n", $i, $val['uniq'] ? 'checked' : '');
	}
	printf("</td>");
	printf("<td align='center'>");
	if ($val['fixed']) {
	    printf("%d", intval($val['not_null']));
	} else {
	    printf("<input type='checkbox' name='not_null%d' %s>\n", $i, $val['not_null'] ? 'checked' : '');
	}
	printf("</td>");
        printf("<td align='left'>");
	if ($val['fixed']) {
	    printf("%s", $val['default']);
	} else {
	    if ($val['type'] == WAFFLE_COLUMN_RADIO ||
		$val['type'] == WAFFLE_COLUMN_SELECT) {
		
		$yy = $GLOBALS['waffle_mydirname'].'_option.yml';
		$option = WaffleMAP::new_with_cache($yy);
		$ao = $option->get_all('column_id = ' . intval($val['id']), 'id');

		printf("<select name='default%d'>\n", $i);
		foreach ($ao as $kk => $vv) {
		    printf("<option mame='default%d' value='%d'%s>%s\n",
			   $kk + 1, $kk + 1, (($kk + 1) == $val['default'] ? ' selected' : ''), WaffleMAP::truncate($vv['name'], 20));
		}
		printf("</select>\n");
	    } else if ($val['type'] == WAFFLE_COLUMN_CHECKBOX) {
		printf("<input type='radio' name='default%d' value='1' %s>%s<br>\n", $i, intval($val['default']) ? 'checked' : '', _AD_CHECKBOX_CHECK);
		printf("<input type='radio' name='default%d' value='0' %s>%s", $i, intval($val['default']) ? '' : 'checked', _AD_CHECKBOX_NO_CHECK);
	    } else if ($val['type'] == WAFFLE_COLUMN_TEXTAREA ||
		       $val['type'] == WAFFLE_COLUMN_HTMLTEXT) {
		/* --- */
	    } else if ($val['type'] == WAFFLE_COLUMN_DATE) {
		printf("<input type='text' name='default%d' value='%s'>", $i, htmlspecialchars($val['default']));
	    } else {
		printf("<input type='text' name='default%d' value='%s'>", $i, htmlspecialchars($val['default']));
	    }
	}
	printf("</td>\n");
        printf("<td align='left'><input type='text' name='order%d' value='%s' size='5'></td>\n", $i, intval($val['order']));
	printf("<td align='center'>");
	printf("<input type='checkbox' name='detailview%d' %s>", $i, $val['detailview'] ? 'checked' : '');
	printf("</td>\n");
	printf("<td align='center'>");
	if ($val['fixed'] == 0) {
	    printf("<input type='checkbox' name='insertview%d' %s>", $i, $val['insertview'] ? 'checked' : '');
	}
	printf("</td>\n");
	printf("<td align='center'>");
	if ($val['fixed'] == 0) {
	    printf("<input type='checkbox' name='updateview%d' %s>", $i, $val['updateview'] ? 'checked' : '');
	}
	printf("</td>\n");
	printf("<td align='center'>");
	if (true || $val['primary_key'] == 0) {
	    printf("<input type='checkbox' name='listview%d' %s>", $i, $val['listview'] ? 'checked' : '');
	} else {
	    printf("<input type='hidden' name='listview%d' value='1'>", $i);
	}
	printf("</td>\n");
	printf("<td align='center'>");
	if ($val['fixed'] == 0) {
	    printf("<input type='checkbox' name='updatable%d' %s>", $i, $val['updatable'] ? 'checked' : '');
	}
	printf("</td>\n");
	printf("<td align='center'>");
	if (isset($search_column[$val['type']]) && $search_column[$val['type']]) {
	    printf("<input type='checkbox' name='search%d' %s>", $i, $val['search'] ? 'checked' : '');
	}
	printf("</td>\n");
	printf("<td align='center'> ");
	if ($val['fixed'] == 0) {
	    if (isset($edit_column_ok[$val['type']]) && $edit_column_ok[$val['type']]) {
		printf("<a href='index.php?op=edit_column_" . $no2type[$val['type']] . "&column_id=%s&table_id=%s&type=%d'><nobr>%s</nobr></a> ", $val['id'], $val['table_id'], $val['type'], _AD_EDIT);
	    }
	    printf("<a href='index.php?op=delete_column&id=%s&table_id=%s&column_id=%d'><nobr>%s</nobr></a>", $val['id'], $val['table_id'], $val['id'],  _AD_DELETE);
	}
	printf("</td>");
        print "</tr>\n";
	
	$i++;
    }
    
    print "
        <tr><td class='foot' align='center' colspan='14'>
		<input type='hidden' name='op' value='edit_table' />
		<input type='hidden' name='id' value='" . intval($_GET['id']) . "' />
		<input type='submit' name='submit' value='" . _SUBMIT . "' />
		<input type='reset' />
	</td></tr></table><br>
    ";

    echo "	<table border='0' cellpadding='0' cellspacing='1' class='outer'>
    		<tr>
		<td class='odd'><a href='?op=add_column&table_id=".intval($_GET['id'])."'>"._AD_ADD_COLUMN."</a> </td>
	</tr></table>";

}

function waffle_admin_add_column()
{
    echo "<table border='0' cellpadding='0' cellspacing='1' width='70%' class='outer'>\n";
    echo "<tr><th colspan=2 align='center'>" . _AD_ADD_COLUMN_1 . "</th></tr>\n";

    echo "<tr><td class='head'>" . _AD_INPUT_COLUMN_NAME . "</td>" .
      "<td class='even'>  <form action='index.php'>".
      "<input type=text name=name size=" . WAFFLE_MAX_COLUMN_NAME_SIZE . " maxlength=".WAFFLE_MAX_COLUMN_NAME_SIZE."></td></tr>" .
      "<tr><td class='head'>" . _AD_SELECT_TYPE . "</td>" .
      "<td class='even'><input type='hidden' name='op' value='add_column_2'>" .
      "<input type='hidden' name='table_id' value='".intval($_GET['table_id'])."'>" .
      "<select name='type'>";
    
    global $support_column;
    global $type2no;
    foreach ($type2no as $k => $v) {
	if (isset($support_column[$v]) == false) {
	    continue;
	}
	printf("<option value='%d'>%s\n", $v, constant('_AD_COLUMN_' . strtoupper($k)));
    }
    
    echo " </select></td></tr>
	   <tr><td class='head'><td class='even' ><input type='submit' value='"._AD_NEXT."'>
	   </form>";
    echo "</td></tr></table>\n";
}

function waffle_admin_add_column_2()
{
    if (WAFFLE_MAX_COLUMN_NAME_SIZE < strlen($_GET['name'])) {
	printf("<font color='red'>" . sprintf(_AD_COLUMN_OVER_MAX, WAFFLE_MAX_COLUMN_NAME_SIZE) . "</font><BR><BR>\n");
	waffle_admin_add_column();
	return;
    }

    if ($_GET['type'] == 1) {
	waffle_admin_add_column_2_integer();
    } else if ($_GET['type'] == 2) {
	waffle_admin_add_column_2_string();
    } else if ($_GET['type'] == 3) {
	waffle_admin_add_column_2_textarea();
    } else if ($_GET['type'] == 5) {
	waffle_admin_add_column_2_string();
    } else if ($_GET['type'] == 6) {
	waffle_admin_add_column_2_string();
    } else if ($_GET['type'] == 7) {
	waffle_admin_add_column_2_radio();
    } else if ($_GET['type'] == 8) {
	waffle_admin_add_column_2_select();
    } else if ($_GET['type'] == WAFFLE_COLUMN_CHECKBOX) {
	waffle_admin_add_column_2_checkbox();
    } else if ($_GET['type'] == 12) {
	waffle_admin_add_column_2_image();
    } else if ($_GET['type'] == 13) {
	waffle_admin_add_column_2_string();
    } else if ($_GET['type'] == 14) {
	waffle_admin_add_column_2_file();
    } else if ($_GET['type'] == 15) {
	waffle_admin_add_column_2_textarea();
    } else if ($_GET['type'] == 16) {
	waffle_admin_add_column_2_textarea();
    } else if ($_GET['type'] == 17) {
	waffle_admin_add_column_2_string();
    } else if ($_GET['type'] == 19) {
	waffle_admin_add_column_2_time();
    } else if ($_GET['type'] == 20) {
	waffle_admin_add_column_2_date();
    } else if ($_GET['type'] == 21) {
	waffle_admin_add_column_2_datetime();
    } else if ($_GET['type'] == 22) {
	waffle_admin_add_column_2_relation();
    }

}

function waffle_admin_add_column_2_integer()
{
    global $no2type;
    global $myts;

    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan=2 align='center'>" . _AD_ADD_COLUMN_2 . "</th></tr>\n";
    echo "<!--<tr class='odd'><th>" . _AD_STRING_MAXLENGTH . "</th>".
        "<td><input type=text name=maxlength value='255'></td></tr>" .
      "<tr class='odd'><th>" . _AD_STRING_SIZE . "</th>".
      "<td><input type=text name=size value='32'></td></tr>-->" .
      "<tr><td class='head'>" . _AD_STRING_DEFAULT . "</td>" .
	"<td class='even'><input type=text name=default value=''></td></tr>
	 <tr><td class='head'> </td>
	  <td class='even'>
	<input type='checkbox' name='not_null'>".
      _AD_STRING_NOT_NULL . "<br><br> " .
      "<input type='checkbox' name='uniq'>" .
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_string()
{
    global $no2type;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';

    echo "<form action='index.php'>\n
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=not_null value='" . (isset($_GET['not_null']) && $_GET['not_null'] ? 1 : 0 ) . "'>
        <input type=hidden name=uniq value='" . (isset($_GET['uniq']) && $_GET['uniq'] ? 1 : 0 ) . "'>
	<input type=hidden name=name value='".addslashes($_GET['name'])."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_STRING_MAXLENGTH . "</td>".
        "
	<td class='even'><input type=text name=maxlength value='255'></td></tr>" .
      "<tr><td class='head'>" . _AD_STRING_SIZE . "</td>".
      "<td class='even'><input type=text name=size value='32'></td></tr>" .
      "<tr><td class='head'>" . _AD_STRING_DEFAULT . "</td>" .
	"<td class='even'><input type=text name=default value=''></td></tr>
	 <tr><td class='head'> </td>
	  <td class='even'>
	<input type='checkbox' name=not_null>".
      _AD_STRING_NOT_NULL . "<br><br> " .
      "<input type='checkbox' name=uniq>" . 
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_textarea()
{
    global $no2type;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';

    echo "<form action='index.php'>\n
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=not_null value='" . (isset($_GET['not_null']) && $_GET['not_null'] ? 1 : 0 ) . "'>
        <input type=hidden name=uniq value='" . (isset($_GET['uniq']) && $_GET['uniq'] ? 1 : 0 ) . "'>
	<input type=hidden name=name value='". htmlspecialchars($_GET['name'])."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_TEXTAREA_MAXLENGTH . "</td>".
        "<td class='even'><input type=text name=maxlength value='255'></td></tr>" .
      "<tr><td class='head'>" . _AD_TEXTAREA_ROWS . "</td>".
      "<td class='even'><input type=text name=rows value='5'></td></tr>" .
      "<tr><td class='head'>" . _AD_TEXTAREA_COLS . "</td>".
      "<td class='even'><input type=text name=cols value='30'></td></tr>" .
      "<tr><td class='head'>" . _AD_STRING_DEFAULT . "</td>" .
	"<td class='even'><textarea name='default' rows='7' cols='20'></textarea></td></tr>
	 <tr><th class='head'> </td>
	  <td class='even'>
	<input type='checkbox' name=not_null>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name=uniq>" . 
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_checkbox()
{
    global $no2type;
    global $myts;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_DEFAULT . "</td>" .
	"<td class='even'>" .
        "<input type='radio' name=default value='1'>". _AD_CHECKBOX_CHECK . 
        "<input type='radio' name=default value='0' CHECKED>". _AD_CHECKBOX_NO_CHECK . 
        "</td></tr>" .
	 "<tr><td class='head'> </td>" .
	 " <td class='even'> " .
	 "<input type='checkbox' name='not_null'>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name='uniq'>" .
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_select()
{
    waffle_admin_add_column_2_radio();
}

function waffle_admin_add_column_2_radio()
{
    global $no2type;
    global $myts;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_RADIO_OPTION . "</td>" .
	"<td class='even'>";
    echo "<table><tr><td>";
    if ($_REQUEST['preset'] == 1) {
	$i = 1;
	global $waffle_ad_prefecture;
        foreach ($waffle_ad_prefecture as $val) {
	    printf("<input type='radio' name='default' value='%d'%s>", $i, ($i == 1 ? ' checked' :''));
	    printf("<input type='text' name='option%d' value='%s' maxlength='255'><br>\n", $i, $val);
	    $i++;
	}
    } else {
        for ($i=1; $i <= 10; $i++) {
	    printf("<input type='radio' name='default' value='%d'%s>", $i, ($i == 1 ? ' checked' :''));
	    printf("<input type='text' name='option%d' value='' maxlength='255'><br>\n", $i);
	}
    }
    echo "</td><td valign='top'>";
    echo _AD_PRESET . "<br>";
    echo "<a href='index.php?name=".$_REQUEST['name'].'&op='.$_REQUEST['op'].'&table_id='.$_REQUEST['table_id'].'&type='.$_REQUEST['type']. "&preset=0'>" . _AD_PRESET_DEFAULT . "</a><br>";
    echo "<a href='index.php?name=".$_REQUEST['name'].'&op='.$_REQUEST['op'].'&table_id='.$_REQUEST['table_id'].'&type='.$_REQUEST['type']. "&preset=1'>" . _AD_PRESET_PREFECTURE . "</a><br>";
    echo "</td></tr></table>";
    echo _AD_RADIO_OPTION_IS_DEFUALT .
        "</td></tr>" .
	 "<tr><td class='head'> </td>" .
	 " <td class='even'> " .
	 "<input type='checkbox' name='not_null'>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name='uniq'>" .
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_image()
{
    global $no2type;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';

    echo "<form action='index.php'>\n
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=not_null value='" . (isset($_GET['not_null']) && $_GET['not_null'] ? 1 : 0 ) . "'>
        <input type=hidden name=uniq value='" . (isset($_GET['uniq']) && $_GET['uniq'] ? 1 : 0 ) . "'>
	<input type=hidden name=name value='".addslashes($_GET['name'])."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'> </td>
	  <td class='even'>
	<input type='checkbox' name=not_null>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name=uniq>" . 
            _AD_STRING_UNIQ . "</td></tr>";
    echo "<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_file()
{
    global $no2type;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';

    echo "<form action='index.php'>\n
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=not_null value='" . (isset($_GET['not_null']) && $_GET['not_null'] ? 1 : 0 ) . "'>
        <input type=hidden name=uniq value='" . (isset($_GET['uniq']) && $_GET['uniq'] ? 1 : 0 ) . "'>
	<input type=hidden name=name value='".addslashes($_GET['name'])."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'> </td>
	  <td class='even'>
	<input type='checkbox' name=not_null>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name=uniq>" . 
            _AD_STRING_UNIQ . "</td></tr>";
    echo "<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_time()
{
    global $no2type;
    global $myts;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_DEFAULT . "</td>" .
	"<td class='even'>";

    echo
        "<input type='checkbox' name='default' value='1'>". _AD_DATE_DEFAULT_CHECK ;
										  
//      " <input type='text' name='year' size=5 maxlength=4 value='2005'> : " .
    echo " <select name='hour'>";
    for ($i=0; $i<=23; $i++) {
        printf(" <option value='%02d'>%02d", $i, $i);
    }
    echo " </select> : \n";
    echo " <select name='min'>";
    for ($i=0; $i<=59; $i++) {
        printf(" <option value='%02d'>%02d", $i, $i);
    }
    echo " </select> : \n";
    echo " <select name='sec'> ";
    for ($i=0; $i<=59; $i++) {
        printf(" <option value='%02d'>%02d", $i, $i);
    }
    echo " </select>";
    
    echo "</td></tr>";
    
    echo "<tr><td class='head'> </td>" .
	 " <td class='even'> " .
	 "<input type='checkbox' name='not_null'>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name='uniq'>" .
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_date()
{
    global $no2type;
    global $myts;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_DEFAULT . "</td>" .
	"<td class='even'>";

    echo
        "<input type='checkbox' name='default' value='1'>". _AD_DATE_DEFAULT_CHECK .
        " <input type='text' name='year' size=5 maxlength=4 value='2005'> / " .
        " <select name='month'>";
    for ($i=1; $i<=12; $i++) {
        echo " <option value='" . $i . "'>" . $i;
    }
    echo " </select> / \n";
    echo " <select name='day'> ";
    for ($i=1; $i<=31; $i++) {
        echo " <option value='" . $i . "'>" . $i;
    }
    echo " </select>";
    
    echo "</td></tr>";
    
    echo "<tr><td class='head'> </td>" .
	 " <td class='even'> " .
	 "<input type='checkbox' name='not_null'>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name='uniq'>" .
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_datetime()
{
    global $no2type;
    global $myts;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_DEFAULT . "</td>" .
	"<td class='even'>";

    echo
        "<input type='checkbox' name='default' value='1'>". _AD_DATE_DEFAULT_CHECK .
        " <input type='text' name='year' size=5 maxlength=4 value='2005'> / " .
        " <select name='month'>";
    for ($i=1; $i<=12; $i++) {
        echo " <option value='" . $i . "'>" . $i;
    }
    echo " </select> / \n";
    echo " <select name='day'> ";
    for ($i=1; $i<=31; $i++) {
        echo " <option value='" . $i . "'>" . $i;
    }
    echo " </select>";

    echo " <select name='hour'>";
    for ($i=0; $i<=23; $i++) {
        printf(" <option value='%02d'>%02d", $i, $i);
    }
    echo " </select> : \n";
    echo " <select name='min'>";
    for ($i=0; $i<=59; $i++) {
        printf(" <option value='%02d'>%02d", $i, $i);
    }
    echo " </select> : \n";
    echo " <select name='sec'> ";
    for ($i=0; $i<=59; $i++) {
        printf(" <option value='%02d'>%02d", $i, $i);
    }
    echo " </select>";
    
    echo "</td></tr>";
    
    echo "<tr><td class='head'> </td>" .
	 " <td class='even'> " .
	 "<input type='checkbox' name='not_null'>".
      _AD_STRING_NOT_NULL . "<BR />" .
      "  <br />
	<input type='checkbox' name='uniq'>" .
            _AD_STRING_UNIQ . "</td></tr>
	<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_relation()
{
    global $no2type;
    global $myts;

    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';

    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_2_relation_2'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_2 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_COLUMN_RELATION_SETTING . "</td>" .
	"<td class='even'>";
    
    echo _AD_COLUMN_RELATION_TABLE . "<br>\n";;

    $y = $GLOBALS['waffle_mydirname'].'_table.yml';
    $table = WaffleMAP::new_with_cache($y);
    $alldata = $table->get_all('', array('order', 'id'));
    
    echo " <select name='rel_table_id'>";
    foreach ($alldata as $key => $val) {
        echo " <option value='" . $val['id'] . "'>" . $val['name'] . '('.$GLOBALS['waffle_mydirname'] . '_data' . $val['id'] . ')';
    }
    echo " </select> <BR>\n";
    echo _AD_COLUMN_RELATION_INFO1 . "<br>\n";;
    
    echo "</td></tr>";

    echo "<tr><td class='head'>";
    echo "</td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_add_column_2_relation_2()
{
    global $no2type;
    global $myts;
    
    echo '"' . htmlspecialchars($_GET['name']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';

    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='add_column_3'>
	<input type=hidden name=name value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	<input type=hidden name=rel_table_id value='".addslashes($_GET['rel_table_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan='2' align='center'>" . _AD_ADD_COLUMN_3 ."</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_COLUMN_RELATION_SETTING2 . "</td>" .
	"<td class='even'>";
    
    echo _AD_COLUMN_RELATION_V_COLUMN . "<br>\n";

    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $alldata = $column->get_all('table_id = ' .intval($_GET['rel_table_id']), 'order');
    
    $ar = array();
    foreach ($alldata as $key => $val) {
	$ar[$val['name']] = $val['desc'];
    }

    echo " <select name='rel_v_column'>";
//    echo " <option value='t" . $_GET['rel_table_id'] . "_id'>t" . $_GET['rel_table_id'] . '_id';
    for ($i=1; $i <=WAFFLE_COLUMN_MAX; $i++) {
	$c = "t" . $_GET['rel_table_id'] . '_c' . $i;
        echo " <option value='" . $c . "'>" . $c;
	if (isset($ar[$c]) && $ar[$c]) {
	    echo '(' . $ar[$c] . ')';
	} else {
	    echo '(' . _AD_NO_DEFINE . ')';
	}
    }
    echo " </select> <br>\n";
    echo _AD_COLUMN_RELATION_INFO2 . "<br>\n";
    
    echo "</td></tr>";

    echo "<tr><td class='head'>";
    echo "</td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";

    
    echo "</table>";
}

function waffle_admin_add_column_3()
{
    global $no2type;
    global $myts;

    if (isset($_GET['default'])) {
	$default = $_GET['default'];
    }

    echo _AD_STRING_CREATE_OK;
    echo "<form>
	   <table border='0' cellpadding='0' cellspacing='1' width='70%' class='outer'>
	   <tr><th colspan=2 align='center'>" . _AD_ADD_COLUMN_CONFIRM. "</th></tr>
	   <tr>
	   <td class='head'>" . _AD_COLUMN_NAME . "</td><td class='even'>".htmlspecialchars($_GET['name'])."</td>
	   </tr>
	   <tr>
	   <td class='head'>" . _AD_COLUMN_TYPE . "</td><td class='even'>" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . "</td>
	   </tr>";

    if ($_GET['type'] == WAFFLE_COLUMN_RADIO) {
	echo " <tr>".
	  "<td class='head'>"._AD_DEFAULT."</td><td class='even'>".htmlspecialchars($_GET['option' . $_GET['default']])."</td>" .
	  "</tr>";
    } else if ($_GET['type'] == WAFFLE_COLUMN_TIME) {
	echo " <tr>".
	  "<td class='head'>"._AD_DEFAULT."</td>";
	if (isset($_GET['default']) && $_GET['default']) {
	    $default = sprintf("%02d:%02d:%02d", $_GET['hour'], $_GET['min'], $_GET['sec']);
	    echo "<td class='even'>" . $default . "</td>";
	} else {
	    echo "<td class='even'>" . _AD_NO . "</td>";
	}
	echo "</tr>";
    } else if ($_GET['type'] == WAFFLE_COLUMN_DATE) {
	echo " <tr>".
	  "<td class='head'>"._AD_DEFAULT."</td>";
	if (isset($_GET['default']) && $_GET['default']) {
	    $default = sprintf("%04d-%02d-%02d", $_GET['year'], $_GET['month'], $_GET['day']);
	    echo "<td class='even'>" . $default . "</td>";
	} else {
	    echo "<td class='even'>" . _AD_NO . "</td>";
	}
	echo "</tr>";
    } else if ($_GET['type'] == WAFFLE_COLUMN_DATETIME) {
	echo " <tr>".
	  "<td class='head'>"._AD_DEFAULT."</td>";
	if (isset($_GET['default']) && $_GET['default']) {
	    $default = sprintf("%04d/%02d/%02d %02d:%02d:%02d", 
			       $_GET['year'], $_GET['month'], $_GET['day'], 
			       $_GET['hour'], $_GET['min'], $_GET['sec']);
	    echo "<td class='even'>" . $default . "</td>";
	} else {
	    echo "<td class='even'>" . _AD_NO . "</td>";
	}
	echo "</tr>";
    } else if ($_GET['type'] == WAFFLE_COLUMN_RELATION) {
	echo " <tr>".
	  "<td class='head'>"._AD_COLUMN_RELATION_SETTING."</td>";
	
	echo "<td class='even'>" ._AD_COLUMN_RELATION_TABLE . ":";
	echo $GLOBALS['waffle_mydirname'] . "_data" . $_GET['rel_table_id'] . "<br>\n";
	echo _AD_COLUMN_RELATION_V_COLUMN . ":";
        echo $_GET['rel_v_column'];
	echo "</td>";
	
	echo "</tr>";
    } else {
	echo " <tr>".
	  "<td class='head'>"._AD_DEFAULT."</td><td class='even'>".(isset($_GET['default']) ? nl2br(htmlspecialchars($_GET['default'])) : '')."</td>" .
	  "</tr>";
    }
    
    if ($_GET['type'] == WAFFLE_COLUMN_INTEGER) {
    } else if ($_GET['type'] == WAFFLE_COLUMN_STRING) {
    echo " <tr>
	   <td class='head'>" . _AD_MAXLENGTH . "</td><td class='even'>".htmlspecialchars($_GET['maxlength'])."</td>
	   </tr>
	   <tr>
	   <td class='head'>" . _AD_SIZE . "</td><td class='even'>".addslashes($_GET['size'])."</td>
	   </tr>";
    } else if ($_GET['type'] == WAFFLE_COLUMN_RADIO ||
	       $_GET['type'] == WAFFLE_COLUMN_SELECT) {
	echo " <tr>";
	echo " <td class='head'>" . _AD_RADIO_OPTION . "</td>";
	echo "<td class='even'>";
	for ($i=1; $i<=WAFFLE_OPTION_MAX; $i++) {
	    if (isset($_GET['option' . $i]) && $_GET['option' . $i] != '') {
		printf("%s<br>\n", addslashes($_GET['option' . $i]));
	    }
	}
	echo "</td>";
	echo "  </tr> ";
    } else if ($_GET['type'] == WAFFLE_COLUMN_TEXTAREA) {
    echo " <tr>
	   <td class='head'>" . _AD_TEXTAREA_MAXLENGTH . "</td><td class='even'>".addslashes($_GET['maxlength'])."</td>
	   </tr>
	   <tr>
	   <td class='head'>" . _AD_TEXTAREA_ROWS. "</td><td class='even'>".intval($_GET['rows'])."</td>
	   </tr>
	   <tr>
	   <td class='head'>" . _AD_TEXTAREA_COLS. "</td><td class='even'>".intval($_GET['cols'])."</td>
	   </tr>";
    }
    if ($_GET['type'] != WAFFLE_COLUMN_RELATION) {
	echo " <tr>
	   <td class='head'>" . _AD_STRING_NOT_NULL . "</td><td class='even'>" . (isset($_GET['not_null']) && $_GET['not_null'] ? 1 : 0). "</td>
	   </tr>
	   <tr>
	   <td class='head'>" . _AD_STRING_UNIQ . "</td><td class='even'>" . (isset($_GET['uniq']) && $_GET['uniq'] ? 1 : 0). "</td>
	   </tr>";
    }
    
    echo "<tr><td class='head'> </td><td class='even'>";
    echo "	<input type='hidden' name='op' value='add_column_4' />
		<input type='hidden' name='table_id' value='".addslashes($_GET['table_id'])."' />
		<input type='hidden' name='type' value='".addslashes($_GET['type'])."' />
		<input type='hidden' name='name' value='".$myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['name']))."' />";
    echo "      <input type='hidden' name='default' value='".(isset($default) ? addslashes($default) : '')."' />
		<input type='hidden' name='not_null' value='".(isset($_GET['not_null']) && $_GET['not_null'] ? 1 : 0)."' />
                <input type='hidden' name='uniq' value='".(isset($_GET['uniq']) && $_GET['uniq'] ? 1 : 0)."' />";
    echo "      <input type='hidden' name='maxlength' value='".(isset($_GET['maxlength']) ? addslashes($_GET['maxlength']) : 0)."' />";
    echo "      <input type='hidden' name='rows' value='".(isset($_GET['rows']) ? addslashes($_GET['rows']) : 0)."' />";
    echo "      <input type='hidden' name='cols' value='".(isset($_GET['cols']) ? addslashes($_GET['cols']) : 0 )."' />";
    echo "      <input type='hidden' name='rel_table_id' value='".(isset($_GET['rel_table_id']) ? addslashes($_GET['rel_table_id']) : '')."' />";
    echo "      <input type='hidden' name='rel_v_column' value='".(isset($_GET['rel_v_column']) ? addslashes($_GET['rel_v_column']) : '')."' />";
    
    for ($i=1; $i<=WAFFLE_OPTION_MAX; $i++) {
	if (isset($_GET['option' . $i]) && $_GET['option' . $i] != '') {
	    printf("<input type='hidden' name='option%d' value='%s'>\n",
		   $i, $myts->htmlSpecialChars($myts->stripSlashesGPC($_GET['option' . $i]))
		   );
	}
    }
    
    echo "<input type='hidden' name='size' value='".(isset($_GET['size']) ? addslashes($_GET['size']) : 0)."' />\n";
    echo "<input type='submit' name='submit' value='" . _SUBMIT . "' /></form>";
    echo "</td></tr>";
    echo  "</table>";
    
}

function waffle_admin_add_column_4()
{
    global $xoopsDB;
    global $no2dbtype;
    global $search_column;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $t_table = $GLOBALS['waffle_mydirname'].'_data' . intval($_GET['table_id']);
    $column = WaffleMAP::new_with_cache($y);
    
    $column_name = 't' . intval($_GET['table_id']) . '_c' . WaffleMAP::get_config_inc('data' . intval($_GET['table_id']) .  '_index');
    
    if (isset($search_column[$_GET['type']]) && $search_column[$_GET['type']]) {
	$search = 1;
    } else {
	$search = 0;
    }

    $a = array(
	       'table_id' => intval($_GET['table_id']),
	       'name' => $column_name,
	       'desc' => $_GET['name'],
	       'type' => $_GET['type'],
	       'valid' => 1,
	       'uniq' => intval($_GET['uniq']),
	       'order' => 100,
	       'fixed' => 0,
	       'default' => $_GET['default'],
	       'primary_key' => 0,
	       'serial' => 0,
	       'maxlength' => $_GET['maxlength'],
	       'size' => $_GET['size'],
	       'rows' => $_GET['rows'],
	       'cols' => $_GET['cols'],
	       'detailview' => 1,
	       'insertview' => 1,
	       'updateview' => 1,
	       'listview' => 1,
	       'updatable' => 1,
	       'search' => $search,
	       'not_null' => intval($_GET['not_null']),
	       'rel_table' => $GLOBALS['waffle_mydirname'] . '_data' . $_GET['rel_table_id'],
	       'rel_column' => 't' . $_GET['rel_table_id'] . '_id',
	       'rel_v_column' => $_GET['rel_v_column']
	       );
    $column->insert($a);

    if ($_GET['type'] == WAFFLE_COLUMN_RADIO ||
	$_GET['type'] == WAFFLE_COLUMN_SELECT) {
	$column_id = $xoopsDB->getInsertId();
	
	$y = $GLOBALS['waffle_mydirname'].'_option.yml';
	$option = WaffleMAP::new_with_cache($y);
	
	for ($i=1; $i<=WAFFLE_OPTION_MAX; $i++) {
	    if (isset($_GET['option' . $i]) && $_GET['option' . $i] != '') {
		$o = array(
			   'column_id' => $column_id,
			   'name' => $_GET['option' . $i]
			   );
		$option->insert($o);
	    }
	}
    }
    
    $sql = 'ALTER TABLE ' . $xoopsDB->prefix($t_table) . ' ADD COLUMN ' . addslashes($column_name) . ' ' . $no2dbtype[$_GET['type']];

    $xoopsDB->queryF($sql);

    $yaml_data = waffle_db2yaml($_GET['table_id']);
    WaffleMAP::set_config($t_table . '.yml', $yaml_data);
    
    ob_clean();
    redirect_header('index.php?op=edit_table&id=' . $_GET['table_id'],
		    2, _AD_ADDED_COLUMN);
    exit();
}

function waffle_admin_delete_column()
{
    global $no2type;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $c = $column->get_row(intval($_GET['column_id']));
    
    echo _AD_DELETE_COLUMN_OK;
    echo "<form>
	   <table border='0' cellpadding='0' cellspacing='1' width='70%' class='outer'>
	   <tr class='odd'>
	   <th>名前</th><td>".addslashes($c['name'])."</td>
	   </tr>
	   <tr class='odd'>
	   <th>概要</th><td>".addslashes($c['desc'])."</td>
	   </tr>
	   <tr class='odd'>
	   <th>型</th><td>" . constant('_AD_COLUMN_' . strtoupper($no2type[$c['type']])) . "</td>
	   </tr>";

    echo " <tr class='odd'>
	   <th>"._AD_DEFAULT."</th><td>".addslashes($c['default'])."</td>
	   </tr>";
    
    if ($c['type'] == 1) {
    echo " <tr class='odd'>
	   <th>最大文字数</th><td>".addslashes($c['maxlength'])."</td>
	   </tr class='odd'>
	   <tr class='odd'>
	   <th>入力フィールドサイズ</th><td>".addslashes($c['size'])."</td>
	   </tr>";
    } else if ($c['type'] == 2) {
    echo " <tr class='odd'>
	   <th>最大文字数</th><td>".addslashes($c['maxlength'])."</td>
	   </tr class='odd'>
	   <tr class='odd'>
	   <th>入力フィールドサイズ</th><td>".addslashes($c['size'])."</td>
	   </tr>";
    }
    echo "							  
	   <tr class='odd'>
	   <th>not null</th><td>1</td>
	   </tr>
	   <tr class='odd'>
	   <th>uniq</th><td>0</td>
	   </tr>
	   </table>
        <div align='center'>
		<input type='hidden' name='op' value='delete_column_2' />
		<input type='hidden' name='table_id' value='" . $_GET['table_id']. "' />
		<input type='hidden' name='column_id' value='" . $_GET['column_id']. "' />
		<input type='submit' name='submit' value='" . _SUBMIT . "' />
        </div>
    </form>
    ";
    echo "";
}

function waffle_admin_delete_column_2()
{
    global $no2type;
    global $xoopsDB;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    
    $c = $column->get_row($_GET['column_id']);
    
    $column->delete_one($_GET['column_id']);
    
    $yaml_data = waffle_db2yaml($_GET['table_id']);
    $t_table = $GLOBALS['waffle_mydirname'].'_data' . $_GET['table_id'];
    WaffleMAP::set_config($t_table . '.yml', $yaml_data);
    
    $t_table = $GLOBALS['waffle_mydirname'].'_data' . intval($_GET['table_id']);
    $sql = 'ALTER TABLE ' . $xoopsDB->prefix($t_table) . ' DROP COLUMN `' . addslashes($c['name']) . '`';

    $xoopsDB->queryF($sql);
    
    ob_clean();
    redirect_header('index.php?op=edit_table&id=' . $_GET['table_id'],
		    2, _AD_DELETED);
    exit();
}

function waffle_admin_edit_column_url()
{
    waffle_admin_edit_column_string();
}

function waffle_admin_edit_column_email()
{
    waffle_admin_edit_column_string();
}

function waffle_admin_edit_column_string()
{
    global $no2type;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $c = $column->get_row($_GET['column_id']);

    echo '"' . htmlspecialchars($c['desc']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$c['type']])) . '<br /><br />';

    echo "<form action='index.php'>\n
	<input type=hidden name=op value='edit_column_string_2'>
	<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>
	<input type=hidden name=type value='".addslashes($_GET['type'])."'>
	<input type=hidden name=column_id value='".addslashes($_GET['column_id'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr><th colspan=2 align='center'>" . _AD_EDIT_COLUMN. "</th></tr>\n";
    echo "<tr><td class='head'>" . _AD_STRING_MAXLENGTH . "</td>".
         "<td class='even'><input type=text name=maxlength value='" . intval($c['maxlength']). "'></td></tr>" .
         "<tr><td class='head'>" . _AD_STRING_SIZE . "</td>".
         "<td class='even'><input type=text name=size value='" . intval($c['size']) . "'></td></tr>" .
         "<tr><td class='head'> </td><td class='even'>
	   <input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_edit_column_string_2()
{
    global $no2type;
    
    $a = array(
	       'id' => $_GET['column_id'],
	       'maxlength' => $_GET['maxlength'],
	       'size' => $_GET['size']
	       );
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $column->update_one($a);
    
    waffle_admin_yaml_update($_GET['table_id']);
    
    ob_clean();
    redirect_header('index.php?op=edit_table&id=' . $_GET['table_id'],
		    2, _AD_UPDATED);
    exit();
}

function waffle_admin_edit_column_htmltext()
{
    waffle_admin_edit_column_textarea();
}

function waffle_admin_edit_column_php_code()
{
    waffle_admin_edit_column_textarea();
}

function waffle_admin_edit_column_textarea()
{
    global $no2type;
    global $myts;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $c = $column->get_row($_GET['column_id']);

    echo '"' . htmlspecialchars($c['desc']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$c['type']])) . '<br /><br />';

    echo "<form action='index.php'>\n" .
	"<input type=hidden name=op value='edit_column_textarea_2'>\n" .
	"<input type=hidden name=table_id value='".addslashes($_GET['table_id'])."'>".
        "<input type=hidden name=column_id value='".addslashes($_GET['column_id'])."'>".
        "<input type=hidden name=type value='".addslashes($_GET['type'])."'>\n";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr class='odd'><th>" . _AD_DEFAULT . "</th>\n";
    echo "<td><textarea name='default'>" . $myts->htmlSpecialChars($myts->stripSlashesGPC($c['default'])) . "</textarea></td></tr>\n";

    echo "<tr class='odd'><th>" . _AD_TEXTAREA_MAXLENGTH . "</th>\n".
        "<td><input type=text name=maxlength value='" . intval($c['maxlength']). "'></td></tr>\n" .
      "<tr class='odd'><th>" . _AD_TEXTAREA_ROWS . "</th>\n".
      "<td><input type=text name=rows value='" . intval($c['rows']) . "'></td></tr>\n" .
      "<tr class='odd'><th>" . _AD_TEXTAREA_COLS . "</th>\n".
      "<td><input type=text name=cols value='" . intval($c['cols']) . "'></td></tr>\n" .
      "	<tr  class='odd'><th> </th><td>\n" .
      "<input type='submit' value='"._AD_CONFIRM."'>
	   </form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_edit_column_textarea_2()
{
    global $no2type;
    
    $a = array(
	       'id' => $_GET['column_id'],
	       'default' => $_GET['default'],
	       'maxlength' => $_GET['maxlength'],
	       'rows' => $_GET['rows'],
	       'cols' => $_GET['cols']
	       );
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $column->update_one($a);
    
    waffle_admin_yaml_update($_GET['table_id']);
    
    ob_clean();
    redirect_header('index.php?op=edit_table&id=' . $_GET['table_id'],
		    2, _AD_UPDATED);
    exit();
}

function waffle_admin_edit_column_select()
{
    waffle_admin_edit_column_radio();
}

function waffle_admin_edit_column_radio()
{
    global $no2type;
    global $myts;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $c = $column->get_row($_GET['column_id']);
    
    $y = $GLOBALS['waffle_mydirname'].'_option.yml';
    $option = WaffleMAP::new_with_cache($y);
    
    if (isset($_GET['delete_option_id'])) {
	$option->delete_one($_GET['delete_option_id']);
    }
    
    $o = $option->get_all('column_id = ' . intval($c['id']));
    
    echo '"' . htmlspecialchars($c['desc']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>" .
      "<input type=hidden name=type value='".$_GET['type']."'>" .
      "<input type=hidden name=op value='edit_column_radio_2'>".
      "<input type=hidden name=table_id value='".intval($_GET['table_id'])."'>".
      "<input type=hidden name=column_id value='".intval($_GET['column_id'])."'>
" .
      "<input type=hidden name=type value='".intval($_GET['type'])."'>";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr class='odd'><th>" . _AD_RADIO_OPTION . "</th>" .
	"<td>";
    
    foreach ($o as $key => $val) {
//	printf("<input type='radio' name='default' value='%d'%s>", $key + 1, ($c['default'] == ($key + 1) ? ' checked' :''));
	printf("<input type='text' name='option%d' value='%s' maxlength='255'>", $key + 1, $myts->htmlSpecialChars($myts->stripSlashesGPC($val['name'])));
	printf("<input type='hidden' name='option_id%d' value='%s' >", $key + 1, intval($val['id']));
//	printf("<a href='index.php?op=edit_column_radio&type=%d&table_id=%d&column_id=%d&delete_option_id=%d'>%s</a>", $_GET['type'], $_GET['table_id'], $_GET['column_id'], $val['id'], _AD_DELETE);
	printf("<br>\n");
    }
    
    printf("<a href='index.php?op=edit_column_radio_add_option&table_id=%d&column_id=%d&type=%d'>%s</a> | ", intval($_GET['table_id']), intval($_GET['column_id']), intval($_GET['type']), _AD_RADIO_ADD_OPTION);
    printf("<a href='index.php?op=edit_column_radio_delete_option&table_id=%d&column_id=%d&type=%d'>%s</a>", intval($_GET['table_id']), intval($_GET['column_id']), intval($_GET['type']), _AD_RADIO_DELETE_OPTION);
    echo "</td></tr>";
    
    echo "<tr  class='odd'><th> </th><td>".
      "<input type='submit' value='"._AD_UPDATE."'>".
      "</form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_edit_column_radio_2()
{
    global $no2type;
    global $myts;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    
    $y = $GLOBALS['waffle_mydirname'].'_option.yml';
    $option = WaffleMAP::new_with_cache($y);
    $o = $option->get_all('column_id = ' . intval($_GET['column_id']), 'id');
    
    $a = array('id' => intval($_GET['column_id']));
//    $a = array('id' => intval($_GET['column_id']),
//	       'default' => intval($_GET['default']),
//	       );
    $column->update_one($a);

    foreach ($o as $key => $val) {
	if (isset($_GET['option' . ($key + 1)]) == false) {
	    continue;
	}
	
	$a = array('id' => $_GET['option_id' . ($key + 1)],
		   'name' => $_GET['option' . ($key + 1)]
		   );
	$option->update_one($a);
    }
    
    ob_clean();
    redirect_header('index.php?op=edit_table&id=' . $_GET['table_id'],
		    2, _AD_UPDATED);
    exit();
}

function waffle_admin_edit_column_radio_delete_option()
{
    global $no2type;
    global $myts;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $c = $column->get_row($_GET['column_id']);
    
    $y = $GLOBALS['waffle_mydirname'].'_option.yml';
    $option = WaffleMAP::new_with_cache($y);
    
    if (isset($_GET['delete_option_id'])) {
	$option->delete_one($_GET['delete_option_id']);
    }
    
    $o = $option->get_all('column_id = ' . intval($c['id']));
    
    echo '"' . htmlspecialchars($c['desc']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo _AD_SELECT_DELETE_OPTION;
    echo "<form action='index.php'>" .
      "<input type=hidden name=type value='".$_GET['type']."'>" .
      "<input type=hidden name=op value='edit_column_radio_delete_option_2'>".
      "<input type=hidden name=table_id value='".intval($_GET['table_id'])."'>".
      "<input type=hidden name=column_id value='".intval($_GET['column_id'])."'>
" .
      "<input type=hidden name=type value='".intval($_GET['type'])."'>";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr class='odd'><th>" . _AD_RADIO_OPTION . "</th>" .
	"<td>";
    
    foreach ($o as $key => $val) {
	printf("<input type='checkbox' name='option%d' value='%d'>", $key + 1, $val['id']);
	print $myts->htmlSpecialChars($myts->stripSlashesGPC($val['name']));
	printf("<br>\n");
    }
    
//    printf("<a href='index.php?op=edit_column_radio_add_option&table_id=%d&column_id=%d&type=%d'>%s</a>", intval($_GET['table_id']), intval($_GET['column_id']), intval($_GET['type']), _AD_RADIO_ADD_OPTION);
//    printf("<a href='index.php?op=edit_column_radio_delete_option&table_id=%d&column_id=%d&type=%d'>%s</a>", intval($_GET['table_id']), intval($_GET['column_id']), intval($_GET['type']), _AD_RADIO_DELETE_OPTION);
    echo "</td></tr>";
    
    echo "<tr  class='odd'><th> </th><td>".
      "<input type='submit' value='"._AD_UPDATE."'>".
      "</form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_edit_column_radio_delete_option_2()
{
    global $no2type;
    global $myts;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    
    $y = $GLOBALS['waffle_mydirname'].'_option.yml';
    $option = WaffleMAP::new_with_cache($y);
    $o = $option->get_all('column_id = ' . intval($_GET['column_id']), 'id');
    
    $a = array('id' => intval($_GET['column_id']));
//    $a = array('id' => intval($_GET['column_id']),
//	       'default' => intval($_GET['default']),
//	       );
    $column->update_one($a);

    for ($i=0; $i<WAFFLE_OPTION_MAX; $i++) {
	if (isset($_GET['option' . $i]) == false) {
	    continue;
	}
	
	$option->delete_one($_GET['option' . $i]);
    }
    
    ob_clean();
    redirect_header('index.php?op=edit_table&id=' . $_GET['table_id'],
		    2, _AD_DELETED);
    exit();
}

function waffle_admin_edit_column_radio_add_option()
{
    global $no2type;
    global $myts;
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $c = $column->get_row($_GET['column_id']);
    
    $y = $GLOBALS['waffle_mydirname'].'_option.yml';
    $option = WaffleMAP::new_with_cache($y);
    $o = $option->get_all('column_id = ' . intval($c['id']));
    
    echo '"' . htmlspecialchars($c['desc']). '"' . ":" . constant('_AD_COLUMN_' . strtoupper($no2type[$_GET['type']])) . '<br /><br />';
    echo "<form action='index.php'>
	<input type=hidden name=type value='".$_GET['type']."'>
	<input type=hidden name=op value='edit_column_radio_add_option_2'>
	<input type=hidden name=table_id value='".intval($_GET['table_id'])."'>
	<input type=hidden name=column_id value='".intval($_GET['column_id'])."'>
	<input type=hidden name=type value='".intval($_GET['type'])."'>
	   ";

    echo "<table border='0' cellpadding='0' cellspacing='1' width='90%' class='outer'>\n";
    echo "<tr class='odd'><th>" . _AD_RADIO_OPTION . "</th>" .
	"<td>";
    
    for ($i=0; $i<=20; $i++) {
	printf("<input type='text' name='option%d' value='' maxlength='255'><br>\n", $i);
    }
    
    echo "</td></tr>";
    
    echo "<tr  class='odd'><th> </th><td>".
      "<input type='submit' value='"._AD_ADD."'>".
      "</form></td></tr>";
    
    echo "</table>";
}

function waffle_admin_edit_column_radio_add_option_2()
{
    global $no2type;
    global $myts;
    
    $y = $GLOBALS['waffle_mydirname'].'_option.yml';
    $option = WaffleMAP::new_with_cache($y);
    $o = $option->get_all('column_id = ' . intval($_GET['column_id']), 'id');
    
    for ($i=0; $i<=20; $i++) {
	if ($_GET['option' . ($i)] == '') {
	    continue;
	}

	$a = array('column_id' => intval($_GET['column_id']),
		   'name' => $_GET['option' . ($i)]);
	$option->insert($a);
    }
    
    waffle_admin_yaml_update($_GET['table_id']);
    
    ob_clean();
    redirect_header('index.php?op=edit_table&id=' . $_GET['table_id'],
		    2, _AD_ADDED);
    exit();
}

?>
