<?php
if (!class_exists('Sabai')) exit();

require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_LightWindow_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_LightWindow_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Enables the LightWindow javascript library. See http://www.stickmanlabs.com/lightwindow/ for the details of the javascript library.');
        $this->_requiredPlugins = array('prototype');
    }
}