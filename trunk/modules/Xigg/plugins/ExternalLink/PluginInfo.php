<?php
if (!class_exists('Sabai')) exit();

require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_ExternalLink_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_ExternalLink_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Adds a small link icon to external links. Opens external links in a new window when clicked.');
        $this->_params = array('localhost'  => array('label'   => $this->_('URL will be considered local if contains the following text'),
                                                     'default' => $_SERVER['HTTP_HOST']));
        $this->_requiredPlugins = array('prototype');
    }
}