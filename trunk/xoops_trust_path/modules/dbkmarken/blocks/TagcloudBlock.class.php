<?php
/**
 * @file
 * @package sdoc
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit();
}

require_once DBKMARKEN_TRUST_PATH . "/includes/getTagCloud.php";
require_once DBKMARKEN_TRUST_PATH . "/class/Module.class.php";

/**
 * Sdoc_ContentBlock
**/
class Dbkmarken_TagcloudBlock extends Legacy_BlockProcedure
{
    /**
     * @var Sdoc_ItemsHandler
     * 
     * @private
    **/
    var $_mHandler = null;
    
    /**
     * @var Sdoc_ItmesObject
     * 
     * @private
    **/
    var $_mOject = null;
    
    /**
     * @var string[]
     * 
     * @private
    **/
    var $_mOptions = array();
    
    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  bool
     * 
     * @public
    **/
    function prepare()
    {
        return parent::prepare() && $this->_parseOptions() && $this->_setupObject();
    }
    
    /**
     * _parseOptions
     * 
     * @param   void
     * 
     * @return  bool
     * 
     * @private
    **/
    function _parseOptions()
    {
        return true;
    }
    
    /**
     * getBlockOption
     * 
     * @param   string  $key
     * 
     * @return  string
     * 
     * @public
    **/
    function getBlockOption($key)
    {
        return isset($this->_mOptions[$key]) ? $this->_mOptions[$key] : null;
    }
    
    /**
     * getOptionForm
     * 
     * @param   void
     * 
     * @return  string
     * 
     * @public
    **/
    function getOptionForm()
    {
    }
    
    /**
     * _setupObject
     * 
     * @param   void
     * 
     * @return  bool
     * 
     * @private
    **/
    function _setupObject()
    {
        //get module asset for handlers
        /*
        $asset = null;
        XCube_DelegateUtils::call(
            'Module.dbkmarken.Global.Event.GetAssetManager',
            new XCube_Ref($asset),
            $this->_mBlock->get('dirname')
        );
        */
	
        //$this->_mHandler =& $asset->getObject('handler','bm');
	
		$handler =& xoops_gethandler('module');
		$module =& $handler->getByDirname($this->_mBlock->get('dirname'));
		$moduleRunner = new Dbkmarken_Module($module);

		//TagCloud
		$where = "";
		$this->_mObject = Dbkmarken_GetTagCloud($where, $moduleRunner->getModuleConfig('tagcloud_min'), $moduleRunner->getModuleConfig('tagcloud_max'), $this->_mBlock->get('dirname'));

		return true;
    }

    /**
     * execute
     * 
     * @param   void
     * 
     * @return  void
     * 
     * @public
    **/
    function execute()
    {
        $root =& XCube_Root::getSingleton();
    
        $render =& $this->getRenderTarget();
        $render->setTemplateName($this->_mBlock->get('template'));
        $render->setAttribute('block',$this->_mObject);
        $render->setAttribute('dirname',$this->_mBlock->get('dirname'));
        
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        $renderSystem->renderBlock($render);
    }
}

?>
