<?php

/*
 * $Id: modifier.format_timestamp.php,v 1.1.2.1 2008/09/21 21:10:35 xoopserver Exp $
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