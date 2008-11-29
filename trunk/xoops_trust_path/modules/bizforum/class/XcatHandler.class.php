<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class Bizforum_XcatHandler
{
	var $mService = null;
	var $mClient = null; 
	var $mModule = null;
	var $mDirname = "";

	//constructor
	//if you use this object in block, argument $dirname is required
	function Bizforum_XcatHandler($dirname)
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
        $configHandler =& Bizforum_Utils::getXoopsHandler('config');
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

	function getCatList($action)
	{
		if (is_object($this->mClient)) {
			//get user id
			$root =& XCube_Root::getSingleton();
			$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;

			//get cat list from xcat service
			return $this->mClient->call('getTree', array('gr_id'=>$this->getConfig('gr_id'), 'cat_id'=>0, 'p_id'=>0, 'action'=>$action, 'uid'=>$uid, 'dirname'=>$this->mDirname));
		}
	}

	function checkPermit($catId, $action)
	{
		//get user id
		$root =& XCube_Root::getSingleton();
		$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;

		return $this->mClient->call('checkPermitByUid', array('cat_id'=>$catId, 'uid'=>$uid, 'action'=>$action, 'dirname'=>$this->mDirname));
	}

	function getPermitCatIds($catId=0, $action)
	{
		if(! $action){
			$action = $this->getPermitTitle('viewer');
		}
	
		if($catId>0){
			//$pId = $this->mClient->call('getCat', array('cat_id'=>$catId));
		}
	
		//get user id
		$root =& XCube_Root::getSingleton();
		$uid = ($root->mContext->mXoopsUser) ? $root->mContext->mXoopsUser->get('uid') : 0;
	
		$tree = $this->mClient->call('getTree', array('gr_id'=>$this->getConfig('gr_id'), 'cat_id'=>0, 'p_id'=>$catId, 'action'=>$action, 'uid'=>$uid, 'dirname'=>$this->mDirname));
		$ids = array();
		foreach(array_keys($tree) as $key){
			if($tree[$key]['permit']==1){
				$ids[] = $tree[$key]['cat_id'];
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
