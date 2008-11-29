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

/**
 * Sdoc_ContentBlock
**/
class Dbkmarken_BmBlock extends Legacy_BlockProcedure
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
        $opts = explode('|',$this->_mBlock->get('options'));
        $this->_mOptions = array(
            'limit'            => (intval($opts[0])>0 ? intval($opts[0]) : 5),
        );
        
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
        if(!$this->prepare())
        {
            return null;
        }
    
		$form = "<label for='dispNum'>"._AD_DBKMARKEN_LANG_DISPLAY_NUMBER."</label>&nbsp;:
		<input type='text' size='5' name='options[0]' id='dispNum' value='".$this->getBlockOption('limit')."' />\n" ;
		return $form;
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
    	//get limit number from block option
    	$limit = $this->getBlockOption('limit');
    
        //get module asset for handlers
        $asset = null;
        XCube_DelegateUtils::call(
            'Module.dbkmarken.Global.Event.GetAssetManager',
            new XCube_Ref($asset),
            $this->_mBlock->get('dirname')
        );
	
        $this->_mHandler =& $asset->getObject('handler','bm');
	
		$bmCriteria = new CriteriaCompo('1', '1');
		$bmCriteria->setSort('reg_unixtime');
		$bmCriteria->setOrder('DESC');
		$bmCriteria->setLimit($limit);
	
		$objects = & $this->_mHandler->getObjects($bmCriteria);
	
		//get tags for each bookmark
		$tagHandler =& $asset->getObject('handler','tag');
		foreach(array_keys($objects) as $key){
			$objects[$key]->mTag =& $tagHandler->getObjects(new Criteria('bm_id', $objects[$key]->get('bm_id')));
		}
	
        $this->_mObject = $objects;
    
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
        $render->setAttribute('bm',$this->_mObject);
        $render->setAttribute('dirname',$this->_mBlock->get('dirname'));
        
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        $renderSystem->renderBlock($render);
    }
}

?>
