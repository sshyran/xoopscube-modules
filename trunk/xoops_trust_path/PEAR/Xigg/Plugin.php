<?php
require_once 'SabaiPlugin/Main.php';

class Xigg_Plugin extends SabaiPlugin_Main
{
    /**
     * @var string
     * @access private
     */
    var $_localeDomain;

    function Xigg_Plugin($name, $path, $params)
    {
        parent::SabaiPlugin_Main($name, $path, $params);
        $this->_localeDomain = 'Xigg_Plugin_' . $this->_name;
        bindtextdomain($this->_localeDomain, $this->_path . '/locales');
        bind_textdomain_codeset($this->_localeDomain, SABAI_CHARSET);
    }

    /**
     * Translates a message string
     *
     * @access protected
     * @param string $msgid
     * @return string
     */
    function _($msgid)
    {
        return dgettext($this->_localeDomain, $msgid);
    }

    function onInit(&$context){}
}