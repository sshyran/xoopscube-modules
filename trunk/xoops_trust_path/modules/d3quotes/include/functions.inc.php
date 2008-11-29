<?php

function fgets_for_Excel($fp) {

		$rtn="";
		while($line=fgets($fp,2097152)) {
			$rtn .= $line;
			if ((strlen($line)>1) && (substr($line,strlen($line)-2,2)=="\r\n"))
				break;
		}
		return $rtn;
}

function mark_save($in,$putFlg=0,$mydirname) {
	global $tmp_mark;
	
	if (is_array($in)) {
		foreach ($in as $each) {
			if (!in_array($each,$tmp_mark))
				array_push($tmp_mark,$each);
		}
		$rec="";
		foreach ($tmp_mark as $each) {
			$rec .= $each.",";
		}
		$rec=substr($rec,0,strlen($rec)-1);
		$fp=fopen(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.tmp',"wb+");
		fputs($fp,$rec);
		fclose($fp);
	} else {
		if ($putFlg) {
			$rec="";
			foreach ($tmp_mark as $each) {
				$rec .= $each.",";
			}
			$rec=substr($rec,0,strlen($rec)-1);
			$fp=fopen(XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/cache/mq_citas.tmp',"wb+");
			fputs($fp,$rec);
			fclose($fp);
		} else {
			if (in_array($in,$_SESSION['mq_check'])) {
				if (!in_array($in,$tmp_mark))
					array_push($tmp_mark,$in);
			} else {
				if (in_array($in,$tmp_mark))
					array_splice($tmp_mark,array_search($in,$tmp_mark),1);
			}
		}
	}
}

function mark_load($in) {
	global $tmp_mark;

	if (!is_array($in)) {
		if (in_array($in,$tmp_mark)) {
			if (!in_array($in,$_SESSION['mq_check']))
				array_push($_SESSION['mq_check'],$in);
		}	else	{
			if (in_array($in,$_SESSION['mq_check']))
				array_splice($_SESSION['mq_check'],array_search($in,$_SESSION['mq_check']),1);
		}
	} else {
		foreach ($in as $each) {
			if (in_array($each,$tmp_mark))
				array_push($_SESSION['mq_check'],$each);
			else
				array_splice($_SESSION['mq_check'],array_search($each,$_SESSION['mq_check']),1);
		}
	}

	return;
}

function csvDB(&$texto,&$line,$mydirname) {

		$xoopsDB =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$errmsg = "";
		$texto2="";

		$wquoteFlg=0;
		for ($i=0;$i<strlen($texto);$i++){
			switch(substr($texto,$i,1)){
				case "\"" :
					if ($wquoteFlg) {
						if (($i+1)<strlen($texto) && 
							substr($texto,$i+1,1)=="\"") {
							$texto2 .= "\"";
							$i++;
						} else {
							$wquoteFlg=0;
							$texto2 .= substr($texto,$i,1);
						}
					} else {
						$wquoteFlg=1;
						$texto2 .= substr($texto,$i,1);
					}
				break;
				case "," :
					if ($wquoteFlg)
						$texto2 .= substr($texto,$i,1);
					else
						$texto2 .= "\\,";
				break;
				case ";" :
					if ($wquoteFlg)
						$texto2 .= substr($texto,$i,1);
					else
						$texto2 .= "\\,";
				break;
				case "\t" :
					if ($wquoteFlg)
						$texto2 .= substr($texto,$i,1);
					else
						$texto2 .= "\\,";
				break;
				case "\r" :
					if ($wquoteFlg) {
						if (($i+1)<strlen($texto) &&
							substr($texto,$i+1,1)=="\n") {
								$texto2 .= "\\\r\\\n";
								$i++;
						} else {
							$texto2 .= substr($texto,$i,1);
						}
					} else {
						$texto2 .= substr($texto,$i,1);
					}
				break;
				default :
					$texto2 .= substr($texto,$i,1);
				break;
			}
		}
		$eachRec = explode("\r\n",$texto2);
		foreach($eachRec as $oneRec) {
			$oneRec = str_replace("\\\r\\\n","\r\n",$oneRec);
			$line++;
			$errflg=0;
			if ($oneRec!="") {
				$eachItem = explode("\\,",$oneRec);
				$oneRec = str_replace("\\,",",",$oneRec);
				switch(count($eachItem)) {
					case 1:
						$oneItem=trim($eachItem[0],'" \t\n\r\0\x0b');
						if (ereg("^[0-9]+$",$oneItem)) {
							$id=$oneItem;
							$sql = "DELETE FROM ".$xoopsDB->prefix($mydirname."_citas")." WHERE id=".$id."";
							$xoopsDB->query($sql);
						} else {
							$errmsg.="["._MD_D3QUOTES_LINE.$line."]--["._MD_D3QUOTES_ERR3."]--[".$oneRec."]\n";
							$errflg=1;
							break ;
						}
					break;
					case 2 :
						$itemCnt=0;
						foreach($eachItem as $oneItem) {
							$itemCnt++;
							$str=strpos($oneItem,"\"");
							$end=strrpos($oneItem,"\"");
							if ($str===False || ($end-$str) < 1) {
								$errflg=1;
								$errmsg .= "["._MD_D3QUOTES_LINE.$line."]--["._MD_D3QUOTES_ERR1."]--[".$oneRec."]\n";
								break;
							} else {
								if ($itemCnt==1)
									$texto=substr($oneItem,$str+1,$end-$str-1);
								else
									$autor=substr($oneItem,$str+1,$end-$str-1);
							}
						}
						if ($errflg==0) {
							$autor = addslashes($autor);
							$texto = addslashes($texto);
							$newid = $xoopsDB->genId($xoopsDB->prefix($mydirname."_citas")."id");
							$sql = "INSERT INTO ".$xoopsDB->prefix($mydirname."_citas")." (id, autor, texto) VALUES (".$newid.", '".$autor."', '".$texto."')";
							if (!$xoopsDB->query($sql)) {
								xoops_cp_header();
								include(dirname(__FILE__).'/mymenu.php');
								echo "Could not add Record";
								xoops_cp_footer();
							}
						}
					break;
					case 3 :
						$itemCnt=0;
						foreach($eachItem as $oneItem) {
							$itemCnt++;
							switch($itemCnt) {
								case 1 :
									$oneItem=trim($oneItem,'" \t\n\r\0\x0b');
									if (ereg("^[0-9]+$",$oneItem)) {
										$id=$oneItem;
									} else {
										$errmsg.="["._MD_D3QUOTES_LINE.$line."]--["._MD_D3QUOTES_ERR2."]--[".$oneRec."]\n";
										$errflg=1;
										break 2;
									}
								break;
								case 2 :
									$str=strpos($oneItem,"\"");
									$end=strrpos($oneItem,"\"");
									if ($str===False || ($end-$str) < 1) {
										$errmsg .= "["._MD_D3QUOTES_LINE.$line."]--["._MD_D3QUOTES_ERR2."]--[".$oneRec."]\n";
										$errflg=1;
										break 2;
									} else {
										$texto=substr($oneItem,$str+1,$end-$str-1);
									}
								break;
								case 3 :
									$str=strpos($oneItem,"\"");
									$end=strrpos($oneItem,"\"");
									if ($str===False || ($end-$str) < 1) {
										$errmsg .= "["._MD_D3QUOTES_LINE.$line."]--["._MD_D3QUOTES_ERR2."]--[".$oneRec."]\n";
										$errflg=1;
										break 2;
									} else {
										$autor=substr($oneItem,$str+1,$end-$str-1);
									}
								break;
							}
						}
						if ($errflg==0) {
							$autor = addslashes($autor);
							$texto = addslashes($texto);
							$sql = "UPDATE ".$xoopsDB->prefix($mydirname."_citas")." SET autor='".$autor."',texto='".$texto."' WHERE id=".$id."";
							$xoopsDB->query($sql);
						}
					break;
					default :
						$errmsg.="["._MD_D3QUOTES_LINE.$line."]--["._MD_D3QUOTES_ERR1."]--[".$oneRec."]\n";
					break;
				}
			}
		}
		return $errmsg;
}

?>