<?php

function b_cubookmarken_block_singletag($options)
{
	$myts =& MyTextSanitizer::getInstance();
	$ret = array();

	//Menu
	if(! $options[0]){
		$options[0] = 5;
	}
	$bmHandler =& xoops_getmodulehandler('bm', 'cubookmarken');
	global $xoopsDB;
	if($options[1]){
		$sql = "SELECT b.*, t.tag_name, t.bm_id FROM ".$xoopsDB->prefix('cubookmarken_bm') ." b LEFT JOIN ". $xoopsDB->prefix('cubookmarken_tag') ." t ON t.bm_id=b.bm_id WHERE t.tag_name='". $myts->makeTboxData4Show($options[1]) ."' ORDER BY b.reg_unixtime DESC LIMIT ". intval($options[0]);
	
		$result = $bmHandler->db->query($sql);
		if (!$result) {
			return $ret;
		}
	
		while($row = $bmHandler->db->fetchArray($result)) {
			$obj =& new $bmHandler->mClass();
			$obj->assignVars($row);
			$obj->loadTag();
			$obj->unsetNew();
		
			$ret[]=&$obj;
			unset($obj);
		}
	}

	return $ret;
}


function b_cubookmarken_block_singletag_edit( $options )
{
	$tagHandler =& xoops_getmodulehandler('tag', 'cubookmarken');
	$tags =& $tagHandler->getObjects();
	foreach(array_keys($tags) as $keyT){
		$tagName[$keyT] = $tags[$keyT]->getShow('tag_name');
	}
	$tagNames = array_unique($tagName);
	
	$form = "
		<p>
		<label for='dispNum'>"._MB_CUBOOKMARKEN_LANG_DISPLAY_NUMBER."</label>&nbsp;:
		<input type='text' size='5' name='options[0]' id='dispNum' value='".$options[0]."' />\n
		</p>\n
		<p>
		<label for='tag'>"._MB_CUBOOKMARKEN_LANG_TAG."</label>&nbsp;:
		<select name='options[1]'>\n";
		foreach(array_keys($tagNames) as $key){
	        $form .= "<option value='".$tagNames[$key]."'";
	        if($tagNames[$key] == $options[1]){
		       $form .= " selected='selected'";
		    }
			$form .= '>'. $tagNames[$key] ."</option>\n";
		}
		$form.="</select></p>
	\n" ;

	return $form;
}

?>
