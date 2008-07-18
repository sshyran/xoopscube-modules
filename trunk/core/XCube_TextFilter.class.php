<?php
/**
 *
 * @package XCube
 * @version $Id: XCube_TextFilter.class.php,v 1.2 2007/06/24 07:26:21 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/>
 * @license http://xoopscube.sourceforge.net/bsd_licenses.txt Modified BSD license
 *
 */

/**
 *
 * @final
 */
class XCube_TextFilter
{
    var $mDummy=null;  //Dummy member for preventing object be treated as empty.

    function getInstance(&$instance) {
       if (empty($instance)) {
            $instance = new XCube_TextFilter();
        }
    }
    
    function toShow($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }

    function toEdit($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }

}
?>
