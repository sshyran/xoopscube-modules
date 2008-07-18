<?php
/*
This file has been generated by the Sabai scaffold script. Do not edit this file directly.
If you need to customize the class, use the following file:
Xigg/library/Xigg/Model/Vote.php
*/
class Xigg_Model_VoteBase extends Sabai_Model_Entity
{
    function Xigg_Model_VoteBase(&$model)
    {
        parent::Sabai_Model_Entity('Vote', $model);
        $this->_vars = array('vote_id' => 0, 'vote_created' => 0, 'vote_updated' => 0, 'vote_score' => 0, 'vote_ip' => null, 'vote_node_id' => null, 'vote_userid' => null);
    }

    function varNames()
    {
        return array('id' => _('Id'), 'created' => _('Created'), 'updated' => _('Updated'), 'score' => _('Score'), 'ip' => _('Ip'), 'node_id' => _('Node id'), 'userid' => _('Userid'));
    }

    function propertyNames()
    {
        return array('score' => _('Score'), 'ip' => _('Ip'), 'Node' => 'Node');
    }

    function localPropertyNames()
    {
        return array('score' => _('Score'), 'ip' => _('Ip'));
    }

    function getUserId()
    {
        return $this->getVar('userid');
    }

    function assignUser(&$user)
    {
        $this->_setVar('userid', $user->getId());
    }

    function &_fetchUser()
    {
        if (!isset($this->_objects['User'])) {
            $user_id = $this->getUserId();
            $identities = $this->_model->fetchUserIdentities(array($user_id));
            $this->_objects['User'] =& $identities[$user_id];
        }
        return $this->_objects['User'];
    }

    function isOwnedBy(&$user)
    {
        return $this->getUserId() == $user->getId();
    }

    function getId()
    {
        return $this->getVar('id');
    }

    function setId($value)
    {
        $this->setVar('id', $value);
    }

    function getTimeCreated()
    {
        return $this->getVar('created');
    }

    function getTimeUpdated()
    {
        return $this->getVar('updated');
    }

    function assignNode(&$entity)
    {
        if ($entity->getName() != 'Node') {
            return false;
        }
        return $this->_assignEntity('node_id', $entity);
    }

    function unassignNode()
    {
        return $this->_unassignEntity('node_id');
    }

    function &_fetchNode()
    {
        if (!isset($this->_objects['Node'])) {
            $this->_objects['Node'] =& $this->_fetchEntity('Node', 'node_id');
        }
        return $this->_objects['Node'];
    }

    function _getVar($name)
    {
        return $this->_vars['vote_' . $name];
    }

    function _setVar($name, $value)
    {
        switch ($name) {
        case 'id':
            $this->_vars['vote_id'] = $value;
            break;
        case 'score':
            $this->_vars['vote_score'] = $value;
            break;
        case 'ip':
            $this->_vars['vote_ip'] = trim($value);
            break;
        case 'node_id':
            $this->_vars['vote_node_id'] = $value;
            break;
        case 'userid':
            $this->_vars['vote_userid'] = trim($value);
            break;
        default:
            trigger_error(sprintf('Error trying to set value for variable %s. This variable is either read-only or does not exist for this entity', $name), E_USER_WARNING);
            return false;
        }
        return true;
    }

    function &__get($name)
    {
        $ret = null;
        settype($name, 'string');
        switch ($name) {
        case 'score':
            $ret = $this->getVar('score');
            break;
        case 'ip':
            $ret = $this->getVar('ip');
            break;
        case 'Node':
            $ret =& $this->_fetchNode();
            break;
        case 'User':
            $ret =& $this->_fetchUser();
            break;
        default:
        }
        return $ret;
    }

    function __set($name, $value)
    {
        settype($name, 'string');
        switch ($name) {
        case 'score':
            $this->setVar('score', $value);
            break;
        case 'ip':
            $this->setVar('ip', $value);
            break;
        case 'Node':
            if (is_array($value)) {
                $entity =& $value[0];
            } else {
                $entity =& $value;
            }
            $this->assignNode($entity);
            break;
        default:
        }
    }

