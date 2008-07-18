<?php
require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_GoogleBlogSearchPing_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_GoogleBlogSearchPing_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Google Blog Search Ping plugin');
        $this->_params = array('blogName' => array('label'    => $this->_('The name of blog'),
                                                   'default'  => '',
                                                   'required' => true),
                               'blogURL'  => array('label'    => $this->_('The URL of blog site'),
                                                   'default'  => '',
                                                   'required' => true));
    }
}