<?php
require_once 'Sabai/Event/Dispatcher.php';
require_once 'Sabai/Handle/Decorator/Cache.php';
require_once 'Sabai/Handle/Decorator/Autoload.php';
require_once 'Sabai/Handle/Class.php';

class SabaiPlugin extends Sabai_Event_Dispatcher
{
    var $_pluginDir;
    var $_pluginPrefix;

    function SabaiPlugin($pluginDir, $pluginPrefix)
    {
        $this->_pluginDir = (array)$pluginDir;
        $this->_pluginPrefix = $pluginPrefix;
    }

    function getPluginDir()
    {
        return $this->_pluginDir;
    }

    function loadPlugins($force = false)
    {
        if ($force || (!$data = $this->_isCached('plugins'))) {
            $data = array();
            $this->clearEventListeners();
            $local = $this->getLocalPlugins($force);
            $active_plugins = $this->getActivePlugins($force);
            foreach (array_keys($active_plugins) as $plugin_name) {
                if ($plugin_data = @$local[$plugin_name]) {
                    $plugin_params = $active_plugins[$plugin_name]['params'];
                    foreach ($plugin_data['params'] as $param_name => $param_data) {
                        if (!array_key_exists($param_name, $plugin_params)) {
                            $plugin_params[$param_name] = $param_data['default'];
                        }
                    }
                    $plugin_handle =& new Sabai_Handle_Decorator_Cache(
                                        new Sabai_Handle_Decorator_Autoload(
                                          new Sabai_Handle_Class($plugin_data['class'], array($plugin_name, $plugin_data['dir'], $plugin_params)),
                                          $plugin_data['file']));
                    $data[$plugin_name] = array('handle' => &$plugin_handle, 'events' => $plugin_data['events']);
                }
            }
            $this->_cache($data, 'plugins');
        }
        foreach (array_keys($data) as $plugin_name) {
            $this->addEventListener($data[$plugin_name]['events'], $data[$plugin_name]['handle'], $plugin_name);
        }
    }

    function getPluginsDependency($force = false)
    {
        if ($force || (!$data = $this->_isCached('plugins_dependency'))) {
            $local = $this->getLocalPlugins($force);
            $active_plugins = $this->getActivePlugins($force);
            $data = array();
            foreach (array_keys($active_plugins) as $plugin_name) {
                if ($plugin_data = @$local[$plugin_name]) {
                    foreach ($plugin_data['dependencies']['plugins'] as $dependant_plugin) {
                        $data[$dependant_plugin['name']][] = $plugin_name;
                    }
                }
            }
            $this->_cache($data, 'plugins_dependency');
        }
        return $data;
    }

    function getPluginDependency($pluginName, $force = false)
    {
        $dependency = $this->getPluginsDependency($force);
        return isset($dependency[$pluginName]) ? $dependency[$pluginName] : false;
    }

    function getLocalPlugins($force = false)
    {
        if ($force || (!$data = $this->_isCached('plugins_local'))) {
            $data = array();
            foreach ($this->_pluginDir as $_plugin_dir) {
                if ($dh = opendir($_plugin_dir)) {
                    while (false !== $file = readdir($dh)) {
                        if (preg_match('/^[a-zA-Z]+[a-zA-Z0-9]*[a-zA-Z0-9]+$/i', $file) && empty($data[$file])) {
                            $plugin_dir = $_plugin_dir . '/' . $file;
                            if (is_dir($plugin_dir)) {
                                $plugin_file_info = $plugin_dir . '/PluginInfo.php';
                                $plugin_file_main = $plugin_dir . '/Plugin.php';
                                if (file_exists($plugin_file_info) && file_exists($plugin_file_main)) {
                                    require_once $plugin_file_info;
                                    require_once $plugin_file_main;
                                    $plugin_class_info = $this->_pluginPrefix . $file . '_Info';
                                    $plugin_class_main = $this->_pluginPrefix . $file;
                                    if (class_exists($plugin_class_info) && class_exists($plugin_class_main)) {
                                        $plugin_info =& new $plugin_class_info($file, $plugin_dir);
                                        $plugin_events = array_map(array(&$this, '_mapEvent'), array_filter(get_class_methods($plugin_class_main), array(&$this, '_filterEvent')));
                                        // param names starting with an underscore(_) is reserverd for internal use
                                        $plugin_params = $plugin_info->getParams();
                                        foreach (array_keys($plugin_params) as $plugin_param_name) {
                                            if (strpos($plugin_param_name, '_') === 0) {
                                                unset($plugin_params[$plugin_param_name]);
                                            }
                                        }
                                        $data[$file] = array(
                                                        'dir'           => $plugin_dir,
                                                        'file'          => $plugin_file_main,
                                                        'class'         => $plugin_class_main,
                                                        'params'        => $plugin_params,
                                                        'version'       => $plugin_info->getVersion(),
                                                        'summary'       => $plugin_info->getSummary(),
                                                        'description'   => $plugin_info->getDescription(),
                                                        'can_uninstall' => $plugin_info->canUninstall(),
                                                        'events'        => $plugin_events,
                                                        'dependencies'  => $plugin_info->getDependencies(),
                                                        );
                                    } else {
                                        trigger_error(sprintf('Required class %s and/or %s does not exist for plugin %s', $plugin_class_info, $plugin_class_main, $file), E_USER_WARNING);
                                    }
                                } else {
                                    trigger_error(sprintf('Required class file does not exist for plugin %s', $file), E_USER_WARNING);
                                }
                            }
                        }
                    }
                    closedir($dh);
                }
                ksort($data);
                $this->_cache($data, 'plugins_local');
            }
        }
        return $data;
    }

    function getInstalledPlugins($force = false)
    {
        if ($force || (!$data = $this->_isCached('plugins_installed'))) {
            $data = $this->_doGetInstalledPlugins();
            $this->_cache($data, 'plugins_installed');
        }
        return $data;
    }

    function getActivePlugins($force = false)
    {
        if ($force || (!$data = $this->_isCached('plugins_active'))) {
            $data = $this->_doGetActivePlugins();
            $this->_cache($data, 'plugins_active');
        }
        return $data;
    }

    function getLocalPlugin($pluginName, $force = false)
    {
        $local_plugins = $this->getLocalPlugins($force);
        return isset($local_plugins[$pluginName]) ? $local_plugins[$pluginName] : false;
    }

    function isPluginInstalled($pluginName, $force = false)
    {
        $plugins = $this->getInstalledPlugins($force);
        return isset($plugins[$pluginName]) ? $plugins[$pluginName] : false;
    }

    function isPluginActive($pluginName, $force = false)
    {
        $plugins = $this->getActivePlugins($force);
        return isset($plugins[$pluginName]) ? $plugins[$pluginName] : false;
    }

    function _filterEvent($method)
    {
        return (strpos($method, 'on') === 0);
    }

    function _mapEvent($method)
    {
        return substr($method, 2);
    }

    function _isCached($id)
    {
    }

    function _cache($data, $id)
    {
    }

    function _doGetInstalledPlugins()
    {
    }

    function _doGetActivePlugins()
    {
    }
}