    function initVar($name, $value)
    {
        switch ($name) {
        case 'vote_id':
            $this->_vars['vote_id'] = $value;
            break;
        case 'vote_created':
            $this->_vars['vote_created'] = $value;
            break;
        case 'vote_updated':
            $this->_vars['vote_updated'] = $value;
            break;
        case 'vote_score':
            $this->_vars['vote_score'] = $value;
            break;
        case 'vote_ip':
            $this->_vars['vote_ip'] = $value;
            break;
        case 'vote_node_id':
            $this->_vars['vote_node_id'] = $value;
            break;
        case 'vote_userid':
            $this->_vars['vote_userid'] = $value;
            break;
        default:
        }
    }
}

class Xigg_Model_VoteRepositoryBase extends Sabai_Model_EntityRepository
{
    function Xigg_Model_VoteRepositoryBase(&$model)
    {
        parent::Sabai_Model_EntityRepository('Vote', $model);
    }
    function &fetchByUser($id, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $it =& $this->_fetchByForeign('vote_userid', $id, $limit, $offset, $sort, $order);
        return $it;
    }

    function &paginateByUser($id, $perpage = 10, $sort = null, $order = null)
    {
        $it =& $this->_paginateByEntity('User', $id, $perpage, $sort, $order);
        return $it;
    }

    function countByUser($id)
    {
        return $this->_countByForeign('vote_userid', $id);
    }

    function &fetchByUserAndCriteria($id, &$criteria, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $it =& $this->_fetchByForeignAndCriteria('vote_userid', $id, $criteria, $limit, $offset, $sort, $order);
        return $it;
    }

    function &paginateByUserAndCriteria($id, &$criteria, $perpage = 10, $sort = null, $order = null)
    {
        $it =& $this->_paginateByEntityAndCriteria('User', $id, $criteria, $perpage, $sort, $order);
        return $it;
    }

    function countByUserAndCriteria($id, &$criteria)
    {
        return $this->_countByForeignAndCriteria('vote_userid', $id, $criteria);
    }

    function &fetchByNode($id, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $it =& $this->_fetchByForeign('vote_node_id', $id, $limit, $offset, $sort, $order);
        return $it;
    }

    function &paginateByNode($id, $perpage = 10, $sort = null, $order = null)
    {
        $it =& $this->_paginateByEntity('Node', $id, $perpage, $sort, $order);
        return $it;
    }

    function countByNode($id)
    {
        return $this->_countByForeign('vote_node_id', $id);
    }

    function &fetchByNodeAndCriteria($id, &$criteria, $limit = 0, $offset = 0, $sort = null, $order = null)
    {
        $it =& $this->_fetchByForeignAndCriteria('vote_node_id', $id, $criteria, $limit, $offset, $sort, $order);
        return $it;
    }

    function &paginateByNodeAndCriteria($id, &$criteria, $perpage = 10, $sort = null, $order = null)
    {
        $it =& $this->_paginateByEntityAndCriteria('Node', $id, $criteria, $perpage, $sort, $order);
        return $it;
    }

    function countByNodeAndCriteria($id, &$criteria)
    {
        return $this->_countByForeignAndCriteria('vote_node_id', $id, $criteria);
    }

    function &_getCollectionByRowset(&$rs)
    {
        $collection =& new Xigg_Model_VotesByRowset($rs, $this->_model->create('Vote'), $this->_model);
        return $collection;
    }

    function &createCollection($entities = array(), $key = 0)
    {
        $collection =& new Xigg_Model_Votes($this->_model, $entities, $key);
        return $collection;
    }
}

class Xigg_Model_VotesByRowset extends Sabai_Model_EntityCollection_Rowset
{
    function Xigg_Model_VotesByRowset(&$rs, &$emptyEntity, &$model, $key = 0)
    {
        parent::Sabai_Model_EntityCollection_Rowset('Votes', $rs, $emptyEntity, $model, $key);
    }

    function _loadRow(&$entity, $row)
    {
        $entity->initVars($row);
    }
}

class Xigg_Model_Votes extends Sabai_Model_EntityCollection_Array
{
    function Xigg_Model_Votes(&$model, $entities = array(), $key = 0)
    {
        parent::Sabai_Model_EntityCollection_Array($model, 'Votes', $entities, $key);
    }
}