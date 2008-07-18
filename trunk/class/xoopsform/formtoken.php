<?php
/**
 *
 * @package Legacy
 * @version $Id: formtoken.php,v 1.2 2007/06/24 07:26:21 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class XoopsFormToken extends XoopsFormHidden {
    /**
     * Constructor
     *
     * @param object    $token  XoopsToken instance
    */
    function XoopsFormToken($token)
    {
        if(is_object($token)) {
            parent::XoopsFormHidden($token->getTokenName(), $token->getTokenValue());
        }
        else {
            parent::XoopsFormHidden('','');
        }
    }
}
?>