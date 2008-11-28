<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Xcat_CatObject extends XoopsSimpleObject
{
	var $mTargetFlag = "";
	var $mDelFlag = false;
	var $mGr = null;
	var $_mGrLoadedFlag = false;
	var $mPermit = null;
	var $_mPermitLoadedFlag = false;
	var $mPcat = null;
	var $_mPcatLoadedFlag = false;
	var $mChildren = null;
	var $_mChildrenLoadedFlag = false;
	var $mCatPath = array();
	var $_mCatPathLoadedFlag = false;

	/**
	 * @public
	 */
	function Xcat_CatObject()
	{
		$this->initVar('cat_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('cat_title', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('gr_id', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('p_id', XOBJ_DTYPE_INT, '0', false);
		$this->initVar('modules', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('imageurl', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('cat_desc', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('weight', XOBJ_DTYPE_INT, '10', false);
		$this->initVar('options', XOBJ_DTYPE_TEXT, '', false);
	}

	/**
	 * @public
	 * for delegate
	 */
	function &getSingleton()
	{
		static $instance;
	
		if (!is_object($instance)) {
			$instance = new Xcat_CatObject();
		}
	
		return $instance;
	}

	/**
	 * @public
	 * load Gr Object of this category.
	 */
	function loadGr()
	{
		if ($this->_mGrLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('gr', 'xcat');
			$this->mGr =& $handler->get($this->get('gr_id'));
			$this->_mGrLoadedFlag = true;
		}
	}

	/**
	 * @public
	 * load Permit Objects of this category.
	 */
	function loadPermit($criteria = null)
	{
		if ($this->_mPermitLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('permit', 'xcat');
			if($criteria){
				$this->mPermit =& $handler->getObjects($criteria);
			}else{
				$this->mPermit =& $handler->getObjects(new Criteria('cat_id', $this->get('cat_id')));
			}
			$this->_mPermitLoadedFlag = true;
		}
	}

	/**
	 * @public
	 */
	function &createPermit()
	{
		$handler =& xoops_getmodulehandler('permit', 'xcat');
		$obj =& $handler->create();
		$obj->set('cat_id', $this->get('cat_id'));
		return $obj;
	}

	/**
	 * @public
	 * load parent category Object of this category.
	 */
	function loadPcat()
	{
		if ($this->_mPcatLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('cat', 'xcat');
			$this->mPcat =& $handler->get($this->get('p_id'));
			$this->_mPcatLoadedFlag = true;
		}
	}

	/**
	 * @public
	 * 
	 */
	function getDepth()
	{
		$this->loadCatPath();
		return count($this->mCatPath['cat_id']) + 1;
	}

	/**
	 * @public
	 * load child categories Objects of this category.
	 */
	function loadChildren($dirname="")
	{
		if ($this->_mChildrenLoadedFlag == false) {
			$handler =& xoops_getmodulehandler('cat', 'xcat');
			$criteria = new CriteriaCompo('1', '1');
			$criteria->add(new Criteria('p_id', $this->get('cat_id')));
			$criteria->setSort('weight', 'ASC');
			$children =& $handler->getObjects(new Criteria('p_id', $this->get('cat_id')));
			//check module confinement
			foreach(array_keys($children) as $key){
				if($children[$key]->checkDirname($dirname)){
					$this->mChildren[] = $children[$key];
				}
				
			}
			$this->_mChildrenLoadedFlag = true;
		}
	}

	/**
	 * @public
	 * get child categories' id and title array.
	 */
	function getChildList($dirname="")
	{
		$this->loadChildren($dirname);
		foreach(array_keys($this->mChildren) as $key){
			$children['cat_id'][$key] = $this->mChildren[$key]->getShow('cat_id');
			$children['cat_title'][$key] = $this->mChildren[$key]->getShow('cat_title');
		}
		return $children;
	}

	/**
	 * @public
	 * call load category function if not loaded yet.
	 */
	function loadCatPath(){
		//set this category's parent cat_id
		if($this->_mCatPathLoadedFlag==false){
			$this->mCatPath['cat_id'] = array();
			$this->mCatPath['cat_title'] = array();
			$this->mCatPath['modules'] = array();
			$p_id = $this->get('p_id');
			$this->_loadCatPath($p_id);
			$this->_mCatPathLoadedFlag=true;
		}
	}

	/**
	 * @private
	 * load category path array retroactively.
	 */
	function _loadCatPath($p_id){
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($p_id);
		if(is_object($cat)){
			$this->mCatPath['cat_id'][] = $cat->getShow('cat_id');
			$this->mCatPath['cat_title'][] = $cat->getShow('cat_title');
			$this->mCatPath['modules'][] = $cat->getShow('modules');
			$this->_loadCatPath($cat->get('p_id'));
		}
	}

	/**
	 * @public
	 * get the permissions for this category.
	 * At first, check the permission of this category.
	 * If the permission is not set, check the upper category's permission retroactively.
	*/
	function getThisPermit($groupid=0)
	{
		$permitHandler =& xoops_getmodulehandler('permit', 'xcat');
		$criteria=new CriteriaCompo('1', '1');
		$criteria->add(new Criteria('cat_id', $this->get('cat_id')));
		if(intval($groupid)>0){
			$criteria->add(new Criteria('groupid', $groupid));
		}

		//if this category don't have permissions, check the upper category's permissions retroactively
		if($permitArr =& $permitHandler->getObjects($criteria)){
			$this->mTargetFlag = 'cur';	//current cat has permission
			return $permitArr;
		}
		else{
			//get the category path from the top category in descendant order
			$this->loadCatPath();
			//check if the category has permission in order
			foreach(array_keys($this->mCatPath['cat_id']) as $key){
				$criteria2 = new CriteriaCompo('1', '1');
				$criteria2->add(new Criteria('cat_id', $this->mCatPath['cat_id'][$key]));
				if(intval($groupid)>0){
					$criteria2->add(new Criteria('groupid', $groupid));
				}
				$permitArr =& $permitHandler->getObjects($criteria2);
				if($permitArr){
					break 1;
				}
			}
			//set default permissions from Gr, if any permission is set in this Category Tree
			if(! $permitArr){
				$grHandler =& xoops_getmodulehandler('gr', 'xcat');
				$gr =& $grHandler->get($this->get('gr_id'));
				$actions = unserialize($gr->get('actions'));
				foreach(array_keys($actions['title']) as $keyG){
					$permissions[$keyG] = $actions['default'][$keyG];
				}
				if(intval($groupid)>0){
					$permitArr[0] = $permitHandler->create();
					$permitArr[0]->set('cat_id', $this->get('cat_id'));
					$permitArr[0]->set('permissions', serialize($permissions));
					$permitArr[0]->set('groupid', $groupid);
					$permitArr[0]->set('uid', 0);
				}
				else{
					$groupHandler =& xoops_gethandler('member');
					$group =& $groupHandler->getGroups();
					foreach(array_keys($group) as $keyM){
						$permitArr[$keyM] = $permitHandler->create();
						$permitArr[$keyM]->set('cat_id', $this->get('cat_id'));
						$permitArr[$keyM]->set('permissions', serialize($permissions));
						$permitArr[$keyM]->set('groupid', $group[$keyM]->get('groupid'));
						$permitArr[$keyM]->set('uid', 0);
					}
				}
			}
		
			$this->mTargetFlag = 'anc';	//ancestoral cat has permission
			return $permitArr;
		}
	}

	/**
	 * @public
	 * get the user specific permissions for this category.
	 * At first, check the permission of this category.
	 * If the permission is not set, check the upper category's permission retroactively.
	*/
	function getThisUserPermit()
	{
		$uidArr = array();
	
		$permitHandler =& xoops_getmodulehandler('permit', 'xcat');
		$criteria=new CriteriaCompo('1', '1');
		$criteria->add(new Criteria('cat_id', $this->get('cat_id')));
		$criteria->add(new Criteria('uid', '0', '>'));
	
		//if this category don't have permissions, check the upper category's permissions retroactively
		$permitArr[$this->get('cat_id')] =& $permitHandler->getObjects($criteria);
	
		foreach(array_keys($permitArr[$this->get('cat_id')]) as $key){
			//add uids already found, in order to omit them in the following process
			$uidArr[] = $permitArr[$this->get('cat_id')][$key]->get('uid');
		}
	
		//get the category path from the top category in descendant order
		$this->loadCatPath();
	
		//check if the category has permission in order
		foreach(array_keys($this->mCatPath['cat_id']) as $key){
			$catId = $this->mCatPath['cat_id'][$key];
			$criteria2 = new CriteriaCompo('1', '1');
			$criteria2->add(new Criteria('cat_id', $catId));
			$criteria2->add(new Criteria('uid', '0', '>'));
			//omit uids already found
			foreach(array_keys($uidArr) as $key2){
				$criteria2->add(new Criteria('uid', $uidArr[$key2], "!="));
			}
		
			$permitArr[$catId] =& $permitHandler->getObjects($criteria2);
		
			foreach(array_keys($permitArr[$catId]) as $key3){
				//add uids already found, in order to omit them in the following process
				$uidArr[] = $permitArr[$catId][$key3]->get('uid');
			}
		}
	
		$retArr = array();
		foreach(array_keys($permitArr) as $key4){
			foreach(array_keys($permitArr[$key4]) as $key5){
				if(@$permitArr[$key4][$key5]){
					$retArr[] = $permitArr[$key4][$key5];
				}
			}
		}
	
		return $retArr;
	}

	/**
	 * @public
	 * check permission about the given uid and action.
	 * check about all groups the user is belong to.
	*/
	function checkPermitByUid($action, $uid=0, $dirname="")
	{
		//check group permission
		if(intval($uid)>0){
			$handler =& xoops_getmodulehandler('groups_users_link', 'user');
			$groups =& $handler->getObjects(new Criteria('uid', $uid));
		}
		else{	//case:guest
			$groupHandler = xoops_getmodulehandler('groups', 'user');
			$groups =& $groupHandler->getObjects(new Criteria('group_type', 'Anonymous'));
		}
		foreach(array_keys($groups) as $keyG){
			if($this->checkPermitByGroupid($action, $groups[$keyG]->get('groupid'), $dirname)){
				return true;
			}
		}
	
		//check module confinement
		if(! $this->checkDirname($dirname)){
			return false;
		}
	
		//check user specific permission ?
		$permitArr = $this->getThisUserPermit();
		foreach(array_keys($permitArr) as $keyP){
			if($permitArr[$keyP]->get('uid')==$uid){
				return true;
			}
		}
		return false;
	}

	/**
	 * @public
	 * check permission about the given groupid and action.
	*/
	function checkPermitByGroupid($action, $groupid, $dirname="")
	{
		//check this category is for specific dirname ?
		if(! $this->checkDirname($dirname)){
			return false;
		}
	
		$permitArr = $this->getThisPermit($groupid);
		//check illegal permission settings
		if(count($permitArr)>1){
			echo "duplicated permission settings about the combination of groupid and cat_id";
			die();
		}
		elseif(count($permitArr)==0){
			return false;
		}
		$permissions =unserialize($permitArr[0]->get('permissions'));
		if(@$permissions[$action]==1){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 *	@public
	 *  module confinement function
	 *  check specified dirname is set in the categories' modules field ?
	 */
	function checkDirname($dirname="")
	{
		if(! $dirname){
			return true;
		}
		$modulesArr = $this->getModulesArr();
		if(! $modulesArr){
			return true;
		}
		if(in_array($dirname, $modulesArr)){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 *	@public
	 *  module confinement function
	 *  get modules field of the nearest category from this one.
	 */
	function getModulesArr(){
		if($this->get('modules')){
			return explode(',', $this->get('modules'));
		}
	
		$this->loadCatPath();
		//search parent categories' modules confinement
		foreach(array_keys($this->mCatPath['modules']) as $key){
			if($this->mCatPath['modules'][$key]){
				return explode(',', $this->mCatPath['modules'][$key]);
			}
		}
	}

}

class Xcat_CatHandler extends XoopsObjectGenericHandler
{
	var $mTable = 'xcat_cat';
	var $mPrimary = 'cat_id';
	var $mClass = 'Xcat_CatObject';

	function delete(&$obj)
	{
		$handler =& xoops_getmodulehandler('permit');
		$handler->deleteAll(new Criteria('cat_id', $obj->get('cat_id')));
		unset($handler);

		return parent::delete($obj);
	}
}

?>
