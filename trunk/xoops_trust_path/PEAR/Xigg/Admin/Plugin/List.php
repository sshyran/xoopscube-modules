<?php
require_once 'Sabai/Controller/ModelEntityPaginate.php';

class Xigg_Admin_Plugin_List extends Sabai_Controller_ModelEntityPaginate
{
    var $_sortBy = array('priority', 'DESC');
    var $_select;

    function Xigg_Admin_Plugin_List()
    {
        parent::Sabai_Controller_ModelEntityPaginate('Plugin', array('properties' => array('name', 'version', 'active', 'priority')));
    }

    function &_onPaginateEntities(&$entities, &$context)
    {
        $installed = array();
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        $local = $plugin_manager->getLocalPlugins($context->request->getAsBool('refresh'));
        while ($plugin =& $entities->getNext()) {
            $plugin_name = $plugin->getLabel();
            if (isset($local[$plugin_name])) {
                $installed[$plugin_name] = $local[$plugin_name];
                unset($local[$plugin_name]);
            }
        }
        $context->response->setVars(array(
                                      'requested_select' => $this->_select,
                                      'requested_sortby' => implode(',', $this->_sortBy),
                                      'local_plugins'    => $local,
                                      'installed_plugins' => $installed,
                                      'plugins_dependency' => $plugin_manager->getPluginsDependency()
                                    ));
        return $entities;
    }

    function &_getRequestedCriteria(&$request)
    {
        $this->_select = $request->getAsStr('select');
        switch($this->_select) {
            case 'active':
                $criteria =& Sabai_Model_Criteria::createValue('plugin_active', 1);
                break;
            default:
                $this->_select = 'all';
                $criteria = false;
                break;
        }
        return $criteria;
    }

    function _getRequestedSort(&$request)
    {
        if ($sort_by = $request->getAsStr('sortby')) {
            $sort_by = explode(',', $sort_by);
            if (count($sort_by) == 2) {
                $this->_sortBy = $sort_by;
            }
        }
        if ($this->_sortBy[0] == 'priority') {
            return 'priority';
        }
        return array($this->_sortBy[0], 'priority');
    }

    function _getRequestedOrder(&$request)
    {
        if ($this->_sortBy[0] != 'priority') {
            return array($this->_sortBy[1], 'DESC');
        }
        return $this->_sortBy[1];
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}