<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractListAction.class.php";

class Dbkmarken_BmCseAction extends Dbkmarken_AbstractListAction
{

	function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', 'bm');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =& $this->mAsset->getObject('filter', "bm");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=BmCse";
	}

	function getDefaultView()
	{
		$bmArr = array();
	
		$handler =& $this->_getHandler();
		$bmArr =& $handler->getObjects();
	
		foreach(array_keys($bmArr) as $key){
			$url = $bmArr[$key]->get('url');
			//format "~.jp*", "~.com*" is invalid in Linked CSE.
			//so, add "/" at the end of url.
			if(preg_match("{(.*)\/.*}i", $url2)==0){
				$url2 .= "/";
			}
			//search the whole site/directory
			if ($this->mModule->getModuleConfig('cse_replaceurl') == '1'){
				$url2 = preg_replace("{(.*)\/.*\.(htm|html)$}i", "$1/", $url);
				$url2 .= "*";
			}
			else{	//search only bookmarked page
				$url2 = $url;
			}
			$bmArr[$key]->set('url', $url2);
		}
		$this->mObjects = $bmArr;
		return DBKMARKEN_FRAME_VIEW_INDEX;

	}

	function executeViewIndex(&$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . "_bm_cse.xml");
        $render->setAttribute('dirname',$this->mAsset->mDirname);
		$render->setAttribute('objects', $this->mObjects);

		//RSS Data create
		if (function_exists('mb_http_output')) {
			mb_http_output('pass');
		}
		header ('Content-Type:text/xml; charset=utf-8');
		$tpl = new XoopsTpl();
		$tpl->assign('objects', $this->mObjects);

		$tpl->display("db:". $this->mAsset->mDirname ."_bm_cse.xml");
	}


}

?>
