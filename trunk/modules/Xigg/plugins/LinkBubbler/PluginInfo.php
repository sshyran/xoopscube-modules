<?php
if (!class_exists('Sabai')) exit();

require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_LinkBubbler_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_LinkBubbler_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Enables popup for website screenshots');
        $this->_requiredPlugins = array('prototype');
    }
}