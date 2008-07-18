<?php
require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_TextWiki_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_TextWiki_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Text editing using the Text_Wiki syntax');
    }
}