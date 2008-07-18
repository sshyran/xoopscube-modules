<?php
require_once 'Xigg/PluginManager.php';

class Xigg_Service_PluginManager extends Sabai_Service_Provider
{
    function Xigg_Service_PluginManager($pluginDir)
    {
        parent::Sabai_Service_Provider(array(
                                         'pluginDir'    => $pluginDir,
                                         'pluginPrefix' => 'Xigg_Plugin_'
                                       ),
                                       array('Model', 'Cacher')
                                      );
    }

    function &_doGetService($params, $services)
    {
        $plugin_manager =& new Xigg_PluginManager($params['pluginDir'], $params['pluginPrefix'], $services['Model'], $services['Cacher']);
        $plugin_manager->loadPlugins(false);
        return $plugin_manager;
    }
}