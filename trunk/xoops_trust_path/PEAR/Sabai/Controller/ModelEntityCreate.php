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
class Sabai_Controller_ModelEntityCreate extends Sabai_Controller
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
    var $_viewName;
    /**
     * @var array
     * @access protected
     */
    var $_successURL;
    /**
     * @var bool
     * @access protected
     */
    var $_autoAssignUser;

    /**
     * Constructor
     *
     * @param string $entityName
     * @param array $options
     * @return Sabai_Controller_ModelEntityCreate
     */
    function Sabai_Controller_ModelEntityCreate($entityName, $options = array())
    {
        $this->_entityName = $entityName;
        $options = array_merge(array('viewName' => null, 'successURL' => null, 'autoAssignUser' => true), $options);
        $this->_viewName = $options['viewName'];
        $this->_successURL = $options['successURL'];
        $this->_autoAssignUser = $options['autoAssignUser'];
    }

    /**
     * Executes the action
     *
     * @param Sabai_Controller_Context $context
     */
    function _doExecute(&$context)
    {
        $model =& $this->_getModel($context);
        $entity =& $model->create($this->_entityName);
        if (!$this->_onCreateEntity($entity, $context)) {
            return;
        }
        require_once 'Sabai/Form/Decorator/Token.php';
        $form =& new Sabai_Form_Decorator_Token($this->_getEntityForm($entity, $context), $this->_entityName . '_create');
        if ($context->request->isPost()) {
            if ($form->validateValues($context->request->getAll())) {
                $entity->applyForm($form);
                if ($this->_autoAssignUser && is_callable(array(&$entity, 'assignUser'))) {
                    $entity->assignUser($context->user);
                }
                $entity->markNew();
                if ($model->commit()) {
                    $this->_onEntityCreated($entity, $context);
                    $context->response->setSuccess(sprintf('%s created successfully', $this->_entityName), $this->_successURL);
                    return;
                }
            }
        }
        $form->onView();
        $context->response->setVars(array(
                                      'entity_form'         => &$form,
                                      'entity_id'           => $entity->getId(),
                                      'entity_name'         => $this->_entityName,
                                      'entity_name_lc'      => strtolower($this->_entityName),
                                      'entity_labels'       => $model->getPropertyNamesFor($this->_entityName)
                                    ));
        if (!empty($this->_viewName)) {
            $context->response->popContentName();
            $context->response->pushContentName($this->_viewName);
        }
        //exit;
    }

    /**
     * Gets a entity form object
     *
     * @param Sabai_Model_Entity $entity
     * @param Sabai_Controller_Context $context
     * @return Sabai_Model_EntityForm
     */
    function &_getEntityForm(&$entity, &$context)
    {
        $form =& $entity->toForm();
        return $form;
    }

    /**
     * Callback method called just before creating the entity
     *
     * @return bool
     * @param Sabai_Model_Entity $entity
     * @param Sabai_Controller_Context $context
     * @access protected
     */
    function _onCreateEntity(&$entity, &$context)
    {
        return true;
    }

    /**
     * Callback method called just after the creation of entity is commited to the datasource
     *
     * @param Sabai_Model_Entity $entity
     * @param Sabai_Controller_Context $context
     * @access protected
     */
    function _onEntityCreated(&$entity, &$context){}

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