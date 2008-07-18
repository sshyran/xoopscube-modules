<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Handle
 * @subpackage Decorator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Sabai_Handle_Decorator
 */
require_once 'Sabai/Handle/Decorator.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Handle
 * @subpackage Decorator
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Handle_Decorator_Autoload extends Sabai_Handle_Decorator
{
    /**
     * @var array
     * @access protected
     */
    var $_classFiles;

    /**
     * Constructor
     *
     * @param Sabai_Handle &$handle
     * @param mixed $classFile string or array
     */
    function Sabai_Handle_Decorator_Autoload(&$handle, $classFile)
    {
        parent::Sabai_Handle_Decorator($handle);
        $this->_classFiles = (array)$classFile;
    }

    /**
     * Gets an instance
     *
     * @return object
     */
    function &instantiate()
    {
        foreach ($this->_classFiles as $file) {
            require_once $file;
        }
        $ret =& $this->_handle->instantiate();
        return $ret;
    }
}