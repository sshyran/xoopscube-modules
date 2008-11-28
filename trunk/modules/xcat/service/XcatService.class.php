<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/TreeObject.class.php";

class Xcat_CatObj extends XCube_Object
{
	function getPropertyDefinition()
	{
		$ret = array(
			S_PUBLIC_VAR("int cat_id"),
			S_PUBLIC_VAR("string cat_title"),
			S_PUBLIC_VAR("int gr_id"),
			S_PUBLIC_VAR("int p_id"),
			S_PUBLIC_VAR("text modules"),
			S_PUBLIC_VAR("text imageurl"),
			S_PUBLIC_VAR("text cat_desc"),
			S_PUBLIC_VAR("int weight"),
			S_PUBLIC_VAR("text options"),
			S_PUBLIC_VAR("int cat_depth"),
			S_PUBLIC_VAR("string permit")
		);
		
		return $ret;
	}
}

class Xcat_CatObjArray extends XCube_ObjectArray
{
	function getClassName()
	{
		return "Xcat_CatObj";
	}
}

class Xcat_GrObj extends XCube_Object
{
	function getPropertyDefinition()
	{
		$ret = array(
			S_PUBLIC_VAR("int gr_id"),
			S_PUBLIC_VAR("string gr_title"),
			S_PUBLIC_VAR("int level"),
			S_PUBLIC_VAR("int actions"),
		);
		
		return $ret;
	}
}

class Xcat_GrObjArray extends XCube_ObjectArray
{
	function getClassName()
	{
		return "Xcat_GrObj";
	}
}

class Xcat_CatTitle extends XCube_Object
{
	function getPropertyDefinition()
	{
		$ret = array(
			S_PUBLIC_VAR("string cat_title"),
		);
		
		return $ret;
	}
}

class Xcat_CatTitleArray extends XCube_ObjectArray
{
	function getClassName()
	{
		return "Xcat_CatTitle";
	}
}


class Xcat_CatService extends XCube_Service
{
	var $mServiceName = "Xcat_CatService";
	var $mNameSpace = "Xcat";
	var $mClassName = "Xcat_CatService";
	
	function prepare()
	{
		$this->addType('Xcat_CatObj');
		$this->addType('Xcat_CatObjArray');
		$this->addType('Xcat_GrObj');
		$this->addType('Xcat_GrObjArray');
		$this->addType('Xcat_CatTitle');
		$this->addType('Xcat_CatTitleArray');
	
		$this->addFunction(S_PUBLIC_FUNC('Xcat_CatObjArray getChildren(int cat_id, string action, int uid, string dirname)'));
		$this->addFunction(S_PUBLIC_FUNC('Xcat_CatObjArray getCatPath(int cat_id, string order)'));
		$this->addFunction(S_PUBLIC_FUNC('bool checkPermitByUid(string action, int uid, int cat_id, string dirname)'));
		$this->addFunction(S_PUBLIC_FUNC('bool checkPermitByGroupid(string action, int groupid, int cat_id, string dirname)'));
		$this->addFunction(S_PUBLIC_FUNC('Xcat_GrObjArray getGrList()'));
		$this->addFunction(S_PUBLIC_FUNC('Xcat_CatObjArray getTree(int gr_id, int cat_id, int p_id, string action, int uid, string dirname)'));
		$this->addFunction(S_PUBLIC_FUNC('string getTitle(int cat_id)'));
		$this->addFunction(S_PUBLIC_FUNC('Xcat_CatTitleArray getTitleList(int gr_id, string dirname)'));
		$this->addFunction(S_PUBLIC_FUNC('Xcat_CatObj getCat(int cat_id, string dirname)'));
		$this->addFunction(S_PUBLIC_FUNC('Xcat_CatObj getParent(int cat_id)'));
	}

	/**
	 * @public
	 * check permission about the given groupid and action.
	*/
	function getTitle()
	{
		$root =& XCube_Root::getSingleton();
		$catId = $root->mContext->mRequest->getRequest('cat_id');
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($catId);
		if($cat){
			return $cat->get('cat_title');
		}
		else{
			return "";
		}
	}

	/**
	 * @public
	 * load child categories Objects of this category.
	 */
	function getChildren()
	{
		$catArr = array();
	
		$root =& XCube_Root::getSingleton();
		$catId = $root->mContext->mRequest->getRequest('cat_id');
		$action = $root->mContext->mRequest->getRequest('action');
		$uid = $root->mContext->mRequest->getRequest('uid');
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($catId);
		$cat->loadChildren($dirname);
		foreach(array_keys($cat->mChildren) as $key){
			$catArr[$key] = $cat->mChildren[$key]->gets();
			$catArr[$key]['cat_depth'] = $cat->mChildren[$key]->getDepth();
			if($action){
				if($cat->mChildren[$key]->checkPermitByUid($action, intval($uid))=='true'){
					$catArr[$key]['permit'] = 1;
				}
				else{
					$catArr[$key]['permit'] = 0;
				}
			}
			else{
				$catArr[$key]['permit'] = 1;
			}
		}
		return $catArr;
	}

