<?php
require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_Akismet_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_Akismet_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Anti SPAM plugin using the Akismet API');
        $this->_params = array('apikey' => array('label'    => $this->_('Akismet API key'),
                                                 'default'  => '',
                                                 'required' => true));
    }
}