<?php
/**
* @file preload/FlatdataEmbeddataInsert.class.php
* for embed flatdata in edituser.php/register.php , et al.
* MOD:2009.2.15
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
		if (strstr(xoops_getenv('REQUEST_URI'), 'register')) {
			$dir = $_POST['flatdata_fd_dir'];
			$temp_fd_confirm = array();
			foreach ($_POST as $key => $val) {
				if (strpos($key, 'flatdata_') === 0 || strpos($key, $dir) === 0) {
					$temp_fd_confirm[$key] = $val;
				}
			}
			$_SESSION['flatdata_confirm'] = serialize($temp_fd_confirm) ;
		} else {
			//edituser
			FlatdataEmbeddataInsert::insert();
		}
	}

	function registUser($newuser)
	{
		$uid = $newuser->get('uid') ;
		//$_POST = unserialize($_SESSION['flatdata_confirm']);
		$temp_fd_confirm = unserialize($_SESSION['flatdata_confirm']);
		$dir = $temp_fd_confirm['flatdata_fd_dir'];
		foreach ($temp_fd_confirm as $key => $val) {
			if (strpos($key, 'flatdata_') === 0 || strpos($key, $dir) === 0) {
				$_POST[$key] = $val;
			}
		}
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

		if ($n == 1) {
			$did = isset($_POST['flatdata_did']) ? intval($_POST['flatdata_did']) : 0 ;
			$flatdata->update($did,$fidarr);
		} else {
			if( ! $flatdata->embed_preCheck($fidarr) ) return ;
			$flatdata->embedData() ;
			$flatdata->insert($fidarr);
		}
	}//END : function insert


}//END of class
?>
