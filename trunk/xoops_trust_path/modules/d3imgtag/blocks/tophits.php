<?php

if(! defined('D3IMGTAG_BLOCK_TOPHITS_INCLUDED')) {

define('D3IMGTAG_BLOCK_TOPHITS_INCLUDED' , 1);

function b_d3imgtag_tophits_show($options)
{
	global $xoopsDB ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$photos_num = empty( $options[1] ) ? 5 : intval( $options[1] ) ;
	$title_max_length = empty( $options[2] ) ? 20 : intval( $options[2] ) ;
	$cat_limitation = empty( $options[3] ) ? 0 : intval( $options[3] ) ;
	$cat_limit_recursive = empty( $options[4] ) ? 0 : 1 ;
	$cols = empty( $options[6] ) ? 1 : intval( $options[6] ) ;

	$this_template = 'db:'.$mydirname.'_block_tophits.html';

	require(dirname(dirname(__FILE__)).'/include/read_configs.php');

	// Category limitation
	if($cat_limitation) {
		if($cat_limit_recursive) {
			include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
			$cattree = new XoopsTree($table_cat , "cid" , "pid");
			$children = $cattree->getAllChildId($cat_limitation);
			$whr_cat = "l.cid IN (";
			foreach($children as $child) {
				$whr_cat .= "$child,";
			}
			$whr_cat .= "$cat_limitation)";
		} else {
			$whr_cat = "l.cid='$cat_limitation'";
		}
	} else {
		$whr_cat = '1' ;
	}

	$block = array();
	$myts =& MyTextSanitizer::getInstance();
	$result = $xoopsDB->query("SELECT l.lid , l.img, l.cid , l.title , l.ext , l.res_x , l.res_y , l.submitter , l.status , l.date AS unixtime , l.hits , l.rating , l.votes , l.comments , c.title AS cat_title FROM $table_photos l LEFT JOIN $table_cat c ON l.cid=c.cid WHERE l.status>0 AND $whr_cat ORDER BY hits DESC" , $photos_num , 0);

	$count = 1 ;
	while($photo = $xoopsDB->fetchArray($result)) {
		$photo['title'] = $myts->makeTboxData4Show($photo['title']);
		$photo['cat_title'] = $myts->makeTboxData4Show( $photo['cat_title'] ) ;
		if(strlen($photo['title']) >= $title_max_length) {
			if(! XOOPS_USE_MULTIBYTES) {
				$photo['title'] = substr($photo['title'] , 0 , $title_max_length - 1) . "...";
			} else if(function_exists('mb_strcut')) {
				$photo['title'] = mb_strcut($photo['title'] , 0 , $title_max_length - 1) . "...";
			}
		}
		$photo['suffix'] = $photo['hits'] > 1 ? 'hits' : 'hit' ;
		$photo['date'] = formatTimestamp($photo['unixtime'] , 's');
		$photo['thumbs_url'] = $thumbs_url ;

		if(in_array(strtolower($photo['ext']) , $d3imgtag_normal_exts)) {
			$width_spec = "width='$d3imgtag_thumbsize'";
			if($d3imgtag_makethumb) {
				list($width , $height , $type) = getimagesize("$thumbs_dir/{$photo['img']}.{$photo['ext']}");
				if($width <= $d3imgtag_thumbsize) 
				// if thumb images was made, 'width' and 'height' will not set.
				$width_spec = '' ;
			}
			$photo['width_spec'] = $width_spec ;
		} else {
			$photo['ext'] = 'gif' ;
			$photo['width_spec'] = '' ;
		}

		$block['photo'][$count++] = $photo ;
	}
	$block['mod_url'] = $mod_url ;
	$block['cols'] = $cols ;

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


function b_d3imgtag_tophits_edit($options)
{
	global $xoopsDB ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$photos_num = empty( $options[1] ) ? 5 : intval( $options[1] ) ;
	$title_max_length = empty( $options[2] ) ? 20 : intval( $options[2] ) ;
	$cat_limitation = empty( $options[3] ) ? 0 : intval( $options[3] ) ;
	$cat_limit_recursive = empty( $options[4] ) ? 0 : 1 ;
	$cols = empty( $options[6] ) ? 1 : intval( $options[6] ) ;

	include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");

	$cattree = new XoopsTree($xoopsDB->prefix("{$mydirname}_cat") , "cid" , "pid");

	ob_start();
	$cattree->makeMySelBox("title" , "title" , $cat_limitation , 1 , 'options[3]');
	$catselbox = ob_get_contents();
	ob_end_clean();

	return "
		"._MB_D3IMGTAG_TEXT_DISP." &nbsp;
		<input type='hidden' name='options[0]' value='{$mydirname}' />
		<input type='text' size='4' name='options[1]' value='$photos_num' style='text-align:right;' />
		<br />
		"._MB_D3IMGTAG_TEXT_STRLENGTH." &nbsp;
		<input type='text' size='6' name='options[2]' value='$title_max_length' style='text-align:right;' />
		<br />
		"._MB_D3IMGTAG_TEXT_CATLIMITATION." &nbsp; $catselbox
		"._MB_D3IMGTAG_TEXT_CATLIMITRECURSIVE."
		<input type='radio' name='options[4]' value='1' ".($cat_limit_recursive?"checked='checked'":"")."/>"._YES."
		<input type='radio' name='options[4]' value='0' ".($cat_limit_recursive?"":"checked='checked'")."/>"._NO."
		<br />
		<input type='hidden' name='options[5]' value='' />
		"._MB_D3IMGTAG_TEXT_COLS."&nbsp;
		<input type='text' size='2' name='options[6]' value='$cols' style='text-align:right;' />
		<br />
		\n";
}

function b_d3imgtag_tophits_p_show($options)
{
	global $xoopsDB ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$photos_num = empty( $options[1] ) ? 5 : intval( $options[1] ) ;
	$title_max_length = empty( $options[2] ) ? 20 : intval( $options[2] ) ;
	$cat_limitation = empty( $options[3] ) ? 0 : intval( $options[3] ) ;
	$cat_limit_recursive = empty( $options[4] ) ? 0 : 1 ;
	$cols = empty( $options[6] ) ? 1 : intval( $options[6] ) ;

	$this_template = 'db:'.$mydirname.'_block_tophits_p.html';

	require(dirname(dirname(__FILE__)).'/include/read_configs.php');

	// Category limitation
	if($cat_limitation) {
		if($cat_limit_recursive) {
			include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
			$cattree = new XoopsTree($table_cat , "cid" , "pid");
			$children = $cattree->getAllChildId($cat_limitation);
			$whr_cat = "l.cid IN (";
			foreach($children as $child) {
				$whr_cat .= "$child,";
			}
			$whr_cat .= "$cat_limitation)";
		} else {
			$whr_cat = "l.cid='$cat_limitation'";
		}
	} else {
		$whr_cat = '1' ;
	}

	$block = array();
	$myts =& MyTextSanitizer::getInstance();
	$result = $xoopsDB->query("SELECT l.lid , l.img, l.cid , l.title , l.ext , l.res_x , l.res_y , l.submitter , l.status , l.date AS unixtime , l.hits , l.rating , l.votes , l.comments , c.title AS cat_title FROM $table_photos l LEFT JOIN $table_cat c ON l.cid=c.cid WHERE l.status>0 AND $whr_cat ORDER BY hits DESC" , $photos_num , 0);

	$count = 1 ;
	while($photo = $xoopsDB->fetchArray($result)) {
		$photo['title'] = $myts->makeTboxData4Show($photo['title']);
		$photo['cat_title'] = $myts->makeTboxData4Show( $photo['cat_title'] ) ;
		if(strlen($photo['title']) >= $title_max_length) {
			if(! XOOPS_USE_MULTIBYTES) {
				$photo['title'] = substr($photo['title'] , 0 , $title_max_length - 1) . "...";
			} else if(function_exists('mb_strcut')) {
				$photo['title'] = mb_strcut($photo['title'] , 0 , $title_max_length - 1) . "...";
			}
		}
		$photo['suffix'] = $photo['hits'] > 1 ? 'hits' : 'hit' ;
		$photo['date'] = formatTimestamp($photo['unixtime'] , 's');
		$photo['thumbs_url'] = $thumbs_url ;

		if(in_array(strtolower($photo['ext']) , $d3imgtag_normal_exts)) {
			$width_spec = "width='$d3imgtag_thumbsize'";
			if($d3imgtag_makethumb) {
				list($width , $height , $type) = getimagesize("$thumbs_dir/{$photo['img']}.{$photo['ext']}");
				if($width <= $d3imgtag_thumbsize) 
				// if thumb images was made, 'width' and 'height' will not set.
				$width_spec = '' ;
			}
			$photo['width_spec'] = $width_spec ;
		} else {
			$photo['ext'] = 'gif' ;
			$photo['width_spec'] = '' ;
		}

		$block['photo'][$count++] = $photo ;
	}
	$block['mod_url'] = $mod_url ;
	$block['cols'] = $cols ;

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


function b_d3imgtag_tophits_p_edit($options)
{
	global $xoopsDB ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$photos_num = empty( $options[1] ) ? 5 : intval( $options[1] ) ;
	$title_max_length = empty( $options[2] ) ? 20 : intval( $options[2] ) ;
	$cat_limitation = empty( $options[3] ) ? 0 : intval( $options[3] ) ;
	$cat_limit_recursive = empty( $options[4] ) ? 0 : 1 ;
	$cols = empty( $options[6] ) ? 1 : intval( $options[6] ) ;

	include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");

	$cattree = new XoopsTree($xoopsDB->prefix("{$mydirname}_cat") , "cid" , "pid");

	ob_start();
	$cattree->makeMySelBox("title" , "title" , $cat_limitation , 1 , 'options[3]');
	$catselbox = ob_get_contents();
	ob_end_clean();

	return "
		"._MB_D3IMGTAG_TEXT_DISP." &nbsp;
		<input type='hidden' name='options[0]' value='{$mydirname}' />
		<input type='text' size='4' name='options[1]' value='$photos_num' style='text-align:right;' />
		<br />
		"._MB_D3IMGTAG_TEXT_STRLENGTH." &nbsp;
		<input type='text' size='6' name='options[2]' value='$title_max_length' style='text-align:right;' />
		<br />
		"._MB_D3IMGTAG_TEXT_CATLIMITATION." &nbsp; $catselbox
		"._MB_D3IMGTAG_TEXT_CATLIMITRECURSIVE."
		<input type='radio' name='options[4]' value='1' ".($cat_limit_recursive?"checked='checked'":"")."/>"._YES."
		<input type='radio' name='options[4]' value='0' ".($cat_limit_recursive?"":"checked='checked'")."/>"._NO."
		<br />
		<input type='hidden' name='options[5]' value='' />
		"._MB_D3IMGTAG_TEXT_COLS."&nbsp;
		<input type='text' size='2' name='options[6]' value='$cols' style='text-align:right;' />
		<br />
		\n";
}

}

?>