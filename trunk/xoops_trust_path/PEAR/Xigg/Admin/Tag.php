<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Tag extends Sabai_Controller_Front
{
    function Xigg_Admin_Tag()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Tag_', dirname(__FILE__) . '/Tag');
        $this->addControllerFilter(array('Update', 'Delete', 'Details'), '_isValidTagRequested');
    }

    function _getRoutes(&$context)
    {
        $routes['tag/list'] = array('controller' => 'List');
        $routes['tag/submit'] = array('controller' => 'Submit');
        $routes['tag/delete_empty_tags'] = array('controller' => 'DeleteEmptyTags');
        $routes['tag/add'] = array('controller' => 'Create');
        $routes['tag/:tag_id/edit'] = array('controller' => 'Update', 'requirements' => array(':tag_id' => '\d+'));
        $routes['tag/:tag_id/delete'] = array('controller' => 'Delete', 'requirements' => array(':tag_id' => '\d+'));
        $routes['tag/:tag_id'] = array('controller' => 'Details', 'requirements' => array(':tag_id' => '\d+'));
        return $routes;
    }

    function _isValidTagRequestedBeforeFilter(&$context)
    {
        $this->_parent->isValidEntityRequestedBeforeFilter('Tag', $context);
    }
}