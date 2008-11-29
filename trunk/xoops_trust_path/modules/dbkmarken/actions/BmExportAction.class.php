<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractListAction.class.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/function.php";

class Dbkmarken_BmExportAction extends Dbkmarken_AbstractListAction
{

	var $mExportArr = null;
	var $mRequestUid = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', "bm");
		return $handler;
	}

	/**
	 * @public
	 */
	function isMemberOnly()
	{
		return true;
	}

	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
		// $filter =& new Dbkmarken_BmFilterForm();
		$filter =& $this->mAsset->getObject('filter', "bm");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function isAdminOnly()
	{
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$this->mAllowUseredit = "0";
			return true;
		}
		else{
			$this->mAllowUseredit = "1";
		}
	}

	/**
	 * @protected
	 */
	function _getBaseUrl()
	{
		return "./index.php?action=BmExport";
	}

	//kilica	overwrite AbstructActionForm
	/**
	 * @public
	 */
	function getDefaultView()
	{
		//set uid
		$this->mRequestUid = $this->mRoot->mContext->mXoopsUser->get('uid');

		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		//sort by registered time
		$handler =& $this->_getHandler();
		$criteria = $this->mFilter->getCriteria();
		$criteria->add(new Criteria('uid', $this->mRequestUid));
		$criteria->setLimit('0');
		$this->mObjects =& $handler->getObjects($criteria);
		foreach(array_keys($this->mObjects) as $key)
		{
			$this->mObjects[$key]->loadTag($this->mAsset->mDirname);

			$this->mExportArr[$key]['title'] = xoops_utf8_encode($this->mObjects[$key]->getShow('bm_title'));
			$this->mExportArr[$key]['link'] = $this->mObjects[$key]->getShow('url');
			$this->mExportArr[$key]['pubDate'] = $this->mObjects[$key]->getShow('reg_unixtime');
			$tags = "";
			foreach(array_keys($this->mObjects[$key]->mTag) as $keyT){
				if($tags==""){
					$tags = $this->mObjects[$key]->mTag[$keyT]->getShow('tag_name');
				}
				else{
					$tags = $tags . ',' . $this->mObjects[$key]->mTag[$keyT]->getShow('tag_name');
				}
			}
			$this->mExportArr[$key]['tags'] = xoops_utf8_encode($tags);
			$this->mExportArr[$key]['description'] = htmlspecialchars(xoops_utf8_encode($this->mObjects[$key]->get('memo')), ENT_QUOTES);
		}
		
		return DBKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		global $xoopsConfig;
	
		if($this->mRequestUid){
			$handler = xoops_gethandler('user');
			$user =& $handler->getObjects(new Criteria('uid', $this->mRequestUid));
			
			if($user[0]->getShow('name')){
				$username = $user[0]->getShow('name');
			}
			else{
				$username = $user[0]->getShow('uname');
			}
		}
		$exportTitle = xoops_utf8_encode($username) ."'s Bookmark in ". htmlspecialchars(xoops_utf8_encode($xoopsConfig['sitename']), ENT_QUOTES);

		$tpl = new XoopsTpl();
		$tpl->assign('exportTitle', $exportTitle);
		$tpl->assign('exportArr', $this->mExportArr);
        $tpl->assign('dirname', $this->mAsset->mDirname);
		$tpl->display("db:". $this->mAsset->mDirname . "_export.html");

	}
}

?>
