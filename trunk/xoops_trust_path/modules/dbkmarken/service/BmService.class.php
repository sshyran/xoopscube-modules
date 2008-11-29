<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

//require_once DBKMARKEN_TRUST_PATH . '/class/AbstractService.class.php';

class Dbkmarken_BmObj extends XCube_Object
{
	function getPropertyDefinition()
	{
		$ret = array(
			S_PUBLIC_VAR("int bm_id"),
			S_PUBLIC_VAR("string bm_title"),
			S_PUBLIC_VAR("string url"),
			S_PUBLIC_VAR("int uid"),
			S_PUBLIC_VAR("Dbkmarken_TagObjArray tags"),
			S_PUBLIC_VAR("text memo")
		);
		
		return $ret;
	}
}

class Dbkmarken_BmObjArray extends XCube_ObjectArray
{
	function getClassName()
	{
		return "Dbkmarken_BmObj";
	}
}

class Dbkmarken_TagObj extends XCube_Object
{
	function getPropertyDefinition()
	{
		$ret = array(
			S_PUBLIC_VAR("int tag_id"),
			S_PUBLIC_VAR("string tag_name"),
			S_PUBLIC_VAR("int bm_id"),
			S_PUBLIC_VAR("int uid")
		);
		
		return $ret;
	}
}

class Dbkmarken_TagObjArray extends XCube_ObjectArray
{
	function getClassName()
	{
		return "Dbkmarken_TagObj";
	}
}

class Dbkmarken_BmService extends XCube_Service
{
	var $mServiceName = "Dbkmarken_BmService";
	var $mNameSpace = "Dbkmarken";
	var $mClassName = "Dbkmarken_BmService";
	
	function prepare()
	{
		$this->addType('Dbkmarken_BmObj');
		$this->addType('Dbkmarken_BmObjArray');
	
		$this->addFunction(S_PUBLIC_FUNC('Dbkmarken_BmObjArray getBm(string url, bool mybm, string dirname)'));
		$this->addFunction(S_PUBLIC_FUNC('Dbkmarken_BmObj updateBm(int bm_id, string bm_title, string url, text tags, text memo, string dirname)'));
	}

	/**
	 * @public
	 * get bookmarks about a given page.
	*/
	function getBm()
	{
		$root =& XCube_Root::getSingleton();
		$url = $root->mContext->mRequest->getRequest('url');
		$url = str_replace('&amp;', '&', $url);
		$myBm = $root->mContext->mRequest->getRequest('mybm');
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		//get Bm handler
		$asset = null;
		XCube_DelegateUtils::call(
		    'Module.dbkmarken.Global.Event.GetAssetManager',
		    new XCube_Ref($asset),
		    $dirname
		);
	
		$bm = array();
		if(is_object($asset) && is_a($asset, 'Dbkmarken_AssetManager'))
		{
			$criteria = new CriteriaCompo('1', '1');
			$criteria->add(new Criteria('url', $url));
			if($myBm==true && $root->mContext->mXoopsUser){
				$criteria->add(new Criteria('uid', $root->mContext->mXoopsUser->get('uid')));
			}
		    $handler = $asset->getObject('handler','bm');
		    $bm =& $handler->getObjects($criteria);
		}
	
		foreach(array_keys($bm) as $key){
			$bmArr[$key]['bm_id'] = $bm[$key]->get('bm_id');
			$bmArr[$key]['bm_title'] = $bm[$key]->get('bm_title');
			$bmArr[$key]['url'] = $bm[$key]->get('url');
			$bmArr[$key]['uid'] = $bm[$key]->get('uid');
			$bmArr[$key]['memo'] = $bm[$key]->get('memo');
			$bm[$key]->loadTag($dirname);
			$tagArr = array();
			foreach(array_keys($bm[$key]->mTag) as $tKey){
				$tagArr[] = $bm[$key]->mTag[$tKey]->get('tag_name');
			}
			$bmArr[$key]['tags'] = $tagArr;
		}
		
		return $bmArr;
	}

	/**
	 * @public
	 * update bookmark
	 */
	function updateBm()
	{
		$root =& XCube_Root::getSingleton();
		$_REQUEST['bm_id'] = $root->mContext->mRequest->getRequest('bm_id');
		$_REQUEST['bm_title'] = $root->mContext->mRequest->getRequest('bm_title');
		$_REQUEST['url'] = $root->mContext->mRequest->getRequest('url');
		$_REQUEST['tags'] = $root->mContext->mRequest->getRequest('tags');
		$_REQUEST['memo'] = $root->mContext->mRequest->getRequest('memo');
		$dirname = $root->mContext->mRequest->getRequest('dirname');
	
		$root->mController->setupModuleContext($dirname);
		$root->mLanguageManager->loadModuleMessageCatalog($dirname);

		require_once XOOPS_MODULE_PATH . "/". $dirname ."/class/Module.class.php";

		//from /legacy/kernel/Legacy_controller.class.php
		$handler =& xoops_gethandler('module');
		$module =& $handler->getByDirname($dirname);
		if (!is_object($module)) {
			XCube_DelegateUtils::call('Legacy.Event.Exception.XoopsModuleNotFound', $dirname);
			$root->mController->executeRedirect(XOOPS_URL . '/', 1, "You can't access this URL.");	// TODO need message catalog.
			die();
		}

		$moduleRunner = new ucfirst($dirname) . _Module($module);
		$moduleRunner->setActionName('BmEdit');
		$root->mController->mExecute->add(array(&$moduleRunner, 'execute'));

		$root->mController->_processModule();

		$root->mController->execute();
	}

}
?>