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
class Dbkmarken_SingletagBlock extends Legacy_BlockProcedure
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
		$myts =& MyTextSanitizer::getInstance();
	
        $opts = explode('|',$this->_mBlock->get('options'));
        $this->_mOptions = array(
            'limit'	=> (intval($opts[0])>0 ? intval($opts[0]) : 5),
            'tag'	=> $myts->makeTboxData4Show($opts[1])
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
		$form = "<label for='". $this->_mBlock->get('dirname') ."block_dispNum'>"._AD_DBKMARKEN_LANG_DISPLAY_NUMBER."</label>&nbsp;:
		<input type='text' size='5' name='options[0]' id='". $this->_mBlock->get('dirname') ."block_dispNum' value='".$this->getBlockOption('limit')."' /><br />\n
		<label for='". $this->_mBlock->get('dirname') ."block_singletag'>"._AD_DBKMARKEN_LANG_TAG."</label>&nbsp;:
		<input type='text' size='32' name='options[1]' id='". $this->_mBlock->get('dirname') ."block_singletag' value='".$this->getBlockOption('tag')."' />\n" ;
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

    	//get block options
    	$limit = $this->getBlockOption('limit');
    	$tag = $this->getBlockOption('tag');
    
        //get module asset for handlers
        $asset = null;
        XCube_DelegateUtils::call(
            'Module.dbkmarken.Global.Event.GetAssetManager',
            new XCube_Ref($asset),
            $this->_mBlock->get('dirname')
        );
	
        $this->_mHandler =& $asset->getObject('handler','bm');
	
		global $xoopsDB;
		if($tag){
			$sql = "SELECT b.*, t.tag_name, t.bm_id FROM ".$xoopsDB->prefix($this->_mBlock->get('dirname') .'_bm') ." b LEFT JOIN ". $xoopsDB->prefix($this->_mBlock->get('dirname') .'_tag') ." t ON t.bm_id=b.bm_id WHERE t.tag_name='". $tag ."' ORDER BY b.reg_unixtime DESC LIMIT ". intval($limit);
			$result = $this->_mHandler->db->query($sql);
			if ($result) {
				while($row = $this->_mHandler->db->fetchArray($result)) {
					$obj =& new $this->_mHandler->mClass();
					$obj->assignVars($row);
					$obj->loadTag($this->_mBlock->get('dirname'));
					$obj->unsetNew();
				
					$objects[]=&$obj;
					unset($obj);
				}
			}
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
        $renderSystem->renderBlock($render);
    }
}

?>
