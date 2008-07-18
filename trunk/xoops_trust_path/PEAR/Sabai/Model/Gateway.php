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
class Sabai_Model_Gateway
{
    /**
     * @access protected
     * @var Sabai_DB
     */
    var $_db;

    function setDB(&$db)
    {
        $this->_db =& $db;
    }

    function getTableName()
    {
        return $this->_db->getResourcePrefix() . $this->getName();
    }

    /**
     * @return array All fields used within this gateway
     */
    function getAllFields()
    {
        return array_merge($this->getSortFields(), $this->getFields());
    }

    function &selectById($id, $fields = array())
    {
        $ret =& $this->_db->query($this->_getSelectByIdQuery($id, $fields));
        return $ret;
    }

    /**
     * Selects a row data by PK from the main table. For normal entities, this
     * is exactly the same as calling selectById(). Tree entities require this
     * query because selectById() will fail on after Insert trigger when the
     * tree table is not yet filled with data associated with the main table.
     *
     * @param string $id
     * @param array $fields
     * @return Sabai_DB_Rowset
     */
    function &selectByIdFromMainTable($id, $fields = array())
    {
        $ret =& $this->selectById($id, $fields);
        return $ret;
    }

    function &selectByCriteria(&$criteria, $fields = array(), $limit = 0, $offset = 0, $sort = null,
                               $order = null, $group = null)
    {
        $criteria_str = '';
        $criteria->acceptGateway($this, $criteria_str);
        $ret =& $this->selectBySQL($this->_getSelectByCriteriaQuery($criteria_str, $fields),
                                   $limit,
                                   $offset,
                                   $sort,
                                   $order,
                                   $group);
        return $ret;
    }

    function insert($values)
    {
        if ($this->_db->isTriggerEnabled()) {
            if (!$this->_db->exec($this->_getInsertQuery($values))) {
                return false;
            }
            return $this->_db->lastInsertId($this->getTableName(), $this->getName() . '_id');
        } else {
            return $this->_insertWithTrigger($values);
        }
    }

    function _insertWithTrigger($values)
    {
        if (!$this->_beforeInsertTrigger($values) || !$this->_db->exec($this->_getInsertQuery($values))) {
            return false;
        }
        $id = $this->_db->lastInsertId($this->getTableName(), $this->getName() . '_id');
        if (!$rs =& $this->selectByIdFromMainTable($id)) {
            // this should not happen here,
            return false;
        }
        $this->_afterInsertTrigger($id, $rs->fetchAssoc());
        return $id;
    }

    function _beforeInsertTrigger($new)
    {
        return true;
    }

    function _afterInsertTrigger($id, $new){}

    function update($id, $values)
    {
        if ($this->_db->isTriggerEnabled()) {
            return $this->_db->exec($this->_getUpdateQuery($id, $values));
        } else {
            return $this->_updateWithTrigger($id, $values);
        }
    }

    function _updateWithTrigger($id, $values)
    {
        if (!$rs =& $this->selectById($id)) {
            return false;
        }
        $old = $rs->fetchAssoc();
        if (!$this->_beforeUpdateTrigger($id, $values, $old)
            || !$this->_db->exec($this->_getUpdateQuery($id, $values))) {
            return false;
        }
        $this->_afterUpdateTrigger($id, $values, $old);
        return true;
    }

    function _beforeUpdateTrigger($id, $new, $old)
    {
        return true;
    }

    function _afterUpdateTrigger($id, $new, $old){}

    function delete($id)
    {
        if ($this->_db->isTriggerEnabled()) {
            return $this->_db->exec($this->_getDeleteQuery($id));
        } else {
            return $this->_deleteWithTrigger($id);
        }
    }

    function _deleteWithTrigger($id)
    {
        if (!$rs =& $this->selectById($id)) {
            return false;
        }
        $old = $rs->fetchAssoc();
        if (!$this->_beforeDeleteTrigger($id, $old)
            || !$this->_db->exec($this->_getDeleteQuery($id))) {
            return false;
        }
        $this->_afterDeleteTrigger($id, $old);
        return true;
    }

    function _beforeDeleteTrigger($id, $old)
    {
        return true;
    }

