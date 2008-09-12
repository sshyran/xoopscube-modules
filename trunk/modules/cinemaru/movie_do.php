<?php

include 'header.php';
require_once('include/db.php');
require_once('include/groupperm_function.php');
require_once('constants.php');
require_once('include/misc.php');
include XOOPS_ROOT_PATH.'/header.php';

$mydirname = basename( dirname( __FILE__ ) ) ;
$xoopsTpl->assign('mydirname', $mydirname);
$constpref = strtoupper( $mydirname ) ;

$groupperm_insertable = cinemaru_checkright(constant($constpref.'_GROUPPERM_INSERTABLE'));
if ($groupperm_insertable == 0) {
    redirect_header('index.php', 2, _MD_CINEMARU_NO_REG_AUTH);
    exit();
}

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
	'name' => _MD_CINEMARU_GENRE,
        'type' => CINEMARU_TYPE_NUMERIC,
        'not_null' => 0,
	'min' => 0,
	'max' => 200,
	'regexp' => null,
    ),
);

if (isset($_FILES['file'])) {
    $config['file'] = array(
	'name' => _MD_CINEMARU_MOVIE_FILE,
        'type' => CINEMARU_TYPE_FILE_FLV_MP3,
        'not_null' => 1,
	'min' => 0,
	'max' => 0,
	'regexp' => null,
    );
    $file_type = constant($constpref.'_FORM_FILE_TYPE_FLV_MP3');
} else {
    $config['file_url'] = array(
	'name' => _MD_CINEMARU_FILE_URL,
        'type' => CINEMARU_TYPE_URL,
        'not_null' => 1,
	'min' => 0,
	'max' => 100,
	'regexp' => null,
    );
    if (preg_match('/^http:\/\/[a-z]+\.youtube\.com\//i', @$_POST['file_url'])) {
	$file_type = constant($constpref.'_FORM_FILE_TYPE_YOUTUBE_URL');
    } else {
	$file_type = constant($constpref.'_FORM_FILE_TYPE_FILE_URL');
    }
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

$error = cinemaru_validator($config);

if (0 < count($error)) {
    // エラーあり
    
    $groupperm_superinsert = cinemaru_checkright(constant($constpref.'_GROUPPERM_SUPERINSERT'));
    $xoopsTpl->assign('superinsert', $groupperm_superinsert);
    $xoopsTpl->assign('error', $error);
} else {
    // エラーなし
    
    cinemaru_mkdir_p();

    $valid = cinemaru_checkright(constant($constpref.'_GROUPPERM_SUPERINSERT'));
    
    $randam_code = cinemaru_get_randam_code();
    $id = cinemaru_movie_add($randam_code, $valid);

    if ($file_type == constant($constpref.'_FORM_FILE_TYPE_FLV_MP3')) {
	preg_match('/\.(flv|mp3)$/i', $_FILES['file']['name'], $r);
	$movie_ext = @$r[1];
    }
    if ($image_file_type == constant($constpref.'_FORM_FILE_TYPE_IMAGE')) {
	preg_match('/\.(jpg|jpeg|png|gif)$/i', $_FILES['image_file']['name'], $r);
	$image_ext = @$r[1];
    }

    cinemaru_movie_file_name_update($id, $randam_code, @$movie_ext, @$image_ext, @$_POST['file_url'], @$_POST['image_file_url'], $file_type);

    $d = XOOPS_ROOT_PATH . '/uploads/' . $mydirname . '/';
    $f = $id . '_' . $randam_code;
    
    if ($file_type == constant($constpref.'_FORM_FILE_TYPE_FLV_MP3')) {
	$movie = $d . 'movie/' . $f . '.' . $movie_ext;
	move_uploaded_file($_FILES['file']['tmp_name'], $movie);
    }
    if ($image_file_type == constant($constpref.'_FORM_FILE_TYPE_IMAGE')) {
	$image = $d . 'image/' . $f . '.' . $image_ext;
	if ($_FILES['image_file']['tmp_name'] != '') {
	    move_uploaded_file($_FILES['image_file']['tmp_name'], $image);
	}
    }
    
    $tags['POST_NAME'] = $_REQUEST['title'];
    $tags['POST_URL'] = XOOPS_URL . '/modules/' . $mydirname . '/movie.php?id=' . intval($id);
    
    $notification_handler =& xoops_gethandler('notification');
    $notification_handler->triggerEvent('global', 0, 'new_post', $tags);
    
    redirect_header('movie.php?id=' . intval($id), 2, _MD_CINEMARU_THANKSSUBMIT);
    exit();
}

include XOOPS_ROOT_PATH.'/footer.php';


