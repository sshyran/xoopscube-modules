<?php
include_once "admin_header.php";

$DataForConfig = array('SHOW_DAY','SHOW_YESTERDAY','SHOW_WEEK','SHOW_MONTH','SHOW_AVE','MAX_WIDTH','IP_INTERVAL','LOG_LIMIT');

foreach ($DataForConfig as $key) {
	if (!preg_match('/^[A-Za-z0-9\-_]+$/', $key)) { exit(); }
	if (isset($_POST[$key]) && ($_POST[$key] != $CONF[$key])) {
		$CONF[$key] = intval($_POST[$key]);
		$sql = "UPDATE ".$xoopsDB->prefix('logcounterx_cfg')." SET cfgvalue = '${CONF[$key]}' WHERE cfgname = '$key'";
		$res = $xoopsDB->queryF($sql);
	}
}

print	'<h3>'._LCX_ADM_GENCONF.'</h3>
		<hr />
		<br />
		<form name="form1" method="post" action="genadm.php" style="margin-bottom:0;">'.
		'<table class="outer"><tr><th colspan="2">'._LCX_ADM_GENCONF.'</th></tr>';

print_input_area ('SHOW_DAY',		$CONF['SHOW_DAY'],	_LCX_ADM_DAY_NAME,	_LCX_ADM_DAY_DESC,	'yesno');
print_input_area ('SHOW_YESTERDAY',	$CONF['SHOW_YESTERDAY'],_LCX_ADM_YDAY_NAME,	_LCX_ADM_YDAY_DESC,	'yesno');
print_input_area ('SHOW_WEEK',		$CONF['SHOW_WEEK'],	_LCX_ADM_WEEK_NAME,	_LCX_ADM_WEEK_DESC,	'yesno');
print_input_area ('SHOW_MONTH',		$CONF['SHOW_MONTH'],	_LCX_ADM_MONTH_NAME,	_LCX_ADM_MONTH_DESC,	'yesno');
print_input_area ('SHOW_AVE',		$CONF['SHOW_AVE'],	_LCX_ADM_AVE_NAME,	_LCX_ADM_AVE_DESC,	'yesno');
print_input_area ('MAX_WIDTH',		$CONF['MAX_WIDTH'],	_LCX_ADM_MAXWIDTH_NAME,	_LCX_ADM_MAXWIDTH_DESC,	'text');
print_input_area ('IP_INTERVAL',	$CONF['IP_INTERVAL'],	_LCX_ADM_IPIT_NAME,	_LCX_ADM_IPIT_DESC,	'text');
print_input_area ('LOG_LIMIT',		$CONF['LOG_LIMIT'],	_LCX_ADM_LOGLIM_NAME,	_LCX_ADM_LOGLIM_DESC,	'text');

print	'<tr valign="top" align="left">'.
        '<td colspan="2" class="foot"><input type="submit" value="'. _SUBMIT.'" />'.
		'</td></tr>'.
        '</table></form>';

include_once "admin_footer.php";

function print_input_area($nam, $val, $ttl, $dsc, $typ) {
	print	'<tr><td class="head" width="40%">'.$ttl.'<br />'."\n".
			''.$dsc.'</td><td class="even">'."\n";
	if ($typ == 'yesno') {
		if ($val) {
			print	'<input type="radio" name="'.$nam.'" value="1" style="background-color:#00FF00;" checked="checked" />'._YES."\n";
			print	'<input type="radio" name="'.$nam.'" value="0" />'._NO."\n";
		} else {
			print	'<input type="radio" name="'.$nam.'" value="1" />'._YES."\n";
			print	'<input type="radio" name="'.$nam.'" value="0" style="background-color:#00FF00;" checked="checked" />'._NO."\n";
		}
	} else {
		print	'<input type="text" size="12" name="'.$nam.'" value="'.$val.'" />'."\n";
	}
	print	'</td></tr>'."\n";
	return 1;
}
?>