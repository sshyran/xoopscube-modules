<?php

function checkURL( $url ){
	$url = str_replace( XOOPS_URL , "" , $url );
//	if( strpos($url,'http://')!==0 && strpos($url,'https://')!==0 && strpos($url,'ftp://')!==0  ){
//		$url = ( strpos($url,'/')!==0 ) ? XOOPS_URL."/$url" : XOOPS_URL.$url ;
//	}
	//add last slash //extention
		//html, htm, xml, shtml, shtm, stm, rtf, pdf, css, js, 
		//php, cgi, pl, plx, py, rb, asp, aspx, 
		//gif, png, jpg, jpeg, avi, asf, asx, wmv, mpg, mov, rm, ram, swf, mp3, wma, wav,
		//zip, lzh, tar, gz, tgz
//	if( substr_count($url,'/')==2
//		|| ( !strpos($url,'?') && strrpos($url,'/')!=(strlen($url)-1) && preg_match('/.*\.[0-9a-zA-Z]{2,5}$/',$url)==0 )
	if( !strpos($url,'?') && strrpos($url,'/')!=(strlen($url)-1) && preg_match('/.*\.[0-9a-zA-Z]{2,5}$/',$url)==0 ){
			$url .= "/" ;
	}
	return $url;
}


// re-numbering
function renumberS(){
	global $table_menu, $xoopsDB;
	$sql = "SELECT subid FROM $table_menu ORDER BY sortnum ASC";
	$result = $xoopsDB->query($sql);
	$newnum = 1;
	while( $row = $xoopsDB->fetchArray($result) ){
		$xoopsDB->query( "UPDATE $table_menu SET sortnum=$newnum WHERE subid=". $row['subid'] );
		$newnum++;
	}
}

function renumberS_forblock(){
	global $table_menu, $xoopsDB;
	$sql = "SELECT subid FROM $table_menu ORDER BY blockid ASC, sortnum ASC";
	$result = $xoopsDB->query($sql);
	$newnum = 1;
	while( $row = $xoopsDB->fetchArray($result) ){
		$xoopsDB->query( "UPDATE $table_menu SET sortnum=$newnum WHERE subid=". $row['subid'] );
		$newnum++;
	}
}

//re-numbering BlockID and check hierarchy
function renumberB(){
	global $table_menu, $xoopsDB;
	$sql = "SELECT * FROM $table_menu ORDER BY sortnum ASC";
	$result = $xoopsDB->query($sql);
	$newblock = $cnt = $b_hiera = 0;
	while( $row = $xoopsDB->fetchArray($result) ){
		if( $row['hiera']==0 || $cnt==0 ) $newblock++;
		//ŠK‘wƒ`ƒFƒbƒN
		if( ( $row['hiera']!=0 && $cnt==0 ) ||
			( ($row['hiera']-$b_hiera)>1 ) ){
			$flag = 1 ;
		}else{
			$flag = 0 ;
		}
		//db update
		$xoopsDB->query( "UPDATE $table_menu SET blockid=$newblock, flag=$flag WHERE subid=".$row['subid'] );
		//after process
		$b_hiera = $row['hiera'];
		$cnt++;
	}
}

function makeFlow(){
	global $table_menu, $xoopsDB;
	$sql = "SELECT count(*) FROM $table_menu WHERE flag=1";
	list( $error ) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	$ret = false;
	if( $error < 1 ){
		$sql = "SELECT subid,hiera FROM $table_menu ORDER BY sortnum ASC";
		$result = $xoopsDB->query($sql);
		$b_hiera = $b_flow = 0;
		while( $row = $xoopsDB->fetchArray($result) ){
			if( $row['hiera'] == 0 ) {
				$flow = "0";
			}else{
				$gap = $row['hiera'] - $b_hiera;
				if( $gap == 1 )  $flow = $b_flow .'-'. $b_subid;
				if( $gap == 0 )  $flow = $b_flow ;
				if( $gap < 0 ){
					$tempflow = explode("-",$b_flow);
					for($i=0; $i<=($row['hiera']) ; $i++){
						$tempf[] = $tempflow[$i];
					}
					$flow = join( '-' , $tempf );
				}
			}
			$sql = "UPDATE $table_menu SET flow='$flow' WHERE subid=". $row['subid'];
			$xoopsDB->query($sql) or die( "DB Error: make flow : ". $row['subid'] ) ;
			$b_hiera = $row['hiera'];
			$b_flow = $flow;
			$b_subid = $row['subid'];
			unset($tempf);
		}
		$ret = true ;
	}
	return $ret;
}

function tmCodeDecode($text){
	$patterns[] = "/javascript:/si";
	$replacements[] = "java script:";
	$patterns[] = "/about:/si";
	$replacements[] = "about :";
	$ret = preg_replace($patterns, $replacements, $text);
	return $ret;
}


?>