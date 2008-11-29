<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractListAction.class.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/getTagCloud.php";

class Dbkmarken_BmTopicsAction extends Dbkmarken_AbstractListAction
{

	var $tagCloud = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', "bm");
		return $handler;
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
				$objects[$key]->loadTag($this->mAsset->mDirname);
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
		if($this->mRoot->mContext->mRequest->getRequest('uid')){
			$where= 'uid='. intval($this->mRoot->mContext->mRequest->getRequest('uid'));
		}
		$this->tagCloud = Dbkmarken_GetTagCloud($where, $this->mModule->getModuleConfig('tagcloud_min'), $this->mModule->getModuleConfig('tagcloud_max'), $this->mAsset->mDirname);
		
		return DBKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . "_bm_topics.html");
        $render->setAttribute('dirname',$this->mAsset->mDirname);
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
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);
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
