<?php
/*
This file has been generated by the Sabai scaffold script. Do not edit this file directly.
If you need to customize the class, use the following file:
Xigg/library/Xigg/Model/MemberCriteria.php
*/
require_once 'Sabai/Model/EntityCriteria.php';

class Xigg_Model_MemberCriteriaBase extends Sabai_Model_EntityCriteria
{

    function &idIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_id', $value));
    }

    function &idIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_id', $value, '>'));
    }

    function &idIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_id', $value, '<'));
    }

    function &idIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_id', $value, '>='));
    }

    function &idIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_id', $value, '<='));
    }

    function &idIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('member_id', $values));
    }

    function &idNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('member_id', $values));
    }

    function &createdIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_created', $value));
    }

    function &createdIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_created', $value, '>'));
    }

    function &createdIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_created', $value, '<'));
    }

    function &createdIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_created', $value, '>='));
    }

    function &createdIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_created', $value, '<='));
    }

    function &createdIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('member_created', $values));
    }

    function &createdNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('member_created', $values));
    }

    function &updatedIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_updated', $value));
    }

    function &updatedIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_updated', $value, '>'));
    }

    function &updatedIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_updated', $value, '<'));
    }

    function &updatedIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_updated', $value, '>='));
    }

    function &updatedIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_updated', $value, '<='));
    }

    function &updatedIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('member_updated', $values));
    }

    function &updatedNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('member_updated', $values));
    }

    function &role_idIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_role_id', $value));
    }

    function &role_idIsGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_role_id', $value, '>'));
    }

    function &role_idIsSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_role_id', $value, '<'));
    }

    function &role_idIsOrGreaterThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_role_id', $value, '>='));
    }

    function &role_idIsOrSmallerThan($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_role_id', $value, '<='));
    }

    function &role_idIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('member_role_id', $values));
    }

    function &role_idNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('member_role_id', $values));
    }

    function &useridIs($value)
    {
        return $this->add(Sabai_Model_Criteria::createValue('member_userid', $value));
    }

    function &useridStartsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('member_userid', $str, '^'));
    }

    function &useridEndsWith($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('member_userid', $str, '$'));
    }

    function &useridContains($str)
    {
        return $this->add(Sabai_Model_Criteria::createString('member_userid', $str));
    }

    function &useridIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createIn('member_userid', $values));
    }

    function &useridNotIn($values)
    {
        return $this->add(Sabai_Model_Criteria::createNotIn('member_userid', $values));
    }
}