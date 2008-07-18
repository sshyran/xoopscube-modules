<?php
require_once 'HTMLPurifier.php';

class Xigg_Service_HTMLPurifier extends Sabai_Service_Provider
{
    function Xigg_Service_HTMLPurifier($cacheDir)
    {
        parent::Sabai_Service_Provider(array(
                                         'cacheSerializerPath' => $cacheDir,
                                         'uriDisableExternalResources' => true,
                                         'attrEnableID' => true,
                                         'htmlAllowed' => null),
                                       array('PluginManager'));
    }

    function &_doGetService($params, $services)
    {
        if (empty($params['cacheSerializerPath']) || !is_dir($params['cacheSerializerPath'])) {
            die('Invalid cache directory.');
        }
        if (!is_writable($params['cacheSerializerPath'])) {
            die(sprintf('The cache directory %s must be configured writeable by the server.', $params['cacheSerializerPath']));
        }
        $config = HTMLPurifier_Config::createDefault();
        $config->autoFinalize = false;
        //$config->set('Core', 'Encoding', SABAI_CHARSET);
        // remove the port part
        if ($pos = strpos($_SERVER['HTTP_HOST'], ':')) {
        	$config->set('URI', 'Host', substr($_SERVER['HTTP_HOST'], 0, $pos));
        } else {
        	$config->set('URI', 'Host', $_SERVER['HTTP_HOST']);
        }
        $config->set('Cache', 'SerializerPath', $params['cacheSerializerPath']);
        $config->set('Attr', 'EnableID', $params['attrEnableID']);
        $config->set('URI', 'DisableExternalResources', $params['uriDisableExternalResources']);
        if (!empty($params['htmlAllowed'])) {
            $config->set('HTML', 'Allowed', $params['htmlAllowed']);
        }
        $config->set('HTML', 'DefinitionID', 'Xigg');
        $config->set('HTML', 'DefinitionRev', 1);
        $htmlDef =& $config->getHTMLDefinition(true);
        $htmlDef->addAttribute('a', 'rel', 'CDATA');
        $services['PluginManager']->dispatch('HTMLPurifierConfigure', array(&$config));
        $HTMLPurifier =& new HTMLPurifier($config);
        $services['PluginManager']->dispatch('HTMLPurifierInit', array(&$HTMLPurifier));
        return $HTMLPurifier;
    }
}