<?php

if (! function_exists('b_d3downloads_toprank_show') ) {
	function b_d3downloads_toprank_show( $options )
	{
		global $xoopsConfig ;
		$db =& Database::getInstance() ;
		$myts =& MyTextSanitizer::getInstance() ;

		include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
		include_once dirname( dirname(__FILE__) ).'/class/block_download.php' ;

		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , b_d3downloads_allowed_order() ) ? 'd.hits DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$max_size = empty( $options[4] ) ?  25 : intval( $options[4] )  ;
		$date_format = empty( $options[5] ) ? 'Y/m/d' :  htmlspecialchars ( $options[5] , ENT_QUOTES ) ;
		$block_type= empty( $options[6] ) ? 1 : intval( $options[6] ) ;
		$this_template = empty( $options[7] ) ? 'db:'.$mydirname.'_block_toprank.html' : trim( $options[7] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$user_access = new user_access( $mydirname ) ;
		$whr = "d.cid IN (".implode(",", $user_access->can_read() ).")" ;
		// categories
		if( $categories === array() ) {
			$whr_categories = '1' ;
		} else {
			$whr_categories = 'd.cid IN ('.implode(',',$categories).')' ;
		}
		$block_download = new block_download( $mydirname ) ;
		$downdata = $block_download->get_downdata_for_block( $whr, $max_entry, $max_size, $date_format, $block_type, $selected_order, $whr_categories );

		if( ! empty( $downdata ) ){
			$block['download'] = $downdata ;
			$block['mydirname'] = $mydirname ;
			$block['mod_url'] = XOOPS_URL.'/modules/'.$mydirname ;
			$block['selected_order'] = $selected_order;
			$block['type'] = $block_type;
			$block['lang_title'] = _MB_D3DOWNLOADS_LANG_TITLE;
			$block['lang_category'] = _MB_D3DOWNLOADS_LANG_CTITLE;
			$block['lang_postname'] = _MB_D3DOWNLOADS_LANG_POSTNAME;
			$block['lang_hits'] = _MB_D3DOWNLOADS_LANG_HITS;
			$block['lang_rating'] = _MB_D3DOWNLOADS_LANG_RATING;
			$block['lang_votes'] = _MB_D3DOWNLOADS_LANG_VOTES;
			$block['lang_updated'] = _MB_D3DOWNLOADS_LANG_DATE;

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
	}
}

if (! function_exists('b_d3downloads_toprank_edit') ) {
	function b_d3downloads_toprank_edit( $options )
	{
		$mydirname = empty( $options[0] ) ? 'd3downloads' : $options[0] ;
		$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
		$selected_order = empty( $options[2] ) || ! in_array( $options[2] , b_d3downloads_allowed_order() ) ? 'd.hits DESC' : $options[2] ;
		$max_entry = empty( $options[3] ) ? 10 : intval( $options[3] )  ;
		$max_size = empty( $options[4] ) ?  25 : intval( $options[4] )  ;
		$date_format = empty( $options[5] ) ? 'Y/m/d' :  htmlspecialchars ( $options[5] , ENT_QUOTES ) ;
		$block_type= empty( $options[6] ) ? 1 : intval( $options[6] ) ;
		if( $block_type == 1 ) {
			$block_type_1 = "checked='checked'" ;
			$block_type_2 = "" ;
			$block_type_3 = "" ;
		} elseif( $block_type == 2 ) {
			$block_type_1 = "" ;
			$block_type_2 = "checked='checked'" ;
			$block_type_3 = "" ;
		} elseif( $block_type == 3 ) {
			$block_type_1 = "" ;
			$block_type_2 = "" ;
			$block_type_3 = "checked='checked'" ;
		}
		$this_template = empty( $options[7] ) ? 'db:'.$mydirname.'_block_toprank.html' : trim( $options[7] ) ;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( array(
			'mydirname' => $mydirname ,
			'categories' => $categories ,
			'categories_imploded' => implode( ',' , $categories ) ,
			'order_options' => b_d3downloads_allowed_order() ,
			'selected_order' => $selected_order ,
			'max_entry' => $max_entry ,
			'max_size' => $max_size ,
			'date_format' => $date_format ,
			'block_size_1' => $block_type_1 ,
			'block_size_2' => $block_type_2 ,
			'block_size_3' => $block_type_3 ,
			'this_template' => $this_template ,
		) ) ;
		return $tpl->fetch( 'db:'.$mydirname.'_blockedit_toprank.html' ) ;
	}
}

if (! function_exists('b_d3downloads_allowed_order') ) {
	function b_d3downloads_allowed_order()
	{
		return array(
			'd.hits' ,
			'd.hits DESC' ,
			'd.rating' ,
			'd.rating DESC' ,
			'd.votes' ,
			'd.votes DESC' ,
			'd.title' ,
			'd.title DESC' ,
			'd.date' ,
			'd.date DESC' ,
		) ;
	}
}
?>