	/**
	 * @public
	 * call load category function if not loaded yet.
	 */
	function getCatPath(){
		$catPath= array();
	
		$root =& XCube_Root::getSingleton();
		$catId = $root->mContext->mRequest->getRequest('cat_id');
		$order = $root->mContext->mRequest->getRequest('order');
	
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($catId);
		$cat->loadCatPath();
		if($order=='ASC' && count($cat->mCatPath)>0){
			$catPath['cat_id'] = array_reverse($cat->mCatPath['cat_id']);
			$catPath['cat_title'] = array_reverse($cat->mCatPath['cat_title']);
			$catPath['modules'] = array_reverse($cat->mCatPath['modules']);
		}
		else{
			$catPath = $cat->mCatPath;
		}
		return $catPath;
	}

	/**
	 * @public
	 * check permission about the given uid and action.
	 * check about all groups the user is belong to.
	*/
	function checkPermitByUid()
	{
		$root =& XCube_Root::getSingleton();
		$action = $root->mContext->mRequest->getRequest('action');
		$uid = $root->mContext->mRequest->getRequest('uid');
		$catId = $root->mContext->mRequest->getRequest('cat_id');
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		//print $action .'uid'. $uid . 'cat_id'.$catid;die();
	
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($catId);
		return $cat->checkPermitByUid($action, $uid, $dirname);
	}

	/**
	 * @public
	 * check permission about the given groupid and action.
	*/
	function checkPermitByGroupid()
	{
		$root =& XCube_Root::getSingleton();
		$action = $root->mContext->mRequest->getRequest('action');
		$uid = $root->mContext->mRequest->getRequest('groupid');
		$catId = $root->mContext->mRequest->getRequest('cat_id');
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($catId);
		return $cat->checkPermitByGroupid($action, $groupid, $dirname);
	}

	/**
	 * @public
	 */
	function getGrList()
	{
		$grArr = array();
	
		$handler =& xoops_getmodulehandler('gr', 'xcat');
		$gr =& $handler->getObjects();
		foreach(array_keys($gr) as $key){
			$grArr[$key] = $gr[$key]->gets();
		}
		return $grArr;
	}

	function getTree()
	{
		$tree = array();
	
		$root =& XCube_Root::getSingleton();
		$catId = intval($root->mContext->mRequest->getRequest('cat_id'));
		$grId = intval($root->mContext->mRequest->getRequest('gr_id'));
		$pId = intval($root->mContext->mRequest->getRequest('p_id'));
		$action = $root->mContext->mRequest->getRequest('action');
		$uid = intval($root->mContext->mRequest->getRequest('uid'));
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		if($grId>0){
			$treeObj = new Xcat_TreeObject($grId);
		}
		elseif($catId>0){
			$treeObj = new Xcat_TreeObject();
			$treeObj->loadGrByCatId($catId);
		}
		elseif($pId>0){
			$treeObj = new Xcat_TreeObject();
			$treeObj->loadGrByCatId($pId);
		}
		else{
			return false;
		}
		$treeObj->loadTree($pId, $dirname);
		foreach(array_keys($treeObj->mTree) as $key){
			$tree[$key] = $treeObj->mTree[$key]->gets();
			$tree[$key]['cat_depth'] = $treeObj->mTree[$key]->getDepth();
			if($action){
				if($treeObj->mTree[$key]->checkPermitByUid($action, $uid)=='true'){
					$tree[$key]['permit'] = 1;
				}
				else{
					$tree[$key]['permit'] = 0;
				}
			}
			else{
				$tree[$key]['permit'] = 1;
			}
		}
		return $tree;
	}

	function getTitleList()
	{
		$catList = array();
	
		$root =& XCube_Root::getSingleton();
		$grId = $root->mContext->mRequest->getRequest('gr_id');
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$catArr =& $handler->getObjects(new Criteria('gr_id', $grId));
		foreach(array_keys($catArr) as $key){
			if($catArr[$key]->checkDirname($dirname)){
				$catList[$catArr[$key]->get('cat_id')] = $catArr[$key]->get('cat_title');
			}
		}
		return $catList;
	}

	function getCat()
	{
		$root =& XCube_Root::getSingleton();
		$catId = $root->mContext->mRequest->getRequest('cat_id');
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($catId);
		if($cat->checkDirname($dirname)){
			return $cat->gets();
		}
		else{
			return false;
		}
	}

	function getParent()
	{
		$root =& XCube_Root::getSingleton();
		$catId = $root->mContext->mRequest->getRequest('cat_id');
	
		$handler =& xoops_getmodulehandler('cat', 'xcat');
		$cat =& $handler->get($catId);
		$parent =& $handler->get($cat->get('p_id'));
		return $parent;
	}

}


?>