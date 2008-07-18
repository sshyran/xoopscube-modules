<?php
require_once 'Sabai/Controller/ModelEntityPaginate.php';

class Xigg_Admin_Tag_List extends Sabai_Controller_ModelEntityPaginate
{
    var $_sortBy = array('name', 'ASC');

    function Xigg_Admin_Tag_List()
    {
        parent::Sabai_Controller_ModelEntityPaginate('Tag', array('perpage' => 20));
    }

    function _getRequestedSort(&$request)
    {
        if ($sort_by = $request->getAsStr('sortby')) {
            $sort_by = explode(',', $sort_by);
            if (count($sort_by) == 2) {
                $this->_sortBy = $sort_by;
            }
        }
        return $this->_sortBy[0];
    }

    function _getRequestedOrder(&$request)
    {
        if (!empty($this->_sortBy[1])) {
            return $this->_sortBy[1];
        }
    }

    function &_onPaginateEntities(&$entities, &$context)
    {
        $context->response->setVars(array('requested_sortby' => implode(',', $this->_sortBy)));
        $entities =& $entities->with('Nodes');
        $entities->rewind();
        return $entities;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}