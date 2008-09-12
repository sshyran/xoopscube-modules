<?php

// validate class

define('CINEMARU_TYPE_TEXT', '1');
define('CINEMARU_TYPE_MAIL', '2');
define('CINEMARU_TYPE_PASSWORD', '3');
define('CINEMARU_TYPE_NUMERIC', '4');
define('CINEMARU_TYPE_FILE_FLV_MP3', '5');
define('CINEMARU_TYPE_FILE_IMAGE', '6');
define('CINEMARU_TYPE_URL', '7');

define('CINEMARU_REG_MAIL', '/^[0-9A-Za-z\-_\.]{1,40}\@[0-9A-Za-z\.]{3,40}$/');
define('CINEMARU_REG_URL', '/^http:\/\/.+$/');

function cinemaru_validator($config)
{
    $error = array();

    foreach ($config as $key => $val) {
	$str = @$_REQUEST[$key];
	if (@$val['type'] == CINEMARU_TYPE_FILE_FLV_MP3 || @$val['type'] == CINEMARU_TYPE_FILE_IMAGE) {
	    if (@$val['not_null'] && @$_FILES[$key]['name'] == "") {
		$error[] = sprintf(_MD_CINEMARU_ERROR_NO_FILE, $val['name']);
	    } else if (@$val['not_null'] && @$val['type'] == CINEMARU_TYPE_FILE_FLV_MP3 && preg_match('/\.(flv|mp3)$/i', $_FILES[$key]['name']) == false) {
		$error[] = sprintf(_MD_CINEMARU_ERROR_NO_FLV_FILE, $val['name']);
	    } else if (@$val['not_null'] && @$val['type'] == CINEMARU_TYPE_FILE_IMAGE && preg_match('/\.(jpg|jpeg|gif|png)$/i', $_FILES[$key]['name']) == false) {
		$error[] = sprintf(_MD_CINEMARU_ERROR_NO_IMAGE_FILE, $val['name']);
	    } else {
		if (@$val['not_null'] && $_FILES[$key]['error'] == UPLOAD_ERR_INI_SIZE) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_UPLOAD_ERR_INI_SIZE, $val['name']);
		} else if (@$val['not_null'] && $_FILES[$key]['error'] == UPLOAD_ERR_FORM_SIZE) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_UPLOAD_ERR_FORM_SIZE, $val['name']);
		} else if (@$val['not_null'] && $_FILES[$key]['error'] == UPLOAD_ERR_PARTIAL) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_UPLOAD_ERR_PARTIAL, $val['name']);
		} else if (@$val['not_null'] && $_FILES[$key]['error'] == UPLOAD_ERR_NO_FILE) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_UPLOAD_ERR_NO_FILE, $val['name']);
		} else if (defined('UPLOAD_ERR_NO_TMP_DIR') && @$val['not_null'] && @$_FILES[$key]['error'] == UPLOAD_ERR_NO_TMP_DIR) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_UPLOAD_ERR_NO_TMP_DIR, $val['name']);
		} else if (defined('UPLOAD_ERR_CANT_WRITE') && @$val['not_null'] && @$_FILES[$key]['error'] == UPLOAD_ERR_CANT_WRITE) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_UPLOAD_ERR_CANT_WRITE, $val['name']);
		} else if (defined('UPLOAD_ERR_EXTENSION') && @$val['not_null'] && $_FILES[$key]['error'] == UPLOAD_ERR_EXTENSION) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_UPLOAD_ERR_EXTENSION, $val['name']);
		}
	    }
	} else {
	
	    if (@$val['not_null'] && $str == '') {
		$error[] = sprintf(_MD_CINEMARU_ERROR_NO_DATA, $val['name']);
		continue;
	    }
	
	    if (@$val['max'] && @$val['max'] < strlen($str)) {
		$error[] = sprintf(_MD_CINEMARU_ERROR_SIZE_OVER, $val['name'], $val['max']);
	    }
	
	    if (@$val['min'] &&  strlen($str) < @$val['min']) {
		$error[] = sprintf(_MD_CINEMARU_ERROR_SIZE_UNDER, $val['name'], $val['min']);
	    }
	
	    if (@$val['type'] == CINEMARU_TYPE_MAIL) {
		if (preg_match(CINEMARU_REG_MAIL, $str) == false) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_MAIL_NG_FORMAT, $val['name']);
		}
	    }
	
	    if (@$val['type'] == CINEMARU_TYPE_URL) {
		if (preg_match(CINEMARU_REG_URL, $str) == false) {
		    $error[] = sprintf(_MD_CINEMARU_ERROR_URL_NG_FORMAT, $val['name']);
		}
	    }
	
	    if (@$val['confirm'] && $str != $_REQUEST[$val['confirm']]) {
		$error[] = sprintf(_MD_CINEMARU_ERROR_CONFIRM_NO_MATCH, $val['name']);
	    }
	}
    }
    
    return $error;
}
