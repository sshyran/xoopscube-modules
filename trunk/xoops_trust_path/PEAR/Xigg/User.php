<?php
require_once 'Sabai/User/Decorator.php';

class Xigg_User extends Sabai_User_Decorator
{
    var $_initialized = false;

    function Xigg_User(&$user)
    {
        parent::Sabai_User_Decorator($user);
        $this->setAttribute('permissions', array());
        $this->setAttribute('admin', false);
    }

    function setIdentity(&$identity)
    {
        parent::setIdentity($identity);
        // Set as not initialized when identity changes(after login etc.)
        $this->_initialized = false;
    }

    function isInitialized()
    {
        return $this->_initialized;
    }

    function setInitialized($flag = true)
    {
        $this->_initialized = $flag;
    }

    function setPermissions($perms)
    {
        $this->setAttribute('permissions', $perms);
    }

    function hasPermission($name)
    {
        if ($this->isAdmin()) {
            return true;
        }
        $permissions = $this->getPermissions();
        foreach ((array)$name as $_name) {
            if (in_array($_name, $permissions)) {
                return true;
            }
        }
        return false;
    }

    function getPermissions()
    {
        return $this->getAttribute('permissions');
    }

    function isAdmin()
    {
        return $this->getAttribute('admin');
    }

    function setAdmin($flag)
    {
        $this->setAttribute('admin', $flag);
    }
}