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
class Bizforum_TopicBlock extends Legacy_BlockProcedure
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
            'limit'	=> (intval($opts[0])>0 ? intval($opts[0]) : 5),
            'catIds'	=> $opts[1]
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
		$form = "<label for='". $this->_mBlock->get('dirname') ."block_dispNum'>"._AD_BIZFORUM_LANG_DISPLAY_NUMBER."</label>&nbsp;:
		<input type='text' size='5' name='options[0]' id='". $this->_mBlock->get('dirname') ."block_dispNum' value='".$this->getBlockOption('limit')."' /><br />\n
		<label for='". $this->_mBlock->get('dirname') ."block_showCat'>"._AD_BIZFORUM_LANG_SHOW_CAT."</label>&nbsp;:
		<input type='text' size='64' name='options[1]' id='". $this->_mBlock->get('dirname') ."block_topic' value='".$this->getBlockOption('catIds')."' />\n" ;
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
		$catIdArr = array();

    	//get block options
    	$limit = $this->getBlockOption('limit');
    	if($this->getBlockOption('catIds')){
	    	$catIdArr = explode(',', $this->getBlockOption('catIds'));
	    }
    
        //get module asset for handlers
        $asset = null;
        XCube_DelegateUtils::call(
            'Module.bizforum.Global.Event.GetAssetManager',
            new XCube_Ref($asset),
            $this->_mBlock->get('dirname')
        );
	
        $this->_mHandler =& $asset->getObject('handler','topic');
        $criteria = new CriteriaCompo('1', '1');
        $criteria->addSort('last_unixtime', 'DESC');
        $criteria->setLimit($limit);
	
    	//use subcriteria for permitted ids
        require_once BIZFORUM_TRUST_PATH . '/class/XcatHandler.class.php';
        $xcatHandler = new Bizforum_XcatHandler($this->_mBlock->get('dirname'));
	    $catCriteria = new CriteriaCompo('1', '1');
    	if($catIdArr){	//get requested categories and check permission
	        foreach(array_keys($catIdArr) as $key){
	        	if($xcatHandler->checkPermit($catIdArr[$key], 'viewer')){
	        		$catCriteria->add(new Criteria('cat_id', $catIdArr[$key]));
	        	}
	        }
	        if($catCriteria->getCountChildElements()==0){
	        	return true;
	        }
	    }
	    else{	//get all permit categories
	    	$ids = $xcatHandler->getPermitCatIds(0, 'viewer');
	        foreach(array_keys($ids) as $key){
        		$catCriteria->add(new Criteria('cat_id', $ids[$key]), 'OR');
	        }
	    }
        $criteria->add($catCriteria);
    
        $objects = $this->_mHandler->getObjects($criteria);
        foreach(array_keys($objects) as $keyC){
        	$objects[$keyC]->countPost($this->_mBlock->get('dirname'));
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
        $render->setAttribute('block', $this->_mObject);
        $render->setAttribute('dirname', $this->_mBlock->get('dirname'));
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        //var_dump($renderSystem);die();
        $renderSystem->renderBlock($render);
    }
}

?>
