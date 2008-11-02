<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/cubookmarken/include/getTagCloud.php";

class Cubookmarken_BmTopicsAction extends Cubookmarken_AbstractListAction
{

	var $tagCloud = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "bm");
		return $handler;
	}

	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
		// $filter =& new Cubookmarken_BmFilterForm();
		$filter =& $this->mAsset->create('filter', "bm");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	/**
	 * @protected
	 */
	function _getBaseUrl()
	{
		return "./index.php?action=BmTopics";
	}


	//kilica	override AbstructActionForm
	/**
	 * @public
	 */
	function getDefaultView()
	{
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		$handler =& $this->_getHandler();
		$criteria = $this->mFilter->getCriteria($start = null, $limit = 300);
		//within 2 weeks
		$criteria->add(new Criteria('reg_unixtime', time() - $this->mModule->getModuleConfig('popular_term') * 86400, '>'));
		$criteria->setSort('url');
		$objects =& $handler->getObjects($criteria);	
		
		if($objects){
			foreach(array_keys($objects) as $key)
			{
				$objects[$key]->loadTag();
				//count users who bookmarks the same url
				$objects[$key]->bm_count = $handler->getCount(new Criteria('url', $objects[$key]->get('url')));
				//check script insertion attack
				$myts = new MyTextSanitizer();
				if(! $myts->checkUrlString($objects[$key]->get('url'))){
					$objects[$key]->set('url', "");
					$objects[$key]->set('bm_title', "*** This may be bookmarked by attacker ! ***");
				}
			}
			
			//omit duplicated url and count these url
			$i = 0;
			$bm_count = 0;
			$url = $objects[0]->get('url');
			foreach(array_keys($objects) as $key2){
				if($url == $objects[$key2]->get('url')){
					$bm_count = $bm_count + 1;
					if($bm_count >= $this->mModule->getModuleConfig('popular_count')){
						$this->mObjects[$i] = $objects[$key2];
						$this->mObjects[$i]->setVar('bm_count', $bm_count);
					}
				}
				else{
					$bm_count = 1;
					$url = $objects[$key2]->get('url');
					$i++;
					if($bm_count >= $this->mModule->getModuleConfig('popular_count')){
						$this->mObjects[$i] = $objects[$key2];
						$this->mObjects[$i]->setVar('bm_count', $bm_count);
					}
				}
			}
			//sort by register unixtime(desc)
			usort($this->mObjects, 'object_sort_desc');
		}
		
		//TagCloud
		$where ="";
		if(xoops_getrequest('uid')){
			$where= 'uid='. intval(xoops_getrequest('uid'));
		}
		$this->tagCloud = getTagCloud($where, $this->mModule->getModuleConfig('tagcloud_min'), $this->mModule->getModuleConfig('tagcloud_max'));
		
		return CUBOOKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName("cubookmarken_bm_topics.html");
		#cubson::lazy_load_array('bm', $this->mObjects);
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
	
		$render->setAttribute('tagCloud', $this->tagCloud);
	
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$render->setAttribute('allow_useredit', false);
		}
		else{
			$render->setAttribute('allow_useredit', true);
		}
	
		//set module header
		if($this->mRoot->mContext->mModule->getModuleConfig('css_file')){
			$render->setAttribute('xoops_module_header','<link rel="stylesheet" type="text/css" media="screen" href="'. XOOPS_URL . $this->mRoot->mContext->mModule->getModuleConfig('css_file') .'" />');
		}
	}
}

function object_sort_asc($a, $b)
{
    if ($a->get('reg_unixtime') == $b->get('reg_unixtime')) {
        return 0;
    }
    return $a->get('reg_unixtime') > $b->get('reg_unixtime') ? 1 : -1;


}

function object_sort_desc($a, $b)
{
    if ($a->get('reg_unixtime') == $b->get('reg_unixtime')) {
        return 0;
    }
    return $a->get('reg_unixtime') < $b->get('reg_unixtime') ? 1 : -1;


}

?>
