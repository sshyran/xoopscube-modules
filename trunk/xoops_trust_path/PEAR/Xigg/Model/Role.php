<?php
class Xigg_Model_Role extends Xigg_Model_RoleBase
{
    function Xigg_Model_Role(&$model)
    {
        parent::Xigg_Model_RoleBase($model);
    }

    function getPermissions()
    {
        if ($permissions = $this->get('permissions')) {
            return explode('|', $permissions);
        }
        return array();
    }

    function setPermissions($permsArr)
    {
        $this->set('permissions', implode('|', $permsArr));
    }
}

class Xigg_Model_RoleRepository extends Xigg_Model_RoleRepositoryBase
{
    function Xigg_Model_RoleRepository(&$model)
    {
        parent::Xigg_Model_RoleRepositoryBase($model);
    }
}