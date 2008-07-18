<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Plugin extends Sabai_Controller_Front
{
    function Xigg_Admin_Plugin()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Plugin_', dirname(__FILE__) . '/Plugin');
    }

    function _getRoutes(&$context)
    {
        $routes['plugin/install/:plugin_name'] = array('controller' => 'Install');
        $routes['plugin/configure/:plugin_name'] = array('controller' => 'Configure');
        $routes['plugin/upgrade/:plugin_name'] = array('controller' => 'Upgrade');
        $routes['plugin/list'] = array('controller' => 'List');
        $routes['plugin/:id/uninstall'] = array('controller' => 'Uninstall', 'requirements' => array(':id' => '\d+'));
        return $routes;
	}

    function &getForm($pluginData, $active = 1, $priority = 0, $paramValues = array())
    {
        require_once 'Sabai/Form.php';
        require_once 'Sabai/Form/Element/InputText.php';
        require_once 'Sabai/Form/Element/SelectYesNo.php';
        require_once 'Sabai/Form/Decorator/Token.php';
        $form =& new Sabai_Form();
        foreach ($pluginData['params'] as $param_key => $param_data) {
            switch(@$param_data['type']) {
                case 'yesno':
                    $input =& new Sabai_Form_Element_SelectYesNo($param_key);
                    break;
                case 'textarea':
                    require_once 'Sabai/Form/Element/Textarea.php';
                    $input =& new Sabai_Form_Element_Textarea($param_key, 8, 60);
                    break;
                case 'input_multi':
                    require_once 'Sabai/Form/Element/Textarea.php';
                    $input =& new Sabai_Form_Element_Textarea($param_key, 8, 60);
                    break;
                case 'input':
                default:
                    $input =& new Sabai_Form_Element_InputText($param_key);
            }
            if ($value = array_key_exists($param_key, $paramValues) ?
                            $paramValues[$param_key] :
                                (array_key_exists('default', $param_data) ?
                                    $param_data['default'] :
                                        null)) {
                if (@$param_data['type'] == 'input_multi') {
                    $value = implode("\n", $value);
                }
                $input->setValue($value);
            }
            $form->addElement($input, $param_data['label']);
            if (!empty($param_data['required'])) {
                $form->validatesPresenceOf($param_key, sprintf(_('"%s" is required'), $param_data['label']), _(' '));
            }
        }
        $form->addElement(new Sabai_Form_Element_SelectYesNo('_active'), _('Active'));
        $form->addElement(new Sabai_Form_Element_InputText('_priority', 5, 5), _('Priority'));
        $form->setValues(array('_active' => $active, '_priority' => $priority));
        $form =& new Sabai_Form_Decorator_Token($form, 'Plugin_install');
        return $form;
    }

    function &isPluginInstalled(&$context, $pluginName)
    {
        $plugin = false;
        $model =& $context->application->locator->getService('Model');
        $plugin_r =& $model->getRepository('Plugin');
        $plugins =& $plugin_r->fetchByCriteria(Sabai_Model_Criteria::createValue('plugin_name', $pluginName));
        if ($plugins->size() > 0) {
            $plugin =& $plugins->getFirst();
        }
        return $plugin;
    }
}