<?php

require_once dirname(dirname(__FILE__)).'/D3pipesBlockAbstract.class.php' ;

class D3pipesBlockMiniamazonitems extends D3pipesBlockAbstract {

	var $target_dirname = '' ;
	var $trustdirname = 'miniamazon' ;

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
		$this->func_name = 'b_miniamazon_newitem_show' ;
		$this->block_options = array(
			'disable_renderer' => true ,
			0 => $this->target_dirname , // mydirname
			1 => empty( $params[1] ) ? 5 : intval( $params[1] ) , // items_num
			2 => empty( $params[2] ) ? 20 : intval( $params[2] ) , // title_max_length
			3 => empty( $params[3] ) ? 1 : intval( $params[3] ) , // cols
		) ;

		return true ;
	}

	function reassign( $data )
	{
		$entries = array() ;
		foreach( $data['items'] as $item ) {
			$entry = array(
				'pubtime' => $item['regtimestamp'] , 
				'link' => $data['mod_url'].'/index.php?act=item&lid='.$item['lid'] ,
				'headline' =>  $item['title']  ,
				'description' =>  $item['description']  ,
			) ;
			$entry['fingerprint'] = $entry['link'] ;
			$entries[] = $entry ;
		}

		return $entries ;
	}

}

?>