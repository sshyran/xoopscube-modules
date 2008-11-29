<?php
//  ------------------------------------------------------------------------ //
//                      Random Quotes Module for                             //
//               XOOPS - PHP Content Management System 2.0                   //
//                            Version 1.0.0                                  //
//                   Copyright (c) 2002 Mario Figge                          //
//                   modified by CACHE 2005/1/14                             //
//                   modified by manta 2007/10/23                            //
//                       http://www.zona84.com                               //
// ------------------------------------------------------------------------- //

include_once "admin_header.php";

if ($xoopsConfig['language']=="japanese")
	include_once XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/jcode.php';
if (is_file(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.tmp')) {
	$fp=fopen(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.tmp',"rb+");
	$tmp=fgets($fp,2097152);
	fclose($fp);
	if ($tmp)
		$tmp_mark=explode(",",$tmp);
	else
		$tmp_mark = array();
} else {
	$tmp_mark = array();
}

// include fuctions
include XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/functions.inc.php';



/*
 * RandomQuotes: admin menu operations
 */

$op = "list";

foreach ($_GET as $k => $v) {
	switch ($k) {
	case "filter":  case "andor":  case "selItem":  case "selMode":
	case "selRecord":  case "selRecord2":  case "selRecord3":  case "selRecord4":
	case "replaceBefore":  case "replaceAfter":
	case "io":  case "markOp":  case "op":  case "autor":  case "texto":
		if (get_magic_quotes_gpc()) {
			$v = stripslashes($v);
		}
		//$v = htmlspecialchars($v);
		$$k = $v;
		break;
	case "page":  case "edit":  case "add":  case "start":  case "ok":  case "MAX_FILE_SIZE":
		$$k = intval($v);
		break;
	case "id":   case "oldtexto":  case "oldautor":  case "newtexto":  case "newautor":
	case "check":  case "checkR":
		$$k = $v;
		break;
	default:
		break;
	}
}

foreach ($_POST as $k => $v) {
	switch ($k) {
	case "filter":  case "andor":  case "selItem":  case "selMode":
	case "selRecord":  case "selRecord2":  case "selRecord3":  case "selRecord4":
	case "replaceBefore":  case "replaceAfter":
	case "io":  case "markOp":  case "op":  case "autor":  case "texto":
		if (get_magic_quotes_gpc()) {
			$v = stripslashes($v);
		}
		//$v = htmlspecialchars($v);
		$$k = $v;
		break;
	case "page":  case "edit":  case "add":  case "start":  case "ok":  case "MAX_FILE_SIZE":
		$$k = intval($v);
		break;
	case "id":   case "oldtexto":  case "oldautor":  case "newtexto":  case "newautor":
	case "check":  case "checkR":
		$$k = $v;
		break;
	default:
		break;
	}
}

if (isset($page))
	$_SESSION['mq_page'] = $page;
if (isset($filter))
	$_SESSION['mq_filter'] = get_magic_quotes_gpc() ? stripslashes($filter) : $filter;
if (isset($andor))
	$_SESSION['mq_andor'] = $andor;
if (isset($edit) && ereg("^[0-9]{1,2}$",$edit))
	$_SESSION['mq_edit'] = $edit;
if (isset($add) && ereg("^[0-9]{1,2}$",$add))
	$_SESSION['mq_add'] = $add;
if (isset($selItem))
	$_SESSION['mq_selItem'] = $selItem;
if (isset($selRecord))
	$_SESSION['mq_selRecord'] = $selRecord;
if (isset($selRecord2))
	$_SESSION['mq_selRecord2'] = $selRecord2;
if (isset($selRecord3))
	$_SESSION['mq_selRecord3'] = $selRecord3;
if (isset($selRecord4))
	$_SESSION['mq_selRecord4'] = $selRecord4;
if (isset($selMode))
	$_SESSION['mq_selMode'] = $selMode;
if (isset($replaceBefore))
	$_SESSION['mq_replaceBefore'] = get_magic_quotes_gpc() ? stripslashes($replaceBefore) : $replaceBefore;
if (isset($replaceAfter))
	$_SESSION['mq_replaceAfter'] = get_magic_quotes_gpc() ? stripslashes($replaceAfter) : $replaceAfter;
if (isset($id))
	$_SESSION['mq_id'] = $id;
if (isset($oldtexto))
	$_SESSION['mq_oldtexto'] = $oldtexto;
if (isset($oldautor))
	$_SESSION['mq_oldautor'] = $oldautor;
if (isset($newtexto))
	$_SESSION['mq_newtexto'] = $newtexto;
if (isset($newautor))
	$_SESSION['mq_newautor'] = $newautor;
if (isset($io))
	$_SESSION['mq_io'] = $io;
if (isset($markOp))
	$_SESSION['mq_markOp'] = $markOp;
if (isset($checkR)) {
	$check2=array();
	for ($i=0;$i<count($checkR);$i++) {
		for ($j=0;$j<count($check);$j++) {
			if ($check[$j]==$checkR[$i])
				break;
		}
		if ($j<count($check))
			$check2[$checkR[$i]]=1;
		else
			$check2[$checkR[$i]]=0;
	}
	foreach($check2 as $key => $val) {
		if (in_array($key,$_SESSION['mq_check'])){
			if (!$val)
				array_splice($_SESSION['mq_check'],array_search($key,$_SESSION['mq_check']),1);
		} else {
			if ($val)
				array_push($_SESSION['mq_check'],$key);
		}
	}
}
			
if (empty($start))
	$start=0;

if ($op == "list") {
    // List quoete in database, and form for add new.
    $myts =& MyTextSanitizer::getInstance();
    xoops_cp_header();
    include(dirname(__FILE__).'/mymenu.php');
	$_SESSION['mq_id']=array();
	$_SESSION['mq_oldtexto']=array();
	$_SESSION['mq_oldautor']=array();
	$_SESSION['mq_newtexto']=array();
	$_SESSION['mq_newautor']=array();

	if (empty($_SESSION['mq_page']))
		$page=10;
	else
		$page=$_SESSION['mq_page'];
	if (empty($_SESSION['mq_filter']))
		$filter='';
	else
		$filter=$_SESSION['mq_filter'];
	if (empty($_SESSION['mq_andor']))
		$andor='AND';
	else
		$andor=$_SESSION['mq_andor'];
	if (empty($_SESSION['mq_edit']))
		$edit=2;
	else
		$edit=$_SESSION['mq_edit'];
	if (empty($_SESSION['mq_add']))
		$add=3;
	else
		$add=$_SESSION['mq_add'];
	if (empty($_SESSION['mq_check']))
		$_SESSION['mq_check']=array();

    echo "
    <h4 style='text-align:left;'>"._MD_D3QUOTES_TITLE."</h4>

    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='outer'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='head' width='10%'>"._MD_D3QUOTES_PAGE." </td>
                <td class='odd' width='10%'>
					<select name='page'>\n";
	if ($page==9999)
		echo "				<option value='9999' selected>all\n";
	else
		echo "				<option value='9999'>all\n";
	for ($i=5;$i<=30;$i+=5) {
		if ($i==$page)
			echo "				<option value='".$i."' selected>".$i."\n";
		else
			echo "				<option value='".$i."'>".$i."\n";
	}

	echo "
					</select>
                </td>
                <td class='head' width='10%'>"._MD_D3QUOTES_FILTER." </td>
                <td class='odd' width='30%'>
                    <input type='text' name='filter' value='".$myts->makeTboxData4Edit($filter)."' size='30' maxlength='255' />
					<select name='andor'>";
						switch ($andor){
							case 'MARK' :
	echo "
							<option value='MARK' selected>"._MD_D3QUOTES_MARK."
							<option value='AND'>"._MD_D3QUOTES_AND."
							<option value='OR'>"._MD_D3QUOTES_OR."
							<option value='XAND'>"._MD_D3QUOTES_XAND."
							<option value='XOR'>"._MD_D3QUOTES_XOR."
							<option value='ID'>"._MD_D3QUOTES_ID;
							break;
							case 'AND' :
	echo "
							<option value='MARK'>"._MD_D3QUOTES_MARK."
							<option value='AND' selected>"._MD_D3QUOTES_AND."
							<option value='OR'>"._MD_D3QUOTES_OR."
							<option value='XAND'>"._MD_D3QUOTES_XAND."
							<option value='XOR'>"._MD_D3QUOTES_XOR."
							<option value='ID'>"._MD_D3QUOTES_ID;
							break;
							case 'OR' :
	echo "
							<option value='MARK'>"._MD_D3QUOTES_MARK."
							<option value='AND'>"._MD_D3QUOTES_AND."
							<option value='OR' selected>"._MD_D3QUOTES_OR."
							<option value='XAND'>"._MD_D3QUOTES_XAND."
							<option value='XOR'>"._MD_D3QUOTES_XOR."
							<option value='ID'>"._MD_D3QUOTES_ID;
							break;
							case 'XAND' :
	echo "
							<option value='MARK'>"._MD_D3QUOTES_MARK."
							<option value='AND'>"._MD_D3QUOTES_AND."
							<option value='OR'>"._MD_D3QUOTES_OR."
							<option value='XAND' selected>"._MD_D3QUOTES_XAND."
							<option value='XOR'>"._MD_D3QUOTES_XOR."
							<option value='ID'>"._MD_D3QUOTES_ID;
							break;
							case 'XOR' :
	echo "
							<option value='MARK'>"._MD_D3QUOTES_MARK."
							<option value='AND'>"._MD_D3QUOTES_AND."
							<option value='OR'>"._MD_D3QUOTES_OR."
							<option value='XAND'>"._MD_D3QUOTES_XAND."
							<option value='XOR' selected>"._MD_D3QUOTES_XOR."
							<option value='ID'>"._MD_D3QUOTES_ID;
							break;
							case 'ID' :
	echo "
							<option value='MARK'>"._MD_D3QUOTES_MARK."
							<option value='AND'>"._MD_D3QUOTES_AND."
							<option value='OR'>"._MD_D3QUOTES_OR."
							<option value='XAND'>"._MD_D3QUOTES_XAND."
							<option value='XOR'>"._MD_D3QUOTES_XOR."
							<option value='ID' selected>"._MD_D3QUOTES_ID;
							break;
						}

	echo "
					</select>
                </td>
				<td class='head' width='10%'>"._MD_D3QUOTES_EDIT_HEIGHT."</td>
                <td class='odd' width='10%'>
                    <input type='text' name='edit' value='$edit' size='2' maxlength='2' />
				</td>
				<td class='head' width='10%'>"._MD_D3QUOTES_ADD_HEIGHT."</td>
                <td class='odd' width='10%'>
                    <input type='text' name='add' value='$add' size='2' maxlength='2' />
                    <input type='hidden' name='op' value='list' />
                    <input type='submit' value='"._SUBMIT."' />
				</td></tr>
            </table>
        </td></tr>
    </table>
    </form>

    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='outer'>
    <table width='100%' border='0' cellpadding='4' cellspacing='1'>
    <tr class='head' align='center'><td align='left'>"._MD_D3QUOTES_TEXTO."</td><td>"._MD_D3QUOTES_AUTOR."</td><td>"._MD_D3QUOTES_ID."</td><td>"._MD_D3QUOTES_OP."</td></tr>";
	if (empty($filter))	{
		$query = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_citas");
		if ($andor=='MARK' && count($_SESSION['mq_check'])>0) {
			$query .= " WHERE ";
			foreach($_SESSION['mq_check'] as $word) {
				$query .= "id='".$word."' OR ";
			}
			$query = substr($query,0,strlen($query)-4);
		}			
	}	else	{
		$query = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_citas");
		switch($andor) {
			case 'ID' :
				$eachWords=explode(' ',$filter);
				$chk_id_cnt=0;
				foreach($eachWords as $word) {
					if (!ereg("^[0-9]+$",$word))
						$chk_id_cnt++;
				}
				if ($chk_id_cnt<count($eachWords)) {
					$query .= " WHERE ";
					foreach($eachWords as $word) {
						if (ereg("^[0-9]+$",$word))
							$query .= "id='".$word."' OR ";
					}
					$query = substr($query,0,strlen($query)-4);
				}
			break;
			case 'MARK' :
				if (count($_SESSION['mq_check'])>0) {
					$query .= " WHERE ";
					foreach($_SESSION['mq_check'] as $word) {
						$query .= "id='".$word."' OR ";
					}
					$query = substr($query,0,strlen($query)-4);
				}
			break;
			default :
				if ($andor=='XAND' || $andor=='XOR') {
					$query .= " WHERE NOT ((";
					$andor2 = substr($andor,1,strlen($andor)-1);
				} else {
					$query .= " WHERE (";
					$andor2=$andor;
				}
				$eachWords = explode(' ',$filter);
				foreach($eachWords as $word) {
					$query .= "texto LIKE '%".addslashes($word)."%' ".$andor2." ";
				}
				$query = substr($query,0,strlen($query)-strlen($andor2)-2);
				$query .= ") OR (";
				foreach($eachWords as $word) {
					$query .= "autor LIKE '%".addslashes($word)."%' ".$andor2." ";
				}
				$query = substr($query,0,strlen($query)-strlen($andor2)-2);
				$query .= ")";
				if ($andor=="XAND" || $andor=="XOR")
					$query .= ")";
			break;
		}
 	}
	$query .= " ORDER BY id";
   	$result = $xoopsDB->query($query);
	$dbCount = mysql_num_rows($result);
	$_SESSION['mq_query'] = $query;

    $count = 0;
	$count2 = 0;
    while ( list($id, $texto, $autor) = $xoopsDB->fetchRow($result) ) {
		if ($count >= $start && $count < ($start + $page)) {
			$texto=$myts->makeTboxData4Edit($texto);
			$autor=$myts->makeTboxData4Edit($autor);
			echo "<tr class='odd'><td align='left'>
            <input type='hidden' value='$id' name='id[]' />
            <input type='hidden' value='$texto' name='oldtexto[]' />
   	        <textarea name='newtexto[]' rows='".$edit."' cols='40'>$texto</textarea>
            </td>
        <td align='center'>
            <input type='hidden' value='$autor' name='oldautor[]' />
            <input type='text' value='$autor' name='newautor[]' maxlength='255' size='20' />
        </td>
		<td>
			".$id."
		</td>
        <td nowrap='nowrap' align='right'><a href='index.php?op=del&amp;id=".$id."&amp;ok=0&amp;start=".$start."'>"._DELETE."</a>
		<input type='hidden' name='checkR[]' value='".$id."' />
		<input type='checkbox' name='check[]' value='".$id."'";
			if (in_array($id,$_SESSION['mq_check']))
				echo " checked";
			echo " /></td></tr>";
			
			$count2++;
		}
        $count++;
    }
    if ($count2 > 0) {
        echo "<tr align='center' class='head'><td colspan='4'><input type='submit' value='"._SUBMIT."' /><input type='hidden' name='op' value='edit' />
		<input type='hidden' name='start' value='$start' /></td></tr>";
		if ( $dbCount > $page) {
			include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
			$pagenav = new XoopsPageNav($dbCount, $page, $start, 'start');
			echo "<tr align='center' class = 'odd'><td colspan='4'>".$pagenav->renderNav()."</td></tr>";
		}
		echo "<tr align='center' class = 'head'><td colspan='4'>"._MD_D3QUOTES_TARGET_CNT1.$dbCount._MD_D3QUOTES_TARGET_CNT2."</td></tr>";
    }
    echo "</table></td></tr></table></form>
    <br /><br />";

	if (empty($_SESSION['mq_selMode']))
		$selMode='input';
	else
		$selMode=$_SESSION['mq_selMode'];
	if (empty($_SESSION['mq_errmsg']))
		$errmsg="";
	else
		$errmsg=$_SESSION['mq_errmsg'];
	if (!empty($_SESSION['mq_rec'])) {
		$errmsg = $_SESSION['mq_rec'];
		$_SESSION['mq_rec']="";
	}
	if ($selMode=='input') {
		$selectM_1="selected";
		$selectM_2="";
	}	else	{
		$selectM_1="";
		$selectM_2="selected";
	}

	echo "
    <h4 style='text-align:left;'>"._MD_D3QUOTES_ADD."</h4>
    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='outer'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='head'>"._MD_D3QUOTES_AUTOR." </td>
                <td class='odd'>
                    <input type='text' name='autor' size='30' maxlength='255' /></td>
                <td class='head'>"._MD_D3QUOTES_SELECT_MODE." </td>
                <td class='odd'>
					<select name='selMode'>
						<option value='input' ".$selectM_1.">"._MD_D3QUOTES_INPUT."
						<option value='csv' ".$selectM_2.">"._MD_D3QUOTES_CSV."
					</select>
                 </td></tr>
                <tr nowrap='nowrap'>
                <td class='head'>"._MD_D3QUOTES_TEXTO." </td>
                <td class='odd' colspan='3'>
                    <textarea name='texto' cols='40' rows='".$add."'>".$errmsg."</textarea>
                </td></tr>
                <tr>
                <td class='head'>&nbsp;</td>
                <td class='odd' colspan='3'>
                    <input type='hidden' name='op' value='add' />
                    <input type='hidden' name='start' value='$start' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

	if (empty($_SESSION['mq_selItem']))
		$selItem='texto';
	else
		$selItem=$_SESSION['mq_selItem'];
	if (empty($_SESSION['mq_selRecord']))
		$selRecord='display';
	else
		$selRecord=$_SESSION['mq_selRecord'];
	if (empty($_SESSION['mq_replaceBefore']))
		$replaceBefore='';
	else
		$replaceBefore=$_SESSION['mq_replaceBefore'];
	if (empty($_SESSION['mq_replaceAfter']))
		$replaceAfter='';
	else
		$replaceAfter=$_SESSION['mq_replaceAfter'];
	if ($selItem=='texto') {
		$selectI_1="selected";
		$selectI_2="";
	}	else	{
		$selectI_1="";
		$selectI_2="selected";
	}
	switch($selRecord) {
		case 'mark' :
			$selectR_1="selected";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'display' :
			$selectR_1="";
			$selectR_2="selected";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'select' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="selected";
			$selectR_4="";
		break;
		case 'all' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="selected";
		break;
	}

echo "
    <br /><br />
    <h4 style='text-align:left;'>"._MD_D3QUOTES_REPLACE."</h4>
    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='outer'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='head'>"._MD_D3QUOTES_SELECT_ITEM." </td>
                <td class='odd'>
					<select name='selItem'>
						<option value='texto' ".$selectI_1.">"._MD_D3QUOTES_TEXTO."
						<option value='autor' ".$selectI_2.">"._MD_D3QUOTES_AUTOR."
					</select>
                </td>
                <td class='head'>"._MD_D3QUOTES_SELECT_RECORD." </td>
                <td class='odd'>
					<select name='selRecord'>
						<option value='mark' ".$selectR_1.">"._MD_D3QUOTES_MARK."
						<option value='display' ".$selectR_2.">"._MD_D3QUOTES_DISPLAY."
						<option value='select' ".$selectR_3.">"._MD_D3QUOTES_SELECT."
						<option value='all' ".$selectR_4.">"._MD_D3QUOTES_ALL."
					</select>
                </td></tr>
                <tr nowrap='nowrap'>
                <td class='head'>"._MD_D3QUOTES_REPLACE_BEFORE." </td>
                <td class='odd' colspan='3'>
                    <textarea name='replaceBefore' cols='40' rows='".$add."'>".$myts->makeTboxData4Edit($replaceBefore)."</textarea>
                </td></tr>
                <tr nowrap='nowrap'>
                <td class='head'>"._MD_D3QUOTES_REPLACE_AFTER." </td>
                <td class='odd' colspan='3'>
                    <textarea name='replaceAfter' cols='40' rows='".$add."'>".$myts->makeTboxData4Edit($replaceAfter)."</textarea>
                </td></tr>
                <tr>
                <td class='head'>&nbsp;</td>
                <td class='odd' colspan='3'>
                    <input type='hidden' name='op' value='rep' />
                    <input type='hidden' name='start' value='$start' />
                    <input type='hidden' name='ok' value='0' />";
	$count=0;
	if (mysql_num_rows($result) !== 0) mysql_data_seek($result,0);
    while ( list($id, $texto, $autor) = $xoopsDB->fetchRow($result) ) {
		if ($count >= $start && $count < ($start + $page)) {
			$texto = $myts->makeTboxData4Edit($texto);
			$autor = $myts->makeTboxData4Edit($autor);
	echo "
                   	<input type='hidden' name='id[]' value='$id' />
                   	<input type='hidden' name='oldtexto[]' value='$texto' />
                   	<input type='hidden' name='oldautor[]' value='$autor' />
                   	<input type='hidden' name='newtexto[]' value='$texto' />
                   	<input type='hidden' name='newautor[]' value='$autor' />";
		}
		$count++;
	}
	echo "
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

	if (empty($_SESSION['mq_selRecord2']))
		$selRecord2='display';
	else
		$selRecord2=$_SESSION['mq_selRecord2'];
	switch($selRecord2) {
		case 'mark' :
			$selectR_1="selected";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'display' :
			$selectR_1="";
			$selectR_2="selected";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'select' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="selected";
			$selectR_4="";
		break;
		case 'all' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="selected";
		break;
	}

	echo "
    <h4 style='text-align:left;'>"._MD_D3QUOTES_DELETE."</h4>
    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='outer'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='head' width='30%'>"._MD_D3QUOTES_SELECT_RECORD." </td>
                <td class='odd' width='70%'>
					<select name='selRecord2'>
						<option value='mark' ".$selectR_1.">"._MD_D3QUOTES_MARK."
						<option value='display' ".$selectR_2.">"._MD_D3QUOTES_DISPLAY."
						<option value='select' ".$selectR_3.">"._MD_D3QUOTES_SELECT."
						<option value='all' ".$selectR_4.">"._MD_D3QUOTES_ALL."
					</select>
                    <input type='hidden' name='op' value='cut' />
                    <input type='hidden' name='start' value='$start' />";
					$count=0;
					if (mysql_num_rows($result) !== 0) mysql_data_seek($result,0);
    				while ( list($id, $texto, $autor) = $xoopsDB->fetchRow($result) ) {
						if ($count >= $start && $count < ($start + $page)) {
	echo "
                   	<input type='hidden' name='id[]' value='$id' />";
						}
						$count++;
					}
	echo "
                    <input type='hidden' name='ok' value='0' />
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

	if (empty($_SESSION['mq_selRecord4']))
		$selRecord4='display';
	else
		$selRecord4=$_SESSION['mq_selRecord4'];
	switch($selRecord4) {
		case 'mark' :
			$selectR_1="selected";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'display' :
			$selectR_1="";
			$selectR_2="selected";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'select' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="selected";
			$selectR_4="";
		break;
		case 'all' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="selected";
		break;
	}
	if (empty($_SESSION['mq_markOp']))
		$markOp='on';
	else
		$markOp=$_SESSION['mq_markOp'];
	switch ($markOp) {
		case 'on'	:
			$radio_1="checked";
			$radio_2="";
			$radio_3="";
			$radio_4="";
		break;
		case 'off' :
			$radio_1="";
			$radio_2="checked";
			$radio_3="";
			$radio_4="";
		break;
		case 'save' :
			$radio_1="";
			$radio_2="";
			$radio_3="checked";
			$radio_4="";
		break;
		case 'load' :
			$radio_1="";
			$radio_2="";
			$radio_3="";
			$radio_4="checked";
		break;
	}

	echo "
    <h4 style='text-align:left;'>"._MD_D3QUOTES_MARK_TITLE."</h4>
    <form action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='outer'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='head' width='20%' rowspan='2'>"._MD_D3QUOTES_MARK_SELECT." </td>
				<td class='odd' width='30%'>
				<input type='radio' name='markOp' value='on' ".$radio_1." />"._MD_D3QUOTES_RADIO_ON."
				<input type='radio' name='markOp' value='off' ".$radio_2." />"._MD_D3QUOTES_RADIO_OFF."</td>
                <td class='head' width='20%' rowspan='2'>"._MD_D3QUOTES_SELECT_RECORD." </td>
                <td class='odd' width='30%' rowspan='2'>
					<select name='selRecord4'>
						<option value='mark' ".$selectR_1.">"._MD_D3QUOTES_MARK."
						<option value='display' ".$selectR_2.">"._MD_D3QUOTES_DISPLAY."
						<option value='select' ".$selectR_3.">"._MD_D3QUOTES_SELECT."
						<option value='all' ".$selectR_4.">"._MD_D3QUOTES_ALL."
					</select>
                    <input type='hidden' name='op' value='mark' />
                    <input type='hidden' name='start' value='$start' />";
					$count=0;
					if (mysql_num_rows($result) !== 0) mysql_data_seek($result,0);
    				while ( list($id, $texto, $autor) = $xoopsDB->fetchRow($result) ) {
						if ($count >= $start && $count < ($start + $page)) {
	echo "
                   	<input type='hidden' name='id[]' value='$id' />";
						}
						$count++;
					}
	echo "
                    <input type='submit' value='"._SUBMIT."' />
				</td></tr>
				<tr>
                <td class='odd' width='30%'>
				<input type='radio' name='markOp' value='save' ".$radio_3." />"._MD_D3QUOTES_RADIO_SAVE."
				<input type='radio' name='markOp' value='load' ".$radio_4." />"._MD_D3QUOTES_RADIO_LOAD."
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

	if (empty($_SESSION['mq_selRecord3']))
		$selRecord3='display';
	else
		$selRecord3=$_SESSION['mq_selRecord3'];
	switch($selRecord3) {
		case 'mark' :
			$selectR_1="selected";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'display' :
			$selectR_1="";
			$selectR_2="selected";
			$selectR_3="";
			$selectR_4="";
		break;
		case 'select' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="selected";
			$selectR_4="";
		break;
		case 'all' :
			$selectR_1="";
			$selectR_2="";
			$selectR_3="";
			$selectR_4="selected";
		break;
	}
	if (empty($_SESSION['mq_io']))
		$io='stream';
	else
		$io=$_SESSION['mq_io'];
	switch($io) {
		case 'stream' :
			$selectIO_1="selected";
			$selectIO_2="";
		break;
		case 'server' :
			$selectIO_1="";
			$selectIO_2="selected";
		break;
	}

	echo "
    <h4 style='text-align:left;'>"._MD_D3QUOTES_FILE."</h4>
    <form ENCTYPE='multipart/form-data' action='index.php' method='post'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
        <td class='outer'>
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>
                <tr nowrap='nowrap'>
                <td class='head'>"._MD_D3QUOTES_UPLOAD." </td>
                <td class='odd'>
					<input type='hidden' name='MAX_FILE_SIZE' value='2097152'>
					<input name='mq_citas' type='file'>
				</td>
                <td class='head'>"._MD_D3QUOTES_DOWNLOAD." </td>
                <td class='odd'>
					<select name='selRecord3'>
						<option value='mark' ".$selectR_1.">"._MD_D3QUOTES_MARK."
						<option value='display' ".$selectR_2.">"._MD_D3QUOTES_DISPLAY."
						<option value='select' ".$selectR_3.">"._MD_D3QUOTES_SELECT."
						<option value='all' ".$selectR_4.">"._MD_D3QUOTES_ALL."
					</select>
				</td>
                <td class='head'>"._MD_D3QUOTES_IO." </td>
                <td class='odd'>
					<select name='io'>
						<option value='stream' ".$selectIO_1.">"._MD_D3QUOTES_STREAM."
						<option value='server' ".$selectIO_2.">"._MD_D3QUOTES_SERVER."
					</select>
                    <input type='hidden' name='op' value='file' />
                    <input type='hidden' name='start' value='$start' />";
					$count=0;
					if (mysql_num_rows($result) !== 0) mysql_data_seek($result,0);
    				while ( list($id, $texto, $autor) = $xoopsDB->fetchRow($result) ) {
						if ($count >= $start && $count < ($start + $page)) {
	echo "
                   	<input type='hidden' name='id[]' value='$id' />";
						}
						$count++;
					}
	echo "
                    <input type='submit' value='"._SUBMIT."' />
                </td></tr>
            </table>
        </td></tr>
    </table>
    </form>";

    xoops_cp_footer();
    exit();
}

if ($op == "add") {
    // Add quote
	if (empty($_SESSION['mq_selMode']))
		$selMode='input';
	else
		$selMode=$_SESSION['mq_selMode'];
	$myts =& MyTextSanitizer::getInstance();
	$_SESSION['mq_errmsg']="";
	if ($selMode=='input') {
		$autor = $myts->makeTboxData4Save($autor);
		$texto = $myts->makeTboxData4Save($texto);
		$newid = $xoopsDB->genId($xoopsDB->prefix($mydirname."_citas")."id");
		$sql = "INSERT INTO ".$xoopsDB->prefix($mydirname."_citas")." (id, autor, texto) VALUES (".$newid.", '".$autor."', '".$texto."')";
		if (!$xoopsDB->query($sql)) {
			xoops_cp_header();
			include(dirname(__FILE__).'/mymenu.php');
			echo "Could not add Record";
			xoops_cp_footer();
		} else {
			redirect_header("index.php?op=list&amp;start=".$start,1,_XD_DBSUCCESS);
		}
	} else {
		$line=0;
		$texto=$myts->stripSlashesGPC($texto);
		$errmsg=csvDB($texto,$line,$mydirname);
		$_SESSION['mq_errmsg']=$myts->makeTboxData4Edit($errmsg);
		redirect_header("index.php?op=list&amp;start=".$start,1,_XD_DBSUCCESS);
	}
    exit();
}

if ($op == "edit") {
    // Edit quotes
    $myts =& MyTextSanitizer::getInstance();
    $count = count($newautor);
    for ($i = 0; $i < $count; $i++) {
        if ( $newautor[$i] != $oldautor[$i] || $newtexto[$i] != $oldtexto[$i]) {
            $autor = $myts->makeTboxData4Save($newautor[$i]);
            $texto = $myts->makeTboxData4Save($newtexto[$i]);
            $sql = "UPDATE ".$xoopsDB->prefix($mydirname."_citas")." SET autor='".$autor."',texto='".$texto."' WHERE id=".$id[$i]."";
            $xoopsDB->query($sql);
        }
    }
    redirect_header("index.php?op=list&amp;start=".$start,1,_XD_DBSUCCESS);
    exit();
}

if ($op == "rep") {
    // Replace quotes
	if (empty($_SESSION['mq_selItem']))
		$selItem='texto';
	else
		$selItem=$_SESSION['mq_selItem'];
	if (empty($_SESSION['mq_selRecord']))
		$selRecord='display';
	else
		$selRecord=$_SESSION['mq_selRecord'];
	if (empty($_SESSION['mq_replaceBefore']))
		$replaceBefore='';
	else
		$replaceBefore=$_SESSION['mq_replaceBefore'];
	if (empty($_SESSION['mq_replaceAfter']))
		$replaceAfter='';
	else
		$replaceAfter=$_SESSION['mq_replaceAfter'];
	if (empty($_SESSION['mq_id']))
		$id=array();
	else
		$id=$_SESSION['mq_id'];
	if (empty($_SESSION['mq_oldtexto']))
		$oldtexto=array();
	else
		$oldtexto=$_SESSION['mq_oldtexto'];
	if (empty($_SESSION['mq_oldautor']))
		$oldautor=array();
	else
		$oldautor=$_SESSION['mq_oldautor'];
	if (empty($_SESSION['mq_newtexto']))
		$newtexto=array();
	else
		$newtexto=$_SESSION['mq_newtexto'];
	if (empty($_SESSION['mq_newautor']))
		$newautor=array();
	else
		$newautor=$_SESSION['mq_newautor'];

    if ($ok == 1) {
	    $myts =& MyTextSanitizer::getInstance();
		switch($selRecord) {
			case 'mark' :
			    foreach ($_SESSION['mq_check'] as $id) {
					$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id=".$id." ORDER BY id";
					$result = $xoopsDB->query($sql);
					list($id,$texto,$autor) = $xoopsDB->fetchRow($result);
					$texto2=$texto;
					$autor2=$autor;
					if ($selItem=='texto')
						$texto=str_replace($replaceBefore,$replaceAfter,$texto);
					else
						$autor=str_replace($replaceBefore,$replaceAfter,$autor);
					if ($texto != $texto2 || $autor != $autor2) {
						$sql = "UPDATE ".$xoopsDB->prefix($mydirname."_citas")." SET autor='".addslashes($autor)."',texto='".addslashes($texto)."' WHERE id=".$id."";
						$xoopsDB->query($sql);
					}
				}
			break;
			case 'display' :
			    $count = count($newautor);
			    for ($i = 0; $i < $count; $i++) {
					if ($selItem=='texto')
						$newtexto[$i] = str_replace($replaceBefore,$replaceAfter,$newtexto[$i]);
					else
						$newautor[$i] = str_replace($replaceBefore,$replaceAfter,$newautor[$i]);
					if ( $newautor[$i] != $oldautor[$i] || $newtexto[$i] != $oldtexto[$i]) {
						$autor = addslashes($newautor[$i]);
						$texto = addslashes($newtexto[$i]);
						$sql = "UPDATE ".$xoopsDB->prefix($mydirname."_citas")." SET autor='".$autor."',texto='".$texto."' WHERE id=".$id[$i]."";
						$xoopsDB->query($sql);
					}
				}
			break;
			case 'select' :
				$result = $xoopsDB->query($_SESSION['mq_query']);
				while ( list($id,$texto,$autor) = $xoopsDB->fetchRow($result) ) {
					$texto2=$texto;
					$autor2=$autor;
					if ($selItem=='texto')
						$texto=str_replace($replaceBefore,$replaceAfter,$texto);
					else
						$autor=str_replace($replaceBefore,$replaceAfter,$autor);
					if ($texto != $texto2 || $autor != $autor2) {
						$sql = "UPDATE ".$xoopsDB->prefix($mydirname."_citas")." SET autor='".addslashes($autor)."',texto='".addslashes($texto)."' WHERE id=".$id."";
						$xoopsDB->query($sql);
					}
				}
			break;
			case 'all' :
				$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_citas")." ORDER BY id";
				$result = $xoopsDB->query($sql);
    			while ( list($id,$texto,$autor) = $xoopsDB->fetchRow($result) ) {
					$texto2 = $texto;
					$autor2 = $autor;
					if ($selItem=='texto')
						$texto = str_replace($replaceBefore,$replaceAfter,$texto);
					else
						$autor = str_replace($replaceBefore,$replaceAfter,$autor);
					if ( $texto != $texto2 || $autor != $autor2) {
						$sql = "UPDATE ".$xoopsDB->prefix($mydirname."_citas")." SET autor='".addslashes($autor)."',texto='".addslashes($texto)."' WHERE id=".$id."";
						$xoopsDB->query($sql);
					}
				}
			break;
		}
	    redirect_header("index.php?op=list&amp;start=".$start,1,_XD_DBSUCCESS);
		exit();
	} else {
        xoops_cp_header();
	include(dirname(__FILE__).'/mymenu.php');
        xoops_confirm(array('op' => 'rep', 'ok' => 1, 'start' => $start), 'index.php', _MD_D3QUOTES_SUREREP);
        xoops_cp_footer();
        exit();
	}
}

if ($op == "cut") {
    // Cut quotes
	if (empty($_SESSION['mq_selRecord2']))
		$selRecord2='display';
	else
		$selRecord2=$_SESSION['mq_selRecord2'];
	if (empty($_SESSION['mq_markOp']))
		$markOp='on';
	else
		$markOp=$_SESSION['mq_markOp'];
	if (empty($_SESSION['mq_id']))
		$id=array();
	else
		$id=$_SESSION['mq_id'];

    if ($ok == 1) {
		switch($selRecord2) {
			case 'mark' :
			    foreach ($_SESSION['mq_check'] as $id) {
					$sql = "DELETE FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id=".$id."";
					$xoopsDB->query($sql);
				}
				$_SESSION['mq_check']=array();
			break;
			case 'display' :
			    $count = count($id);
			    for ($i = 0; $i < $count; $i++) {
					$sql = "DELETE FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id=".$id[$i]."";
					$xoopsDB->query($sql);
					if (in_array($id[$i],$_SESSION['mq_check']))
						array_splice($_SESSION['mq_check'],array_search($id[$i],$_SESSION['mq_check']),1);
				}
			break;
			case 'select' :
				$result = $xoopsDB->query($_SESSION['mq_query']);
				while ( list($id,$texto,$autor) = $xoopsDB->fetchRow($result) ) {
					$sql = "DELETE FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id=".$id."";
					$xoopsDB->query($sql);
					if (in_array($id,$_SESSION['mq_check']))
						array_splice($_SESSION['mq_check'],array_search($id,$_SESSION['mq_check']),1);
				}
			break;
			case 'all' :
				$sql = "DELETE FROM ".$xoopsDB->prefix($mydirname."_citas");
				$xoopsDB->query($sql);
				$sql="ALTER TABLE ".$xoopsDB->prefix($mydirname."_citas")." AUTO_INCREMENT=1";
				$xoopsDB->query($sql);
				$_SESSION['mq_check'] = array();
			break;
		}
		$sql = "OPTIMIZE TABLE ".$xoopsDB->prefix($mydirname."_citas");
		$xoopsDB->query($sql);
	    redirect_header("index.php?op=list&amp;start=".$start,1,_XD_DBSUCCESS);
		exit();
	} else {
        xoops_cp_header();
	include(dirname(__FILE__).'/mymenu.php');
        xoops_confirm(array('op' => 'cut', 'ok' => 1, 'start' => $start), 'index.php', _MD_D3QUOTES_SUREDEL);
        xoops_cp_footer();
        exit();
	}
}

if ($op == "mark") {
    // Mark quotes
	if (empty($_SESSION['mq_selRecord4']))
		$selRecord4='display';
	else
		$selRecord4=$_SESSION['mq_selRecord4'];
	if (empty($_SESSION['mq_markOp']))
		$markOp='on';
	else
		$markOp=$_SESSION['mq_markOp'];
	if (empty($_SESSION['mq_id']))
		$id=array();
	else
		$id=$_SESSION['mq_id'];

	switch($selRecord4) {
		case 'mark' :
			switch($markOp) {
				case 'off' :	$_SESSION['mq_check'] = array();	break;
				case 'save' :	mark_save($_SESSION['mq_check'],$mydirname);	break;
				case 'load' :	mark_load($_SESSION['mq_check']);	break;
				default : break;
			}
		break;
		case 'display' :
		    $count = count($id);
		    for ($i = 0; $i < $count; $i++) {
				switch($markOp) {
					case 'on' :
						if (!in_array($id[$i],$_SESSION['mq_check']))
							array_push($_SESSION['mq_check'],$id[$i]);
					break;
					case 'off' :
						if (in_array($id[$i],$_SESSION['mq_check']))
							array_splice($_SESSION['mq_check'],array_search($id[$i],$_SESSION['mq_check']),1);
					break;
					case 'save' :
						mark_save($id[$i],0,$mydirname);
					break;
					case 'load' :	
						mark_load($id[$i]);
					break;
				}
			}
			if ($markOp=='save')
				mark_save(0,1,$mydirname);
		break;
		case 'select' :
			$result = $xoopsDB->query($_SESSION['mq_query']);
			while ( list($id) = $xoopsDB->fetchRow($result) ) {
				switch($markOp) {
					case 'on' :
						if (!in_array($id,$_SESSION['mq_check']))
							array_push($_SESSION['mq_check'],$id);
					break;
					case 'off' :
						if (in_array($id,$_SESSION['mq_check']))
							array_splice($_SESSION['mq_check'],array_search($id,$_SESSION['mq_check']),1);
					break;
					case 'save' :
						mark_save($id,0,$mydirname);
					break;
					case 'load' :	
						mark_load($id);
					break;
				}
			}
			if ($markOp=='save')
				mark_save(0,1,$mydirname);
		break;
		case 'all' :
			$sql = "SELECT id FROM ".$xoopsDB->prefix($mydirname."_citas")." ORDER BY id";
			$result=$xoopsDB->query($sql);
			while ( list($id) = $xoopsDB->fetchRow($result) ) {
				switch ($markOp){
					case 'on' :
						if (!in_array($id,$_SESSION['mq_check']))
							array_push($_SESSION['mq_check'],$id);
					break;
					case 'off' :
						if (in_array($id,$_SESSION['mq_check']))
							array_splice($_SESSION['mq_check'],array_search($id,$_SESSION['mq_check']),1);
					break;
					case 'save' :
						mark_save($id,0,$mydirname);
					break;
					case 'load' :	
						mark_load($id);
					break;
				}
			}
			if ($markOp=='save')
				mark_save(0,1,$mydirname);
		break;
	}
    redirect_header("index.php?op=list&amp;start=".$start,1,_MD_D3QUOTES_MARK_UPDATE);
	exit();
}

if ($op == "file") {
    // Cut quotes
	if (empty($_SESSION['mq_selRecord3']))
		$selRecord3='display';
	else
		$selRecord3=$_SESSION['mq_selRecord3'];
	if (empty($_SESSION['mq_io']))
		$io='stream';
	else
		$io=$_SESSION['mq_io'];
	if (empty($_SESSION['mq_id']))
		$id=array();
	else
		$id=$_SESSION['mq_id'];
	$_SESSION['mq_rec']="";

	if (empty($_FILES['mq_citas']['name'])) {
		switch($selRecord3) {
			case 'mark' :
			    $i=0;
			    foreach ($_SESSION['mq_check'] as $id) {
					$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id=".$id." ORDER BY id";
					$result = $xoopsDB->query($sql);
					list($rec[$i]['id'],$rec[$i]['texto'],$rec[$i]['autor']) = mysql_fetch_row($result);
					$i++;
				}
			break;
			case 'display' :
			    $count = count($id);
			    for ($i = 0; $i < $count; $i++) {
					$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id=".$id[$i]." ORDER BY id";
					$result = $xoopsDB->query($sql);
					list($rec[$i]['id'],$rec[$i]['texto'],$rec[$i]['autor']) = mysql_fetch_row($result);
				}
			break;
			case 'select' :
				$result = $xoopsDB->query($_SESSION['mq_query']);
				$i=0;
				while (list($rec[$i]['id'],$rec[$i]['texto'],$rec[$i]['autor']) = $xoopsDB->fetchRow($result) ) {
					$i++;
				}
				array_pop($rec);
			break;
			case 'all' :
				$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_citas")." ORDER BY id";
				$result = $xoopsDB->query($sql);
				$i=0;
				while (list($rec[$i]['id'],$rec[$i]['texto'],$rec[$i]['autor']) = $xoopsDB->fetchRow($result) ) {
					$i++;
				}
				array_pop($rec);
			break;
		}
		$fp=fopen(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv',"wb+");
		foreach($rec as $oneRec) {
			$oneRec['texto'] = str_replace("\r\n","\n",$oneRec['texto']);
			$oneRec['autor'] = str_replace("\r\n","\n",$oneRec['autor']);
			$oneRec['texto'] = str_replace("\"","\"\"",$oneRec['texto']);
			$oneRec['autor'] = str_replace("\"","\"\"",$oneRec['autor']);
			if ($xoopsConfig['language']=="japanese" && $io=='stream') {
				$oneRec['texto'] = JcodeConvert($oneRec['texto'],1,2);
				$oneRec['autor'] = JcodeConvert($oneRec['autor'],1,2);
			}
			fputs($fp,"\"".$oneRec['id']."\",\"".$oneRec['texto']."\",\"".$oneRec['autor']."\"\r\n");
		}
		fclose($fp);
		if ($io=='stream') {
			@set_time_limit(600);
			header("Content-disposition:inline ;  filename=mq_citas.csv");
			header("Content-type: text/octet-stream");
			header("Pragma: no-cache");
			header("Expires: 0");
			readfile(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv');
			unlink(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv');
		} else {
			redirect_header("index.php?op=list&amp;start=".$start,1,_MD_D3QUOTES_DOWNLOAD);
		}
		exit();
	} else {
		$rec="";
		if ($io=='stream') {
			if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv'))
				unlink(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv');
			if (copy($_FILES['mq_citas']['tmp_name'],XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv')) {
				$fp=fopen(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv',"rb+");
				$rec=fread($fp,2097152);
				fclose($fp);
			}
			if ($xoopsConfig['language']=="japanese")
				$rec=JcodeConvert($rec,2,1);
			unlink(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.csv');
		} else {
			if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/'.$_FILES['mq_citas']['name'])) {
				$fp=fopen(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/'.$_FILES['mq_citas']['name'],"rb+");
				$myts =& MyTextSanitizer::getInstance();
				$errmsg="";
				$line=0;
				while($oneLine=fgets_for_Excel($fp)) {
					$errmsg .= csvDB($oneLine,$line,$mydirname);
				}
				fclose($fp);
				$_SESSION['mq_errmsg']=$myts->makeTboxData4Edit($errmsg);
			}
		}
		if ($io=='stream')
			$_SESSION['mq_selMode']="csv";
		$_SESSION['mq_rec']=$rec;
		redirect_header("index.php?op=list&amp;start=".$start,1,_MD_D3QUOTES_FILEUPLOAD);
        exit();
	}
}

if ($op == "del") {
    // Delete quote
    if ($ok == 1) {
        $sql = "DELETE FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id = ".$id ;
        if (!$xoopsDB->query($sql)) {
            xoops_cp_header();
            include(dirname(__FILE__).'/mymenu.php');
            echo "Could not delete category";
            xoops_cp_footer();
        } else {
			if (in_array($id,$_SESSION['mq_check']))
				array_splice($_SESSION['mq_check'],array_search($id,$_SESSION['mq_check']),1);
            redirect_header("index.php?op=list&amp;start=".$start,1,_XD_DBSUCCESS);
        }
        exit();
    } else {
        xoops_cp_header();
	include(dirname(__FILE__).'/mymenu.php');
        xoops_confirm(array('op' => 'del', 'id' => $id, 'ok' => 1, 'start' => $start), 'index.php', _MD_D3QUOTES_SUREDEL);
        xoops_cp_footer();
        exit();
    }
}

?>