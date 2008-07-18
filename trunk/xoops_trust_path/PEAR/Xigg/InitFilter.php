<?php
require_once 'Sabai/Controller/Filter.php';

class Xigg_InitFilter extends Sabai_Controller_Filter
{
    function before(&$context)
    {
        // Is it an AJAX request?
        if ($context->request->getAsBool(XIGG_REQUEST_AJAX_PARAM, false)) {
            $context->response->setRedirect(false); // no redirection
            $context->response->noLayout(); // send partial content
        }

        // Use PATH_INFO to pass route
        $context->request->setRouteMethod(SABAI_REQUEST_WEB_ROUTE_METHOD_PATHINFO);

        // Set some useful template helpers
        $template =& $context->response->getTemplate();
        $template->setObject('Request', $context->request);
        $template->setObject('Config', $context->application->config);
        $template->setObject('User', $context->user);

        $plugin_manager =& $context->application->locator->getService('PluginManager');
        $plugin_manager->setDefaultEventVars(array(&$context));
    }
}