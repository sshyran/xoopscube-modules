<?php

require_once dirname(dirname(dirname(__FILE__))).'/d3pipes/joints/D3pipesBlockAbstract.class.php' ;

class D3pipesBlockCouponslistSubstance extends D3pipesBlockAbstract {

	var $target_dirname = '' ;
	var $trustdirname = 'coupons' ;

	function init()
	{
		// parse and check option for this class
		$params = array_map( 'trim' , explode( '|' , $this->option ) ) ;
		if( empty( $params[0] ) ) {
			$this->errors[] = _MD_D3PIPES_ERR_INVALIDDIRNAMEINBLOCK."\n($this->pipe_id)" ;
			return false ;
		}
		$this->target_dirname = preg_replace( '/[^0-9a-zA-Z_-]/' , '' , $params[0] ) ;

		// configurations (file, name, block_options)
		$this->func_file = XOOPS_ROOT_PATH.'/modules/'.$this->target_dirname.'/blocks/blocks.php' ;
		$this->func_name = 'b_coupons_top_show' ;
		$this->block_options = array(
			'disable_renderer' => true ,
			0 => $this->target_dirname , // mydirname
			1 => 0 , // ORDER BY regidate DESC
			2 => empty( $params[2] ) ? 10 : intval( $params[2] ) , // number
			3 => empty( $params[3] ) ? '' : $params[3] , // category
		) ;

		return true ;
	}


	function reassign( $data )
	{
		$entries = array() ;
		foreach( $data['coupons'] as $cp ) {
			$entry = array(
				'pubtime' => $cp['regidate_STP'] , 
				'link' => XOOPS_URL.'/modules/'.$this->target_dirname.'/index.php?lid='.$cp['lid'] ,
				'headline' =>  $this->unhtmlspecialchars($cp['title'])  ,//
			) ;
			$entry['fingerprint'] = $entry['link'] ;
			$entries[] = $entry ;
		}
		return $entries ;
	}

}

?>