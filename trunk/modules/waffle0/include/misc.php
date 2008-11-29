<?php

if (defined('__WAFFLE_MISC_PHP__')) {
    return;
}

define('__WAFFLE_MISC_PHP__', '1');

function waffle_truncate($str, $size)
{
    if (strlen($str) <= $size) {
	return $str;
    }
    
    return substr($str, 0, $size);
}

function waffle_validate_time($hour, $min, $sec) {
        if ($hour < 0 || 23 < $hour) {
	            return false;
	}
    
        if ($min < 0 || 59 < $min) {
	            return false;
	}
    
        if ($sec < 0 || 59 < $sec) {
	            return false;
	}
    
        return true;
}

function waffle_validate_date($year, $month, $day) {
        $mday = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    
        if (waffle_is_leap($year)) {
	    $mday[1] = 29;
	}
    
        if ($month < 1 || 12 < $month || $day < 1) {
	            return false;
	}
    
        if ($mday[$month - 1] < $day) {
	            return false;
	}
    
        return true;
}

function waffle_is_leap($year) {
        if ( (($year % 4) == 0 && ($year % 100) != 0) || ($year % 400) == 0) {
	            return true;
	} else {
	            return false;
	}
}

function waffle_format_file_size($size)
{
    if ($size == 0) {
	return '0KB';
    }
    
    if ($size < (1024 * 1024)) {
	return sprintf('%3.1fKB', $size / 1024);
    }

    return sprintf('%4.1fMB', $size / 1024 / 1024);
}

function waffle_send_admin_mail($subject, $message)
{
    global $xoopsConfig;
    
    $xoopsMailer =& getMailer();
    $xoopsMailer->useMail();
    $xoopsMailer->setToEmails($xoopsConfig['adminmail']);
    $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
    $xoopsMailer->setFromName($xoopsConfig['sitename']);
    $xoopsMailer->setSubject($subject);
    $xoopsMailer->setBody($message);
    $xoopsMailer->send();
}

?>
