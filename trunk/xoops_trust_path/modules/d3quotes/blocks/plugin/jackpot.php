<?php
function mq_plugin($param,$mq_input) {

	srand((double)microtime()*1000000);
	$x = rand(1,$param[0]);
	
	$rtn['textoIn']="";
	if ($x==1)
		$rtn['autorIn']="JackPot";
	else
		$rtn['autorIn']="Lose";
	$rtn['textoOut']="";
	$rtn['autorOut']="Bingo";
	$rtn['form']="";

	return $rtn;
}
?>