    function _afterDeleteTrigger($id, $old){}

    /**
     * Enter description here...
     *
     * @param Sabai_Model_Criteria $criteria
     * @param array $values
     * @return mixed number of affected rows on success, false on failure
     */
    function updateByCriteria(&$criteria, $values)
    {
        $sets = array();
        $fields = $this->getFields();
        foreach (array_keys($values) as $k) {
            if (isset($fields[$k])) {
                $operator = '=';
                $this->_sanitizeForQuery($values[$k], $fields[$k], $operator);
                $sets[$k] = $k . $operator . $values[$k];
            }
        }
        $criteria_str = '';
        $criteria->acceptGateway($this, $criteria_str);
        if (!$this->_db->exec($this->_getUpdateByCriteriaQuery($criteria_str, $sets))) {
            return false;
        }
        return $this->_db->affectedRows();
    }

    function deleteByCriteria(&$criteria)
    {
        $criteria_str = '';
        $criteria->acceptGateway($this, $criteria_str);
        if (!$this->_db->exec($this->_getDeleteByCriteriaQuery($criteria_str))) {
            return false;
        }
        return $this->_db->affectedRows();
    }

    function countByCriteria(&$criteria, $group = null)
    {
        $criteria_str = '';
        $criteria->acceptGateway($this, $criteria_str);
        $sql = $this->_getCountByCriteriaQuery($criteria_str);
        if (!empty($group)) {
            $fields = $this->getAllFields();
            if (isset($fields[$group])) {
                $sql .= ' GROUP BY ' . $group;
            }
        }
        if ($rs =& $this->_db->query($sql)) {
            return $rs->fetchSingle();
        }
        return 0;
    }

    function &selectBySQL($sql, $limit = 0, $offset = 0, $sort = null, $order = null, $group = null)
    {
        if (!empty($group)) {
            $fields = $this->getFields();
            if (isset($fields[$group])) {
                $sql .= ' GROUP BY ' . $group;
            }
        }
        if (!empty($sort)) {
            $sort_fields = $this->getSortFields();
            settype($sort, 'array');
            settype($order, 'array');
            foreach (array_keys($sort) as $i) {
                if (isset($sort_fields[$sort[$i]])) {
                    $order[$i] = (isset($order[$i]) && $order[$i] == 'DESC') ? 'DESC': 'ASC';
                    $order_by[] = "{$sort[$i]} $order[$i]";
                }
            }
            if (isset($order_by)) {
                $sql .= ' ORDER BY ' . implode(',', $order_by);
            }
        }
        $rs =& $this->_db->query($sql, $limit, $offset);
        return $rs;
    }

    function visitCriteriaEmpty(&$criteria, &$criteriaStr, $validateField)
    {
        $criteriaStr .= '1=1';
    }

    function visitCriteriaComposite(&$criteria, &$criteriaStr, $validateField)
    {
        $elements = $criteria->getElements();
        $count = count($elements);
        $conditions = $criteria->getConditions();
        $criteriaStr .= '(';
        $elements[0]->acceptGateway($this, $criteriaStr, $validateField);
        for ($i = 1; $i < $count; $i++) {
            $criteriaStr .= ' ' . $conditions[$i] . ' ';
            $elements[$i]->acceptGateway($this, $criteriaStr, $validateField);
        }
        $criteriaStr .= ')';
    }

    function visitCriteriaCompositeNot(&$criteria, &$criteriaStr, $validateField)
    {
        $criteriaStr .= 'NOT ' . $this->visitCriteriaComposite($criteria, $criteriaStr, $validateField);
    }

    function _visitCriteria(&$criteria, &$criteriaStr, $operator, $validateField)
    {
        $key = $criteria->getKey();
        $data_type = null;
        if ($validateField) {
            $fields = $this->getAllFields();
            if (!isset($fields[$key])) {
                return;
            }
            $data_type = $fields[$key];
        }
        $value = $criteria->getValue();
        $this->_sanitizeForQuery($value, $data_type, $operator);
        $criteriaStr .= "$key $operator $value";
    }

    function visitCriteriaIs(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteria($criteria, $criteriaStr, '=', $validateField);
    }

    function visitCriteriaIsNot(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteria($criteria, $criteriaStr, '!=', $validateField);
    }

