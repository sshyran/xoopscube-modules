<?php

$mydirname = basename( dirname ( dirname ( dirname( __FILE__ ) ) ) ) ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

define($constpref."_NAME","CINEMARU");

// A brief description of this module
define($constpref."_DESC","このモジュールは動画モジュールです。");
define($constpref."_MODULE_DESCRIPTION","このモジュールは動画モジュールです。");

// Names of admin menu items
define($constpref."_ADMENU1", "設定");
define($constpref."_ADMENU_GROUPPERM", "グループの全体的な権限");


define($constpref."_MOVIE_MAX_SIZE", "動画の最大ファイルサイズ");
define($constpref."_MOVIE_MAX_DEFAULT", "10485760");

define($constpref."_SUBMIT", "投稿する");

define($constpref.'_TAG_MAX_SIZE', 'タグの最大文字数');
define($constpref.'_TAG_MAX_DEFAULT', 50);
define($constpref.'_INPUT_TAG', 'タグ名を入力してください');
define($constpref.'_NUM_OF_TAG', '一つの動画に付けられるタグ数');
define($constpref.'_NUM_OF_TAG_DEFAULT', 10);
define($constpref.'_TAG_ENCODING', 'タグ名の文字コード');
define($constpref.'_TAG_ENCODING_DEFAULT', 'UTF-8');
define($constpref.'_NUM_OF_THUMB', '１画面で表示するサムネイルの数');
define($constpref.'_NUM_OF_THUMB_DEFAULT', '10');
define($constpref.'_THUMB_BGCOLOR', 'サムネイルの背景色');
define($constpref.'_THUMB_BGCOLOR_DESC', 'サムネイルの背景色を指定します。#FF8888 のように指定してください。省略すると背景色は指定されません。');
define($constpref.'_THUMB_BGCOLOR_DEFAULT', '');



// Names of blocks for this module (Not all module has blocks)
define($constpref."_BLOCK_RANDOM", "ランダム表示");
define($constpref."_BLOCK_THUMB", "サムネイル表示");



// 通知機能

define($constpref.'_GLOBAL_NOTIFY', 'モジュール全体');
define($constpref.'_GLOBAL_NOTIFYDSC', 'モジュール全体のスケジュールに対する通知オプション');

define ($constpref.'_GLOBAL_NEWPOST_NOTIFY', '登録');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYCAP', '登録があった場合に通知する');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYDSC', '登録があった場合に通知する');
define ($constpref.'_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 登録がありました');

define ($constpref.'_GLOBAL_UPDATE_NOTIFY', '更新');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYCAP', '更新があった場合に通知する');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYDSC', '更新があった場合に通知する');
define ($constpref.'_GLOBAL_UPDATE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 更新がありました');

define($constpref.'_SHOW_USER_ID', '動画中のコメントにユーザIDを付ける');
define($constpref.'_SHOW_USER_ID_DESC', '動画中のコメントの前にユーザIDを付ける。');
define($constpref.'_SHOW_USER_ID_DEFAULT', '0');
define($constpref.'_SHOW_USER_ID_OK', '付ける');
define($constpref.'_SHOW_USER_ID_NG', '付けない');


// name setting
define($constpref.'_NAME_SETTING', '名前表示設定');
define($constpref.'_SET_NAME', 'ログインID');
define($constpref.'_SET_UNAME', '本名');
define($constpref.'_SET_NAME_AND_UNAME', 'ログインID＋本名');
define($constpref.'_SET_UNAME_OR_NAME', '本名、ただし本名が未設定の場合はログインID');

// avatar setting
define($constpref.'_SHOW_AVATAR', '動画中のコメントにアバターをつける');
define($constpref.'_SHOW_AVATAR_DEFAULT', '0');
define($constpref.'_SHOW_AVATAR_OK', '付ける');
define($constpref.'_SHOW_AVATAR_NG', '付けない');

