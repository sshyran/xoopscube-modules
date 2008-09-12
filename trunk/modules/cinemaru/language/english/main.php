<?php

if (defined('__CINEMARU_MAIN_PHP__')) {
    return;
}
define('__CINEMARU_MAIN_PHP__', 1);

define("_MD_CINEMARU_MOVIE_UPLOAD", "Movie/mp3 upload");
define("_MD_CINEMARU_TITLE", "title");
define("_MD_CINEMARU_MOVIE_FILE", "Movie/mp3 file");
define("_MD_CINEMARU_FLV_ONLY", "FLV or MP3 file");
define("_MD_CINEMARU_THUMB_FILE", "Thumb image");
define("_MD_CINEMARU_DESC", "desc");
define("_MD_CINEMARU_GENRE", "junre");
define("_MD_CINEMARU_MOVIE_EDIT", "Edit movie");
define('_MD_CINEMARU_MOVIE_DELETE', 'Delete movie');
define("_MD_CINEMARU_TAG_LOCK", "Tga lock");
define("_MD_CINEMARU_TAG_LOCK_DESC", "lock");
define("_MD_CINEMARU_USER", "User");
define("_MD_CINEMARU_SUBMIT", "Submit");

define('_MD_CINEMARU_ERROR_NO_DATA', 'Input %s ');
define('_MD_CINEMARU_ERROR_MAIL_NG_FORMAT', '%s The input is illegal. ');
define('_MD_CINEMARU_ERROR_URL_NG_FORMAT', '%s The input is illegal. ');
define('_MD_CINEMARU_ERROR_SIZE_OVER', '%s Please input it within %s characters. ');
define('_MD_CINEMARU_ERROR_SIZE_UNDER', '%s Please input it by %s characters or more. ');
define('_MD_CINEMARU_ERROR_CONFIRM_NO_MATCH', '%s No match');
define('_MD_CINEMARU_ERROR_MAIL_EXISTS', 'mail exists');
define('_MD_CINEMARU_ERROR_MAIL_NO_EXISTS', 'The mail address was not registered.');
define('_MD_CINEMARU_ERROR_NO_AUTH', 'The mail address or the password is different.');
define('_MD_CINEMARU_ERROR_NO_PASSWORD', 'The password is different.');
define('_MD_CINEMARU_ERROR_NO_IMAGE_FILE', '%s Not image file');
define('_MD_CINEMARU_ERROR_NO_FLV_FILE', '%s Not flv file');
define('_MD_CINEMARU_ERROR_NG_FILE_UPLOAD', '%s File upload is illegal');
define('_MD_CINEMARU_ERROR_NO_FILE', '%s Input file name');

define('_MD_CINEMARU_ERROR_UPLOAD_ERR_INI_SIZE', 'File size over(UPLOAD_ERR_INI_SIZE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_FORM_SIZE', 'File size over(UPLOAD_ERR_FORM_SIZE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_PARTIAL', 'Upload error(UPLOAD_ERR_PARTIAL)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_NO_FILE', 'Upload error(UPLOAD_ERR_NO_FILE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_NO_TMP_DIR', 'Upload error(UPLOAD_ERR_NO_TMP_DIR)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_CANT_WRITE', 'Upload error(UPLOAD_ERR_CANT_WRITE)');
define('_MD_CINEMARU_ERROR_UPLOAD_ERR_EXTENSION', 'Upload error(UPLOAD_ERR_EXTENSION)');

define('_MD_CINEMARU_ERROR_NO_TITLE', 'Input title');
define('_MD_CINEMARU_ERROR_DESC_OVER', 'The explanation is within 1000 characters. ');
define('_MD_CINEMARU_COUNT', 'Hit');
define('_MD_CINEMARU_COMMENT', 'comment');
define('_MD_CINEMARU_EDIT', 'edit');
define('_MD_CINEMARU_DELETE', 'delete');
define('_MD_CINEMARU_ADD', 'insert');
define('_MD_CINEMARU_UPLOAD', 'upload');
define('_MD_CINEMARU_UPDATE', 'update');

define('_MD_CINEMARU_MOVIE_NOT_FOUND', 'Movie/mp3 not found');
define('_MD_CINEMARU_UPDATED', 'Updated');
define('_MD_CINEMARU_DELETED', 'Deleted');
define('_MD_CINEMARU_THANKSSUBMIT', 'Thanks submit');

