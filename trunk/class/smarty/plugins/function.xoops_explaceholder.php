<?php
/**
 *
 * @package Legacy
 * @version $Id: function.xoops_explaceholder.php,v 1.2 2007/06/24 07:26:21 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xoops_explaceholder
 * Version:  1.0
 * Date:     Oct 12, 2006
 * Author:   minahito
 * Purpose:  Extended place holder
 * Input:    control =
 * 
 * Examples: <{xoops_explaceholder control=sp_pagenavi pagenavi=$pagenavi}>
 * -------------------------------------------------------------
 */
function smarty_function_xoops_explaceholder($params, &$smarty)
{
	$buf = null;
	
	if (isset($params['control'])) {
		XCube_DelegateUtils::call('Legacy.Event.Explaceholder.Get.' . $params['control'], new XCube_Ref($buf), $params);
		
		if ($buf === null) {
			XCube_DelegateUtils::call('Legacy.Event.Explaceholder.Get', new XCube_Ref($buf), $params['control'], $params);
		}
	}
	
	return $buf;
}

?>
