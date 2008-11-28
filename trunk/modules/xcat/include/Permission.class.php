<?php

/* HIKAWA Kilica 											*/
/* format Permissions from Perm Table into html format		*/
/* 2008.05.20												*/

class Xcat_Permission
{
	var $mCat = null;
	var $mGroupArr = array();
	var $mTypeArr = array();
	var $mPerm = array();	//$mPerm['value'][groupid][key], $mPerm['key'][groupid][key]
	var $_mTargetCat = "";	//target category: current("cur") or ancestral("anc")

	function Xcat_Permission($cat)
	{
		$this->mCat = $cat;
		$this->mCat->loadGr();
		$this->setTypeArr();
		$this->setGroupArr();
	}

	//set the array of XOOPS user groups
	function setGroupArr()
	{
		//get the list of user groups
		$groupHandler =& xoops_gethandler('member');
		$group =& $groupHandler->getGroups();
		$g = 0;
		foreach(array_keys($group) as $key){
			$this->mGroupArr['groupid'][$g] = $group[$key]->get('groupid');
			$this->mGroupArr['name'][$g] = $group[$key]->get('name');
			$g++;
		}
	}

	//set permission type master from Gr "options"
	function setTypeArr()
	{
		$typeArr = unserialize($this->mCat->mGr->get('options'));
		$i = 0;
		foreach(array_keys($typeArr) as $key){
			$this->mTypeArr['key'][$i] = $key;
			$this->mTypeArr['name'][$i] = $typeArr[$key];
			$i++;
		}
	}

	//set category's permission values from Perm in from of groupid-permissionKey matrix
	function setPermissions($permissionsArr, $target='cur')
	{
		foreach(array_keys($permissionsArr) as $keyG){
			$g = array_search($permissionsArr[$keyG]->get('groupid'), $this->mGroupArr['groupid']);
			$permissions = unserialize($permissionsArr[$keyG]->get('permissions'));
			//$target: 'cur' or 'anc'
			$this->mPerm['perm_id'][$g][$target] = $permissionsArr[$keyG]->get('perm_id');
			if($g!==false){	//$g may be false in case the group is deleted
				foreach(array_keys($permissions) as $keyP){
					$t = array_search($keyP, $this->mTypeArr['key']);
					if($t!==false){	//$t may be false in case the type is deleted
						$this->mPerm['key'][$g][$t][$target] = $keyP;
						$this->mPerm['value'][$g][$t][$target] = $permissions[$keyP];
					}
				}
			}
		}
	}

	//search permission retroactively
	function getAncestralPermissions()
	{
		$catPath = unserialize($this->mCat->get('cat_path'));
		//get the ancestral permissions
		//if this cat is top level, cat_path should be null.
		if(count($catPath)>0){
			//sort $catPath by descendant order
			$catPathR = array_reverse($catPath, TRUE);
			$permHandler =& xoops_getmodulehandler('perm');
			foreach(array_keys($catPathR) as $keyP){	//$keyP:catPathR
				//get permissions filtered by $catPathR cat_id
				$permArr =& $permHandler->getObjects(new Criteria('cat_id', $keyP));
				if(count($permArr)>0){
					return $permArr;
				}
			}
		}
		//TODO:set default value
		
	}

	//check permission by group, type
	function checkPerm($g, $t)
	{
		return $this->mPerm['value'][$g][$t][$this->getTargetCat()];
	}

	//get the key of permission type
	function getPermKey($g)
	{
		return $this->mPerm['key'][$g];
	}

	function getTargetCat()
	{
		return $this->_mTargetCat;
	}

	function setTargetCat($targetCat)
	{
		$this->_mTargetCat = $targetCat;
	}


}
?>
