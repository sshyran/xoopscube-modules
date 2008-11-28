<?php

/* HIKAWA Kilica 											*/
/* format Permissions from Permit Table into html format		*/
/* 2008.05.20												*/

class Xcat_Permission
{
	var $mCat = null;
	var $mGroupArr = array();
	var $mActionArr = array();
	var $mPermit = array();	//$mPermit['value'][groupid][key]
	var $mUserPermit = array();	//$mUserPermit['value'][uid][key]

	function Xcat_Permission($cat)
	{
		$this->mCat = $cat;
		$this->mCat->loadGr();
		$this->setActionArr();
		$this->setGroupArr();
	}

	/**
	 * @public
	 * set the array of XOOPS user groups.
	 */
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

	/**
	 * @public
	 * set permission action master from Gr "actions".
	 */
	function setActionArr()
	{
		$actionArr = unserialize($this->mCat->mGr->get('actions'));
		$i = 0;
		foreach(array_keys($actionArr['title']) as $key){
			$this->mActionArr['key'][$i] = $key;
			$this->mActionArr['name'][$i] = $actionArr['title'][$key];
			$i++;
		}
	}

	/**
	 * @public
	 * set category's permission values from Permit in from of groupid-permissionKey matrix.
	 */
	function setPermissions($permissionsArr)
	{
		foreach(array_keys($permissionsArr) as $keyG){
			$g = array_search($permissionsArr[$keyG]->get('groupid'), $this->mGroupArr['groupid']);
			$permissions = unserialize($permissionsArr[$keyG]->get('permissions'));
			if($g!==false){	//$g may be false in case the group is deleted
				//$target: 'cur' or 'anc'
				$this->mPermit['permit_id'][$g][$this->mCat->mTargetFlag] = $permissionsArr[$keyG]->get('permit_id');
				foreach(array_keys($permissions) as $keyP){
					$t = array_search($keyP, $this->mActionArr['key']);
					if($t!==false){	//$t may be false in case the action is deleted
						$this->mPermit['key']['group'][$g][$t][$this->mCat->mTargetFlag] = $keyP;
						$this->mPermit['value']['group'][$g][$t][$this->mCat->mTargetFlag] = $permissions[$keyP];
					}
				}
			}
			elseif($permissionsArr[$keyG]->get('uid')>0){
				//$target: 'cur' or 'anc'
				$this->mUserPermit['permit_id'][$permissionsArr[$keyG]->get('uid')][$this->mCat->mTargetFlag] = $permissionsArr[$keyG]->get('permit_id');
				foreach(array_keys($permissions) as $keyP){
					$t = array_search($keyP, $this->mActionArr['key']);
					if($t!==false){	//$t may be false in case the action is deleted
						$this->mUserPermit['key']['user'][$permissionsArr[$keyG]->get('uid')][$t][$this->mCat->mTargetFlag] = $keyP;
						$this->mUserPermit['value']['user'][$permissionsArr[$keyG]->get('uid')][$t][$this->mCat->mTargetFlag] = $permissions[$keyP];
					}
				}
			}
		}
	}

	/**
	 * @public
	 * check permission by group, action.
	 */
	function checkPermitGroup($g, $t)
	{
		return $this->mPermit['value']['group'][$g][$t][$this->getTargetCat()];
	}

	/**
	 * @public
	 * get the key of permission action
	 */
	function getPermitKeyGroup($g)
	{
		return $this->mPermitGroup['key']['group'][$g];
	}

	/**
	 * @public
	 * check permission by user, action.
	 */
	function checkPermitUser($u, $t)
	{
		return $this->mUserPermit['value']['user'][$u][$t][$this->getTargetCat()];
	}

	/**
	 * @public
	 * get the key of permission action
	 */
	function getPermitKeyUser($u)
	{
		return $this->mUserPermit['key']['user'][$u];
	}

	/**
	 * @public
	 */
	function getTargetCat()
	{
		return $this->mCat->mTargetFlag;
	}

}
?>
