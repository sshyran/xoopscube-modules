<?php
require_once $mytrustdirpath . '/include/functions.php';

function b_miniamazon_newitem_show( $options )
{
	global $xoopsDB ;
	$myts =& MyTextSanitizer::getInstance() ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$items_num = empty( $options[1] ) ? 5 : intval( $options[1] ) ;
	$title_max_length = empty( $options[2] ) ? 20 : intval( $options[2] ) ;
	$cols = empty( $options[3] ) ? 1 : intval( $options[3] ) ;
	$this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_newitem.html' : trim( $options[4] ) ;


	//DB table
	$table_items = $xoopsDB->prefix( $mydirname."_items" ) ;
	$table_cat = $xoopsDB->prefix( $mydirname."_cat" ) ;

	$block = array() ;

	$sql = "SELECT l.lid, l.cid, l.uid, l.description, l.regdate, l.clicks, l.title, l.ASIN, l.Creator, l.Manufacturer, l.ProductGroup, l.MediumImage, l.DetailPageURL, l.IsAdult, c.ctitle FROM $table_items l LEFT JOIN $table_cat c ON l.cid=c.cid WHERE l.stats>0 ORDER BY l.regdate DESC";
	$result = $xoopsDB->query( $sql , $items_num , 0 ) ;

	$count = 1 ;
	while( $item = $xoopsDB->fetchArray( $result ) ) {
		$item['title'] = $myts->makeTboxData4Show( $item['title'] ) ;
		if( ! isset( $options['disable_renderer'] ) ){
			if( strlen( $item['title'] ) >= $title_max_length ) {
				if( ! XOOPS_USE_MULTIBYTES ) {
					$item['title'] = substr( $item['title'] , 0 , $title_max_length - 1 ) . "..." ;
				} else if( function_exists( 'mb_strcut' ) ) {
					$item['title'] = mb_strcut( $item['title'] , 0 , $title_max_length - 1 ) . "..." ;
				}
			}
		}
		$item['ctitle'] = $myts->makeTboxData4Show( $item['ctitle'] ) ;
		$item['description'] = strip_tags($myts->displayTarea( $item['description'] , 0 , 0 , 1 , 1 , 1 ) );
		if( ! isset( $options['disable_renderer'] ) ){
			$descmax = 30;	//30 SET
			if( strlen( $item['description'] ) >= $descmax ) {
				if( ! XOOPS_USE_MULTIBYTES ) {
					$item['description'] = substr( $item['description'] , 0 , $descmax - 1 ) . "..." ;
				} else if( function_exists( 'mb_strcut' ) ) {
					$item['description'] = mb_strcut( $item['description'] , 0 , $descmax - 1 ) . "..." ;
				}
			}
		}
		$item['ASIN']          = $myts->makeTboxData4Show( $item['ASIN'] ) ;

		//‹É¬ THUMBZZZA¬ TZZZZZZZA’† MZZZZZZZA‘å LZZZZZZZ
		$image_url = "http://images-jp.amazon.com/images/P/". $item['ASIN'] .".09.THUMBZZZ.jpg";
		if (! check_Image_URL($image_url)) {
			$image_url = FALSE;
		} else {
			$imgsize = @getimagesize($image_url);
			if( $imgsize != false && $imgsize[0] == 1 && $imgsize[1] == 1 ){
				$image_url = FALSE;
			}
		}

		$item['Creator']       = $myts->makeTboxData4Show( $item['Creator'] ) ;
		$item['Manufacturer']  = $myts->makeTboxData4Show( $item['Manufacturer'] ) ;
		$item['ProductGroup']  = $myts->makeTboxData4Show( $item['ProductGroup'] ) ;
		$item['MediumImage']   = $image_url ;
		$item['DetailPageURL'] = $myts->makeTboxData4Show( $item['DetailPageURL'] ) ;
		$item['regtimestamp']  = $item['regdate'] ;
		$item['regdate']       = formatTimestamp( $item['regdate'] , 's' ) ;

		$block['items'][$count++] = $item ;
	}
	$block['mod_url'] = XOOPS_URL . '/modules/' . $mydirname ;
	$block['cols'] = $cols ;
	$block['width'] = intval( 100 / $cols ) ;

	//adult check
	$miniamazon_age = ( empty($_COOKIE['miniamazon_age']) ) ? 0 : intval($_COOKIE['miniamazon_age']) ;
	$block['ma_age'] = $miniamazon_age ;
	

	if( empty( $options['disable_renderer'] ) ) {
		$tpl =& new XoopsTpl();
		$tpl->assign( 'block' , $block );
		$ret['content'] = $tpl->fetch( $this_template );
		return $ret ;
	} else {
		return $block ;
	}
}


function b_miniamazon_newitem_edit( $options )
{
	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$items_num = empty( $options[1] ) ? 5 : intval( $options[1] ) ;
	$title_max_length = empty( $options[2] ) ? 20 : intval( $options[2] ) ;
	$cols = empty( $options[3] ) ? 1 : intval( $options[3] ) ;

	return "<input type='hidden' name='options[0]' value='{$mydirname}' />
		"._MB_MINIAMAZON_EDIT_NUM_DISP." &nbsp;
		<input type='text' size='4' name='options[1]' value='$items_num' style='text-align:right;' />
		<br />
		"._MB_MINIAMAZON_EDIT_TEXT_STRLENGTH." &nbsp;
		<input type='text' size='6' name='options[2]' value='$title_max_length' style='text-align:right;' />
		<br />
		"._MB_MINIAMAZON_EDIT_TEXT_COLS."&nbsp;
		<input type='text' size='2' name='options[3]' value='$cols' style='text-align:right;' />
		<br />
		\n" ;
}



?>