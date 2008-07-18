<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Config
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Config
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Config
{
    /**
     * Gets a config value
     *
     * @param string $name
     * @return mixed
     */
    function get($section = null)
    {
        if (!isset($section)) {
            return $this->_getAll();
        }
        if (!$this->_hasConfig($section)) {
            trigger_error(sprintf('Request to non-existent config key "%s"', $section), E_USER_WARNING);
            return;
        }
        $config = $this->_getConfig($section);
        if (func_num_args() > 1) {
            $names = array_slice(func_get_args(), 1);
            foreach ($names as $name) {
                if (is_array($config) && array_key_exists($name, $config)) {
                    $config = $config[$name];
                } else {
                    trigger_error(sprintf('Request to non-existent config key "%s"', $name), E_USER_WARNING);
                    break;
                }
            }
        }
        return $config;
    }

    /**
     * Checks if config variable is available
     *
     * @abstract
     * @access protected
     * @param string $name
     * @return bool
     */
    function _hasConfig($name){}

    /**
     * Gets a config variable
     *
     * @abstract
     * @access protected
     * @param string $name
     * @return mixed
     */
    function _getConfig($name){}

    /**
     * Gets all config variables
     *
     * @abstract
     * @access protected
     * @param string $name
     * @return array
     */
    function _getAll($name){}
}