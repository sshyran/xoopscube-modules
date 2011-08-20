<?php
/**
 * @version $Id: D3pipesBlockAbstractXCL2.class.php ,ver0.00 2011-07-04 04:15:00 domifara $
 * @brief block for Xoops Cube Legacy
 * @@author domifara
 */


class D3pipesBlockAbstract extends D3pipesBlockAbstractBase {

	// constructor
	public function D3pipesBlockAbstract( $mydirname , $pipe_id , $option )
	{
		parent::__construct($mydirname , $pipe_id , $option);
	}

	function execute( $dummy = '' , $max_entries = '' )
	{

		if( ! $this->init() ) {
			return array() ;
		}

		global $xoopsDB;

		//convert class_name to func_name
		if ( !empty($this->class_name) ) {
			$this->func_name = 'cl::'.preg_replace('/^'.$this->target_dirname.'_/i','',$this->class_name ) ;
		}

		//get bid
		$sql = "SELECT bid FROM " .$xoopsDB->prefix("newblocks"). " WHERE dirname=".$xoopsDB->quoteString($this->target_dirname)." AND show_func=".$xoopsDB->quoteString($this->func_name)." AND block_type='M' ";
		$result = $xoopsDB->query($sql);
		list( $bid ) = $xoopsDB->fetchRow($result);

		// bid check
		if( empty( $bid ) ) {
			$this->errors[] = _MD_D3PIPES_ERR_INVALIDFILEINBLOCK."\n".' bid not found : target_dirname='.$this->target_dirname.' func_name='.$this->func_name.' ('.get_class( $this ).')' ;
			return array() ;
		}
		//----------  get block object  ----------//
		$blockHandler =& xoops_gethandler('block');
		$blockObject =& $blockHandler->get($bid);
		if ( ! is_object($blockObject)) {
			$this->errors[] = _MD_D3PIPES_ERR_INVALIDFILEINBLOCK."\n".' block object not found : target_dirname='.$this->target_dirname.' func_name='.$this->func_name.' ('.get_class( $this ).')' ;
			return array() ;
		}

		// file check
		if( ! file_exists( $this->func_file ) ) {
			$this->errors[] = _MD_D3PIPES_ERR_INVALIDFILEINBLOCK."\n".$this->func_file.' ('.get_class( $this ).')' ;
			return array() ;
		}
		require_once $this->func_file ;

		//d3module check
		$b_template = $blockObject->getVar('template');

		if( (function_exists( $this->func_name ) && empty($b_template)) || array_key_exists ( 'disable_renderer' , $this->block_options )) {
			$block = parent::execute( $dummy , $max_entries );
			return $block;
		}

		//XCL AND other Xoops single module
		$options_separated = implode('|', $this->block_options);
		$blockObject->set('options',$options_separated);
		//get tager of block
		$blockProcedure =& Legacy_Utils::createBlockProcedure($blockObject);
		$blockProcedure->execute();
		$target =& $blockProcedure->getRenderTarget();
		$buffer = $target->getAttributes() ;

		if (array_key_exists('block',$buffer)){
			$block = $buffer['block'];
		}else{
			//class type
			$block = $buffer;
		}
		// update lastfetch_time
		$db =& Database::getInstance() ;
		$db->queryF( "UPDATE ".$db->prefix($this->mydirname."_pipes")." SET lastfetch_time=UNIX_TIMESTAMP() WHERE pipe_id=$this->pipe_id" ) ;

		return $this->reassign( $block ) ;
	}

}


?>