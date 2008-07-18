<?php
class Sabai_Event
{
    var $_type;
    var $_vars;

    function Sabai_Event($type, $vars = array())
    {
        $this->_type = $type;
        $this->_vars = $vars;
    }

    function getType()
    {
        return $this->_type;
    }

    function setVar($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    function setVarRef($key, &$value)
    {
        $this->_vars[$key] =& $value;
    }

    function setVars($vars)
    {
        $this->_vars = array_merge($this->_vars, $vars);
    }

    function getVars()
    {
        return $this->_vars;
    }
}