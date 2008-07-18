<?php
class SabaiPlugin_Info
{
    var $_name;
    var $_path;
    var $_version = '0.0.1dev';
    var $_summary = '';
    var $_description = '';
    var $_canUninstall = true;
    var $_params = array();
    var $_requiredPHP = '';
    var $_requiredPlugins = array();

    function SabaiPlugin_Info($name, $path)
    {
        $this->_name = $name;
        $this->_path = $path;
    }

    function getVersion()
    {
        return $this->_version;
    }

    function getSummary()
    {
        return $this->_summary;
    }

    function getDescription()
    {
        return $this->_description;
    }

    function getParams()
    {
        return $this->_params;
    }

    function getDependencies()
    {
        $plugins = array();
        foreach ($this->_getRequiredPlugins() as $plugin) {
            if (!is_array($plugin)) {
                $plugins[] = array('name' => $plugin, 'version' => null);
            } else {
                $plugins[] = array('name' => $plugin[0], 'version' => isset($plugin[1]) ? $plugin[1] : null);
            }

        }
        return array('php'     => $this->_getRequiredPHP(),
                     'plugins' => $plugins);
    }

    function getDependenciesAsStr()
    {
        $ret[] = 'PHP ' . $this->_getRequiredPHP();
        foreach ($this->_getRequiredPlugins() as $plugin) {
            if (!is_array($plugin)) {
                $ret[] = $plugin;
            } else {
                $ret[] = $plugin[0] . ' ' . (isset($plugin[1]) ? $plugin[1] : '');
            }

        }
        $ret = implode(', ', $ret);
    }

    function canUninstall()
    {
        return $this->_canUninstall;
    }

    function _getRequiredPHP()
    {
        return $this->_requiredPHP;
    }

    function _getRequiredPlugins()
    {
        return $this->_requiredPlugins;
    }
}