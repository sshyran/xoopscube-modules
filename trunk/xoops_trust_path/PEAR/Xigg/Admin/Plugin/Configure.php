<?php
class Xigg_Admin_Plugin_Configure extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$plugin_name = $context->request->getAsStr('plugin_name')) {
            $context->response->setError(_('No plugin specified'), array('base' => '/plugin'));
            return;
        }
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        if (!$plugin =& $this->_parent->isPluginInstalled($context, $plugin_name)) {
            $context->response->setError(_('Plugin not installed'), array('base' => '/plugin'));
            return;
        }
        if (!$plugin_data = $plugin_manager->getLocalPlugin($plugin_name, true)) {
            $context->response->setError(_('Invalid plugin'), array('base' => '/plugin'));
            return;
        }
        $plugin_params_form =& $this->_parent->getForm($plugin_data, $plugin->get('active'), $plugin->get('priority'), $plugin->getParams());
        if ($context->request->isPost()) {
            if ($plugin_params_form->validateValues($context->request->getAll())) {
                if (!$active = $plugin_params_form->getValueFor('_active')) {
                    if ($dependency = $plugin_manager->getPluginDependency($plugin_name, true)) {
                        $context->response->setError(sprintf('Plugin %s is required by %s', $plugin_name, implode(', ', $dependency)), array('base' => '/plugin'));
                        return;
                    }
                } else {
                    if (($php_required = $plugin_data['dependencies']['php']) && version_compare(phpversion(), $php_required, '<')) {
                        $context->response->setError(Sabai_I18N::__('The selected plugin requires PHP %s or higher', $php_required), array('base' => '/plugin'));
                        return;
                    }
                    if ($plugins_required = $plugin_data['dependencies']['plugins']) {
                        $plugins_active = $plugin_manager->getActivePlugins();
                        foreach ($plugins_required as $plugin_required) {
                            if (!array_key_exists($plugin_required['name'], $plugins_active)) {
                                $context->response->setError(Sabai_I18N::__('The selected plugin requires plugin %s to be installed and active', $plugin_required['name']), array('base' => '/plugin'));
                                return;
                            } else {
                                if (isset($plugin_required['version'])) {
                                    if (version_compare($plugins_active[$plugin_required['name']]['version'], $plugin_required['version'], '<')) {
                                        $context->response->setError(Sabai_I18N::__('The selected plugin requires plugin %s version %s or higher to be installed and active', array($plugin_required['name'], $plugin_required['version'])), array('base' => '/plugin'));
                                        return;
                                    }
                                }
                            }
                        }
                    }
                }
                $params = array();
                foreach (array_keys($plugin_data['params']) as $param_name) {
                    $params[$param_name] = $plugin_params_form->getValueFor($param_name);
                    if ($plugin_data['params'][$param_name]['type'] == 'input_multi') {
                        $params[$param_name] = explode("\n", $params[$param_name]);
                    }
                }
                $plugin->setParams($params);
                $plugin->set('active', $active);
                $plugin->set('priority', $plugin_params_form->getValueFor('_priority'));
                if ($plugin->commit()) {
                    // reload plugins
                    $plugin_manager->loadPlugins(true);
                    $context->response->setSuccess(_('Plugin configured successfully'), array('base' => '/plugin'));
                    return;
                }
            }
        }
        $plugin_params_form->onView();
        $context->response->setVars(array(
                                      'plugin_name'        => $plugin_name,
                                      'plugin_params_form' => &$plugin_params_form,
                                      'breadcrumb_current' => _('Configure Plugin')
                                    ));
    }
}