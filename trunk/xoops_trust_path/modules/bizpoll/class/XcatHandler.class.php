<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class Bizpoll_XcatHandler
{
	var $mService = null;
	var $mClient = null; 
	var $mModule = null;
	var $mDirname = "";

	//constructor
	//if you use this object in block, argument $dirname is required
	function Bizpoll_XcatHandler($dirname)
	{
		$this->mDirname = $dirname;
	
		//get category lists from xcat service
		$root =& XCube_Root::getSingleton();
		$this->mService = $root->mServiceManager->getService("Xcat_CatService");
		$this->mClient = $root->mServiceManager->createClient($this->mService);
	}

	/**
	 *  @public
	 *  get module config value
	 */
	function getConfig($config)
	{
        $configHandler =& Bizpoll_Utils::getXoopsHandler('config');
		$configArr =& $configHandler->getConfigsByDirname($this->mDirname);
	
		return $configArr[$config];
	}

	/**
	 *  @public
	 *  get permit title from module config
	 */
	function getPermitTitle($action)
	{
		$actionsArr = explode('|', $this->getConfig('permit_title'));
		switch ($action){
			case "viewer":
				return $actionsArr[0];
				break;
			case "poster":
				return $actionsArr[1];
				break;
			case "editor":
				return $actionsArr[2];
				break;
			case "poller":
				return $actionsArr[3];
				break;
		}
	}

	function getTitle($catId)
	{
		if (is_object($this->mClient)) {
			//get list from xcat service
			return $this->mClient->call('getTitle', array('cat_id'=>$catId));
		}
	}

	function getTitleList()
	{
		if (is_object($this->mClient)) {
			//get list from xcat service
			return $this->mClient->call('getTitleList', array('gr_id'=>$this->getConfig('gr_id'), 'dirname'=>$this->mDirname));
		}
	}

	function getCatList($actionName)
	{
		$action = $this->getPermitTitle($actionName);
		if (is_object($this->mClient)) {
			//get user id
			$root =& XCube_Root::getSingleton();
			$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;

			//get cat list from xcat service
			return $this->mClient->call('getTree', array('gr_id'=>$this->getConfig('gr_id'), 'cat_id'=>0, 'p_id'=>0, 'action'=>$action, 'uid'=>$uid, 'dirname'=>$this->mDirname));
		}
	}

	function checkPermit($catId, $actionName, $enqUid=0)
	{
		$action = $this->getPermitTitle($actionName);
		//get user id
		$root =& XCube_Root::getSingleton();
		$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;
	
		if($this->getConfig('gr_id')>0){
			if($this->mClient->call('checkPermitByUid', array('cat_id'=>$catId, 'uid'=>$uid, 'action'=>$action, 'dirname'=>$this->mDirname))){
				return true;
			}
			elseif($actionName=='editor' && $uid>0 && $enqUid==$uid){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			if($action=="viewer"||$action=="poller"){
				return true;
			}
			elseif($action=="poster"){
				return ($uid>0) ? true : false;
			}
			elseif($action=="editor"){
				//print $uid.':'.$enqUid;die();
				return ($uid>0 && $enqUid==$uid) ? true : false;
			}
			else{
				return false;
			}
		}
	}

	function getPermitCatIds($catId=0, $actionName)
	{
		$action = $this->getPermitTitle($actionName);

		if(! $action){
			$action = $this->getPermitTitle('viewer');
		}
	
		$grId = ($catId>0) ? 0 : $this->getConfig('gr_id');
	
		//get user id
		$root =& XCube_Root::getSingleton();
		$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;
	
		$treeArr = array();
		$treeArr = $this->mClient->call('getTree', array('gr_id'=>$grId, 'cat_id'=>0, 'p_id'=>$catId, 'action'=>$action, 'uid'=>$uid, 'dirname'=>$this->mDirname));
		$ids = array();
		foreach($treeArr as $tree){
			if($tree['permit']==1){
				$ids[] = $tree['cat_id'];
			}
		}
		return $ids;
	}

	function getCatPath($catId)
	{
		if (is_object($this->mClient)) {
			return $this->mClient->call('getCatPath', array('cat_id'=>$catId, 'order'=>'ASC'));
		}
	}

}
?>
