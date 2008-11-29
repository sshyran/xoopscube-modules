<?php

function flatdata_urlCheckReplace( $text )
{
	$returntext = '' ;
	$returntext = preg_replace( 
		array("/[[:cntrl:]]/","/javascript:/si","/about:/si","/vbscript:/si") , 
		array("","java script :","about :","vb script :") ,
		$text 
	);
	return $returntext ;
}

function flatdata_singleNavi( $alldid , $current_did , $nwin=5 )
{
	$navi_html = "" ;
	$numrows = count( $alldid ) ;
	$pos = array_search( $current_did , $alldid ) ;
	if( $numrows > 1 ) {
		//PREV and HEAD
		if( $alldid[0] != $current_did ) {
			$navi_html .= "<a href='index.php?did=".$alldid[0]."' title='To the head'>|&lt;&lt; </a>&nbsp;&nbsp;";
			$navi_html .= "<a href='index.php?did=".$alldid[$pos-1]."'>&laquo; Prev</a>&nbsp;&nbsp;";
		}

		if( $numrows > $nwin ) {
			if( $pos > $nwin / 2 ) {
				if( $pos > round( $numrows - ( $nwin / 2 ) - 1 ) ) {
					$start = $numrows - $nwin + 1 ;
				} else {
					$start = round( $pos - ( $nwin / 2 ) ) + 1 ;
				}
			} else {
				$start = 1 ;
			}
		} else {
			$start = 1 ;
		}
	
		for( $i = $start; $i < $numrows + 1 && $i < $start + $nwin ; $i++ ) {
			if( $alldid[$i-1] == $current_did ) {
				$navi_html .= "[". $alldid[$i-1] ."]&nbsp;&nbsp;";
			} else {
				$navi_html .= "<a href='index.php?did=".$alldid[$i-1]."'>". $alldid[$i-1] ."</a>&nbsp;&nbsp;";
			}
		}

		//NEXT and TAIL
		if( $alldid[$numrows-1] != $current_did ) {
			$navi_html .= "<a href='index.php?did=".$alldid[$pos+1]."'>Next &raquo;</a>&nbsp;&nbsp;" ;
			$navi_html .= "<a href='index.php?did=".$alldid[$numrows-1]."' title='To the tail'> &gt;&gt;|</a>" ;
		}
	}

	return $navi_html ;
}

if( !function_exists('getUnameFromUid') ){
	function getUnameFromUid( $uid )
	{
		$name = '' ;
		if( $uid > 0 ) {
			$member_handler =& xoops_gethandler('member') ;
			$uid_user =& $member_handler->getUser($uid) ;
			if( is_object( $uid_user ) ) {
				$name = htmlspecialchars( $uid_user->uname() , ENT_QUOTES ) ;
			}
		}
		return $name ;
	}
}

if( !function_exists('unhtmlspecialchars') ){
	function unhtmlspecialchars( $text , $quotes = ENT_QUOTES )
	{
		return strtr( $text , array_flip( get_html_translation_table( HTML_SPECIALCHARS , $quotes ) ) + array( '&#039;' => "'" ) ) ;
	}
}

?>