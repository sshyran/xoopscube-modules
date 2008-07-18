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
 * @subpackage EntityCollection
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Model/EntityCollection/Decorator.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Model
 * @subpackage EntityCollection
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Model_EntityCollection_Decorator_User extends Sabai_Model_EntityCollection_Decorator
{
    var $_userIdentities;

    function Sabai_Model_EntityCollection_Decorator_User(&$collection)
    {
        parent::Sabai_Model_EntityCollection_Decorator($collection);
    }

    function rewind()
    {
        $this->_collection->rewind();
        if (!isset($this->_userIdentities)) {
            $this->_userIdentities = array();
            if ($this->_collection->size() > 0) {
                $user_ids = array();
                while ($entity =& $this->_collection->getNext()) {
                    $user_ids[] = $entity->getUserId();
                    unset($entity);
                }
                $this->_userIdentities = $this->_model->fetchUserIdentities(array_unique($user_ids));
                $this->_collection->rewind();
            }
        }
    }

    function &current()
    {
        $current =& $this->_collection->current();
        $current->setObject('User', $this->_userIdentities[$current->getUserId()]);
        return $current;
    }
}