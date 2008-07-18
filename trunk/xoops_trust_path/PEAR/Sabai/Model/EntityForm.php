<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Form.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Model_EntityForm extends Sabai_Form
{
    /**
     * @var Sabai_Model
     * @access protected
     */
    var $_model;
    /**
     * @var string
     * @access protected
     */
    var $_entityId;

    /**
     * Constructor
     * @access protected
     * @param Sabai_Model $model
     */
    function Sabai_Model_EntityForm(&$model)
    {
        $this->_model =& $model;
    }

    /**
     * Sets an id of entity object
     *
     * @param string $entityId
     */
    function setEntityId($entityId)
    {
        $this->_entityId = $entityId;
    }

    /**
     * @abstract
     * @param array $params
     */
    function onInit($params){}

    /**
     * @abstract
     * @param Sabai_Model_Entity $entity
     */
    function onEntity(&$entity){}
}