    function visitCriteriaIsSmallerThan(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteria($criteria, $criteriaStr, '<', $validateField);
    }

    function visitCriteriaIsGreaterThan(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteria($criteria, $criteriaStr, '>', $validateField);
    }

    function visitCriteriaIsOrSmallerThan(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteria($criteria, $criteriaStr, '<=', $validateField);
    }

    function visitCriteriaIsOrGreaterThan(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteria($criteria, $criteriaStr, '>=', $validateField);
    }

    function _visitCriteriaArray(&$criteria, &$criteriaStr, $format, $validateField)
    {
        $key = $criteria->getKey();
        $data_type = null;
        if ($validateField) {
            $fields = $this->getAllFields();
            if (!isset($fields[$key])) {
                return;
            }
            $data_type = $fields[$key];
        }
        $values = $criteria->getValueArray();
        if (!empty($values)) {
            $operator = null;
            foreach ($values as $v) {
                $this->_sanitizeForQuery($v, $data_type, $operator);
                $value[] = $v;
            }
            $criteriaStr .= sprintf($format, $key, implode(',', $value));
        }
    }

    function visitCriteriaIn(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteriaArray($criteria, $criteriaStr, '%s IN (%s)', $validateField);
    }

    function visitCriteriaNotIn(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteriaArray($criteria, $criteriaStr, '%s NOT IN (%s)', $validateField);
    }

    function _visitCriteriaStr(&$criteria, &$criteriaStr, $format, $validateField)
    {
        $key = $criteria->getKey();
        $data_type = null;
        if ($validateField) {
            $fields = $this->getAllFields();
            if (!isset($fields[$key])) {
                return;
            }
            $data_type = $fields[$key];
        }
        $value = sprintf($format, $criteria->getValueStr());
        $operator = 'LIKE';
        $this->_sanitizeForQuery($value, $data_type, $operator);
        $criteriaStr .= "$key LIKE $value";
    }

    function visitCriteriaStartsWith(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteriaStr($criteria, $criteriaStr, '%%%s', $validateField);
    }

    function visitCriteriaEndsWith(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteriaStr($criteria, $criteriaStr, '%s%%', $validateField);
    }

    function visitCriteriaContains(&$criteria, &$criteriaStr, $validateField)
    {
        $this->_visitCriteriaStr($criteria, $criteriaStr, '%%%s%%', $validateField);
    }

    /**
     * @param mixed $value
     * @param int $dataType
     * @param string $operator
     */
    function _sanitizeForQuery(&$value, $dataType = null, &$operator)
    {
        switch($dataType) {
            case SABAI_MODEL_KEY_TYPE_INT_NULL:
                if (is_numeric($value)) {
                    $value = intval($value);
                } else {
                    $value = 'NULL';
                    $operator = ($operator == '!=') ? 'IS NOT' : 'IS';
                }
                break;
            case SABAI_MODEL_KEY_TYPE_INT:
                $value = intval($value);
                break;
            case SABAI_MODEL_KEY_TYPE_FLOAT:
                $value = floatval($value);
                break;
            case SABAI_MODEL_KEY_TYPE_BOOL:
                $value = $this->_db->escapeBool($value);
                break;
            case SABAI_MODEL_KEY_TYPE_BLOB:
                $value = $this->_db->escapeBlob($value);
                break;
            default:
                $value = $this->_db->escapeString($value);
        }
    }

    /**
     * Gets the fields that can be used for sorting.
     * This method will only be overwritten by assoc entities.
     *
     * @return array
     */
    function getSortFields()
    {
        return $this->getFields();
    }

    /**
     * @abstract
     * @access protected
     */
    function getName(){}
    function getFields(){}
    function _getSelectByIdQuery($id, $fields){}
    function _getSelectByCriteriaQuery($criteriaStr, $fields){}
    function _getInsertQuery($values){}
    function _getUpdateQuery($id, $values){}
    function _getDeleteQuery($id){}
    function _getUpdateByCriteriaQuery($criteriaStr, $sets){}
    function _getDeleteByCriteriaQuery($criteriaStr){}
    function _getCountByCriteriaQuery($criteriaStr){}
}