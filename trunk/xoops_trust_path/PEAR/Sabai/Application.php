<?php
class Sabai_Application
{
    /**
     * @access protected
     */
    var $_name;
    var $_path;

    function Sabai_Application($name, $path)
    {
        $this->_name = $name;
        $this->_path = $path;
    }

    function _setLocale($locales, $localeDir = null)
    {
        require_once 'Sabai/I18N.php';
        Sabai_I18N::locale($locales);
        $locale_dir = isset($localeDir) ? $localeDir : $this->_path . '/locales';
        bindtextdomain($this->_name, $locale_dir);
        bind_textdomain_codeset($this->_name, SABAI_CHARSET);
        textdomain($this->_name);
    }

    function run(&$controller, &$context)
    {
        $context->set('application', $this);
        $context->response->pushContentName(strtolower(get_class($controller)));
        $controller->execute($context);
        $context->response->send($context->request);
    }

    function getName()
    {
        return $this->_name;
    }

    function getPath()
    {
        return $this->_path;
    }

    function debug($level = SABAI_LOG_ALL)
    {
        Sabai_Log::level($level);
        require_once 'Sabai/Log/Writer/HTML.php';
        Sabai_Log::writer(new Sabai_Log_Writer_HTML());
    }
}