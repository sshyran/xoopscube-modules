<?php
require_once 'Sabai/Controller/Login.php';

class Xigg_Main_Login extends Sabai_Controller_Login
{
    function &_getAuthenticator(&$context)
    {
        $authenticator =& $context->application->locator->getService('UserAuthenticator');
        return $authenticator;
    }
}