<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZFORUM_TRUST_PATH . '/class/AbstractListAction.class.php';
require_once BIZFORUM_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizforum_PostListAction
**/
class Bizforum_PostListAction extends Bizforum_AbstractListAction
{
	var $mTopicId = 0;
	var $mTopic = null;
	var $mCatTitle = "";
	var $mCatPath = array();
	var $mActionForm = null;
	var $mIsEditor = false;

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizforum_PostHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'post');
        return $handler;
    }

    /**
     * &_getFilterForm
     * 
     * @param   void
     * 
     * @return  Bizforum_PostFilterForm
    **/
    protected function &_getFilterForm()
    {
        // $filter =& new Bizforum_PostFilterForm();
        $filter =& $this->mAsset->getObject('filter', 'post',false);
        $filter->prepare($this->_getPageNavi(), $this->_getHandler());
        return $filter;
    }

    /**
     * _getBaseUrl
     * 
     * @param   void
     * 
     * @return  string
    **/
    protected function _getBaseUrl()
    {
        return './index.php?action=PostList';
    }

	function prepare()
	{
		parent::prepare();
		$this->_setupActionForm();
	
		//topic id is required
		if(intval($this->mRoot->mContext->mRequest->getRequest('topic_id'))>0){
			$this->mTopicId = intval($this->mRoot->mContext->mRequest->getRequest('topic_id'));
		}
		else{
			$this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_NO_TOPIC_REQUESTED);
		}
	
	}

	/**
	 * @public
	 */
	function getDefaultView()
	{
		$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
	
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		$handler =& $this->_getHandler();
		$criteria=$this->mFilter->getCriteria();
	
		$this->mObjects =& $handler->getObjects($criteria);
		foreach(array_keys($this->mObjects) as $key){
			$this->mObjects[$key]->loadReplyPath($this->mAsset->mDirname);
		}
	
		//get Topic
		$topicHandler =& $this->mAsset->getObject('handler', 'topic');
		$this->mTopic = & $topicHandler->get($this->mTopicId);
	
		//set values in ActionForm
        $this->mActionForm->set('post_id', 0);
        $this->mActionForm->set('p_id', 0);
        $this->mActionForm->set('topic_id', $this->mTopicId);
        if($this->mRoot->mContext->mXoopsUser){
	        $this->mActionForm->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
	    }
	
		//check view permission
		if(! $xcatHandler->checkPermit($this->mTopic->get('cat_id'), $xcatHandler->getPermitTitle('viewer'))){
			$this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
		}
		//check edit permission
		if($xcatHandler->checkPermit($this->mTopic->get('cat_id'), $xcatHandler->getPermitTitle('editor'))){
			$this->mIsEditor = true;
		}
	
		//get category path
		$this->mCatTitle = $xcatHandler->getTitle($this->mTopic->get('cat_id'));
		$this->mCatPath = $xcatHandler->getCatPath($this->mTopic->get('cat_id'));
		//var_dump($this->mCatPath);die();
	
		return BIZFORUM_FRAME_VIEW_INDEX;
	}

    /**
     * _setupActionForm
     * 
     * @param   void
     * 
     * @return  void
    **/
    protected function _setupActionForm()
    {
        // $this->mActionForm =& new Bizforum_PostEditForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'post',false,'edit');
        $this->mActionForm->prepare();
    }

    /**
     * executeViewIndex
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
    {
        $render->setTemplateName($this->mAsset->mDirname . '_post_list.html');
        #cubson::lazy_load_array('post', $this->mObjects);
        $render->setAttribute('objects', $this->mObjects);
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('topic', $this->mTopic);
        $render->setAttribute('isEditor', $this->mIsEditor);
        $render->setAttribute('catTitle', $this->mCatTitle);
        $render->setAttribute('catPathArr', $this->mCatPath);
        $render->setAttribute('dirname', $this->mAsset->mDirname);
        $render->setAttribute('pageNavi', $this->mFilter->mNavi);

		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
	
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("language", "1"); 
google.load("jquery", "1");
google.load("jqueryui", "1");
</script>
<script type="text/javascript" src="'.XOOPS_URL.'/common/jquery/cluetip/jquery.cluetip.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/common/jquery/cluetip/jquery.cluetip.css" />
<script type="text/javascript">
google.setOnLoadCallback(function() {
$(".replyPost").click(function(){
$(".'. $this->mAsset->mDirname .'_replyField").empty();
pId = $(this).attr("id").split("_");
$("#legacy_xoopsform_p_id").val(pId[2]);
if(! $("#legacy_xoopsform_uid").val()){
$("#'. $this->mAsset->mDirname .'_replyField_"+pId[2]).append("'. _MD_BIZFORUM_LANG_GUEST_NAME .'<input type=\'input\' id=\'legacy_xoopsform_guest_name\' name=\'guest_name\'>");
}
$("#'. $this->mAsset->mDirname .'_replyField_"+pId[2]).append("'. _MD_BIZFORUM_LANG_BODYTEXT .'<textarea rows=\'7\' cols=\'40\' id=\'legacy_xoopsform_bodytext\' name=\'bodytext\'></textarea><input type=\'submit\' value=\''. _SUBMIT .'\' />");
});
$(".loadPost").cluetip({width: "350", height:"300", closePosition:"title", activation:"click", sticky:true});
});
</script>';
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}
}

?>
