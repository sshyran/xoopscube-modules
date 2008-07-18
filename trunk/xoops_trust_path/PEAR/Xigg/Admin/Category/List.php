<?php
require_once 'Sabai/Controller/ModelEntityPaginate.php';

class Xigg_Admin_Category_List extends Sabai_Controller_ModelEntityPaginate
{
    var $_sortBy = array('name', 'ASC');

    function Xigg_Admin_Category_List()
    {
        parent::Sabai_Controller_ModelEntityPaginate('Category', array('perpage' => 20));
    }

    function &_getRequestedCriteria(&$request)
    {
        $criteria =& Sabai_Model_Criteria::createValue('category_parent', 'NULL');
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
        if ($this->_sortBy[0] == 'name') {
            return 'name';
        }
        return array($this->_sortBy[0], 'name');
    }

    function _getRequestedOrder(&$request)
    {
        if ($this->_sortBy[0] != 'name') {
            return array($this->_sortBy[1], 'ASC');
        }
        return $this->_sortBy[1];
    }

    function &_onPaginateEntities(&$entities, &$context)
    {
        $model =& $this->_getModel($context);
        if ($category_id = $context->request->getAsInt('branch')) {
            while ($category =& $entities->getNext()) {
                if ($category->getId() == $category_id) {
                    $category_r =& $model->getRepository('Category');
                    $children[$category_id] =& $category_r->fetchDescendantsAsTreeByParent($category_id);
                    $context->response->setVar('child_categories', $children);
                    break;
                }
            }
        }
        $entities =& $entities->with('DescendantsCount');
        $category_gw =& $model->getGateway('Category');
        $context->response->setVars(array(
                                      'requested_sortby' => implode(',', $this->_sortBy),
                                      'node_count_sum'   => $category_gw->getNodeCountSumById($entities->getAllIds()),
                                    ));
        return $entities;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}