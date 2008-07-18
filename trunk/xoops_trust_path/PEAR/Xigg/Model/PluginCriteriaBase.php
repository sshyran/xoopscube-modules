<?php
/*
This file has been generated by the Sabai scaffold script. Do not edit this file directly.
If you need to customize the class, use the following file:
Xigg/library/Xigg/Model/PluginCriteria.php
*/
require_once 'Sabai/Model/EntityCriteria.php';

class Xigg_Model_PluginCriteriaBase extends Sabai_Model_EntityCriteria
{

    function &idIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_id', $value));
    }

    function &idIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_id', $value, '>'));
    }

    function &idIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_id', $value, '<'));
    }

    function &idIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_id', $value, '>='));
    }

    function &idIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_id', $value, '<='));
    }

    function &idIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_id', $values));
    }

    function &idNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_id', $values));
    }

    function &createdIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_created', $value));
    }

    function &createdIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_created', $value, '>'));
    }

    function &createdIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_created', $value, '<'));
    }

    function &createdIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_created', $value, '>='));
    }

    function &createdIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_created', $value, '<='));
    }

    function &createdIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_created', $values));
    }

    function &createdNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_created', $values));
    }

    function &updatedIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_updated', $value));
    }

    function &updatedIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_updated', $value, '>'));
    }

    function &updatedIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_updated', $value, '<'));
    }

    function &updatedIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_updated', $value, '>='));
    }

    function &updatedIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_updated', $value, '<='));
    }

    function &updatedIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_updated', $values));
    }

    function &updatedNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_updated', $values));
    }

    function &nameIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_name', $value));
    }

    function &nameStartsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_name', $str, '^'));
    }

    function &nameEndsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_name', $str, '$'));
    }

    function &nameContains($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_name', $str));
    }

    function &nameIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_name', $values));
    }

    function &nameNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_name', $values));
    }

    function &versionIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_version', $value));
    }

    function &versionStartsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_version', $str, '^'));
    }

    function &versionEndsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_version', $str, '$'));
    }

    function &versionContains($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_version', $str));
    }

    function &versionIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_version', $values));
    }

    function &versionNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_version', $values));
    }

    function &activeIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_active', $value));
    }

    function &activeIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_active', $value, '>'));
    }

    function &activeIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_active', $value, '<'));
    }

    function &activeIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_active', $value, '>='));
    }

    function &activeIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_active', $value, '<='));
    }

    function &activeIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_active', $values));
    }

    function &activeNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_active', $values));
    }

    function &paramsStartsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_params', $str, '^'));
    }

    function &paramsEndsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_params', $str, '$'));
    }

    function &paramsContains($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('plugin_params', $str));
    }

    function &priorityIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_priority', $value));
    }

    function &priorityIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_priority', $value, '>'));
    }

    function &priorityIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_priority', $value, '<'));
    }

    function &priorityIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_priority', $value, '>='));
    }

    function &priorityIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_priority', $value, '<='));
    }

    function &priorityIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_priority', $values));
    }

    function &priorityNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_priority', $values));
    }

    function &lockedIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_locked', $value));
    }

    function &lockedIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_locked', $value, '>'));
    }

    function &lockedIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_locked', $value, '<'));
    }

    function &lockedIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_locked', $value, '>='));
    }

    function &lockedIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('plugin_locked', $value, '<='));
    }

    function &lockedIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('plugin_locked', $values));
    }

    function &lockedNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('plugin_locked', $values));
    }
}