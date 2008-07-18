<?php
/**
 * Sabai_User_Authenticator
 */
require_once 'Sabai/User/Authenticator.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   SabaiXOOPS
 * @package    SabaiXOOPS
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/gpl-license.php GNU GPL
 * @link       http://sourceforge.net/projects/sabai
 * @since      Class available since Release 0.1.0
 */
class SabaiXOOPS_User_Authenticator extends Sabai_User_Authenticator
{
    /**
     * Authenticates a user
     *
     * @access protected
     * @param Sabai_Request $request
     * @return Sabai_User_Identity on success, false on failure
     */
    function &authenticate(&$request)
    {
        $parsed = parse_url(XOOPS_URL);
        $server = sprintf('%s://%s%s', $parsed['scheme'], $parsed['host'], isset($parsed['port']) ? ':' . $parsed['port'] : '');
        $url = XOOPS_URL . '/user.php?xoops_redirect=' . str_replace(array($server, '&', '/'), array('', urlencode('&'), urlencode('/')), $request->getPreviousUri());
        header('Location: ' . $url);
        exit;
    }

    function deauthenticate()
    {
        $url = XOOPS_URL . '/user.php?op=logout';
        header('Location: ' . $url);
        exit;
    }
}