define($constpref.'_SHOW_NAME_CLIST', 'コメント一覧に登録者の名前を出す');
define($constpref.'_SHOW_NAME_CLIST_DEFAULT', '1');
define($constpref.'_SHOW_NAME_CLIST_OK', '出す');
define($constpref.'_SHOW_NAME_CLIST_NG', '出さない');

define($constpref.'_GUEST_USER_NAME', 'ゲストユーザの名前');
define($constpref.'_GUEST_USER_NAME_DEFAULT', 'GUEST');

define($constpref.'_SHOW_NAME_MOVIE', '再生画面に登録者の名前を出す');
define($constpref.'_SHOW_NAME_MOVIE_DEFAULT', '1');
define($constpref.'_SHOW_NAME_MOVIE_OK', '出す');
define($constpref.'_SHOW_NAME_MOVIE_NG', '出さない');

define($constpref.'_SHOW_REPORT_LINK', '再生画面に違反報告リンクを出す');
define($constpref.'_SHOW_REPORT_LINK_DEFAULT', '1');
define($constpref.'_SHOW_REPORT_LINK_OK', '出す');
define($constpref.'_SHOW_REPORT_LINK_NG', '出さない');

define($constpref.'_SP_RANDOM_OK', 'ランダムにする');
define($constpref.'_SP_RANDOM_NG', 'ランダムにしない');

define($constpref.'_SP_COMMAND1', 'スペシャルコマンド1');
define($constpref.'_SP_COMMAND1_DEFAULT', 'star');
define($constpref.'_SP_COMMAND1_URL', 'スペシャルコマンド1 URL');
define($constpref.'_SP_COMMAND1_URL_DEFAULT', 'star1.swf');
define($constpref.'_SP_COMMAND1_RAND', 'スペシャルコマンド1 Y軸をランダムにする');
define($constpref.'_SP_COMMAND1_RANDOM_DEFAULT', '1');

define($constpref.'_SP_COMMAND2', 'スペシャルコマンド2');
define($constpref.'_SP_COMMAND2_DEFAULT', 'star2');
define($constpref.'_SP_COMMAND2_URL', 'スペシャルコマンド2 URL');
define($constpref.'_SP_COMMAND2_URL_DEFAULT', 'star2.swf');
define($constpref.'_SP_COMMAND2_RAND', 'スペシャルコマンド2 Y軸をランダムにする');
define($constpref.'_SP_COMMAND2_RANDOM_DEFAULT', '1');

define($constpref.'_SP_COMMAND3', 'スペシャルコマンド3');
define($constpref.'_SP_COMMAND3_DEFAULT', 'star3');
define($constpref.'_SP_COMMAND3_URL', 'スペシャルコマンド3URL');
define($constpref.'_SP_COMMAND3_URL_DEFAULT', 'star3.swf');
define($constpref.'_SP_COMMAND3_RAND', 'スペシャルコマンド3 Y軸をランダムにする');
define($constpref.'_SP_COMMAND3_RANDOM_DEFAULT', '1');

define($constpref.'_RICHTEXT', 'リッチテキスト設定');
define($constpref.'_USE_RICHTEXT', '予約内容にリッチテキストを使う');
define($constpref.'_USE_PLAINTEXT', '予約内容にプレインテキストを使う');

define($constpref.'_BLOG_PASTE', 'ブログ貼り付け機能');
define($constpref.'_BLOG_PASTE_OK', '有効にする');
define($constpref.'_BLOG_PASTE_NG', '無効にする');

define($constpref.'_TOP_MOVIE', 'モジュールトップ画面の表示スタイル');
define($constpref.'_TOP_MOVIE_DESC', 'モジュールトップ画面の動画/MP3のデフォルトの表示スタイル。ただし、ユーザが選択した場合クッキーに記録され、次回からはそちらが優先される。');
define($constpref.'_TOP_MOVIE_LIST', 'リスト表示');
define($constpref.'_TOP_MOVIE_THUMB', 'サムネイル表示');


