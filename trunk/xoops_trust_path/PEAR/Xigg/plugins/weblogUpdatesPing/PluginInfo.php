<?php
require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_weblogUpdatesPing_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_weblogUpdatesPing_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Sends pings to pinging service servers');
        $this->_params = array(
                           'servers'  => array('label'    => $this->_('Servers to ping'),
                                               'default'  => array('http://rpc.weblogs.com/RPC2', 'http://ping.blo.gs', 'http://rpc.technorati.com/rpc/ping'),
                                               'required' => true,
                                               'type'     => 'input_multi'),
                           'blogName' => array('label'    => $this->_('The name of blog'),
                                               'default'  => '',
                                               'required' => true),
                           'blogURL'  => array('label'    => $this->_('The URL of blog site'),
                                               'default'  => '',
                                               'required' => true));
    }
}