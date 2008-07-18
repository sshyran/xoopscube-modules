<?php
require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_YouTube_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_YouTube_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b3';
        $this->_summary = $this->_('Enables YouTube videos to be safely attached in the content.');
        $this->_params = array('width' => array(
                                       'type'     => 'text',
                                       'label'    => $this->_('Width of Youtube video'),
                                       'default'  => '425',
                                       'required' => true),
                               'height' => array(
                                       'type'     => 'text',
                                       'label'    => $this->_('Height of Youtube video'),
                                       'default'  => '355',
                                       'required' => true),
                               'showRelatedVideos' => array(
                                       'type'     => 'yesno',
                                       'label'    => $this->_('Display related videos?'),
                                       'default'  => 0,
                                       'required' => true),
                         );
    }
}