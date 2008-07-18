<?php
class Sabai_Template_PHP_Helper_XiggTime extends Sabai_Template_PHP_Helper
{
    function ago($time)
    {
        return formatTimestamp($time, 'm');
    }
}