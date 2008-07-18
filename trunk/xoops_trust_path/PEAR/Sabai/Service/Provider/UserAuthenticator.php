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

require_once 'Sabai/User/AuthenticatorFactory.php';

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
class Sabai_Service_Provider_UserAuthenticator extends Sabai_Service_Provider
{
    /**
     * Constructor
     *
     * @param string $userScheme
     * @param string $options
     * @return Sabai_Service_Provider_UserAuthenticator
     */
    function Sabai_Service_Provider_UserAuthenticator($userScheme, $options)
    {
        parent::Sabai_Service_Provider(array('userScheme' => $userScheme, 'options' => $options));
    }

    function &_doGetService($params, $services)
    {
        $authenticator =& Sabai_User_AuthenticatorFactory::create($params['userScheme'], $params['options']);
        return $authenticator;
    }
}