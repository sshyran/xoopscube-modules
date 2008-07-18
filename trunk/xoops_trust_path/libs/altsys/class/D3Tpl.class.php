<?php

require_once XOOPS_ROOT_PATH.'/class/template.php' ;
require_once XOOPS_TRUST_PATH.'/libs/altsys/include/altsys_functions.php' ;

class D3Tpl extends XoopsTpl {

	function D3Tpl() {
		parent::XoopsTpl() ;
		if( altsys_get_core_type() == ALTSYS_CORE_TYPE_X20S ) {
			array_unshift( $this->plugins_dir , XOOPS_TRUST_PATH.'/libs/altsys/smarty_plugins' ) ;
		}
	}
}

?>