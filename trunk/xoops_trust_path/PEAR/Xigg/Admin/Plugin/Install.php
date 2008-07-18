<?php
class Xigg_Admin_Plugin_Install extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$plugin_name = $context->request->getAsStr('plugin_name')) {
            $context->response->setError(_('No plugin specified'), array('base' => '/plugin'));
            return;
        }
        if (in_array(strtolower($plugin_name), array('admin', 'article', 'comment', 'trackback', 'vote', 'node', 'xigg', 'core', 'xml-rpc', 'xmlrpc'))) {
            $context->response->setError(Sabai_I18N::__('Plugin name %s is reserved by the system', array($plugin_name)), array('base' => '/plugin'));
            return;
        }
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        if ($this->_parent->isPluginInstalled($context, $plugin_name)) {
            $context->response->setError(_('Plugin installed already'), array('base' => '/plugin'));
            return;
        }
        if (!$plugin_data = $plugin_manager->getLocalPlugin($plugin_name, true)) {
            $context->response->setError(_('Invalid plugin'), array('base' => '/plugin'));
            return;
        }
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
        $plugin_params_form =& $this->_parent->getForm($plugin_data);
        if ($context->request->isPost()) {
            if ($plugin_params_form->validateValues($context->request->getAll())) {
                $model =& $context->application->locator->getService('Model');
                $plugin =& $model->create('Plugin');
                $plugin->set('name', $plugin_name);
                $plugin->set('locked', !$plugin_data['can_uninstall']);
                $params = array();
                foreach (array_keys($plugin_data['params']) as $param_name) {
                    $params[$param_name] = $plugin_params_form->getValueFor($param_name);
                    if (@$plugin_data['params'][$param_name]['type'] == 'input_multi') {
                        $params[$param_name] = explode("\n", $params[$param_name]);
                    }
                }
                $plugin->setParams($params);
                $plugin->set('version', $plugin_data['version']);
                $plugin->set('active', $plugin_params_form->getValueFor('_active'));
                $plugin->set('priority', $plugin_params_form->getValueFor('_priority'));
                $plugin->markNew();
                if ($plugin->commit()) {
                    // reload plugins
                    $plugin_manager->loadPlugins(true);
                    $install_error = _('An error occurred during installation.');
                    $install_result = true;
                    $plugin_manager->dispatch('Install', array(&$install_result, &$install_error), $plugin_name);
                    if (!$install_result) {
                        $plugin->markRemoved();
                        if (!$plugin->commit()) {
                            $install_result .= _(' Additionally, failed deleting plugin info from the database. Please uninstall the plugin manually before reinstall.');
                        }
                        $context->response->setError(Sabai_I18N::__('Plugin installation failure. Please check the plugin %s and try again. Error: %s', array($plugin_name, $install_error)), array('base' => '/plugin'));

                        return;
                    } else {
                        $context->response->setSuccess(_('Plugin installed successfully'), array('base' => '/plugin'));
                        return;
                    }
                }
            }
        }
        $plugin_params_form->onView();
        $context->response->setVars(array(
                                 'plugin_name'        => $plugin_name,
                                 'plugin_params_form' => &$plugin_params_form,
                                 'plugin_version'     => $plugin_data['version'],
                                 'plugin_summary'     => $plugin_data['summary'],
                                 'breadcrumb_current' => _('Install Plugin'),
                                 'php_required'       => $php_required,
                                 'plugins_required'   => $plugins_required,
                                    ));
    }
}