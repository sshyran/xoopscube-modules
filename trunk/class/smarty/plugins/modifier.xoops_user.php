<?php
/**
 *
 * @package Legacy
 * @version $Id: modifier.xoops_user.php,v 1.2 2007/06/24 07:26:21 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     xoops_user
 * Purpose:  Adapter for XoopsUserObject::getVar with using $uid parameter.
 * Input:    uid: user id
 *           key: XoopsUserObject property name
 * -------------------------------------------------------------
 */
function smarty_modifier_xoops_user($uid, $key)
{
	$handler=&xoops_gethandler('member');
	$user=&$handler->getUser(intval($uid));
	if(is_object($user)&&$user->isActive()) {
		return $user->getShow($key);
	}

	return null;
}

?>
