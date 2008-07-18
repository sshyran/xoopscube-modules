<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Service
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.10
*/
/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Service
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.10
 * @abstract
 */
class Sabai_Service_Provider
{
    /**
     * @access private
     * @var array
     */
    var $_defaultParams;
    /**
     * @access private
     * @var array
     */
    var $_uses;

    /**
     * Constructor
     *
     * @param array $defaultParams
     * @param array $uses
     * @return Sabai_Service_Provider
     */
    function Sabai_Service_Provider($defaultParams= array(), $uses = array())
    {
        $this->_defaultParams = $defaultParams;
        $this->_uses = $uses;
    }

    /**
     * Gets an instance of this service
     *
     * @return object
     * @param array $params
     * @param Sabai_Service_Locator $locator
     * @param array $services
     */
    function &getService($params, &$locator, $services)
    {
        $uses = array();
        foreach ($this->_uses as $use) {
            if (isset($services[$use])) {
                $uses[$use] =& $services[$use];
            } else {
                $uses[$use] =& $locator->getService($use);
            }
        }
        $service =& $this->_doGetService(array_merge($this->_defaultParams, $params), $uses);
        return $service;
    }

    /**
     * Gets an instance of this service
     *
     * @abstract
     * @access protected
     * @return object
     * @param array $params
     * @param array $services
     */
    function &_doGetService($params, $services){}
}