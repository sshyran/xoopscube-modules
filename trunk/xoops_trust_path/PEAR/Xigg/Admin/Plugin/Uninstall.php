<?php
require_once 'Sabai/Controller/ModelEntityDelete.php';

class Xigg_Admin_Plugin_Uninstall extends Sabai_Controller_ModelEntityDelete
{
    function Xigg_Admin_Plugin_Uninstall()
    {
        $url = array('base' => '/plugin');
        $options = array('successURL' => $url, 'errorURL' => $url);
        parent::Sabai_Controller_ModelEntityDelete('Plugin', 'id', $options);
    }

    function _onEntityDeleted(&$entity, &$context)
    {
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        // reload plugins
        $plugin_manager->loadPlugins(true);
    }

    function _onDeleteEntity(&$entity, &$context)
    {
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        if ($dependency = $plugin_manager->getPluginDependency($entity->get('name'), true)) {
            $context->response->setError(sprintf('Plugin %s is required by %s', $entity->get('name'), implode(', ', $dependency)), $this->_errorURL);
            return false;
        }
        $uninstall_result = true;
        $uninstall_error = _('An error occurred during uninstallation.');
        $plugin_manager->dispatch('Uninstall', array($entity->get('version'), &$uninstall_result, &$uninstall_error), $entity->get('name'));
        if (!$uninstall_result) {
            $context->response->setError($uninstall_error, $this->_errorURL);
            return false;
        }
        $context->response->setVar('breadcrumb_current', _('Uninstall Plugin'));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}