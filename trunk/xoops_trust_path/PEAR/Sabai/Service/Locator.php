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

require_once 'Sabai/Service/Provider.php';

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
 */
class Sabai_Service_Locator
{
    /**
     * @access protected
     * @var array
     */
    var $_providers = array();
    /**
     * @access protected
     * @var array
     */
    var $_services = array();
    /**
     * @access protected
     * @var array
     */
    var $_definitions = array();
    /**
     * @access private
     * @var string
     */
    var $_providerClassFormat = 'Sabai_Service_Provider_%s';
    /**
     * @access private
     * @var string
     */
    var $_providerFileFormat = 'Sabai/Service/Provider/%s.php';

    /**
     * Sets class name format of provider
     *
     * @param string $format
     */
    function setProviderClassFormat($format)
    {
        $this->_providerClassFormat = $format;
    }

    /**
     * Sets file path format of provider
     *
     * @param string $format
     */
    function setProviderFileFormat($format)
    {
        $this->_providerFileFormat = $format;
    }

    /**
     * Sets custom service definitions
     *
     * @param string $name
     * @param string $id
     * @param array $params
     * @param array $services
     */
    function defineService($name, $id, $params, $services = array())
    {
        // Default settings should be set by addProvider()
        if (!isset($this->_definitions[$name]['default']) || ($id == 'default')) {
            trigger_error('Invalid service', E_USER_ERROR);
        }
        $this->_definitions[$name][$id] = array($params, $services);
    }

    /**
     * Gets a service object
     *
     * @param string $name
     * @param string $id
     * @param array $params
     * @param array $services
     * @return object
     */
    function &getService($name, $id = 'default', $params = array(), $services = array())
    {
        if (!isset($this->_services[$name][$id])) {
            if (!isset($this->_definitions[$name][$id])) {
                $this->defineService($name, $id, $params, $services);
            }
            list($params, $services) = $this->_definitions[$name][$id];
            $provider =& $this->_providers[$name]->instantiate();
            $this->_services[$name][$id] =& $provider->getService($params, $this, $services);
        }
        return $this->_services[$name][$id];
    }

    /**
     * Clears a specific service
     *
     * @param string $name
     * @param string $id
     */
    function clearService($name, $id = null)
    {
        if (isset($id)) {
            unset($this->_services[$name][$id]);
        } else {
            unset($this->_services[$name]);
        }
    }

    /**
     * Adds a service provider as a handle object
     *
     * @param string $name
     * @param Sabai_Handle $handle
     */
    function addProviderHandle($name, &$handle)
    {
        $this->_providers[$name] =& $handle;
        $this->_definitions[$name]['default'] = array(array(), array());
    }

    /**
     * Add a service provider
     *
     * @param string $name
     * @param array $defaultParams
     * @param string $class
     * @param string $file
     */
    function addProvider($name, $defaultParams = array(), $class = null, $file = null)
    {
        require_once 'Sabai/Handle/Decorator/Cache.php';
        require_once 'Sabai/Handle/Decorator/Autoload.php';
        require_once 'Sabai/Handle/Class.php';
        $class = !isset($class) ? sprintf($this->_providerClassFormat, $name) : $class;
        $file = !isset($file) ? sprintf($this->_providerFileFormat, $name) : $file;
        $this->addProviderHandle($name, new Sabai_Handle_Decorator_Cache(
                                          new Sabai_Handle_Decorator_Autoload(
                                            new Sabai_Handle_Class($class, $defaultParams),
                                            $file)));
    }
}