define('_MD_CINEMARU_TAG', 'tag');
define('_MD_CINEMARU_EDIT_TAG', 'edit tag');
define('_MD_CINEMARU_END_EDIT_TAG', 'end tag edit');

define('_MD_CINEMARU_NO_REG_AUTH', 'There is no contribution authority. ');
define('_MD_CINEMARU_NO_DEL_AUTH', 'There is no deletion authority.');
define('_MD_CINEMARU_NO_EDIT_AUTH', 'There is no edit authority. ');
define('_MD_CINEMARU_NO_VALID_AUTH', 'There is no approval authority.');
define('_MD_CINEMARU_NO_REPORT_AUTH', 'There is no report authority.');
define('_MD_CINEMARU_NO_REPORT_LIST_AUTH', 'There is no report list authority.');

define('_MD_CINEMARU_NEXT', 'next');
define('_MD_CINEMARU_PREV', 'prev');

define('_MD_CINEMARU_TOTAL', 'total');

define('_MD_CINEMARU_MOVIE_NO_VALID', 'This animation is waiting for approval. ');
define('_MD_CINEMARU_MOVIE_NO_VALID2', 'Unapproval');
define('_MD_CINEMARU_MOVIE_NO_VALID3', 'Unapproval');
define('_MD_CINEMARU_MOVIE_VALID', 'Approval');
define('_MD_CINEMARU_MOVIE_VALIDED', 'It approved. ');
define('_MD_CINEMARU_MOVIE_NG_VALIDED', 'Unapproval');

define('_MD_CINEMARU_MOVIE_LIST_NO_VALID', 'Only the unapproval animation is displayed. ');
define('_MD_CINEMARU_MOVIE_LIST_NO_VALID_EXISTS', 'There is unapproval animation. ');
define('_MD_CINEMARU_MOVIE_LIST_NORMAL', 'Display usually');

define('_MD_CINEMARU_MOVIE', 'movie');
define('_MD_CINEMARU_TIME', 'date');
define('_MD_CINEMARU_ACTION', 'action');

define('_MD_CINEMARU_NO_COMMENT_READ', 'There is no inspection authority. ');
define('_MD_CINEMARU_NO_DELETE_COMMENT_ADMIN', 'There is no comment deletion authority. ');
define('_MD_CINEMARU_DELETED_COMMENT', 'The comment was deleted. ');
define('_MD_CINEMARU_COMMENT_ADMIN', 'Comment management');
define('_MD_CINEMARU_COMMENT_LIST', 'Comment list');
define('_MD_CINEMARU_COMMENT_TIME', 'Display time');

define('_MD_CINEMARU_LIST', 'list');
define('_MD_CINEMARU_THUMB', 'thunbnail');

define('_MD_CINEMARU_WAIT_VALID', 'After it approves, it comes to be able to reproduce movie/MP3. ');

define('_MD_CINEMARU_SORT', 'sort');
define('_MD_CINEMARU_SORT_NEW', 'new');
define('_MD_CINEMARU_SORT_OLD', 'old');
define('_MD_CINEMARU_SORT_HIGH_HIT', 'high hit');
define('_MD_CINEMARU_SORT_LOW_HIT', 'low hit');

define('_MD_CINEMARU_VIOLATION_REPORT_LIST', 'Violation/NG Link report list');
define('_MD_CINEMARU_VIOLATION_REPORT', 'Violation/NG Link report');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT', 'Category');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_1', 'NG Link');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_2', 'Illegal up-loading');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_3', 'Sexual expression, Expression of violence');
define('_MD_CINEMARU_VIOLATION_REPORT_CAT_4', 'other');

define('_MD_CINEMARU_REPORTED', 'DB Updated');
define('_MD_CINEMARU_DELETED_REPORT', 'Deleted report');
define('_MD_CINEMARU_CHECK_REPORT_LIST', 'There is a violation/NG Link report. ');

define('_MD_CINEMARU_FILE_UPLOAD', 'File upload');
define('_MD_CINEMARU_URL', 'URL');
define('_MD_CINEMARU_FILE_URL', 'File URL');
define('_MD_CINEMARU_IMAGE_FILE_UPLOAD', 'Image file upload');
define('_MD_CINEMARU_IMAGE_FILE_URL', 'Image file URL');

define('_MD_CINEMARU_BLOG_PASTE_TAG', 'Blog paste tag');

define('_MD_CINEMARU_URL_DESC', 'Please input URL to FLV/MP3 file. <br />For YouTube, Please input like http://www.youtube.com/watch?v=xxxxxxxxxxx ');
