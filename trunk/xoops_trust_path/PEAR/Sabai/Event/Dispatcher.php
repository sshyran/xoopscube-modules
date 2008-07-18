<?php
require_once 'Sabai/Event.php';

class Sabai_Event_Dispatcher
{
    var $_events = array();
    var $_eventListenerHandles = array();
    var $_dispatchedEvents = array();
    var $_defaultEventVars = array();

    function setDefaultEventVars($vars)
    {
        $this->_defaultEventVars = $vars;
    }

    function addEventListener($eventType, &$listenerHandle, $listenerName)
    {
        $listenerName = strtolower($listenerName);
        foreach ((array)$eventType as $event_type) {
            $this->_events[strtolower($event_type)][] = $listenerName;
            $this->_eventListenerHandles[$listenerName] =& $listenerHandle;
        }
    }

    function dispatch($eventType, $eventArgs = array(), $listenerName = null)
    {
        if (isset($listenerName)) {
            $this->dispatchListenerEvent($listenerName, new Sabai_Event($eventType, $eventArgs));
        } else {
            $this->dispatchEvent(new Sabai_Event($eventType, $eventArgs));
        }
    }

    function dispatchEvent(&$event)
    {
        $type = strtolower($event->getType());
        if (!isset($this->_dispatchedEvents[$type])) {
            $this->_dispatchedEvents[$type] = true;
            if ($listeners = @$this->_events[$type]) {
                $method = 'on' . $type;
                foreach ($listeners as $listener_name) {
                    if (!$this->_doDispatchEvent($this->_instantiateListener($listener_name), $event, $method)) {
                        break;
                    }
                }
            }
        }
    }

    function dispatchListenerEvent($listenerName, &$event)
    {
        $type = strtolower($event->getType());
        $listenerName = strtolower($listenerName);
        if (!isset($this->_dispatchedEvents[$type][$listenerName])) {
            $this->_dispatchedEvents[$type][$listenerName] = true;
            if (!empty($this->_events[$type]) && in_array($listenerName, $this->_events[$type])) {
                $method = 'on' . $type;
                $listener =& $this->_instantiateListener($listenerName);
                $this->_doDispatchEvent($listener, $event, $method);
            }
        }
    }

    function &_instantiateListener($listenerName)
    {
        $listener =& $this->_eventListenerHandles[$listenerName]->instantiate();
        return $listener;
    }

    function _doDispatchEvent(&$listener, &$event, $method)
    {
        if (false === call_user_func_array(array(&$listener, $method), array_merge($event->getVars(), $this->_defaultEventVars))) {
            return false;
        }
        return true;
    }

    function clearEventListeners()
    {
        $this->_events = array();
        $this->_eventListenerHandles = array();
    }
}