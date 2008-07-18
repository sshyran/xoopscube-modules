<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Category extends Sabai_Controller_Front
{
    function Xigg_Admin_Category()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Category_', dirname(__FILE__) . '/Category');
        $this->addControllerFilter(array('Update', 'Delete', 'Details'), '_isValidCategoryRequested');
    }

    function _getRoutes(&$context)
    {
	    $routes['category/list'] = array('controller' => 'List');
        $routes['category/add'] = array('controller' => 'Create');
        $routes['category/:category_id/edit'] = array('controller' => 'Update', 'requirements' => array(':category_id' => '\d+'));
        $routes['category/:category_id/delete'] = array('controller' => 'Delete', 'requirements' => array(':category_id' => '\d+'));
        $routes['category/:category_id'] = array('controller' => 'Details', 'requirements' => array(':category_id' => '\d+'));
        return $routes;
    }

    function _isValidCategoryRequestedBeforeFilter(&$context)
    {
        $this->_parent->isValidEntityRequestedBeforeFilter('Category', $context);
    }
}