<?php
/**
* @file preload/FlatdataEmbeddataInsert.class.php
* for embed flatdata in edituser.php/register.php , et al.
**/

if(!defined('XOOPS_ROOT_PATH')) exit();


class FlatdataEmbeddataInsert extends XCube_ActionFilter 
{
	function preFilter()
	{
		if( isset($_POST['flatdata_embed_dir']) ){
			$root =& XCube_Root::getSingleton();
			$root->mDelegateManager->add('User_ActionFrame.CreateAction','FlatdataEmbeddataInsert::altExecute',XCUBE_DELEGATE_PRIORITY_FIRST);
			$root->mDelegateManager->add('Legacy.Event.RegistUser.Success','FlatdataEmbeddataInsert::registUser');

			$root->mDelegateManager->add('Flatdata.Event.Embed.Insert','FlatdataEmbeddataInsert::prepareInsert');
			$root->mDelegateManager->add('Flatdata.Event.Embed.Delete','FlatdataEmbeddataInsert::prepareDelete');
		}
	}

	function altExecute()
	{
		$root =& XCube_Root::getSingleton();

		$actionName = "EditUser";
		if( strstr(xoops_getenv('REQUEST_URI'),'register') ){
			$action = $root->mContext->mRequest->getRequest('action');
			if ($action != null && $action =="UserRegister") {
				$actionName = "UserRegister";
			}else{
				$actionName = $action != null ? "UserRegister_confirm" : "UserRegister";
			}
		}
		if( $actionName=="UserRegister" || $actionName=="UserRegister_confirm" ){
			$_SESSION['flatdata_confirm'] = serialize($_POST) ;
			if( $actionName=="UserRegister_confirm" ) return ;//register confirm
		}

		$fileName = XOOPS_MODULE_PATH . "/user/actions/". $actionName ."Action.class.php";
		require_once $fileName;
		$className = "User_".$actionName."Action" ;
		$root->mController->mAction =& new $className(false);
		
		if (!(is_object($root->mController->mAction) && is_a($root->mController->mAction, 'User_Action'))) {
			die();	//< TODO
		}
		if ($root->mController->mAction->isSecure() && !is_object($root->mContext->mXoopsUser)) {
			$root->mController->executeForward(XOOPS_URL . '/');
		}

		$root->mController->mAction->prepare($root->mController, $root->mContext->mXoopsUser, $root->mContext->mModuleConfig);

		if (!$root->mController->mAction->hasPermission($root->mController, $root->mContext->mXoopsUser, $root->mContext->mModuleConfig)) {
			$root->mController->executeForward(XOOPS_URL . '/');
		}
		if (xoops_getenv("REQUEST_METHOD") == "POST") {
			$viewStatus = $root->mController->mAction->execute($root->mController, $root->mContext->mXoopsUser);//register
		}

		switch($viewStatus) {
			case USER_FRAME_VIEW_SUCCESS:
				FlatdataEmbeddataInsert::insert();	//edituser
				$root->mController->mAction->executeViewSuccess($root->mController, $root->mContext->mXoopsUser, $root->mContext->mModule->getRenderTarget());
				break;
			case USER_FRAME_VIEW_ERROR:
				$root->mController->mAction->executeViewError($root->mController, $root->mContext->mXoopsUser, $root->mContext->mModule->getRenderTarget());
				break;
		}
	}

	function registUser($newuser)
	{
		$uid = $newuser->get('uid') ;
		$_POST = unserialize($_SESSION['flatdata_confirm']) ;
		$_POST['flatdata_item_id'] = $uid ;
		$_POST['flatdata_filequery'] = 'register.php' ;
		$_POST['flatdata_embed_uid'] = $uid ;
		FlatdataEmbeddataInsert::insert();
		unset($_SESSION['flatdata_confirm']);
	}


	function prepareInsert($newid)
	{
		$_POST['flatdata_item_id'] = intval($newid) ;
		//$_POST['flatdata_filequery'] = 'singlelink.php?lid='.intval($newid) ;
		FlatdataEmbeddataInsert::insert();
	}

	function prepareDelete($delid)
	{
		FlatdataEmbeddataInsert::insert(intval($delid));
	}

	function insert($delid=0)
	{
		$root =& XCube_Root::getSingleton();

		$mydirname = isset($_POST['flatdata_fd_dir']) ? xoops_getrequest('flatdata_fd_dir') : '' ;
		$mydirname = preg_replace( '[^a-zA-Z0-9_-]' , '' , $mydirname ) ;
		if( empty($mydirname) || !file_exists(XOOPS_ROOT_PATH."/modules/$mydirname/index.php") ) return ;

		$xoopsUser =& $root->mContext->mXoopsUser ;
		$xoopsConfig = $root->mContext->mXoopsConfig ;
		$page = 'embedinsert' ;
		require XOOPS_TRUST_PATH ."/modules/flatdata/main/header.php" ;
		//--------------------------------------------------------------------
		$embed_dir = isset($_POST['flatdata_embed_dir']) ? xoops_getrequest('flatdata_embed_dir') : '' ;
		$item_field = isset($_POST['flatdata_item_field']) ? xoops_getrequest('flatdata_item_field') : '' ;
		$embed_dir = preg_replace( '/[^a-zA-Z0-9._-]/' , '' , $embed_dir ) ;
		$item_field = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $item_field ) ;

		//data exists
		$fidarr = $fields->getFidArray();
		$flatdata->setEmbedWhere("[{$embed_dir}][{$item_field}][".intval($_POST['flatdata_item_id'])."]%");//TODO
		$n = $flatdata->getCount( $fidarr );

		//permission check
		if( !$isadmin ){
			if( $embed_dir=='register.php' ){
				if( $n==1 ){
					if( $_POST['flatdata_item_id']!=$uid || $uid==0 ){
						return ;
					}
				}
			}elseif( $embed_dir=='edituser.php' || $embed_dir=='userinfo.php' ){
				if( $_POST['flatdata_item_id']!=$uid || $uid==0 ){
					return ;
				}
			}else{
				if( $n==1 ){
					$did = isset($_POST['flatdata_did']) ? intval($_POST['flatdata_did']) : 0 ;
					$data = $flatdata->getData( $did , $fidarr );
					if( !($editperm && $data['uid']==$uid) ){
						return ;
					}
				}else{
					if( ! $postperm ){
						return ;
					}
				}
			}
		}

		//DELETE
		if( !empty($delid) ){
			$did = isset($_POST['flatdata_did']) ? intval($_POST['flatdata_did']) : 0 ;
			$data = $flatdata->getData( $did , $fidarr );
			if( $n!=1 || !$data ) return ;
			if( !$isadmin ){
				if( !($delperm && $data['uid']==$uid) ){
					return;
				}
			}
			$flatdata->delete($data['did']);
			return ;
		}

		if( $n==1 ){
			$did = isset($_POST['flatdata_did']) ? intval($_POST['flatdata_did']) : 0 ;
			$flatdata->update($did,$fidarr);
		}else{
			if( ! $flatdata->embed_preCheck($fidarr) ) return ;
			$flatdata->embedData() ;
			$flatdata->insert($fidarr);
		}
	}//END : function insert


}//END of class
?>
