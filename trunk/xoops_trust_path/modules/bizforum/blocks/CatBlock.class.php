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
class Bizforum_CatBlock extends Legacy_BlockProcedure
{
	var $mCount = array();

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
        $this->_mOptions = array();
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
		$form = "";
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
		$objects = array();
	
        //get module asset for handlers
        $asset = null;
        XCube_DelegateUtils::call(
            'Module.bizforum.Global.Event.GetAssetManager',
            new XCube_Ref($asset),
            $this->_mBlock->get('dirname')
        );
	
    	//use subcriteria for permitted ids
        require_once BIZFORUM_TRUST_PATH . '/class/XcatHandler.class.php';
        $xcatHandler = new Bizforum_XcatHandler($this->_mBlock->get('dirname'));
        $this->_mObject = $xcatHandler->getCatList('viewer');
    
    	//set number of news for each category
        $this->_mHandler =& $asset->getObject('handler','topic');
    	foreach(array_keys($this->_mObject) as $key){
    		$criteria = new CriteriaCompo('1', '1');
    		$criteria->add(new Criteria('cat_id', $this->_mObject[$key]['cat_id']));
    		$countArr[$this->_mObject[$key]['cat_id']] = $this->_mHandler->getCount($criteria);
    	}
    	
    	$this->mCount = $countArr;
	
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
        $render->setAttribute('block', $this->_mObject);
        $render->setAttribute('catUrl', XOOPS_URL ."/modules/". $this->_mBlock->get('dirname') ."/index.php?action=TopicList&amp;cat_id=%s");
        $render->setAttribute('dirname', $this->_mBlock->get('dirname'));
    	$render->setAttribute('countArr', $this->mCount);
        
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        $renderSystem->renderBlock($render);
    }
}

?>
