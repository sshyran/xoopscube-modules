<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class LegacyRender_DD6themePreload extends XCube_ActionFilter
{



	function postFilter()
	{

		$theme =& $this->mController->_mStrategy->getMainThemeObject();

		if (is_object($theme)) {		
		$renderSystem =& $this->mRoot->getRenderSystem($theme->get('render_system'));
		
		if (is_object($renderSystem->mXoopsTpl)) {

		if ($this->mRoot->mContext->mModule != null) {
		$dirname = $this->mRoot->mContext->mXoopsModule->get('dirname');
		}
		else {
		$dirname = "NotModule";
		}

		$urlInfo = $this->mController->_parseUrl();

		if (substr($urlInfo[0], 0, 12) == 'viewpmsg.php' || substr($urlInfo[0], 0, 12) == 'readpmsg.php') {
		$dirname = 'pm';
		}

		if (substr($urlInfo[0], 0, 8) == 'user.php' || substr($urlInfo[0], 0, 12) == 'userinfo.php' || substr($urlInfo[0], 0, 12) == 'edituser.php'  || substr($urlInfo[0], 0, 12) == 'lostpass.php'  || substr($urlInfo[0], 0, 12) == 'register.php') {
		$dirname = 'user';
		}

		if (substr($urlInfo[0], 0, 16) == 'notification.php' || substr($urlInfo[0], 0, 10) == 'search.php') {
		$dirname = 'legacy';
		}

		$groups = is_object($this->mController->mRoot->mContext->mXoopsUser) ? $this->mController->mRoot->mContext->mXoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

		if (is_array($groups)) {
		$groups_prefix = implode('_', array_map('intval', $groups));
		}
		elseif ($groups == XOOPS_GROUP_ANONYMOUS) {
		$groups_prefix = XOOPS_GROUP_ANONYMOUS."_";
		}
		else {
		$groups_prefix = "";
		}

		$current_bp_cookie = array();
		$current_bp_cookie = $this->bp_get_module_cookie ($groups_prefix.'dd6theme', $dirname); 

		$lblock6cookie = "nocookie";
		$ccblock6cookie = "nocookie";
		$clblock6cookie = "nocookie";
		$crblock6cookie = "nocookie";
		$rblock6cookie = "nocookie";

		if ($current_bp_cookie != 'nocookie') {
		$count = count($current_bp_cookie);
		for ($i=1; $i<$count; $i++ ) {
		$tmp = explode(':', $current_bp_cookie[$i]);
		if ( $tmp[0] == 'ldropzone') {$lblock6cookie = $tmp[1];}				
		if ( $tmp[0] == 'ccdropzone') {$ccblock6cookie = $tmp[1];}				
		if ( $tmp[0] == 'cldropzone') {$clblock6cookie = $tmp[1];}				
		if ( $tmp[0] == 'crdropzone') {$crblock6cookie = $tmp[1];}				
		if ( $tmp[0] == 'rdropzone') {$rblock6cookie = $tmp[1];}			
		}
		}

		$renderSystem->mXoopsTpl->assign('groupsprefix', $groups_prefix);

		$renderSystem->mXoopsTpl->assign('lblocks6cookie', explode('&', $lblock6cookie));
		$renderSystem->mXoopsTpl->assign('ccblocks6cookie', explode('&', $ccblock6cookie));
		$renderSystem->mXoopsTpl->assign('clblocks6cookie', explode('&', $clblock6cookie));
		$renderSystem->mXoopsTpl->assign('crblocks6cookie', explode('&', $crblock6cookie));
		$renderSystem->mXoopsTpl->assign('rblocks6cookie', explode('&', $rblock6cookie));

		}//if object
		}
	}


	function bp_get_cookie($name)
	{
	$value = !empty($_COOKIE[$name]) ? $_COOKIE[$name] : "";
	if($value) {
		$value_tmp = array();
		$value_tmp2 = array();
		$value_tmp = explode("|", $value);
		$value = array();
		$count = count($value_tmp);
		for( $i=0; $i<$count; $i++ ) {
			$value_tmp2 = explode(",", $value_tmp[$i]);
			$count2 = count($value_tmp2);
			for ( $j=0; $j<$count2; $j++) {
			$value[$i][$j] = $value_tmp2[$j];
			}//for
		} //for		
	}//

	if (!empty($value)) {
	return $value;
	}
	else {
	return "nocookie";
	}

	}

	function bp_get_module_cookie($name, $module)
	{
	$value = !empty($_COOKIE[$name]) ? $_COOKIE[$name] : "";
	if($value) {
		$value_tmp = array();
		$value_tmp2 = array();
		$value_tmp = explode("|", $value);
		$value = array();
		$count = count($value_tmp);
		for( $i=0; $i<$count; $i++ ) {
			$value_tmp2 = explode(",", $value_tmp[$i]);
			if ($value_tmp2[0] == $module) {
			$value = $value_tmp2;
			break;
			}
		} //for
	}//

	if (!empty($value)) {
	return $value;
	}
	else {
	return "nocookie";
	}

	}
	
}

?>