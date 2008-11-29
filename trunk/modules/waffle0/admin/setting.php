<?php

function waffle_admin_setting()
{

    if (isset($_GET[WAFFLE_IMAGE_MAX_X])) {
	WaffleMAP::set_config(WAFFLE_IMAGE_MAX_X, intval($_GET[WAFFLE_IMAGE_MAX_X]));
	WaffleMAP::set_config(WAFFLE_IMAGE_MAX_Y, intval($_GET[WAFFLE_IMAGE_MAX_Y]));
	WaffleMAP::set_config(WAFFLE_IMAGE_MAX_FILESIZE, intval($_GET[WAFFLE_IMAGE_MAX_FILESIZE]));
	WaffleMAP::set_config(WAFFLE_IMAGE_VIEW_MAX_SIZE, intval($_GET[WAFFLE_IMAGE_VIEW_MAX_SIZE]));
	if (isset($_GET[WAFFLE_SETTING_USE_ADMIN_MAIL])) {
	    WaffleMAP::set_config(WAFFLE_SETTING_USE_ADMIN_MAIL, 1);
	} else {
	    WaffleMAP::set_config(WAFFLE_SETTING_USE_ADMIN_MAIL, 0);
	}
	if (isset($_GET[WAFFLE_ONE_TABLE_TO_LIST])) {
	    WaffleMAP::set_config(WAFFLE_ONE_TABLE_TO_LIST, 1);
	} else {
	    WaffleMAP::set_config(WAFFLE_ONE_TABLE_TO_LIST, 0);
	}
	
	ob_clean();
	redirect_header('index.php?op=setting', 2, _AD_UPDATED);
	exit();
	
    }
    
    $x = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_X);
    $y = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_Y);
    $size = WaffleMAP::get_config(WAFFLE_IMAGE_MAX_FILESIZE);
    $vsize = WaffleMAP::get_config(WAFFLE_IMAGE_VIEW_MAX_SIZE);
    $use_admin_mail = WaffleMAP::get_config(WAFFLE_SETTING_USE_ADMIN_MAIL);
    $one_table_to_list = WaffleMAP::get_config(WAFFLE_ONE_TABLE_TO_LIST);
    if ($x == '') {
	$x = WAFFLE_IMAGE_DEFAULT_MAX_X;
    }
    if ($y == '') {
	$y = WAFFLE_IMAGE_DEFAULT_MAX_Y;
    }
    if ($size == '') {
	$size = WAFFLE_IMAGE_DEFAULT_MAX_FILESIZE;
    }
    if ($vsize == '') {
	$vsize = WAFFLE_IMAGE_DEFAULT_VIEW_MAX_SIZE;
    }
    
    print '<form>';
    print _AD_SETTING;
    print '<br>';
    print '<br>';
    print "<table border='0' cellpadding='0' cellspacing='1' width='70%' class='outer'>\n";
    print "<tr>\n";
    print "<th colspan='2'>"._AD_GENERAL_SETTING."</th>\n";
    print "</tr>\n";
    
    print "<tr class='top'><td class='head'>" . _AD_IMAGE_MAX_X . "</td><td class='even'><input type='text' name='" . WAFFLE_IMAGE_MAX_X . "' value='".intval($x)."'></td>\n";
    print "<tr class='top'><td class='head'>" . _AD_IMAGE_MAX_Y . "</td><td class='even'><input type='text' name='" . WAFFLE_IMAGE_MAX_Y . "' value='".intval($y)."'></td>\n";
    print "<tr class='top'><td class='head'>" . _AD_IMAGE_MAX_FILESIZE . "</td><td class='even'><input type='text' name='" . WAFFLE_IMAGE_MAX_FILESIZE . "' value='".intval($size)."'></td>\n";
    print "<tr class='top'><td class='head'>" . _AD_IMAGE_VIEW_MAX_SIZE . "</td><td class='even'><input type='text' name='" . WAFFLE_IMAGE_VIEW_MAX_SIZE . "' value='".intval($vsize)."'></td>\n";
    print "<tr class='top'><td class='head'> </td><td class='even'><input type='checkbox' name='" . WAFFLE_SETTING_USE_ADMIN_MAIL . "' ".(isset($use_admin_mail) && $use_admin_mail ? 'checked' : '').">" . _AD_SETTING_USE_ADMIN_MAIL . "<br>";
    print "<input type='checkbox' name='" . WAFFLE_ONE_TABLE_TO_LIST . "' ".(isset($one_table_to_list) && $one_table_to_list ? 'checked' : '').">" . _AD_ONE_TABLE_TO_LIST;
    print "</td>\n";
    
    print "</tr>\n";
    print "<tr class='top'><td class='head'> </td><td class='even'>\n";
    print "<input type='hidden' name='op' value='setting'>\n";
    print "<input type='reset' name=''> ";
    print "<input type='submit' name=''>\n";
    print "</td></tr>\n";
    print "</table>\n";
    print "</form>\n";
}

?>
