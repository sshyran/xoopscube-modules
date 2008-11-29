<?php
/**
 * @file
 * @package bizpoll
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZPOLL_TRUST_PATH . '/class/AbstractEditAction.class.php';
require_once BIZPOLL_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizpoll_EnqEditAction
**/
class Bizpoll_EnqEditAction extends Bizpoll_AbstractEditAction
{
	var $mUseCat = false;

    /**
     * _getId
     * @param   void
     * @return  int
    **/
    protected function _getId()
    {
        return $this->mRoot->mContext->mRequest->getRequest('enq_id');
    }

	/**
	 * @protected
	 */
	protected function _getCatId()
	{
		if(! $this->mRoot->mContext->mRequest->getRequest('cat_id')){
			return 0;
		}
	
		$xcatHandler = new Bizpoll_Xcathandler($this->mAsset->mDirname);
		if($xcatHandler->checkPermit($this->mRoot->mContext->mRequest->getRequest('cat_id'), 'poster')){
			return intval($this->mRoot->mContext->mRequest->getRequest('cat_id'));
		}
		else{	//unpermitted category request
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
		}
	}

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizpoll_EnqHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'enq');
        return $handler;
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
        // $this->mActionForm =& new Bizpoll_EnqEditForm();
        $this->mActionForm =& $this->mAsset->getObject('form', 'enq', false, 'edit');
        $this->mActionForm->prepare();
    }

	/**
	 * @public
	 */
	public function prepare()
	{
		$xcatHandler = new Bizpoll_XcatHandler($this->mAsset->mDirname);
	
		$this->mUseCat = ($this->mModule->getModuleConfig('gr_id')>0) ? true : false;
	
		parent::prepare();
		//check permission of without category
		if(! $this->mUseCat && ! $this->mRoot->mContext->mXoopsUser){
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
		}
	
		if ($this->mObject->isNew()) {
			if($this->mRoot->mContext->mXoopsUser){
				$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			}
			if($this->mUseCat){
				$this->mObject->set('cat_id', $this->_getCatId());
			}
		}
		else{
			if(! $xcatHandler->checkPermit($this->mObject->get('cat_id'), 'editor', $this->mObject->get('uid'))){
				$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
			}
		}
	}

    /**
     * executeViewInput
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewInput(/*** XCube_RenderTarget ***/ &$render)
    {
    	//get category trees
    	if($this->mUseCat){
	    	$xcatHandler = new Bizpoll_XcatHandler($this->mAsset->mDirname);
	    	$cat = $xcatHandler->getCatList($xcatHandler->getPermitTitle('poster'));
	        $render->setAttribute('catArr', $cat);
	    }
        $render->setTemplateName($this->mAsset->mDirname . '_enq_edit.html');
        $render->setAttribute('actionForm', $this->mActionForm);
        $render->setAttribute('object', $this->mObject);
        $render->setAttribute('useCat', $this->mUseCat);
		$render->setAttribute('useEditor', $this->mModule->getModuleConfig('editor'));
    
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		if($this->mModule->getModuleConfig('editor')=='fckeditor'){
			$moduleHeader .= '<script type="text/javascript" src="'.XOOPS_URL.'/common/fckeditor/fckeditor.js"></script>';
		}
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/common/jquery/date/ui.datepicker.css" />
<script type="text/javascript">
google.load("language", "1"); 
google.load("jquery", "1");
google.load("jqueryui", "1");
</script>
<script type="text/javascript">
google.setOnLoadCallback(function() {
  $(".datePick").datepicker({dateFormat:"yy/mm/dd"});';

	if($this->mObject->get('end_unixtime')<86400){
		$moduleHeader .= '  $("#legacy_xoopsform_end_date").datepicker("disable");';
	}
	else{
		$moduleHeader .= '  $("#displayEndDatetime").css("display", "none");
  $("#removeEndDatetime").css("display", "block");';
	}

		$moduleHeader .= '  $("#displayAbstract").click(function(){
    $("#legacy_xoopsform_abstract").css("display", "block")
  });
  $("#displayEndDatetime").click(function(){
    $("#legacy_xoopsform_end_date").datepicker("enable");
    $("#legacy_xoopsform_end_date").datepicker("setDate", new Date());
    $("#displayEndDatetime").css("display", "none");
    $("#removeEndDatetime").css("display", "block");
  });
  $("#removeEndDatetime").click(function(){
    $("#legacy_xoopsform_end_date").datepicker("disable");
    $("#legacy_xoopsform_end_date").datepicker("setDate", new Date(0));
    $("#displayEndDatetime").css("display", "block");
    $("#removeEndDatetime").css("display", "none");
  });
});
</script>';
		if($this->mModule->getModuleConfig('editor')=='fckeditor'){
			$moduleHeader .= '<script type="text/javascript" src="'.XOOPS_URL.'/common/fckeditor/fckeditor.js"></script>
<script type="text/javascript"><!--
	function fckeditor_exec() {
		var oFCKeditor = new FCKeditor("legacy_xoopsform_description" , "100%" , "500" , "Default");
		oFCKeditor.BasePath = "'.XOOPS_URL.'/common/fckeditor/";
		oFCKeditor.ReplaceTextarea();
	}
// --></script>';
		}
		$render->setAttribute('xoops_module_header', $moduleHeader);
    }

    /**
     * executeViewSuccess
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
    {
        $this->mRoot->mController->executeForward('./index.php?action=EnqView&enq_id='. $this->mObject->getShow('enq_id'));
    }

    /**
     * executeViewError
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewError(/*** XCube_RenderTarget ***/ &$render)
    {
        $this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_DBUPDATE_FAILED);
    }

    /**
     * executeViewCancel
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewCancel(/*** XCube_RenderTarget ***/ &$render)
    {
        $this->mRoot->mController->executeForward('./index.php?action=EnqList');
    }

    /**
     * execute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    public function execute()
    {
		$xcatHandler = new Bizpoll_XcatHandler($this->mAsset->mDirname);
		if(! $xcatHandler->checkPermit($this->mObject->get('cat_id'), 'editor', $this->mObject->get('uid'))){
			$this->mRoot->mController->executeRedirect('./index.php?action=EnqList', 1, _MD_BIZPOLL_ERROR_NOT_PERMITTED);
		}
   	
        if ($this->mObject == null)
        {
            return BIZPOLL_FRAME_VIEW_ERROR;
        }
    
        if ($this->mRoot->mContext->mRequest->getRequest('_form_control_cancel') != null)
        {
            return BIZPOLL_FRAME_VIEW_CANCEL;
        }
    
        $this->mActionForm->load($this->mObject);
    
        $this->mActionForm->fetch();
        $this->mActionForm->validate();
    
        if ($this->mActionForm->hasError())
        {
            return BIZPOLL_FRAME_VIEW_INPUT;
        }
    
        $this->mActionForm->update($this->mObject);
    
        return $this->_doExecute();
  
    }

}

?>
