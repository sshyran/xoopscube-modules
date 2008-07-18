<?php
require_once 'Sabai/Controller/ModelEntityPaginate.php';

class Xigg_Admin_Role_Member_List extends Sabai_Controller_ModelEntityPaginate
{
    var $_sortBy = array('userid', 'ASC');

    function Xigg_Admin_Role_Member_List()
    {
        $options = array('tplVarPages'         => 'member_pages',
                         'tplVarSortKey'       => 'member_sort_key',
                         'tplVarSortOrder'     => 'member_sort_order',
                         'tplVarPageRequested' => 'member_page_requested',
                         'tplVarName'          => 'member_name',
                         'tplVarNameLC'        => 'member_name_lc',
                         'tplVarNamePlural'    => 'member_name_plural',
                         'tplVarNamePluralLC'  => 'member_name_plural_lc',
                         'tplVarLabels'        => 'member_labels',
                         'tplVarEntities'      => 'member_entities',
                   );
        parent::Sabai_Controller_ModelEntityPaginate('Member', $options);
    }

    function &_getRequestedCriteria(&$request)
    {
        $criteria =& Sabai_Model_Criteria::createValue('member_role_id', $request->getAsInt('role_id'));
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
        $context->response->setVars(
                              array(
                                'member_sortby'      => implode(',', $this->_sortBy),
                                'breadcrumb_current' => _('Members'),
                              )
                            );
        $entities =& $entities->with('User');
        return $entities;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}