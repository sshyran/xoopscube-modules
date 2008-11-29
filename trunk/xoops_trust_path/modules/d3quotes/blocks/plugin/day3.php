<?php

function mq_plugin($param,$mq_input,$mydirname = 'd3quotes') {

	if (isset($_SERVER["HTTPS"]) && stristr($_SERVER["HTTPS"], "on")) {
		$urlhead = "https://";
	} else {
		$urlhead = "http://";
	}
	$redirecturl = dirname($urlhead . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) . '/modules/'.$mydirname.'/index.php?page=redirect';

	$rtn['textoIn']="";
	if (empty($mq_input[0]))
		 $rtn['autorIn'] = " ".date($param[0]);
	else
		$rtn['autorIn'] = " ".$mq_input[0].$param[1].$mq_input[1].$param[2];
	if ($mq_input[1]==99)
		$rtn['autorIn'] = " ".$mq_input[0].$param[1]." ";
	if (substr($rtn['autorIn'],0,3) ==" 12" || 
		substr($rtn['autorIn'],0,3)==" 10" ||
		substr($rtn['autorIn'],0,3)==" 11")
		$rtn['autorIn'] = ltrim($rtn['autorIn']);
	$rtn['textoOut']="";
	$rtn['autorOut']="99/99";

	//$rtn['form'] = "<form name='form' action='http://your_site/modules/d3quotes/index.php?page=redirect' method='post'><font color='#0066ff'>".$param[3]."</font>&nbsp;".$param[1]."<select name='mq_input[0]'>";
	$rtn['form'] = "<form name='form' action='".$redirecturl."' method='post'><font color='#0066ff'>".$param[3]."</font>&nbsp;".$param[1]."<select name='mq_input[0]'>";
	for ($i=1;$i<=12;$i++) {
		if (empty($mq_input['0'])) {
			if ($i==1)
				$selected = "selected";
			else
				$selected = "";
		} else {
			if ($mq_input[0]==$i)
				$selected = "selected";
			else
				$selected = "";
		}
		$rtn['form'] .= "<option value='".$i."' ".$selected.">".$i;
	}
	$rtn['form'] .= "</select>&nbsp;".$param[2]."<select name='mq_input[1]'>";
	for ($i=1;$i<=31;$i++) {
		if (empty($mq_input['1'])) {
			if ($i==1)
				$selected = "selected";
			else
				$selected = "";
		} else {
			if ($mq_input[1]==$i)
				$selected = "selected";
			else
				$selected = "";
		}
		$rtn['form'] .= "<option value='".$i."' ".$selected.">".$i;
	}
	if ($mq_input[1]==99)
		$rtn['form'] .= "<option value='99' selected>99";
	else
		$rtn['form'] .= "<option value='99'>99";
	$rtn['form'] .= "</select><input type='submit' value='send'></form>";

	return $rtn;
}
?>