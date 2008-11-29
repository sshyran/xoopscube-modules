<?php

function waffle_admin_rss()
{
    $y = $GLOBALS['waffle_mydirname'].'_table.yml';
    $table = WaffleMAP::new_with_cache($y);

    if (isset($_GET['rss_title']) && isset($_GET['id'])) {
	$ar = array();
	$ar['id']               = $_GET['id'];
	$ar['rss_title']        = $_GET['rss_title'];
	$ar['rss_top_url']      = $_GET['rss_top_url'];
	$ar['rss_summary']      = $_GET['rss_summary'];
	$ar['rss_url_column']   = $_GET['rss_url_column'];
	$ar['rss_title_column'] = $_GET['rss_title_column'];
	$ar['rss_body_column']  = $_GET['rss_body_column'];
	
	$table->update($ar);
    }
    
    $t = $table->get_row(intval($_GET['id']));
    
    $y = $GLOBALS['waffle_mydirname'].'_column.yml';
    $column = WaffleMAP::new_with_cache($y);
    $c = $column->get_all('table_id = ' . intval($_GET['id']), 'order');
    
    print '<form>';
    print _AD_RSS_SETTING . ':' . htmlspecialchars($t['name']);
    print '<br>';
    print '<br>';
    print "<table border='0' cellpadding='0' cellspacing='1' width='70%' class='outer'>\n";
    print "<tr>\n";
    print "<th colspan='2'>"._AD_RSS_SETTING."</th>\n";
    print "</tr>\n";
    
    print "<tr class='top'><td class='head'>" . _AD_RSS_TITLE . "</td><td class='even'><input type='text' name='rss_title' value='".htmlspecialchars($t['rss_title'])."'></td>\n";
    print "<tr class='top'><td class='head'>" . _AD_RSS_TOP_URL . "</td><td class='even'><input type='text' name='rss_top_url' value='".htmlspecialchars($t['rss_top_url'])."'></td>\n";
    print "<tr class='top'><td class='head'>" . _AD_RSS_SUMMARY . "</td><td class='even'><input type='text' name='rss_summary' value='".htmlspecialchars($t['rss_summary'])."'></td>\n";
    print "<tr class='top'><td class='head'>" . _AD_RSS_ITEM_SETTING . "</td><td class='even'></td>\n";

    print "<tr class='top'><td class='head'>" . _AD_RSS_ITEM_URL . "</td><td class='even'>";
    print "<select name='rss_url_column'>\n";
    print "<option value=''>" . _AD_DEFAULT_SETTING . "\n";
    foreach ($c as $key => $val) {
	print "<option value='" . $val['name'] . "'";
	if ($val['name'] == $t['rss_url_column']) {
	    print " selected";
	}
	print ">" . $val['name'] . "(" . ($val['desc']) . ")\n";
    }
    print "</select>\n";
    print "</td>\n";
    
    print "<tr class='top'><td class='head'>" . _AD_RSS_ITEM_TITLE . "</td><td class='even'>";
    print "<select name='rss_title_column'>\n";
    print "<option value=''>" . _AD_DEFAULT_SETTING . "\n";
    foreach ($c as $key => $val) {
	print "<option value='" . $val['name'] . "'";
	if ($val['name'] == $t['rss_title_column']) {
	    print " selected";
	}
	print ">" . $val['name'] . "(" . ($val['desc']) . ")\n";
    }
    print "</select>\n";

    print "</td>\n";
    print "<tr class='top'><td class='head'>" . _AD_RSS_ITEM_BODY . "</td><td class='even'>";
    print "<select name='rss_body_column'>\n";
    print "<option value=''>" . _AD_DEFAULT_SETTING . "\n";
    foreach ($c as $key => $val) {
	print "<option value='" . $val['name'] . "'";
	if ($val['name'] == $t['rss_body_column']) {
	    print " selected";
	}
	print ">" . $val['name'] . "(" . ($val['desc']) . ")\n";
    }
    print "</select>\n";

    print "</td>\n";
    
    print "</tr>\n";
    print "<tr class='top'><td class='head'> </td><td class='even'>\n";
    print "<input type='hidden' name='op' value='rss'>\n";
    print "<input type='hidden' name='id' value='" . intval($_GET['id']) . "'>\n";
    print "<input type='reset' name=''> ";
    print "<input type='submit' name=''>\n";
    print "</td></tr>\n";
    print "</table>\n";
    print '</form>';
}

?>
