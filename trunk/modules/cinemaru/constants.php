<?php

//if (defined('__CINEMARU_CONSTANTS_PHP__')) {
//    return;
//}
//define('__CINEMARU_CONSTANTS_PHP__', 1);

$mydirname = basename( dirname( __FILE__ ) ) ;
$constpref = strtoupper( $mydirname ) ;

define($constpref.'_GROUPPERM_INSERTABLE', 1);
define($constpref.'_GROUPPERM_SUPERINSERT', 2);
define($constpref.'_GROUPPERM_EDITABLE', 4);
define($constpref.'_GROUPPERM_SUPEREDIT', 8);
define($constpref.'_GROUPPERM_SUPERDELETE', 32);
define($constpref.'_GROUPPERM_TOUCHOTHERS', 64);
define($constpref.'_GROUPPERM_TAGINSERTABLE', 128);
define($constpref.'_GROUPPERM_TAGEDITABLE', 256);
define($constpref.'_GROUPPERM_TAGDELETABLE', 512);
define($constpref.'_GROUPPERM_VALID', 1024);
define($constpref.'_GROUPPERM_DELCOMMENT', 2048);
define($constpref.'_GROUPPERM_INSERTCOMMENT', 4096);
define($constpref.'_GROUPPERM_SHOWCOMMENT', 8192);
define($constpref.'_GROUPPERM_REPORT', 16384);
define($constpref.'_GROUPPERM_REPORT_LIST', 32768);

define($constpref.'_THUMB_TITLE_LENGTH', 20);
define($constpref.'_THUMB_DESC_LENGTH', 30);

define($constpref.'_FORM_FILE_TYPE_FLV_MP3', 1);
define($constpref.'_FORM_FILE_TYPE_FILE_URL', 2);
define($constpref.'_FORM_FILE_TYPE_YOUTUBE_URL', 3);

define($constpref.'_FORM_FILE_TYPE_IMAGE', 3);
define($constpref.'_FORM_FILE_TYPE_IMAGE_URL', 4);



