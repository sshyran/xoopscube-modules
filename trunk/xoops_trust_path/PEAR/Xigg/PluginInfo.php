<?php
require_once 'SabaiPlugin/Info.php';

class Xigg_PluginInfo extends SabaiPlugin_Info
{
    var $_localeDomain;

    function Xigg_PluginInfo($name, $path)
    {
        parent::SabaiPlugin_Info($name, $path);
        $this->_localeDomain = strtolower($this->_name) . '_plugin';
        bindtextdomain($this->_localeDomain, $this->_path . '/locales');
        bind_textdomain_codeset($this->_localeDomain, SABAI_CHARSET);
    }

    function _($msgid)
    {
        return dgettext($this->_localeDomain, $msgid);
    }
}