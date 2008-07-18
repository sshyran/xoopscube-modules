<?php
require_once 'Sabai/Controller/Logout.php';

class Xigg_Main_Logout extends Sabai_Controller_Logout
{
    function &_getAuthenticator(&$context)
    {
        $authenticator =& $context->application->locator->getService('UserAuthenticator');
        return $authenticator;
    }
}