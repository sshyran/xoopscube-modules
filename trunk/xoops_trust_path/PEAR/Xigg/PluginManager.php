<?php
require_once 'SabaiPlugin.php';
require_once 'Xigg/Plugin.php';

class Xigg_PluginManager extends SabaiPlugin
{
    var $_model;
    var $_cacher;
    var $_plugins = array();

    function Xigg_PluginManager($pluginDir, $pluginPrefix, &$model, &$cacher)
    {
        parent::SabaiPlugin($pluginDir, $pluginPrefix);
        $this->_model =& $model;
        $this->_cacher =& $cacher;
    }

    function _isCached($id)
    {
        if (!$cached = $this->_cacher->get($id, 'Xigg_PluginManager')) {
            return false;
        }
        return unserialize($cached);
    }

    function _cache($data, $id)
    {
        $this->_cacher->save(serialize($data), $id, 'Xigg_PluginManager');
    }

    function &_instantiateListener($pluginName)
    {
        if (!isset($this->_plugins[$pluginName])) {
            $this->_plugins[$pluginName] =& parent::_instantiateListener($pluginName);
            $this->dispatch('Init', array(), $pluginName);
        }
        return $this->_plugins[$pluginName];
    }

    function _doGetInstalledPlugins()
    {
        $plugins = array();
        $plugin_r =& $this->_model->getRepository('Plugin');
        $plugin_it =& $plugin_r->fetchAll();
        while ($plugin =& $plugin_it->getNext()) {
            $plugins[$plugin->getLabel()] = array(
                                              'params' => $plugin->getParams(),
                                              'version' => $plugin->get('version'));
        }
        return $plugins;
    }

    function _doGetActivePlugins()
    {
        $plugins = array();
        $plugin_r =& $this->_model->getRepository('Plugin');
        $plugin_it =& $plugin_r->fetchByCriteria(Sabai_Model_Criteria::createValue('plugin_active', 1), 0, 0, 'plugin_priority', 'DESC');
        while ($plugin =& $plugin_it->getNext()) {
            $plugins[$plugin->getLabel()] = array(
                                              'params' => $plugin->getParams(),
                                              'version' => $plugin->get('version'));
        }
        return $plugins;
    }
}