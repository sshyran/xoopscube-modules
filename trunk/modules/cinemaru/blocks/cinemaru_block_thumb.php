<?php

if (defined('__CINEMARU_BLOCK_THUMB_PHP__')) {
    return;
}
define('__CINEMARU_BLOCK_THUMB_PHP__', 1);

function b_cinemaru_block_thumb($options)
{
    global $xoopsTpl;
    global $xoopsConfig;
    
    if (count($options) < 5 || $options[0] == '') {
	$options = array('cinemaru', 'counter', 10, 'sort', 1);
    }
    
    $mydirname = $options[0];
    $GLOBALS['mydirname'] = $mydirname;
    
    require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/include/db.php');
    require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/include/misc.php');
    require_once(XOOPS_ROOT_PATH . '/modules/' . $mydirname . '/language/' . $xoopsConfig['language']. '/main.php');

    $movie_list = cinemaru_movie_get_list($options[2], 1, $options[4]);
    $movie_list = cinemaru_movie_truncate($movie_list);
    $xoopsTpl->assign('mydirname', $mydirname);
    $xoopsTpl->assign($mydirname . '_movie_list', $movie_list);
    $xoopsTpl->assign('movie_list', $movie_list);

    return array(1);
}

function b_cinemaru_block_thumb_edit($options)
{
    if (count($options) < 5 || $options[0] == '' || $options[0] == 'counter') {
	$options = array('cinemaru', 'counter', 10, 'sort', 1);
    }
    
    $form = '<input type="hidden" name="options[]" value="' . $options[0] . "\">\n";
    $form .= '<input type="hidden" name="options[]" value="' . $options[1] . "\">\n";
    $form .= "&nbsp;"._MB_CINEMARU_DISP."&nbsp;<input type='text' name='options[]' value='".$options[2]."' />\n";
    $form .= "&nbsp;"._MB_CINEMARU_ARTCLS."";
    $form .= "&nbsp;<br>";
    $form .= "&nbsp;"._MB_CINEMARU_SORT."&nbsp;\n";
    $form .= '<input type="hidden" name="options[]" value="' . $options[3] . '">' . "\n";
    $form .= "<select name='options[]'>\n"; 
    $form .= "<option value='1' " . (@$options[4]==1 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_1 . "\n";
    $form .= "<option value='2' " . (@$options[4]==2 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_2 . "\n";
    $form .= "<option value='3' " . (@$options[4]==3 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_3 . "\n";
    $form .= "<option value='4' " . (@$options[4]==4 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_4 . "\n";
    $form .= "<option value='5' " . (@$options[4]==5 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_5 . "\n";
    $form .= "<option value='6' " . (@$options[4]==6 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_6 . "\n";
    $form .= "<option value='7' " . (@$options[4]==7 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_7 . "\n";
    $form .= "<option value='8' " . (@$options[4]==8 ? 'SELECTED' : '') . ">" . _MB_CINEMARU_SORT_8 . "\n";
    $form .= "</select>\n";
    $form .= "&nbsp;<br>";
    
    return $form;
}
