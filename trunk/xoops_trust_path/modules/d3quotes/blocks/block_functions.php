<?php
//  ------------------------------------------------------------------------ //
//                      Random Quotes Module for                             //
//               XOOPS - PHP Content Management System 2.0                   //
//                            Version 1.0.0                                  //
//                   Copyright (c) 2002 Mario Figge                          //
//                   modified by CACHE 2005/1/11                             //
//                       http://www.zona84.com                               //
// ------------------------------------------------------------------------- //

/******************************************************************************
 * Function: b_random_d3quotes_show
 *         : $options[0] : mydirname 2007/10/29
 * Input   : $options[1] : filter words list
 *         : $options[2] : AND,OR,NOT(AND),NOT(OR),ID,MARK
 *         : $options[3] : plugin file list
 *         : $options[4] : plugin parameter
 *         : $options[5] : display articles count
 *         : $options[6] : database select
 * Output  : $texto: Text of the quote
 *           $autor: Autor of the quote
 ******************************************************************************/

function b_random_d3quotes_show($options) {

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;
	$this_template = 'db:'.$mydirname.'_random_block.html';
	require dirname(dirname(__FILE__)).'/include/configs.inc.php' ;

	$myts =& MyTextSanitizer::getInstance();

	$options[1] = $myts->undoHtmlSpecialChars($options[1]);
	$options[4] = $myts->undoHtmlSpecialChars($options[4]);
	$param=array();
	if ($options[3] != 'NONE') {
		include_once(XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/blocks/plugin/'.$options[3].'.php');
		if ($options[4])
			$param = explode(" ",$options[4]);
	}

    global $xoopsDB;

	if (empty($_SESSION['mq_input']))
		$mq_input=array();
	else
		$mq_input=$_SESSION['mq_input'];
    $block = array();
	$texto ="";
	$autor = "";

	switch($options[2]) {
		default :
			if (empty($options[1])) {
				$query = "SELECT texto,autor FROM ".$xoopsDB->prefix($options[6]);
				if ($options[3] != 'NONE') {
					$plugin=mq_plugin($param,$mq_input,$mydirname);
					$query .= " WHERE";
					if ($plugin['textoIn'])
						$query .= " texto LIKE '%".$plugin['textoIn']."%'";
					if ($plugin['autorIn']) {
						if ($plugin['textoIn'])
							$query .= " OR";
						$query .= " autor LIKE '%".$plugin['autorIn']."%'";
					}
				}
			} else {
				$query = "SELECT texto,autor FROM ".$xoopsDB->prefix($options[6]);
				$query .= " WHERE ";
				if ($options[3] != 'NONE')
					$query .= "(";
				if ($options[2]=='XAND' || $options[2]=='XOR') {
					$query .= "NOT ((";
					$andor = substr($options[2],1,strlen($options[2])-1);
				} else {
					$query .= "(";
					$andor = $options[2];
				}
				$words = explode(" ",$options[1]);
				foreach($words as $eachWord) {
					$query .= "texto LIKE '%".addslashes($eachWord)."%' ".$andor." ";
				}
				$query = substr($query,0,strlen($query)-strlen($andor)-2);
				$query .= ") OR (";
				foreach($words as $eachWord) {
					$query .= "autor LIKE '%".addslashes($eachWord)."%' ".$andor." ";
				}
				$query = substr($query,0,strlen($query)-strlen($andor)-2);
				$query .= ")";
				if ($options[2]=="XAND" || $options[2]=="XOR")
					$query .= ")";
				if ($options[3] != 'NONE') {
					$plugin=mq_plugin($param,$mq_input,$mydirname);
					$query .= ") AND (";
					if ($plugin['textoIn'])
						$query .= "texto LIKE '%".$plugin['textoIn']."%'";
					if ($plugin['autorIn']) {
						if ($plugin['textoIn'])
							$query .= " OR ";
						$query .= "autor LIKE '%".$plugin['autorIn']."%'";
					}
					$query .= ")";
				}
			}
		break;
		case 'ID' :
			$words = explode(" ",$options[1]);
			$chk_id_cnt=0;
			foreach ($words as $eachWord) {
				if (!ereg("^[0-9]+$",$eachWord))
					$chk_id_cnt++;
			}
			$query="SELECT texto, autor FROM ".$xoopsDB->prefix($options[6]);

			if ($chk_id_cnt<count($words)) {
				$query .= " WHERE (";
				foreach ($words as $eachWord) {
					if (ereg("^[0-9]+$",$eachWord))
						$query .= " id='".$eachWord."' OR";
				}
				$query = substr($query,0,strlen($query)-3);
				$query .= ")";
			}
			if ($options[3] != 'NONE') {
				$plugin=mq_plugin($param,$mq_input,$mydirname);
				if ($chk_id_flg<count($words))
					$query .= " AND (";
				else
					$query .= " WHERE (";
				if ($plugin['textoIn'])
					$query .= "texto LIKE '%".$plugin['textoIn']."%'";
				if ($plugin['autorIn']) {
					if ($plugin['textoIn'])
						$query .= " OR ";
					$query .= "autor LIKE '%".$plugin['autorIn']."%'";
				}
				$query .= ")";
			}
		break;
		case 'MARK' :
			if (is_file(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.tmp')) {
				$fp=fopen(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.tmp',"rb+");
				$rec=fgets($fp,2097152);
				fclose($fp);
				if ($rec)
					$tmp_mark=explode(",",$rec);
				else
					$tmp_mark = array();
			} else {
				$tmp_mark = array();
			}
			$query="SELECT texto, autor FROM ".$xoopsDB->prefix($options[6])." WHERE (";
			foreach ($tmp_mark as $each) {
				$query .= "id=".$each." OR ";
			}
			if (count($tmp_mark)==0)
				$query .= "id=0";
			else
				$query = substr($query,0,strlen($query)-4);
			$query .= ")";
			if ($options[3] != 'NONE') {
				$plugin=mq_plugin($param,$mq_input,$mydirname);
				$query .= " AND (";
				if ($plugin['textoIn'])
					$query .= "texto LIKE '%".$plugin['textoIn']."%'";
				if ($plugin['autorIn']) {
					if ($plugin['textoIn'])
						$query .= " OR ";
					$query .= "autor LIKE '%".$plugin['autorIn']."%'";
				}
				$query .= ")";
			}
		break;
	}
	
	$query .= " ORDER BY id";
	$result = $xoopsDB->query($query);
	if ($options[3] != 'NONE' && mysql_num_rows($result)==0) {
		$query="SELECT texto, autor FROM ".$xoopsDB->prefix($options[6]);
		if ($plugin['textoOut'] || $plugin['autorOut'])
			$query .= " WHERE";
		if ($plugin['textoOut'])
			$query .= " texto LIKE '%".$plugin['textoOut']."%'";
		if ($plugin['autorOut']) {
			if ($plugin['textoOut'])
				$query .= " OR";
			$query .= " autor LIKE '%".$plugin['autorOut']."%'";
		}
		$query .= " ORDER BY id";
		$result = $xoopsDB->query($query);
	}

	$total_rows = mysql_num_rows($result);
	if ($options[5] > $total_rows)
		$dsp_articles = $total_rows;
	else
		$dsp_articles = $options[5];

	srand((double)microtime()*1000000);
	$x = array();
	for ($i=0;$i<$dsp_articles;$i++) {
		while($y = rand(1,$total_rows)) {
			if (in_array($y,$x)===False) {
				$x[]=$y;
				break;
			}
		}
	}

	$texto = array();
	$autor = array();

	foreach($x as $y) {
		$count=0;
		mysql_data_seek($result,0);
		while($count < $y){
			list($textoOne,$autorOne) = $xoopsDB->fetchRow($result);
			$count++;
		}
		$texto[]=$textoOne;
		$autor[]=$autorOne;
	}

	$block['texto']=$texto;
	$block['autor']=$autor;
	if (empty($plugin['form']))
		$block['input'] = "";
	else
		$block['input']=$plugin['form'];

	if( empty( $options['disable_renderer'] ) ) {
		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( 'block' , $block ) ;
		$ret['content'] = $tpl->fetch( $this_template ) ;
		return $ret ;
	} else {
		return $block ;
	}
}

/******************************************************************************
 * Function: b_random_d3quotes_edit
 *         : $options[0] : mydirname 2007/10/29
 * Input   : $options[1] : filter words list
 *         : $options[2] : AND,OR,NOT(AND),NOT(OR),ID,MARK
 *         : $options[3] : plugin file list
 *         : $options[4] : plugin parameter
 *         : $options[5] : display articles count
 *         : $options[6] : database select
 * Output  : $form: options input form for block option
 ******************************************************************************/
function b_random_d3quotes_edit($options) {

    global $xoopsDB;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;
	require dirname(dirname(__FILE__)).'/include/configs.inc.php' ;

	$form = "<table width='100%' border='0' cellspacing='1' cellpadding='3'>";
	$form .= "<input type='hidden' name='options[0]' value='$options[0]' />";
	$form .= "<tr><td width='15%'>"._MB_D3QUOTES_FILTER." :</td><td width='85%'>";
	$form .= "<input type='text' name='options[1]' value='$options[1]' size='30' maxlength='255' />&nbsp;&nbsp;";
	$form .= "<select name='options[2]'>";
	switch($options[2]) {
		case 'MARK' :
			$form .= "<option value='MARK' selected>"._MB_D3QUOTES_MARK;
			$form .= "<option value='AND'>"._MB_D3QUOTES_AND;
			$form .= "<option value='OR'>"._MB_D3QUOTES_OR;
			$form .= "<option value='XAND'>"._MB_D3QUOTES_XAND;
			$form .= "<option value='XOR'>"._MB_D3QUOTES_XOR;
			$form .= "<option value='ID'>"._MB_D3QUOTES_ID;
		break;
		case 'AND' :
			$form .= "<option value='MARK'>"._MB_D3QUOTES_MARK;
			$form .= "<option value='AND' selected>"._MB_D3QUOTES_AND;
			$form .= "<option value='OR'>"._MB_D3QUOTES_OR;
			$form .= "<option value='XAND'>"._MB_D3QUOTES_XAND;
			$form .= "<option value='XOR'>"._MB_D3QUOTES_XOR;
			$form .= "<option value='ID'>"._MB_D3QUOTES_ID;
		break;
		case 'OR' :
			$form .= "<option value='MARK'>"._MB_D3QUOTES_MARK;
			$form .= "<option value='AND'>"._MB_D3QUOTES_AND;
			$form .= "<option value='OR' selected>"._MB_D3QUOTES_OR;
			$form .= "<option value='XAND'>"._MB_D3QUOTES_XAND;
			$form .= "<option value='XOR'>"._MB_D3QUOTES_XOR;
			$form .= "<option value='ID'>"._MB_D3QUOTES_ID;
		break;
		case 'XAND' :
			$form .= "<option value='MARK'>"._MB_D3QUOTES_MARK;
			$form .= "<option value='AND'>"._MB_D3QUOTES_AND;
			$form .= "<option value='OR'>"._MB_D3QUOTES_OR;
			$form .= "<option value='XAND' selected>"._MB_D3QUOTES_XAND;
			$form .= "<option value='XOR'>"._MB_D3QUOTES_XOR;
			$form .= "<option value='ID'>"._MB_D3QUOTES_ID;
		break;
		case 'XOR' :
			$form .= "<option value='MARK'>"._MB_D3QUOTES_MARK;
			$form .= "<option value='AND'>"._MB_D3QUOTES_AND;
			$form .= "<option value='OR'>"._MB_D3QUOTES_OR;
			$form .= "<option value='XAND'>"._MB_D3QUOTES_XAND;
			$form .= "<option value='XOR' selected>"._MB_D3QUOTES_XOR;
			$form .= "<option value='ID'>"._MB_D3QUOTES_ID;
		break;
		case 'ID' :
			$form .= "<option value='MARK'>"._MB_D3QUOTES_MARK;
			$form .= "<option value='AND'>"._MB_D3QUOTES_AND;
			$form .= "<option value='OR'>"._MB_D3QUOTES_OR;
			$form .= "<option value='XAND'>"._MB_D3QUOTES_XAND;
			$form .= "<option value='XOR'>"._MB_D3QUOTES_XOR;
			$form .= "<option value='ID' selected>"._MB_D3QUOTES_ID;
		break;
	}
	$form .= "</select></td></tr>";
	$form .= "<tr><td width='15%'>"._MB_D3QUOTES_PLUGIN." :</td><td width='85%'>";
	$form .= "<select name='options[3]'>";

	$filename[] = "NONE.php";	
	$fp = opendir(XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/blocks/plugin');
	while($filename[]=readdir($fp));
	closedir($fp);

	for ($i=0;$i<count($filename);$i++) {
		if (!strpos($filename[$i],".php")===False) {
			$filename[$i] = str_replace(".php","",$filename[$i]);
			if ($filename[$i]==$options[3]) {
				if ($options[3]=='NONE')
					$form .= "<option value='NONE' selected>"._MB_D3QUOTES_NOSELECT;
				else
					$form .= "<option value='".$filename[$i]."' selected>".$filename[$i];
			} else {
				if ($filename[$i]=='NONE')
					$form .= "<option value='NONE'>"._MB_D3QUOTES_NOSELECT;
				else
					$form .= "<option value='".$filename[$i]."'>".$filename[$i];
			}
		}
	}
	$form .= "</select>&nbsp;&nbsp;"._MB_D3QUOTES_PARAM." : <input type='text' name='options[4]' value='$options[4]' size='30' maxlength='255' /></td></tr>";
	$form .= "<tr><td width='15%'>"._MB_D3QUOTES_ARTICLES." :</td><td width='85%'>";
	$form .= "<input type='text' name='options[5]' value='$options[5]' size='3' maxlength='3' />";
	$form .= "<tr><td width='15%'>"._MB_D3QUOTES_DATABASE." :</td><td width='85%'>";

	$conn = $xoopsDB->conn ;
	$result = mysql_list_tables(XOOPS_DB_NAME,$conn);
	$filename=array();
	$i=0;
	while($i < mysql_num_rows($result)) {
		$tbl_name=mysql_tablename($result,$i);
		if (strpos($tbl_name,$xoopsDB->prefix($mydirname."_citas"))!==False)
			$filename[]=str_replace($xoopsDB->prefix('')."_","",$tbl_name);
		$i++;
	}
	$form .= "<select name='options[6]'>";

	for ($i=0;$i<count($filename);$i++) {
		if ($filename[$i]==$options[6])
			$form .= "<option value='".$filename[$i]."' selected>".$filename[$i];
		else
			$form .= "<option value='".$filename[$i]."'>".$filename[$i];
	}
	$form .= "</select>";
	$form .= "</td></tr></table>";

	return $form ;
}

?>