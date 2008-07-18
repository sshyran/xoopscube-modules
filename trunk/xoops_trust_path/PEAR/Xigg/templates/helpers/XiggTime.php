<?php
class Sabai_Template_PHP_Helper_XiggTime extends Sabai_Template_PHP_Helper
{
    function ago($time)
    {
        $diff = time() - $time;
        if ($diff >= 172800) {
            return sprintf(_('%d days ago'), $diff / 86400);
        }
        if ($diff >= 86400) {
            return $this->_dayAgo($diff % 86400);
        }
        if ($diff >= 7200) {
            return $this->_hoursAgo($diff / 3600, $diff % 3600);
        }
        if ($diff >= 3600) {
            return $this->_hourAgo($diff % 3600);
        }
        if ($diff >= 120) {
            return $this->_minutesAgo($diff / 60, $diff % 60);
        }
        if ($diff >= 60) {
            return $this->_minuteAgo($diff % 60);
        }
        return sprintf(ngettext('%d second ago', '%d seconds ago', $diff), $diff);
    }

    function _dayAgo($time)
    {
        if ($time < 3600) {
            return _('1 day ago');
        }
        $time = intval($time / 3600);
        return sprintf(ngettext('1 day %d hour ago', '1 day %d hours ago', $time), $time);
    }

    function _hoursAgo($hours, $time)
    {
        if (!$time = intval($time / 60)) {
            return sprintf(_('%d hours ago'), $hours);
        }
        if ($time > 1) {
            return sprintf(_('%d hours %d minutes ago'), $hours, $time);
        }
        return sprintf(_('%d hours 1 minute ago'), $hours);
    }

    function _hourAgo($time)
    {
        if ($time < 60) {
            return _('1 hour ago');
        }
        $time = intval($time / 60);
        return sprintf(ngettext('1 hour %d minute ago', '1 hour %d minutes ago', $time), $time);
    }

    function _minuteAgo($time)
    {
        if ($time < 1) {
            return _('1 minute ago');
        }
        return sprintf(ngettext('1 minute %d second ago', '1 minute %d seconds ago', $time), $time);
    }

    function _minutesAgo($minutes, $time)
    {
        if ($time < 1) {
            return sprintf(_('%d minutes ago'), $minutes);
        }
        if ($time > 1) {
            return sprintf(_('%d minutes %d seconds ago'), $minutes, $time);
        }
        return sprintf(_('%d minutes 1 second ago'), $minutes);
    }
}