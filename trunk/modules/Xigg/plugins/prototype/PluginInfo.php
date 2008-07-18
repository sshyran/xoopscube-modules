<?php
if (!class_exists('Sabai')) exit();

require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_prototype_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_prototype_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0';
        $this->_summary = $this->_('Enabless prototype(1.6.0.2)/scriptaculous(1.8.1) javascript libraries + prototype.tidbits(1.7.0) from livepipe.net');
    }
}