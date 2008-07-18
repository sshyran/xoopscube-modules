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
class Sabai_User_AuthenticatorFactory
{
    /**
     * Creates a handle of Sabai_User_Authenticator instance
     *
     * @static
     * @param string $scheme
     * @param array $options
     * @return Sabai_User_Authenticator
     */
    function &createHandle($scheme, $options = array())
    {
        $file = false;
        switch ($scheme) {
            case 'flickr':
                $file = 'Sabai/User/Authenticator/Flickr.php';
                $class =  'Sabai_User_Authenticator_Flickr';
                $params = array_merge(array('apiKey'    => '',
                                            'apiSecret' => ''),
                                      $options);
                break;
            case 'hatena':
                $file = 'Sabai/User/Authenticator/Hatena.php';
                $class =  'Sabai_User_Authenticator_Hatena';
                $params = array_merge(array('apiKey'     => '',
                                            'apiSecret'  => '',
                                            'apiJsonLib' => ''),
                                      $options);
                break;
            case 'jugemkey':
                $file = 'Sabai/User/Authenticator/JugemKey.php';
                $class =  'Sabai_User_Authenticator_JugemKey';
                $params = array_merge(array('apiKey'    => '',
                                            'apiSecret' => ''),
                                      $options);
                break;
            case 'openid':
                $file = 'Sabai/User/Authenticator/OpenID.php';
                $class =  'Sabai_User_Authenticator_OpenID';
                $params = array_merge(array('storePath' => '',
                                            'randSource' => '/dev/urandom',
                                            'identityURLVar' => 'openid_url'),
                                      $options);
                break;
            case 'typekey':
                $file = 'Sabai/User/Authenticator/Typekey.php';
                $class =  'Sabai_User_Authenticator_Typekey';
                $params = array_merge(array('apiToken'  => '',
                                            'needEmail' => false),
                                      $options);
                break;
            case 'xoops':
                $file = 'Sabai/User/Authenticator/Auth/XOOPS.php';
                $class =  'Sabai_User_Authenticator_Auth_XOOPS';
                $params = array_merge(array('dbUser' => 'root',
                                            'dbPass' => '',
                                            'dbName' => 'xoops',
                                            'dbPrefix' => 'xoops',
                                            'dbHost' => 'localhost',
                                            'dbScheme' => 'mysql'),
                                      $options);
                break;
            case 'yahoo':
                $file = 'Sabai/User/Authenticator/Yahoo.php';
                $class =  'Sabai_User_Authenticator_Yahoo';
                $params = array_merge(array('apiKey'    => '',
                                            'apiSecret' => ''),
                                      $options);
                break;
            case 'custom':
                $file = isset($options['file']) ? $options['file'] : false;
                $class = $options['class'];
                $params = !empty($options['params']) ? $options['params'] : array();
                break;
            default:
                trigger_error('Invalid user scheme requested', E_USER_ERROR);
                return;
        }
        $handle =& new Sabai_Handle_Class($class, $params);
        if ($file) {
            $handle =& new Sabai_Handle_Decorator_Autoload($handle, $file);
        }
        return $handle;
    }

    /**
     * Creates a Sabai_User_Authenticator instance
     *
     * @static
     * @param string $scheme
     * @param array $options
     * @return Sabai_User_Authenticator
     */
    function &create($scheme, $options)
    {
        $handle =& Sabai_User_AuthenticatorFactory::createHandle($scheme, $options);
        $instance =& $handle->instantiate();
        return $instance;
    }
}