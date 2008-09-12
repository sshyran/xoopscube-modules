<?php

$mydirname = basename( dirname ( dirname ( dirname( __FILE__ ) ) ) ) ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;
  
define($constpref."_NAME","CINEMARU");

// A brief description of this module
define($constpref."_DESC","This module is movie/mp3 manager.");
define($constpref."_MODULE_DESCRIPTION","This module is movie/mp3 manager.");

// Names of admin menu items
define($constpref."_ADMENU1", "setting");
define($constpref."_ADMENU_GROUPPERM", "Group permission");

define($constpref."_MOVIE_MAX_SIZE", "Max movie/mp3 length");
define($constpref."_MOVIE_MAX_DEFAULT", "10485760");

define($constpref."_SUBMIT", "submit");

define($constpref.'_TAG_MAX_SIZE', 'Max number of tag');
define($constpref.'_TAG_MAX_DEFAULT', 50);
define($constpref.'_INPUT_TAG', 'Input tag name');
define($constpref.'_NUM_OF_TAG', 'Number of tag put on one movie.');
define($constpref.'_NUM_OF_TAG_DEFAULT', 10);
define($constpref.'_TAG_ENCODING', 'tag name charset');
define($constpref.'_TAG_ENCODING_DEFAULT', 'EUC-JP');
define($constpref.'_NUM_OF_THUMB', 'Thumbnail number displayed on one screen.');
define($constpref.'_NUM_OF_THUMB_DEFAULT', '10');
define($constpref.'_THUMB_BGCOLOR', 'Thumnail background color');
define($constpref.'_THUMB_BGCOLOR_DESC', '');
define($constpref.'_THUMB_BGCOLOR_DEFAULT', '');

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BLOCK_RANDOM", "randam");
define($constpref."_BLOCK_THUMB", "thumnail");

//notify

define($constpref.'_GLOBAL_NOTIFY', 'Module whole');
define($constpref.'_GLOBAL_NOTIFYDSC', 'The notice option in the whole module');

define ($constpref.'_GLOBAL_NEWPOST_NOTIFY', 'New data');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYCAP', 'It notifies, when there is contribution of a new movie/mp3');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYDSC', 'It notifies, when there is contribution of a new movie/mp3');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: New schedule');

define ($constpref.'_GLOBAL_UPDATE_NOTIFY', 'Update data');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYCAP', 'It notifies, when there is contribution of a update movie/mp3');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYDSC', 'It notifies, when there is contribution of a update movie/mp3');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: updated schedule');

define($constpref.'_SHOW_USER_ID', 'User ID is put up to the comment in animation. ');
define($constpref.'_SHOW_USER_ID_DESC', 'User ID is put up before the comment in animation. ');
define($constpref.'_SHOW_USER_ID_DEFAULT', '0');
define($constpref.'_SHOW_USER_ID_OK', 'It puts it. ');
define($constpref.'_SHOW_USER_ID_NG', "It doesn't put it. ");

// name setting
define($constpref.'_NAME_SETTING', 'Name setting');
define($constpref.'_SET_NAME', 'login ID');
define($constpref.'_SET_UNAME', 'user name');
define($constpref.'_SET_NAME_AND_UNAME', 'login ID + user name');
define($constpref.'_SET_UNAME_OR_NAME', 'user name or login ID');

// avatar setting
define($constpref.'_SHOW_AVATAR', 'Vavatar is put up to the comment in animation. ');
define($constpref.'_SHOW_AVATAR_DEFAULT', '0');
define($constpref.'_SHOW_AVATAR_OK', 'It puts it. ');
define($constpref.'_SHOW_AVATAR_NG', "It doesn't put it. ");

define($constpref.'_SHOW_NAME_CLIST', "Enrollee's name is put out to the comment list. ");
define($constpref.'_SHOW_NAME_CLIST_DEFAULT', '1');
define($constpref.'_SHOW_NAME_CLIST_OK', "It puts it out. ");
define($constpref.'_SHOW_NAME_CLIST_NG', "It doesn't put it out. ");

define($constpref.'_GUEST_USER_NAME', 'Guest user name');
define($constpref.'_GUEST_USER_NAME_DEFAULT', 'GUEST');

define($constpref.'_SHOW_NAME_MOVIE', "Enrollee's name is put out to the reproduction screen. ");
define($constpref.'_SHOW_NAME_MOVIE_DEFAULT', '1');
define($constpref.'_SHOW_NAME_MOVIE_OK', "It puts it out. ");
define($constpref.'_SHOW_NAME_MOVIE_NG', "It doesn't put it out. ");

define($constpref.'_SHOW_REPORT_LINK', 'The report link is put out to the reproduction screen. ');
define($constpref.'_SHOW_REPORT_LINK_DEFAULT', '1');
define($constpref.'_SHOW_REPORT_LINK_OK', 'It puts it out. ');
define($constpref.'_SHOW_REPORT_LINK_NG', "It doesn't put it out. ");

define($constpref.'_SP_RANDOM_OK', 'Random');
define($constpref.'_SP_RANDOM_NG', 'Not random');

define($constpref.'_SP_COMMAND1', "Special command1");
define($constpref.'_SP_COMMAND1_DEFAULT', 'star');
define($constpref.'_SP_COMMAND1_URL', 'Special command1 URL');
define($constpref.'_SP_COMMAND1_URL_DEFAULT', 'star1.swf');
define($constpref.'_SP_COMMAND1_RAND', 'Special command1 randam Y');
define($constpref.'_SP_COMMAND1_RANDOM_DEFAULT', '1');

define($constpref.'_SP_COMMAND2', 'Special command2');
define($constpref.'_SP_COMMAND2_DEFAULT', 'star2');
define($constpref.'_SP_COMMAND2_URL', 'Special command2 URL');
define($constpref.'_SP_COMMAND2_URL_DEFAULT', 'star2.swf');
define($constpref.'_SP_COMMAND2_RAND', 'Special command2 randam Y');
define($constpref.'_SP_COMMAND2_RANDOM_DEFAULT', '1');

define($constpref.'_SP_COMMAND3', 'Special command3');
define($constpref.'_SP_COMMAND3_DEFAULT', 'star3');
define($constpref.'_SP_COMMAND3_URL', 'Special command3 URL');
define($constpref.'_SP_COMMAND3_URL_DEFAULT', 'star3.swf');
define($constpref.'_SP_COMMAND3_RAND', 'Special command3 randam Y');
define($constpref.'_SP_COMMAND3_RANDOM_DEFAULT', '1');

define($constpref.'_RICHTEXT', 'Richtext setting');
define($constpref.'_USE_RICHTEXT', 'Use richtext');
define($constpref.'_USE_PLAINTEXT', 'Use plaintext');

define($constpref.'_BLOG_PASTE', 'Blog paste');
define($constpref.'_BLOG_PASTE_OK', 'It uses it. ');
define($constpref.'_BLOG_PASTE_NG', "It doesn't use it. ");

define($constpref.'_TOP_MOVIE', 'Module top style');
define($constpref.'_TOP_MOVIE_DESC', '');
define($constpref.'_TOP_MOVIE_LIST', 'list');
define($constpref.'_TOP_MOVIE_THUMB', 'thumbnail');
