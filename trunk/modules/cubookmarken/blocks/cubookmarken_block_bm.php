<?php

function b_cubookmarken_block_bm($options)
{
	//Menu
	if(!$options[0]){
		$options[0] = 5;
	}
	$bmCriteria = new CriteriaCompo('1', '1');
	$bmCriteria->setSort('reg_unixtime');
	$bmCriteria->setOrder('DESC');
	$bmCriteria->setLimit(intval($options[0]));
	$bmHandler =& xoops_getmodulehandler('bm', 'cubookmarken');
	$block =& $bmHandler->getObjects($bmCriteria);

	$tagHandler =& xoops_getmodulehandler('tag', 'cubookmarken');
	$tagCriteria = new CriteriaCompo('1', '1');
	foreach(array_keys($block) as $key){
		$block[$key]->mTag =& $tagHandler->getObjects(new Criteria('bm_id', $block[$key]->get('bm_id')));

	}

	return $block;
}


function b_cubookmarken_block_bm_edit( $options )
{

	$form = "
		<label for='dispNum'>"._MB_CUBOOKMARKEN_LANG_DISPLAY_NUMBER."</label>&nbsp;:
		<input type='text' size='5' name='options[0]' id='dispNum' value='".$options[0]."' />
	\n" ;

	return $form;
}

?>
