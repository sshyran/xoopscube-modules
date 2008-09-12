<?php

include 'header.php';
require_once('include/db.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$mydirname = basename( dirname( __FILE__ ) ) ;
$xoopsTpl->assign('mydirname', $mydirname);
$constpref = strtoupper( $mydirname ) ;

$xoopsTpl->assign('cinemaru_module_config', $xoopsModuleConfig);
$xoopsTpl->assign('max_file_size', intval($xoopsModuleConfig['cinemaru_movie_max_size'] / 1024 / 1024));

$xoopsOption['template_main'] = $mydirname . '_movie_form.html';

require_once('include/validator.php');

$config =  array(
    'title' => array(
	'name' => _MD_CINEMARU_TITLE,
        'type' => CINEMARU_TYPE_TEXT,
        'not_null' => 1,
	'min' => 0,
	'max' => 100,
	'regexp' => null,
    ),
    'desc' => array(
	'name' => _MD_CINEMARU_DESC,
        'type' => CINEMARU_TYPE_TEXT,
        'not_null' => 0,
	'min' => 0,
	'max' => 1000,
	'regexp' => null,
    ),
    'genre' => array(
	'name' => _MD_CINEMARU_DESC,
        'type' => CINEMARU_TYPE_NUMERIC,
        'not_null' => 0,
	'min' => 0,
	'max' => 200,
	'regexp' => null,
    ),
);

if (@$_FILES['file']['tmp_name'] != '') {
    $config['file'] = array(
	'name' => _MD_CINEMARU_MOVIE_FILE,
        'type' => CINEMARU_TYPE_FILE_FLV_MP3,
        'not_null' => 0,
	'min' => 0,
	'max' => 0,
	'regexp' => null,
    );
    $file_type = constant($constpref.'_FORM_FILE_TYPE_FLV_MP3');
} else if (@$_POST['file_url'] != '') {
    $config['file_url'] = array(
	'name' => _MD_CINEMARU_FILE_URL,
        'type' => CINEMARU_TYPE_URL,
        'not_null' => 0,
	'min' => 0,
	'max' => 100,
	'regexp' => null,
    );
    if (preg_match('/^http:\/\/[a-z]+\.youtube\.com\//i', @$_POST['file_url'])) {
	$file_type = constant($constpref.'_FORM_FILE_TYPE_YOUTUBE_URL');
    } else {
	$file_type = constant($constpref.'_FORM_FILE_TYPE_FILE_URL');
    }
} else {
    $file_type = 0;
}

if (isset($_FILES['image_file'])) {
    $config['image_file'] = array(
	'name' => _MD_CINEMARU_THUMB_FILE,
        'type' => CINEMARU_TYPE_FILE_FLV_MP3,
        'not_null' => 0,
	'min' => 0,
	'max' => 0,
	'regexp' => null,
    );
    $image_file_type = constant($constpref.'_FORM_FILE_TYPE_IMAGE');
} else {
    $config['image_file_url'] = array(
	'name' => _MD_CINEMARU_THUMB_FILE,
        'type' => CINEMARU_TYPE_URL,
        'not_null' => 0,
	'min' => 0,
	'max' => 100,
	'regexp' => null,
    );
    $image_file_type = constant($constpref.'_FORM_FILE_TYPE_IMAGE_URL');
}

$movie = cinemaru_movie_get_one($_REQUEST['id']);

if (isset($movie['id']) == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NOT_FOUND);
    exit();
}

if ($movie['valid'] == 0 && cinemaru_is_auth_perm() == false) {
    redirect_header('index.php', 2, _MD_CINEMARU_MOVIE_NO_VALID);
    exit();
}

if (isset($xoopsUser)) {
    $uid = $xoopsUser->uid();
} else {
    $uid = 0;
}

$groupperm_touchothers = cinemaru_checkright(constant($constpref.'_GROUPPERM_TOUCHOTHERS'));

if ($groupperm_touchothers == 0 && $movie['owner'] != $uid) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_EDIT_AUTH);
    exit();
}

$error = cinemaru_validator($config);

if (0 < count($error)) {
    // エラーあり
    
    // richtext check
    if ($xoopsModuleConfig['richtext']) {
	require_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	$f = new XoopsFormDhtmlTextArea("", 'desc', @$movie['desc'], 15, 50);
	$xoopsTpl->assign('rich_form', $f->render());
    }
    
    $xoopsTpl->assign('edit', 1);
    $xoopsTpl->assign('error', $error);
} else {
    // エラーなし
    
    if ($file_type == constant($constpref.'_FORM_FILE_TYPE_FLV_MP3')) {
	preg_match('/\.(flv|mp3)$/i', $_FILES['file']['name'], $r);
	$movie_ext = @$r[1];
    }
    if ($image_file_type == constant($constpref.'_FORM_FILE_TYPE_IMAGE')) {
	preg_match('/\.(jpg|jpeg|png|gif)$/i', $_FILES['image_file']['name'], $r);
	$image_ext = @$r[1];
    }
    
    $randam_code = $movie['randam_code'];
    $id = $movie['id'];
    
    $d = XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/';
    $f = $id . '_' . $randam_code;

    $old_movie = '';
    $new_movie = '';
    $movie_f = '';
    if (@$_FILES['file']['tmp_name'] != '') {
	$old_movie = $d . 'movie/' . $movie['file'];
	$new_movie = $d . 'movie/' . $f . '.' . $movie_ext;
	
	if (file_exists($old_movie)) {
	    @unlink($old_movie);
	}
	move_uploaded_file($_FILES['file']['tmp_name'], $new_movie);
	$movie_f = $f . '.' . $movie_ext;;
    }

    $image = '';
    if (@$_FILES['image_file']['tmp_name'] != '') {
	$old_image = $d . 'image/' . $movie['image_file'];
	$new_image = $d . 'image/' . $f . '.' . $image_ext;
	
	if (file_exists($old_image)) {
	    @unlink($old_image);
	}
	move_uploaded_file($_FILES['image_file']['tmp_name'], $new_image);
	$image = $f . '.' . $image_ext;;
    }

    if ($uid != $movie['owner']) {
	$groupperm_superedit = cinemaru_checkright(constant($constpref.'_GROUPPERM_SUPEREDIT'));
	if ($groupperm_superedit) {
	    $valid = 1;
	} else {
	    $valid = 0;
	}
    } else {
	$valid = 1;
    }
    
    $tags['POST_NAME'] = $_REQUEST['title'];
    $tags['POST_URL'] = XOOPS_URL . '/modules/' . $mydirname . '/movie.php?id=' . intval($_REQUEST['id']);
    
    $notification_handler =& xoops_gethandler('notification');
    $notification_handler->triggerEvent('global', 0, 'update', $tags);
    
    cinemaru_movie_title_desc_update(@$_REQUEST['id'], @$_REQUEST['title'], @$_REQUEST['desc'], @$_REQUEST['tag_lock'], @$movie_f, @$image, $valid, @$_POST['file_url'], @$_POST['image_file_url'], $file_type);

    redirect_header('movie.php?id=' . @$_REQUEST['id'], 2, _MD_CINEMARU_UPDATED);
    exit();
}

include XOOPS_ROOT_PATH.'/footer.php';


