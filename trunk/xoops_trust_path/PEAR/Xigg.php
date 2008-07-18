<?php
require_once 'Sabai.php';
require_once 'Sabai/Application.php';
require_once 'Sabai/Config/Array.php';
require_once 'Sabai/Service/Locator.php';

define('XIGG_REQUEST_AJAX_PARAM', '__ajax');

class Xigg extends Sabai_Application
{
    var $config;
    var $locator;

    function Xigg($config)
    {
        parent::Sabai_Application('Xigg', dirname(__FILE__) . '/Xigg');
        // Locale settings
        $this->_setLocale($config['I18N']['locales'], $config['I18N']['localeDir']);

        // Setup services
        $this->locator =& new Sabai_Service_Locator();
        $this->locator->addProvider('DB', array($config['DB']['scheme'], $config['DB']['tablePrefix'], $config['DB']['clientEncoding'], $config['DB']['options']));
        $this->locator->addProvider('Model',array('Xigg_Model_', $this->_path . '/Model'));
        $this->locator->addProvider('UserAuthenticator', array($config['User']['scheme'], $config['User']['Authenticator']));
        $this->locator->addProvider('UserIdentityFetcher', array($config['User']['scheme'], $config['User']['IdentityFetcher']));
        $this->locator->setProviderFileFormat('Xigg/Service/%s.php');
        $this->locator->setProviderClassFormat('Xigg_Service_%s');
        array_push($config['pluginDir'], $this->_path . '/plugins');
        $this->locator->addProvider('PluginManager', array($config['pluginDir']));
        $this->locator->addProvider('HTMLPurifier', array($config['cacheDir'] . '/HTMLPurifier'));
        $this->locator->addProvider('Cacher', array($config['cacheDir'] . '/Cache_Lite/'));

        $this->config =& new Sabai_Config_Array($config);

        //$this->debug();
    }

    function &getInstance($config, $id = 'default')
    {
        static $instance;
        if (!isset($instance[$id])) {
            $instance[$id] =& new Xigg($config);
        }
        return $instance[$id];
    }

    function run(&$controller, &$context)
    {
        require $this->_path . '/InitFilter.php';
        require $this->_path . '/User.php';
        require $this->_path . '/UserFilter.php';
        require_once 'Sabai/Handle/Instance.php';
        $controller->prependFilterHandle(new Sabai_Handle_Instance(new Xigg_UserFilter()));
        $controller->prependFilterHandle(new Sabai_Handle_Instance(new Xigg_InitFilter()));
        $context->set('user', new Xigg_User($context->user));
        parent::run($controller, $context);
    }
}