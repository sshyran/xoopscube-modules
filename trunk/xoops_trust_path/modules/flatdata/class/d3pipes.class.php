<?php

require_once dirname(dirname(dirname(__FILE__))).'/d3pipes/joints/D3pipesBlockAbstract.class.php' ;

class D3pipesBlockFlatdatalistSubstance extends D3pipesBlockAbstract {

	var $target_dirname = '' ;
	var $trustdirname = 'flatdata' ;

	function init()
	{
		// parse and check option for this class
		$params = array_map( 'trim' , explode( '|' , $this->option ) ) ;
		if( empty( $params[0] ) ) {
			$this->errors[] = _MD_D3PIPES_ERR_INVALIDDIRNAMEINBLOCK."\n($this->pipe_id)" ;
			return false ;
		}
		$this->target_dirname = preg_replace( '/[^0-9a-zA-Z_-]/' , '' , $params[0] ) ;

		//perm check
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($this->target_dirname);
		$config_handler =& xoops_gethandler('config');
		$mid = $module->getVar('mid');
		$config =& $config_handler->getConfigsByCat(0,$mid);
		$embed_dispperm = intval($config['embed_disp_perm']) ;
		if( $embed_dispperm==1 ){
			return ;
		}

		// configurations (file, name, block_options)
		$this->func_file = XOOPS_ROOT_PATH.'/modules/'.$this->target_dirname.'/blocks/blocks.php' ;
		$this->func_name = 'b_flatdata_top_show' ;
		$this->block_options = array(
			'disable_renderer' => true ,
			0 => $this->target_dirname , // mydirname
			1 => 0 , //regidate DESC
			2 => empty( $params[2] ) ? 10 : intval( $params[2] ) , // number
			3 => empty( $params[3] ) ? '' : $params[3] , //FID to disp
		) ;

		return true ;
	}


	function reassign( $data )
	{
		$field = $data['field'] ;
		$entries = array() ;
		foreach( $data['datas'] as $fd ) {
			$entry = array(
				'pubtime' => $fd['regidate'] , 
				'link' => XOOPS_URL.'/modules/'.$this->target_dirname.'/index.php?did='.$fd['did'] ,
				'headline' => 'ID:'.$fd['did'].':'.$this->unhtmlspecialchars($fd['data'][$field])  ,
			) ;
			$entry['fingerprint'] = $entry['link'] ;
			$entries[] = $entry ;
		}
		return $entries ;
	}

}

?>