<?php
require_once 'Sabai/Controller/ModelEntityPaginate.php';

class Xigg_Admin_Node_List extends Sabai_Controller_ModelEntityPaginate
{
    var $_select;
    var $_sortBy = array('created', 'DESC');

    function Xigg_Admin_Node_List()
    {
        parent::Sabai_Controller_ModelEntityPaginate('Node', array('perpage' => 20));
    }

    function &_getRequestedCriteria(&$request)
    {
        $this->_select = $request->getAsStr('select');
        switch($this->_select) {
            case 'published':
                $criteria =& Sabai_Model_Criteria::createValue('node_status', XIGG_NODE_STATUS_PUBLISHED);
                break;
            case 'upcoming':
                $criteria =& Sabai_Model_Criteria::createValue('node_status', XIGG_NODE_STATUS_UPCOMING);
                break;
            case 'hidden':
                $criteria =& Sabai_Model_Criteria::createValue('node_hidden', 1);
                break;
            case 'nocategory':
                $criteria =& Sabai_Model_Criteria::createValue('node_category_id', 'NULL');
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
        if ($this->_sortBy[0] == 'created') {
            return 'created';
        }
        return array($this->_sortBy[0], 'created');
    }

    function _getRequestedOrder(&$request)
    {
        if ($this->_sortBy[0] != 'created') {
            return array($this->_sortBy[1], 'DESC');
        }
        return $this->_sortBy[1];
    }

    function &_onPaginateEntities(&$entities, &$context)
    {
        $context->response->setVars(array(
                                      'requested_select' => $this->_select,
                                      'requested_sortby' => implode(',', $this->_sortBy)
                                    ));
        $entities =& $entities->with('Category');
        $entities =& $entities->with('User');
        return $entities;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}