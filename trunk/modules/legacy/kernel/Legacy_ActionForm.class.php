<?php
/**
 *
 * @package Legacy
 * @version $Id: Legacy_ActionForm.class.php,v 1.3 2007/06/24 14:58:52 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XCUBE_CORE_PATH . '/XCube_ActionForm.class.php';

/**
 * @public
 * @brief Provides base action-form class for module developers
 * 
 * This class keeps the spec which was defined at Legacy 2.1 release.
 * XCube_ActionForm will be changed. This class will change to adapt the base
 * class & will provide uniformed spec to developers.
 * 
 * @todo All actionforms of Package_Legacy have to Inheritance this class.
 */
class Legacy_ActionForm extends XCube_ActionForm
{
	/**
	 * @public
	 * @brief Constructor.
	 */
	function Legacy_ActionForm()
	{
		parent::XCube_ActionForm();
	}
}


?>