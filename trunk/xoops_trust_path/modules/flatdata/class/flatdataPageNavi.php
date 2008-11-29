<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' ) ;

class flatdataPageNavi extends XoopsPageNav
{
	var $extra_arg = '' ;
	var $navi_num = 4 ;

	function flatdataPageNavi( $rowsnum , $num , $p , $extra_arg_arr="" , $start_name='p' )
	{
		if( is_array($extra_arg_arr) ) $this->createExtraArg( $extra_arg_arr ) ;
		parent::XoopsPageNav( $rowsnum , $num , $p , $start_name , $this->extra_arg ) ;
	}

	function createExtraArg( $extra_arg_arr )
	{
		if( isset($extra_arg_arr['cat_id']) ) $this->extra_arg .= "page=categ&amp;cat_id=". intval($extra_arg_arr['cat_id']) ;
		if( isset($extra_arg_arr['ord']) ) $this->extra_arg .= $this->checkExtraArg() ."ord=". intval($extra_arg_arr['ord']) ;
		if( isset($extra_arg_arr['ao']) && isset($extra_arg_arr['sf']) && isset($extra_arg_arr['sq']) ){
			$this->extra_arg .= $this->checkExtraArg() ."ao=". intval($extra_arg_arr['ao']) ."&amp;sf=". intval($extra_arg_arr['sf']) ."&amp;sq=".rawurlencode(flatdata_urlCheckReplace($extra_arg_arr['sq'])) ;
		}
		if( isset($extra_arg_arr['uid']) && $extra_arg_arr['uid']>0 ) $this->extra_arg .= $this->checkExtraArg() ."uid=". intval($extra_arg_arr['uid']) ;
	}

	function checkExtraArg()
	{
		$ret= "" ;
		if( $this->extra_arg ) $ret ="&amp;" ;
		return $ret ;
	}

	function renderNav()
	{
		$nav_html = '' ;
		if( isset($_GET['nn']) && $_GET['nn']>0 && $_GET['nn']<=30 ) $this->navi_num = intval($_GET['nn']) ;
		$nav_html = parent::renderNav( $this->navi_num ) ;
		return $nav_html ;
	}

	function renderNavinfo()
	{
		$ret = '' ;
		$last = $this->current + $this->perpage ;
		if( $last > $this->total ) $last = $this->total ;
		$ret = sprintf( _MD_FLATDATA_NAVINFO , $this->current + 1 , $last , $this->total ) ;
		return $ret ;
	}


}
?>