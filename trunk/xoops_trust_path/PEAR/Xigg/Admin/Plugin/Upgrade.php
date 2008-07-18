<?php
class Xigg_Admin_Plugin_Upgrade extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$plugin_name = $context->request->getAsStr('plugin_name')) {
            $context->response->setError(_('No plugin specified'), array('base' => '/plugin'));
            return;
        }
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        if (!$plugin_data = $plugin_manager->getLocalPlugin($plugin_name, true)) {
            $context->response->setError(_('Invalid plugin'), array('base' => '/plugin'));
            return;
        }
        if (!$plugin = $this->_parent->isPluginInstalled($context, $plugin_name)) {
            $context->response->setError(_('Plugin not installed'), array('base' => '/plugin'));
            return;
        }
        if (!version_compare($plugin->get('version'), $plugin_data['version'], '<')) {
            $context->response->setError(_('Plugin is up to date'), array('base' => '/plugin'));
            return;
        }
        $plugin_params_form =& $this->_parent->getForm($plugin_data, $plugin->get('active'), $plugin->get('priority'), $plugin->getParams());
        if ($context->request->isPost()) {
            if ($plugin_params_form->validateValues($context->request->getAll())) {

                $upgrade_error = _('An error occurred during upgrade.');
                $upgrade_result = true;
                $plugin_manager->dispatch('Upgrade', array($plugin->get('version'), $plugin_data['version'], &$upgrade_result, &$upgrade_error), $plugin_name);
                if (!$upgrade_result) {
                    $context->response->setError($upgrade_error, array('base' => '/system/plugin'));
                    return;
                }

                $params = array();
                foreach (array_keys($plugin_data['params']) as $param_name) {
                    $params[$param_name] = $plugin_params_form->getValueFor($param_name);
                    if ($plugin_data['params'][$param_name]['type'] == 'input_multi') {
                        $params[$param_name] = explode("\n", $params[$param_name]);
                    }
                }
                $plugin->setParams($params);
                $plugin->set('version', $plugin_data['version']);
                $plugin->set('active', $plugin_params_form->getValueFor('_active'));
                $plugin->set('priority', $plugin_params_form->getValueFor('_priority'));
                if ($plugin->commit()) {
                    $context->response->setSuccess('Plugin upgraded successfully', array('base' => '/plugin'));
                    return;
                }
            }
        }
        $plugin_params_form->onView();
        $context->response->setVars(array(
                                 'plugin_name'        => $plugin_name,
                                 'plugin_params_form' => &$plugin_params_form,
                                 'plugin_version'     => $plugin_data['version'],
                                 'plugin_summary'     => $plugin_data['summary'],
                                 'breadcrumb_current' => _('Upgrade Plugin')
                                    ));
    }
}