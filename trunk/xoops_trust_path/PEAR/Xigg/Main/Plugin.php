<?php
class Xigg_Main_Plugin extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ($plugin_name = $context->request->getAsStr('plugin_name')) {
            $plugin_mngr =& $context->application->locator->getService('PluginManager');
            $plugin_mngr->dispatch('Plugin', array(), $plugin_name);
        }
    }
}