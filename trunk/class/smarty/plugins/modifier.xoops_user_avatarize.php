<?php
/**
 *
 * @package Legacy
 * @version $Id: modifier.xoops_user_avatarize.php,v 1.2 2007/06/24 07:26:21 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     xoops_user_avatarize
 * Purpose:  Return avatar url by $uid.
 * Input:    uid: user id
 * -------------------------------------------------------------
 */
function smarty_modifier_xoops_user_avatarize($uid)
{
	$handler =& xoops_gethandler('user');
	$user =& $handler->get(intval($uid));
	if (is_object($user) && $user->isActive() && ($user->get('user_avatar') != "blank.gif")) {
		if (file_exists(XOOPS_UPLOAD_PATH . "/" . $user->get('user_avatar'))) {
			return XOOPS_UPLOAD_URL . "/" . $user->getShow('user_avatar');
		}
	}

	return XOOPS_URL . "/modules/user/images/no_avatar.gif";
}

?>
