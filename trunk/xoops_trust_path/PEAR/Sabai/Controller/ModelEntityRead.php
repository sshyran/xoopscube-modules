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
class Sabai_Controller_ModelEntityRead extends Sabai_Controller
{
    /**
     * @var string
     * @access protected
     */
    var $_entityName;
    /**
     * @var string
     * @access protected
     */
    var $_entityIdKey;
    /**
     * @var string
     * @access protected
     */
    var $_viewName;
    /**
     * @var string
     * @access protected
     */
    var $_errorURL;

    /**
     * Constructor
     *
     * @param string $entityName
     * @param string $entityIdKey
     * @param array $options
     * @return Sabai_Controller_ModelEntityRead
     */
    function Sabai_Controller_ModelEntityRead($entityName, $entityIdKey, $options = array())
    {
        $this->_entityName = $entityName;
        $this->_entityIdKey = $entityIdKey;
        $options = array_merge(array('viewName' => null, 'errorURL' => null), $options);
        $this->_viewName = $options['viewName'];
        $this->_errorURL = $options['errorURL'];
    }

    /**
     * Executes the action
     *
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
        if (0 >= $id = $context->request->getAsInt($this->_entityIdKey, 0)) {
            $context->response->setError('Invalid entity ID', $this->_errorURL);
            return;
        }
        $model =& $this->_getModel($context);
        $entity_r =& $model->getRepository($this->_entityName);
        if (!$entity =& $entity_r->fetchById($id)) {
            $context->response->setError('Invalid entity ID', $this->_errorURL);
            return;
        }
        if (!$this->_onReadEntity($entity, $context)) {
            return;
        }
        $context->response->setVars(array(
                                      'entity'              => &$entity,
                                      'entity_id'           => $entity->getId(),
                                      'entity_name'         => $this->_entityName,
                                      'entity_name_lc'      => strtolower($this->_entityName),
                                      'entity_labels'       => $model->getPropertyNamesFor($this->_entityName)
                                    ));
        if (!empty($this->_viewName)) {
            $context->response->popContentName();
            $context->response->pushContentName($this->_viewName);
        }
    }

    /**
     * Callback method called just before viewing the entity
     *
     * @return bool
     * @param Sabai_Model_Entity $entity
     * @param Sabai_Controller_Context $context
     * @access protected
     */
    function _onReadEntity(&$entity, &$context)
    {
        return true;
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