<?php

/*
 * $Id: modifier.format_timestamp.php 290 2008-02-25 03:07:10Z hodaka $
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     xoops formatTimestamp
 * Purpose:  make time format corresponding to his time offset.
 * -------------------------------------------------------------
 */
function smarty_modifier_format_timestamp($time, $format='l', $timeoffset = '')
{
    if (!$time)
        return '';
    
    return formatTimestamp(intval($time), $format, $timeoffset);


}
?>