<?php

class Xcat_TreeObject
{
	var $mGrId = 0;	//category group id(gr_id)
	var $mTree = array();
	var $_mPreparedFlag = false;	//flag if Gr is set
	var $_mTreeLoadedFlag = false;	//flag if CatTree is loaded
	var $mHandler = null;	//Cat handler
	var $mCount = 0;	//counter for $mTree

	/**
	 * @private
	 * constructor
	 */
	function Xcat_TreeObject($gr_id=0)
	{
		$this->mHandler =& xoops_getmodulehandler('cat', 'xcat');

		if(intval($gr_id)>0){
			$this->mGrId = intval($gr_id);
			$this->_loadGr();
			if($this->mGr){
				$this->_mPreparedFlag = true;
			}
		}
	}

	/**
	 * @private
	 */
	function _loadGr()
	{
		if($this->mGrId){
			$handler = xoops_getmodulehandler('gr', 'xcat');
			$this->mGr = $handler->get($this->mGrId);
		}
	}

	/**
	 * @public
	 * load Gr by the given cat_id.
	 * You can use this function when you can't assign gr_id 
	 * at object constructor because of you don't know gr_id value.
	 */
	function loadGrByCatId($cat_id=0)
	{
		if($cat_id){
			$handler = xoops_getmodulehandler('cat', 'xcat');
			$cat = $handler->get($cat_id);
			if(is_object($cat)){
				$this->mGrId = intval($cat->get('gr_id'));
				$this->_loadGr();
				if(is_object($this->mGr))
					$this->_mPreparedFlag = true;
				}
			}
		
	}

	/**
	 * @public
	 * load Category Tree.
	 * if already loaded, do nothing.
	 */
	function loadTree($p_id=0, $dirname="")
	{
		//if gr_id is not set, or if $mTree is already loaded,
		//do nothing in this function.
		if($this->_mPreparedFlag==true && $this->_mTreeLoadedFlag==false){
			$this->_loadTree($p_id, $dirname);
			$this->_mTreeLoadedFlag = true;
		}
	}

	/**
	 * @private
	 * load Categories retroactively and set $mTree array 
	 * in order of category tree.
	 */
	function _loadTree($p_id=0, $dirname="")
	{
		$criteria = new CriteriaCompo('1', '1');
		$criteria->add(new Criteria('gr_id', $this->mGrId));
		$criteria->add(new Criteria('p_id', $p_id));
		$criteria->setSort('weight');
		$catArr =& $this->mHandler->getObjects($criteria);
		foreach(array_keys($catArr) as $key){
			//check module confinement
			if($catArr[$key]->checkDirname($dirname)){
				$this->mTree[$this->mCount] = $catArr[$key];
				$this->mCount++;
				$this->_loadTree($catArr[$key]->get('cat_id'), $dirname);
			}
		}
	}

	/**
	 * @public
	 * add deleted flag on unpermititted categories by uid and action
	 */
	function filterCatByUser($action, $uid=0)
	{
		if($this->_mTreeLoadedFlag==true){
			$handler =& xoops_getmodulehandler('groups_users_link', 'user');
		
			if(intval($uid)>0){
				$groupArr =& $handler->getObjects(new Criteria('uid', $uid));
			}
			else{
				$groupHandler = xoops_getmodulehandler('groups', 'user');
				$groupArr =& $groupHandler->getObjects('group_type', 'Anonymous');
			}
			//check permission of each cat in the given tree
			foreach(array_keys($this->mTree) as $keyT){
				$cat =& $this->mHandler->get($this->mTree[$keyT]->get('cat_id'));
				$permitArr = $cat->getThisPermit();
			
				$checkFlg = false;	//permission check flag
				//check if the user has permission about this category
				foreach(array_keys($permitArr) as $keyP){
					foreach(array_keys($groupArr) as $keyG){
						if($permitArr[$keyP]->get('groupid')==$groupArr[$keyG]->get('groupid')){
							if($permitArr[$keyP]->checkPermit($action)){
								$checkFlg = true;
							}
						}
					}
				}
				//if the user don't have the permission, omit the cat from the tree
				if($checkFlg==false){
					//unset($tree[$keyT]);
					$this->mTree[$keyT]->mDelFlag = true;
				}
			}
		}
	}

}
?>