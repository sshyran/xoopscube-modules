<?php

function mq_plugin($param,$mq_input) {
	
	$rtn['textoIn']="";
	$rtn['autorIn']=" ".date($param[0]);
	if (substr($rtn['autorIn'],0,3) ==" 12" || 
		substr($rtn['autorIn'],0,3)==" 11")
		$rtn['autorIn'] = trim($rtn['autorIn']);
	$rtn['textoOut']="";
	$rtn['autorOut']="99/99";
	$rtn['form']="";

	return $rtn;
}
?>