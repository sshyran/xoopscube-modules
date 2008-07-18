<?php
if (!class_exists('Sabai')) exit();

require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_TinyMCE_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_TinyMCE_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Text editing with TinyMCE editor');
        $this->_params = array('cols'  => array('label'   => $this->_('Text editor textarea columns'),
                                                'default' => '70'),
                               'rows'  => array('label'   => $this->_('Text editor textarea rows'),
                                                'default' => '30'));
    }
}