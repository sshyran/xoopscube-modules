<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.8
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Controller
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.8
 */
class Sabai_Controller_ModelEntityList extends Sabai_Controller
{
    /**
     * @var string
     * @access protected
     */
    var $_entityName;
    /**
     * @var array
     * @access protected
     */
    var $_options;

    /**
     * Constructor
     *
     * @param string $entityName
     * @param array $options
     * @return Sabai_Controller_ModelEntityList
     */
    function Sabai_Controller_ModelEntityList($entityName, $options = array())
    {
        $this->_entityName = $entityName;
        $default = array('viewName'            => null,
                             'tplVarSortKey'       => 'entity_sort_key',
                             'tplVarSortOrder'     => 'entity_sort_order',
                             'tplVarName'          => 'entity_name',
                             'tplVarNameLC'        => 'entity_name_lc',
                             'tplVarNamePlural'    => 'entity_name_plural',
                             'tplVarNamePluralLC'  => 'entity_name_plural_lc',
                             'tplVarLabels'        => 'entity_labels',
                             'tplVarEntities'      => 'entity_objects',
                             'properties'          => array());
        $this->_options = array_merge($default, $options);
    }

    /**
     * Executes the action
     *
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
        $model =& $this->_getModel($context);
        $repository =& $model->getRepository($this->_entityName);
        $sort_key = null;
        if ($sort_key_requested = $this->_getRequestedSort($context->request)) {
            $sort_key = strtolower($this->_entityName) . '_' . $sort_key_requested;
        }
        $sort_order = $this->_getRequestedOrder($context->request);
        if ($criteria =& $this->_getRequestedCriteria($context->request)) {
            $entities =& $repository->fetchByCriteria($criteria, 0, 0, $sort_key, $sort_order);
        } else {
            $entities =& $repository->fetchAll(0, 0, $sort_key, $sort_order);
        }
        $entities =& $this->_onListEntities($entities, $context);
        $context->response->setVars(array(
                                 $this->_options['tplVarSortKey']       => $sort_key_requested,
                                 $this->_options['tplVarSortOrder']     => $sort_order,
                                 $this->_options['tplVarName']          => $this->_entityName,
                                 $this->_options['tplVarNameLC']        => strtolower($this->_entityName),
                                 $this->_options['tplVarNamePlural']    => pluralize($this->_entityName),
                                 $this->_options['tplVarNamePluralLC']  => strtolower(pluralize($this->_entityName)),
                                 $this->_options['tplVarLabels']        => $model->getLocalPropertyNamesFor($this->_entityName, $this->_options['properties']),
                                 $this->_options['tplVarEntities']      => &$entities));

        if (!empty($this->_options['viewName'])) {
            $context->response->popContentName();
            $context->response->pushContentName($this->_options['viewName']);
        }
    }

    function _getRequestedSort(&$request)
    {
        return $request->getAsStr('sort', '');
    }

    function _getRequestedOrder(&$request)
    {
        return $request->getAsStr('order', 'ASC', array('ASC', 'DESC'));
    }

    function &_getRequestedCriteria(&$request)
    {
        $ret = false;
        return $ret;
    }

    /**
     * Callback method called just before viewing the list of entities
     *
     * @return Sabai_Model_EntityCollection
     * @param Sabai_Model_EntityCollection_Rowset $entities
     * @param Sabai_Controller_Context $context
     * @access protected
     */
    function &_onListEntities(&$entities, &$context)
    {
        return $entities;
    }

    /**
     * Returns the mdoel object
     *
     * @access protected
     * @return Sabai_Model
     * @param Sabai_Controller_Context
     */
    function &_getModel(&$context)
    {
    }
}