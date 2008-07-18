<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_User
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.7
*/

/**
 * Sabai_Handle_Class
 */
require_once 'Sabai/Handle/Class.php';
/**
 * Sabai_Handle_Decorator_Autoload
 */
require_once 'Sabai/Handle/Decorator/Autoload.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_User
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.7
 */
class Sabai_User_IdentityFetcherFactory
{
    /**
     * Creates a handle of Sabai_User_IdentityFetcher instance
     *
     * @static
     * @param string $scheme
     * @param array $options
     * @return Sabai_User_IdentityFetcher
     */
    function &createHandle($scheme, $options = array())
    {
        $file = false;
        switch ($scheme) {
            case 'flickr':
                $file = 'Sabai/User/IdentityFetcher/Flickr.php';
                $class = 'Sabai_User_IdentityFetcher_Flickr';
                $params = array_merge(array('apiKey'    => '',
                                            'apiSecret' => ''),
                                      $options);
                break;
            case 'xoops':
                $file = 'Sabai/User/IdentityFetcher/XOOPS.php';
                $class = 'Sabai_User_IdentityFetcher_XOOPS';
                $params = array_merge(array('dbUser' => 'root',
                                            'dbPass' => '',
                                            'dbName' => 'xoops',
                                            'dbPrefix' => 'xoops',
                                            'dbHost' => 'localhost',
                                            'dbScheme' => 'mysql'),
                                      $options);
                break;
            case 'custom':
                $file = isset($options['file']) ? $options['file'] : false;
                $class = $options['class'];
                $params = !empty($options['params']) ? $options['params'] : array();
                break;
            default:
                $file = 'Sabai/User/IdentityFetcher/Default.php';
                $class = 'Sabai_User_IdentityFetcher_Default';
                return;
        }
        $handle =& new Sabai_Handle_Class($class, $params);
        if ($file) {
            $handle =& new Sabai_Handle_Decorator_Autoload($handle, $file);
        }
        return $handle;
    }

    /**
     * Creates a Sabai_User_IdentityFetcher instance
     *
     * @static
     * @param string $scheme
     * @param array $options
     * @return Sabai_User_IdentityFetcher
     */
    function &create($scheme, $options)
    {
        $handle =& Sabai_User_IdentityFetcherFactory::createHandle($scheme, $options);
        $instance =& $handle->instantiate();
        return $instance;
    }
}