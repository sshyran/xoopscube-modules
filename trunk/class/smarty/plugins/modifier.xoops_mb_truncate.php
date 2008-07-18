<?php

/*
 * $Id: modifier.xoops_mb_truncate.php 290 2008-02-25 03:07:10Z hodaka $
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     mbtruncate
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string.
 * -------------------------------------------------------------
 */
function smarty_modifier_xoops_mb_truncate($string, $length = 80, $etc = '...')
{
    if ($length <= 0)
        return '';

    if(!empty($string) && strlen($string) > $length) {
        return xoops_substr($string, 0, $length, $etc = '...');
    }
    else
        return $string;

}
?>
